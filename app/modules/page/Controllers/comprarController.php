<?php

class Page_comprarController extends Page_mainController
{

  public $botonactivo  = 15;
  public function init()
  {
    $permiso = $this->_getSanitizedParam('pms');
    if ($permiso != 1) {
      //si no existe un usuario activo llevar al paso 1
      if (!Session::getInstance()->get('usuario')) {
        header("Location: /");
      }
    }
    /* /page/comprar/cancelarpedidos?pms=1&debug= */

    parent::init();
  }
  public function indexAction()
  {
    $productoModel =  new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    $productosPedidosModel =  new Administracion_Model_DbTable_Productosporpedido();

    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $carrito = $this->getCarrito();

    $data = [];


    foreach ($carrito as $id => $cantidad) {

      $producto = $productoModel->getById($id);
      $producto->producto_categoriainfo = $categoriaModel->getById($producto->producto_categoria);
      // Precio original antes de descuento e IVA
      $precioOriginal = $producto->producto_precio;

      // Calcular el descuento
      $montoDescuento = $precioOriginal * $descuento / 100;

      // Precio después de aplicar el descuento
      $precioConDescuento = $precioOriginal - $montoDescuento;

      // Calcular IVA sobre el precio con descuento
      // $montoIva = $precioOriginal * $iva / 100;
      $montoIva = $precioConDescuento * $iva / 100;

      // Precio final con IVA aplicado
      $precioFinal = $precioConDescuento + $montoIva;

      $producto->producto_precio = $precioFinal;


      // Datos del producto
      $data[$id] = [];
      $data[$id]['detalle'] = $producto;
      $data[$id]['cantidad'] = (int)$cantidad;

      // Total por producto
      $data[$id]['total'] = $producto->producto_precio * $cantidad;
    }


    // print_r($data);
    $this->_view->error_compra = Session::getInstance()->get("error_compra");
    Session::getInstance()->set("error_compra", "");
    $this->_view->carrito = $data;
  }

  public function continuarAction()
  {
    $this->setLayout('blanco');

    // Inicialización de los modelos necesarios
    $productoModel = new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    $configModel = new Administracion_Model_DbTable_Config();
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productosPedidosModel = new Administracion_Model_DbTable_Productosporpedido();

    // Obtener configuración general (porcentaje de IVA)
    $config = $configModel->getById(1);
    $iva = $config->configuracion_iva; // IVA configurado en el sistema

    // Obtener datos del usuario autenticado y su nivel
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje; // Descuento según el nivel del usuario

    // Obtener el carrito de compras actual
    $carrito = $this->getCarrito();

    // Preparar datos para registrar el pedido
    $dataPedido = [
      "pedido_documento" => $usuario->user_cedula, // Documento del cliente
      "pedido_fecha" => date('Y-m-d H:i:s'),      // Fecha y hora actual
      "pedido_nombre" => $usuario->user_empresa,   // Nombre del cliente
      "pedido_telefono" => $usuario->user_telefono, // Teléfono del cliente
      "pedido_correo" => $usuario->user_email,   // Correo del cliente
      "pedido_subtotal" => $this->_getSanitizedParam('subtotal'), // Subtotal del pedido
      "pedido_procentaje_descuento" => $descuento, // Porcentaje de descuento
      "pedido_porcentaje_iva" => $iva,             // Porcentaje de IVA
      "pedido_descuento" => $this->_getSanitizedParam('descuento'), // Monto del descuento
      "pedido_iva" => $this->_getSanitizedParam('iva'),           // Monto del IVA
      "pedido_total" => $this->_getSanitizedParam('total'),       // Total a pagar
      "pedido_estado" => 2, // Estado inicial del pedido (1 = activo)
    ];

    // Insertar el pedido en la base de datos
    $idPedido = $pedidosModel->insert($dataPedido);

    // Verificar si la inserción del pedido fue exitosa
    if (!$idPedido) {
      Session::getInstance()->set("error_compra", "Error al guardar el pedido");
      header('Location: /page/comprar'); // Redirigir en caso de error
      return;
    }




    // Procesar cada producto en el carrito
    foreach ($carrito as $id => $cantidad) {

      $disnponibilidadProducto = $this->descontarInventarioIndividual($id, $cantidad);
      if ($disnponibilidadProducto["error"]) {
        Session::getInstance()->set("error_compra", $disnponibilidadProducto["error"]);
        header('Location: /page/comprar'); // Redirigir en caso de error
        return;
      }

      // Obtener datos del producto actual
      $producto = $productoModel->getById($id);

      // Calcular precios y descuentos
      $precioOriginal = $producto->producto_precio;                // Precio base del producto
      $montoDescuento = $precioOriginal * $descuento / 100;        // Monto del descuento
      $precioConDescuento = $precioOriginal - $montoDescuento;    // Precio con descuento aplicado
      $montoIva = $precioConDescuento * $iva / 100;               // Monto del IVA
      $precioFinal = $precioConDescuento + $montoIva;             // Precio final con IVA

      // Actualizar precio en el objeto del producto
      $producto->producto_precio = $precioFinal;

      // Preparar datos para registrar el producto en el pedido
      $dataProductoPedido = [
        "pedido_producto_pedido" => $idPedido,                     // ID del pedido
        "pedido_producto_producto" => $producto->producto_id,      // ID del producto
        "pedido_producto_nombre" => $producto->producto_nombre,    // Nombre del producto
        "pedido_producto_cantidad" => (int)$cantidad,              // Cantidad comprada
        "pedido_producto_valor" => $precioOriginal,                // Precio base
        "pedido_producto_iva" => $iva,                             // Porcentaje de IVA
        "pedido_producto_valor_iva" => $montoIva,                  // Monto del IVA
        "pedido_producto_descuento" => $descuento,                 // Porcentaje de descuento
        "pedido_producto_valor_descuento" => $montoDescuento,      // Monto del descuento
        "pedido_producto_precio_final" => $cantidad * $precioFinal // Total final por este producto
      ];

      // Insertar el producto en el pedido
      $idPedidoProducto = $productosPedidosModel->insert($dataProductoPedido);

      // Verificar si la inserción del producto fue exitosa
      if (!$idPedidoProducto) {
        Session::getInstance()->set("error_compra", "Error al guardar los productos del pedido");
        header('Location: /page/comprar'); // Redirigir en caso de error
        return;
      }
    }

    /* $descontarInventario =  $this->descontarInventario($idPedido);

    if ($descontarInventario["error"]) {
      Session::getInstance()->set("error_compra", $descontarInventario["error"]);
      header('Location: /page/comprar'); // Redirigir en caso de error
      return;
    } */


    // Redirigir a la página de dirección para completar el pedido
    header('Location: /page/comprar/direccion?id=' . $idPedido);
  }

  public function direccionAction()
  {

    $idPedido = $this->_getSanitizedParam('id');
    $this->getLayout()->setData("ocultarcarrito", 1);

    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $pedido = $pedidosModel->getById($idPedido);

    // if (!$idPedido && $pedido->pedido_estado != 1) {
    if (!$idPedido) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar');
      return;
    }
    $direccionModel = new Administracion_Model_DbTable_Direcciones();
    $departamentosModel = new Administracion_Model_DbTable_Departamentos();
    $municipiosModel = new Administracion_Model_DbTable_Municipios();
    $departamentos = $departamentosModel->getList("", " departamento ASC");
    $this->_view->departamentos = $departamentos;
    $municipios = $municipiosModel->getList("", "municipio ASC");
    $this->_view->municipios = $municipios;
    $usuario = $this->usuarioLogged();
    $direcciones = $direccionModel->getList("direccion_cliente='{$usuario->user_cedula}'");
    foreach ($direcciones as $direccion) {
      $departamento = $departamentosModel->getById($direccion->direccion_departamento);
      $municipio = $municipiosModel->getById($direccion->direccion_ciudad);
      $direccion->direccion_departamento_nombre = $departamento->departamento;
      $direccion->direccion_ciudad_nombre = $municipio->municipio;
    }
    // print_r($direcciones);
    $this->_view->pedido = $pedido;
    $this->_view->idPedido = $idPedido;

    $this->_view->direcciones = $direcciones;

    $this->_view->error_compra = Session::getInstance()->get("error_compra");
    Session::getInstance()->set("error_compra", "");
  }


  public function continuar2Action()
  {
    // Establece el layout en blanco, útil si este método se llama mediante AJAX o requiere una salida mínima.
    $this->setLayout('blanco');
    // error_reporting(E_ALL);

    // Obtener ID del pedido desde los parámetros sanitizados
    $idPedido = $this->_getSanitizedParam('pedido-id');

    // Inicialización de modelos
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $direccionModel = new Administracion_Model_DbTable_Direcciones();

    // Obtener datos del usuario autenticado
    $usuario = $this->usuarioLogged();

    // Obtener el pedido asociado al ID proporcionado
    $pedido = $pedidosModel->getById($idPedido);

    // Validar que exista el ID del pedido y que el estado del pedido sea válido
    // if (!$idPedido || $pedido->pedido_estado != 1) {
    if (!$idPedido || !$pedido) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar'); // Redirigir en caso de error
      return;
    }

    // Obtener datos de la dirección seleccionada o ingresada
    $direccionRadio = $this->_getSanitizedParam('direccion-radio');
    $departamentoId = $this->_getSanitizedParam('departamento');
    $municipioId = $this->_getSanitizedParam('municipio');
    $direccion = $this->_getSanitizedParam('direccion');


    $observacion = $this->_getSanitizedParam('observacion');     // Observación opcional
    $guardarDireccion = $this->_getSanitizedParam('guardar-direccion'); // Bandera para guardar la dirección


    // Validar que se haya proporcionado alguna dirección
    if (!$direccionRadio && !$direccion && !$departamentoId && !$municipioId) {
      Session::getInstance()->set("error_compra", "Debe seleccionar una dirección de envío");
      header('Location: /page/comprar/direccion?id=' . $idPedido);
      return;
    }

    // Si el usuario seleccionó una dirección guardada
    if ($direccionRadio && $direccionRadio != "otra") {
      // Obtener la dirección guardada del usuario
      $direccionGuardada = $direccionModel->getList("direccion_id='{$direccionRadio}' AND direccion_cliente='{$usuario->user_cedula}'")[0];
      // Asignar valores de la dirección guardada
      $departamentoId = $direccionGuardada->direccion_departamento;
      $municipioId = $direccionGuardada->direccion_ciudad;
      $direccion = $direccionGuardada->direccion_direccion;
      $observacion = $direccionGuardada->direccion_observacion;
    }


    // Si el usuario ingresó una nueva dirección
    if ($direccionRadio == "otra") {
      $departamentoId = $this->_getSanitizedParam('departamento'); // Departamento ingresado
      $municipioId = $this->_getSanitizedParam('municipio');       // Municipio ingresado
      $direccion = $this->_getSanitizedParam('direccion');         // Dirección ingresada
      $observacion = $this->_getSanitizedParam('observacion');     // Observación opcional
    }

    // Si el usuario eligió guardar la nueva dirección
    if ($guardarDireccion == 'on') {
      $dataDireccion = [
        "direccion_cliente" => $usuario->user_cedula, // Cliente asociado
        "direccion_departamento" => $departamentoId,  // Departamento de la nueva dirección
        "direccion_ciudad" => $municipioId, // Municipio de la nueva dirección
        "direccion_direccion" => $direccion, // Dirección específica
        "direccion_observacion" => $observacion, // Observación opcional
        "direccion_estado" => 1,  // Estado activo
      ];
      // Insertar la nueva dirección en la base de datos
      $direccionModel->insert($dataDireccion);
    }

    // (Continuar con la edición del pedido si es necesario)
    // Ejemplo para depurar:
    /*  echo "Departamento: $departamentoId<br>";
    echo "Municipio: $municipioId<br>";
    echo "Dirección: $direccion<br>";
    echo "Observación: $observacion<br>";
    echo "Pedido: $idPedido<br>"; */


    // Actualizar el pedido con los datos de la dirección
    $pedidosModel->editField($idPedido, "pedido_departamento", $departamentoId);
    $pedidosModel->editField($idPedido, "pedido_ciudad", $municipioId);
    $pedidosModel->editField($idPedido, "pedido_direccion", $direccion);
    $pedidosModel->editField($idPedido, "pedido_direccion_observacion", $observacion);
    $pedidosModel->editField($idPedido, "pedido_estado", 3);
    header('Location: /page/comprar/pago?id=' . $idPedido);
  }




  public function pagoAction()
  {
    $this->getLayout()->setData("ocultarcarrito", 1);

    $pedidoId = $this->_getSanitizedParam('id');
    if (!$pedidoId) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar');
      return;
    }
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $tiendaCategoria = new Administracion_Model_DbTable_Tiendacategorias();
    $departamentosModel = new Administracion_Model_DbTable_Departamentos();
    $municipiosModel = new Administracion_Model_DbTable_Municipios();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $pedido = $pedidosModel->getById($pedidoId);
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$pedidoId}'");

    foreach ($productos as $producto) {

      $productoDetalle = $productosModel->getById($producto->pedido_producto_producto);
      $producto->producto_categoriainfo = $tiendaCategoria->getById($productoDetalle->producto_categoria)->tienda_categoria_nombre;
      $producto->producto_imagen = $productoDetalle->producto_imagen;
    }

    $pedido->ciudad_nombre = $municipiosModel->getById($pedido->pedido_ciudad)->municipio;
    $pedido->departamento_nombre = $departamentosModel->getById($pedido->pedido_departamento)->departamento;
    // echo "<pre>";
    // print_r($pedido);
    // echo "</pre>";
    $this->_view->pedido = $pedido;
    $this->_view->productos = $productos;
  }

  public function generarpagoAction()
  {
    $this->setLayout("blanco");
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $departamentosModel = new Administracion_Model_DbTable_Departamentos();
    $municipiosModel = new Administracion_Model_DbTable_Municipios();
    $idPedido = $this->_getSanitizedParam('pedido_id');
    //echo $idPedido;
    $pedido = $pedidosModel->getById($idPedido);
    if (!$pedido) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar');
      return;
    }
    Session::getInstance()->set("carrito", []);

    $pedidosModel->editField($idPedido, "pedido_estado", 4);
    $pedido->ciudad_nombre = $municipiosModel->getById($pedido->pedido_ciudad)->municipio;
    $pedido->departamento_nombre = $departamentosModel->getById($pedido->pedido_departamento)->departamento;
    $pedido->pedido_tipo_documento  = "NIT";
    $pedido->pedido_pais  = "CO";
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$idPedido}'");
    $total = $pedido->pedido_total;


    $wompi = Payment_Wompi::getInstance()->getData();
    // print_r($wompi);

    $redirectUrl = $wompi["redirectUrl"];
    $publicKey = $wompi["publicKey"];
    $secretKey = $wompi["secretKey"];
    $events = $wompi["events"];
    $integrity = $wompi["integrity"];
    $reference = $idPedido;
    $moneda = "COP";


    // Fecha actual
    // Crear el objeto DateTime con la fecha y hora actual
    $date = date_create(); // Crear la fecha actual
    date_modify($date, '+15 minutes'); // Sumar 15 minutos
    $fechaExpiracion =  date_format($date, 'c'); // Formatear y mostrar la fecha


    $cadena = $reference . intval($total * 100) . $moneda . $fechaExpiracion . $integrity;


    $cadenaHash = hash("sha256", $cadena);

    // echo "Cadena encriptada: " . $cadenaHash;
    $this->_view->cadenaHash = $cadenaHash;
    $this->_view->redirectUrl = $redirectUrl;
    $this->_view->publicKey = $publicKey;
    $this->_view->secretKey = $secretKey;
    $this->_view->events = $events;
    $this->_view->id = $pedido;
    $this->_view->pedido = $pedido;
    $this->_view->moneda = $moneda;
    $this->_view->fechaExpiracion = $fechaExpiracion;
  }

  public function respuestaAction()
  {

    // $this->setLayout("blanco");
    $id = $this->_getSanitizedParam("id");
    $response = $this->consultarVentaById($id);

    if (!$response) {
      $this->_view->response = false;
    }

    $this->_view->response = $response;
    $this->_view->getListStatus = $this->getListStatus();
  }
  public function confirmacionAction() {}

  public function consultarVentaById($transaction_id)
  {

    $wompi = Payment_Wompi::getInstance()->getData();

    $publicKey = $wompi["publicKey"];

    $api_url = "https://sandbox.wompi.co/v1/transactions/$transaction_id";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_SSL_VERIFYPEER => false, // Desactiva la verificación del certificado
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $publicKey"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {

      return json_decode($response)->data;
    }
  }


  public function getListStatus()
  {
    $data = [];
    $data["PENDING"] = "Transacción pendiente";
    $data["APPROVED"] = "Transacción aprobada";
    $data["DECLINED"] = "Transacción rechazada";
    $data["VOIDED"] = "Transacción anulada";
    $data["ERROR"] = "Error interno del método de pago respectivo";
    return $data;
  }

  public function getPedidoestado()
  {
    $array = array();
    $array["PENDING"] = 9;
    $array["APPROVED"] = 5;
    $array["DECLINED"] = 6;
    $array["VOIDED"] = 7;
    $array["ERROR"] = 8;

    return $array;
  }


  public function descontarInventarioIndividual($productoId, $cantidad)
  {
    $productosModel = new Administracion_Model_DbTable_Productos();
    $productoDetalle = $productosModel->getById($productoId);
    if ($productoDetalle->producto_stock < $cantidad) {
      $res = [
        "error" => "No hay suficiente stock para el producto: " . $productoDetalle->producto_nombre,
        "producto" => $productoDetalle->producto_nombre,
        "stock" => $productoDetalle->producto_stock,
        "cantidad" => $cantidad
      ];

      $carrito = $this->getCarrito();
      if ($carrito[$productoId]) {
        $carrito[$productoId] = $productoDetalle->producto_stock;
      }
      Session::getInstance()->set("carrito", $carrito);
      return $res;
    }
    $nuevoStock = $productoDetalle->producto_stock - $cantidad;
    $productosModel->editField($productoId, "producto_stock", $nuevoStock);
    $res = [
      "error" => false,
      "mensaje" => "Inventario actualizado correctamente"
    ];
  }






  public function descontarInventario($pedidoId)
  {

    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $productosModel = new Administracion_Model_DbTable_Productos();

    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$pedidoId}'");

    foreach ($productos as $producto) {
      $productoDetalle = $productosModel->getById($producto->pedido_producto_producto);

      if ($productoDetalle->producto_stock < $producto->pedido_producto_cantidad) {

        $res = [
          "error" => "No hay suficiente stock para el producto: " . $productoDetalle->producto_nombre,
          "producto" => $productoDetalle->producto_nombre,
          "stock" => $productoDetalle->producto_stock,
          "cantidad" => $producto->pedido_producto_cantidad
        ];
        return $res;
        exit;
      }
      $nuevoStock = $productoDetalle->producto_stock - $producto->pedido_producto_cantidad;
      $productosModel->editField($producto->pedido_producto_producto, "producto_stock", $nuevoStock);
    }

    $res = [
      "error" => false,
      "mensaje" => "Inventario actualizado correctamente"
    ];
    return $res;
  }

  public function cancelarpedidosAction()
  {
    $this->setLayout('blanco');
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();


    // Obtener la fecha y hora actual
    $now = new DateTime();

    // Crear la primera fecha (ayer a las 23:55:00)
    $yesterday = clone $now;
    $yesterday->modify('-1 day')->setTime(23, 55, 0);

    // Crear la segunda fecha (hoy a las 23:58:00)
    $today = clone $now;
    $today->setTime(23, 58, 0);

    // Crear la fecha para filtrar pedidos de estado 4 (1 hora antes de la consulta)
    $thirtyMinutes = clone $now;
    $thirtyMinutes->modify('-30 minutes');

    // Convertir a formato deseado
    $fecha1 = $yesterday->format('Y-m-d H:i:s');
    $fecha2 = $today->format('Y-m-d H:i:s');
    $fechathirtyMinutes = $thirtyMinutes->format('Y-m-d H:i:s');
    // echo $fechathirtyMinutes;
    // Mostrar las fechas
    /*     echo "Fecha 1: $fecha1\n";
    echo "Fecha 2: $fecha2\n"; */

    // $pedidos = $pedidosModel->getList("(pedido_estado = 2 OR pedido_estado = 3 ) AND (pedido_response ='' OR pedido_response IS NULL)   AND (pedido_identificador ='' OR pedido_identificador IS NULL) AND (pedido_validacion ='' OR pedido_validacion IS NULL) AND (pedido_validacion_texto ='' OR pedido_validacion_texto IS NULL) AND (pedido_respuesta ='' OR pedido_respuesta IS NULL) AND (pedido_validacion2 ='' OR pedido_validacion2 IS NULL) AND pedido_fecha BETWEEN '$fecha1' AND '$fecha2' ");
    $pedidos = $pedidosModel->getList("((pedido_estado = 2 OR pedido_estado = 3) AND (pedido_response ='' OR pedido_response IS NULL) AND (pedido_identificador ='' OR pedido_identificador IS NULL) AND (pedido_validacion ='' OR pedido_validacion IS NULL) AND     (pedido_validacion_texto ='' OR pedido_validacion_texto IS NULL) AND     (pedido_respuesta ='' OR pedido_respuesta IS NULL) AND     (pedido_validacion2 ='' OR pedido_validacion2 IS NULL) AND     pedido_fecha BETWEEN '$fecha1' AND '$fecha2')
    OR     (pedido_estado = 4 AND pedido_fecha < '$fechathirtyMinutes')");

    // echo "<pre>";
    // print_r($pedidos);
    // echo "</pre>";
    /*   // Consultar pedidos con estado 4 y fecha al menos 1 hora antes


    //unir los dos arrays
    $pedidos = array_merge($pedidos, $pedidosEstado4);
 */
    foreach ($pedidos as $pedido) {
      $this->retornarInventario($pedido->pedido_id);
      $pedidosModel->editField($pedido->pedido_id, "pedido_estado", 8);
      $pedidosModel->editField($pedido->pedido_id, "pedido_validacion_texto", "Pedido cancelado por el sistema");

      //LOG
      $logModel = new Administracion_Model_DbTable_Log();
      $logData = [];
      $logData['log_usuario'] =  "Sistema";
      // Si los datos son válidos, guardar lo recibido
      $logData['log_log'] = "El pedido #" . $pedido->pedido_id . " ha sido cancelado por el sistema";
      $logData['log_tipo'] = 'Cancelar pedido';
      $logModel->insert($logData);
    }
  }
  public function retornarInventario($pedidoId)
  {

    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$pedidoId}'");

    foreach ($productos as $producto) {
      $productoDetalle = $productosModel->getById($producto->pedido_producto_producto);
      $nuevoStock = $productoDetalle->producto_stock + $producto->pedido_producto_cantidad;
      $productosModel->editField($producto->pedido_producto_producto, "producto_stock", $nuevoStock);
    }
  }

  public function continuar3Action()
  {
    // Establece el layout en blanco, útil si este método se llama mediante AJAX o requiere una salida mínima.
    $this->setLayout('blanco');
    //error_reporting(E_ALL);

    // Obtener ID del pedido desde los parámetros sanitizados
    $idPedido = $this->_getSanitizedParam('pedido_id');



    $json = '{"event":"transaction.updated","data":{"transaction":{"id":"1106153-1732571069-88868","created_at":"2024-11-25T21:44:30.312Z","finalized_at":"2024-11-25T21:44:32.172Z","amount_in_cents":53550000,"reference":"48","customer_email":"juansesdvsf@gmail.com","currency":"COP","payment_method_type":"CARD","payment_method":{"type":"CARD","extra":{"bin":"424242","name":"VISA-4242","brand":"VISA","exp_year":"29","card_type":"CREDIT","exp_month":"02","last_four":"4242","card_holder":"APPROVED","is_three_ds":true,"unique_code":"bbf3f7907db26da85ab4d57213a668ba9d519a3f773ff63b2ae7003393da95bc","three_ds_auth":{"three_ds_auth":{"current_step":"AUTHENTICATION","current_step_status":"COMPLETED"}},"three_ds_auth_type":null,"external_identifier":"7S8AqiZx2m","processor_response_code":"00"},"token":"tok_test_106153_D61082Da04a0ecf1de070fe4F9ba1277","installments":1},"status":"APPROVED","status_message":null,"shipping_address":{"address_line_1":"GUAINu00cdA, Inu00edrida, calle falsa 123","country":"CO","phone_number":"3124624763","city":"Inu00edrida","region":"GUAINu00cdA"},"redirect_url":"http://localhost:8043/page/comprar/respuesta","payment_source_id":null,"payment_link_id":null,"customer_data":{"legal_id":"12312312321-2","device_id":"6a31034b84d2c68a873185c237344831","full_name":"Juan Sebastiu00e1n Sandoval Vargas","phone_number":"+573124624763","legal_id_type":"NIT"},"billing_data":{"legal_id_type":"NIT","legal_id":"12312312321-2"}}},"sent_at":"2024-11-25T21:44:32.275Z","timestamp":1732571072,"signature":{"checksum":"7305d38a4889b6ebe390218c987e1db68474dbdbc83cf940bd528d7cfbeb696f","properties":["transaction.id","transaction.status","transaction.amount_in_cents"]},"environment":"test"}';

    // Inicialización de modelos
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $tiendaCategoria = new Administracion_Model_DbTable_Tiendacategorias();
    $departamentosModel = new Administracion_Model_DbTable_Departamentos();
    $municipiosModel = new Administracion_Model_DbTable_Municipios();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();

    // Obtener datos del usuario autenticado
    $usuario = $this->usuarioLogged();

    // Obtener el pedido asociado al ID proporcionado
    $pedido = $pedidosModel->getById($idPedido);

    $pedidosModel->editarResponse($idPedido, $json);

    /* // Validar que exista el ID del pedido y que el estado del pedido sea válido
    // if (!$idPedido || $pedido->pedido_estado != 1) {
    if (!$idPedido || !$pedido) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar'); // Redirigir en caso de error
      return;
    }


    Session::getInstance()->set("carrito", []);

    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$idPedido}'");

    foreach ($productos as $producto) {

      $productoDetalle = $productosModel->getById($producto->pedido_producto_producto);
      $producto->producto_categoriainfo = $tiendaCategoria->getById($productoDetalle->producto_categoria)->tienda_categoria_nombre;
      $producto->producto_imagen = $productoDetalle->producto_imagen;
    }

    $pedido->ciudad_nombre = $municipiosModel->getById($pedido->pedido_ciudad)->municipio;
    $pedido->departamento_nombre = $departamentosModel->getById($pedido->pedido_departamento)->departamento;

    $this->_view->pedido = $pedido;
    $this->_view->productos = $productos;


    $mailModel = new Core_Model_Sendingemail($this->_view);
    $mail = $mailModel->enviarCorreoTienda($idPedido); */
  }



  public function productosAction()
  {
    $this->setLayout('blanco');
    $productoModel =  new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $carrito = $this->getCarrito();
    if ($carrito) {

      $data = [];

      // Variables para acumuladores


      foreach ($carrito as $id => $cantidad) {

        $producto = $productoModel->getById($id);
        $producto->producto_categoriainfo = $categoriaModel->getById($producto->producto_categoria);

        // Precio original antes de descuento e IVA
        $precioOriginal = $producto->producto_precio;

        // Calcular el descuento
        $montoDescuento = $precioOriginal * $descuento / 100;

        // Precio después de aplicar el descuento
        $precioConDescuento = $precioOriginal - $montoDescuento;

        // Calcular IVA sobre el precio con descuento
        // $montoIva = $precioOriginal * $iva / 100;
        $montoIva = $precioConDescuento * $iva / 100;

        // Precio final con IVA aplicado
        $precioFinal = $precioConDescuento + $montoIva;



        $producto->producto_precio = $precioFinal;
        // Aplica el IVA al precio del producto después de aplicar el descuento
        $data[$id] = [];
        $data[$id]['detalle'] = $producto;
        $data[$id]['cantidad'] = (int)$cantidad;

        //calculando el total
        $data[$id]['total'] = $producto->producto_precio * $cantidad;
      }

      // print_r($data);

      $this->_view->carrito = $data;
    }
  }

  public function infoAction()
  {
    $this->setLayout('blanco');

    $productoModel =  new Administracion_Model_DbTable_Productos();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();

    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $carrito = $this->getCarrito();
    if ($carrito) {
      $data = [];

      // Variables para acumuladores
      $subtotalSinIva = 0;
      $totalDescuento = 0;
      $totalIva = 0;
      $totalConIvaYDescuento = 0;
      foreach ($carrito as $id => $cantidad) {

        $producto = $productoModel->getById($id);

        // Precio original antes de descuento e IVA
        $precioOriginal = $producto->producto_precio;

        // Calcular el descuento
        $montoDescuento = $precioOriginal * $descuento / 100;

        // Precio después de aplicar el descuento
        $precioConDescuento = $precioOriginal - $montoDescuento;

        // Calcular IVA sobre el precio con descuento
        // $montoIva = $precioOriginal * $iva / 100;
        $montoIva = $precioConDescuento * $iva / 100;


        // Precio final con IVA aplicado
        $precioFinal = $precioConDescuento + $montoIva;



        // Total por producto
        $data[$id]['total'] = $precioFinal * $cantidad;

        // Acumuladores
        $subtotalSinIva += $precioOriginal * $cantidad;      // Subtotal sin IVA ni descuento
        $totalDescuento += $montoDescuento * $cantidad;      // Total del descuento
        $totalIva += $montoIva * $cantidad;                  // Total del IVA
        $totalConIvaYDescuento += $data[$id]['total'];       // Total con IVA y descuento
      }


      // print_r($data);
      $this->_view->subtotalSinIva = $subtotalSinIva;
      $this->_view->totalDescuento = $totalDescuento;
      $this->_view->totalIva = $totalIva;
      $this->_view->totalConIvaYDescuento = $totalConIvaYDescuento;
      $this->_view->carrito = $data;
    }
  }

  public function info2Action()
  {

    $this->setLayout('blanco');
    $productoModel =  new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $carrito = $this->getCarrito();

    $data = [];

    // Variables para acumuladores


    foreach ($carrito as $id => $cantidad) {

      $producto = $productoModel->getById($id);
      $producto->producto_categoriainfo = $categoriaModel->getById($producto->producto_categoria);

      // Precio original antes de descuento e IVA
      $precioOriginal = $producto->producto_precio;

      // Calcular el descuento
      $montoDescuento = $precioOriginal * $descuento / 100;

      // Precio después de aplicar el descuento
      $precioConDescuento = $precioOriginal - $montoDescuento;

      // Calcular IVA sobre el precio con descuento
      // $montoIva = $precioOriginal * $iva / 100;
      $montoIva = $precioConDescuento * $iva / 100;

      // Precio final con IVA aplicado
      $precioFinal = $precioConDescuento + $montoIva;



      $producto->producto_precio = $precioFinal;
      // Aplica el IVA al precio del producto después de aplicar el descuento
      $data[$id] = [];
      $data[$id]['detalle'] = $producto;
      $data[$id]['cantidad'] = (int)$cantidad;

      //calculando el total
      $data[$id]['total'] = $producto->producto_precio * $cantidad;
    }

    // print_r($data);

    $this->_view->carrito = $data;
  }
}
/* 
      $producto->producto_precio -= $producto->producto_precio * $descuento / 100;
      // Aplica el IVA al precio del producto después de aplicar el descuento
      $producto->producto_precio *= 1 + $iva / 100;
 */