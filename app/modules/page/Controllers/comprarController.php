<?php

class Page_comprarController extends Page_mainController
{

  public $botonactivo  = 15;
  public function init()
  {

    //si no existe un usuario activo llevar al paso 1
    if (!Session::getInstance()->get('usuario')) {
      // header("Location: /");
    }
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
    $pedido->ciudad_nombre = $municipiosModel->getById($pedido->pedido_ciudad)->municipio;
    $pedido->departamento_nombre = $departamentosModel->getById($pedido->pedido_departamento)->departamento;
    $pedido->pedido_tipo_documento  = "NIT";
    $pedido->pedido_pais  = "CO";
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$idPedido}'");
    $total = $pedido->pedido_total;


    /* 	$placetopay = Payment_Placetopay::getInstance()->getPlacetopay();
		$placetopayData = Payment_Placetopay::getInstance()->getData(); */

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
    echo "referencia: " . $reference;
    echo "<br>";
    echo "total: " . intval($total * 100);
    echo "<br>";
    echo "moneda: " . $moneda;
    echo "<br>";
    echo "fechaExpiracion: " . $fechaExpiracion;
    echo "<br>";
    echo "integrity: " . $integrity;
    echo "<br>";

    // $cadena = $reference . intval($total) . $moneda . $integrity;
    echo "Cadena: " . $cadena;
    echo "<br>";

    $cadenaHash = hash("sha256", $cadena);

    echo "Cadena encriptada: " . $cadenaHash;
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
    $this->setLayout("blanco");
    $id = $this->_getSanitizedParam("id");
    $response = $this->consultarVentaById($id);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    /* stdClass Object ( [data] => stdClass Object ( [id] => 1106153-1732242821-22096 [created_at] => 2024-11-22T02:33:45.034Z [finalized_at] => 2024-11-22T02:33:45.648Z [amount_in_cents] => 53550000 [reference] => 22 [currency] => COP [payment_method_type] => CARD [payment_method] => stdClass Object ( [type] => CARD [extra] => stdClass Object ( [name] => VISA-4242 [brand] => VISA [card_type] => CREDIT [last_four] => 4242 [is_three_ds] => 1 [three_ds_auth] => stdClass Object ( [three_ds_auth] => stdClass Object ( [current_step] => AUTHENTICATION [current_step_status] => COMPLETED ) ) [three_ds_auth_type] => [external_identifier] => iCR7Fi2CZS [processor_response_code] => 00 ) [installments] => 1 ) [payment_link_id] => [redirect_url] => http://localhost:8043/page/comprar/respuesta [status] => APPROVED [status_message] => [merchant] => stdClass Object ( [id] => 106153 [name] => JUMACATA SAS [legal_name] => JUMACATA SAS [contact_name] => MARTHA ISABEL MELO AVENDAÑO [phone_number] => +573115108984 [logo_url] => [legal_id_type] => NIT [email] => jumacata.sas@gmail.com [legal_id] => 901108494-9 [public_key] => pub_test_IgJV5KZuyaM9JRr037F84I12pgvKJ1T9 ) [taxes] => Array ( [0] => stdClass Object ( [type] => VAT [amount_in_cents] => 8550000 ) ) [tip_in_cents] => ) [meta] => stdClass Object ( ) )
 */
    /* http://localhost:8043/page/comprar/respuesta?id=1106153-1732247192-17654&env=test */
    /* http://localhost:8043/page/comprar/respuesta?id=1106153-1732243356-63688&env=test */
    /* http://localhost:8043/page/comprar/respuesta?id=1106153-1732283305-81883&env=test */

    /* http://localhost:8043/page/comprar/respuesta?id=1106153-1732283664-17975&env=test */
  }
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
  public function confirmacionAction()
  {
    // Leer el cuerpo de la solicitud (JSON enviado por Wompi)
    $payload = file_get_contents('php://input');

    // Intentar decodificar el JSON
    $dataReceived = json_decode($payload, true);

    // Preparar el log
    $logData = [];
    if ($dataReceived) {
      // Si los datos son válidos, guardar lo recibido
      $logData['log_log'] = print_r($dataReceived, true);
      $logData['log_tipo'] = 'DATOS RECIBIDOS DE WOMPI';
    } else {
      // Si no se pudo decodificar, registrar el cuerpo como texto
      $logData['log_log'] = $payload;
      $logData['log_tipo'] = 'ENTRO CONFIRMACION (NO SE PUDO DECODIFICAR)';
    }

    // Insertar el log en la base de datos
    $logModel = new Administracion_Model_DbTable_Log();
    $logModel->insert($logData);

    // Responder a Wompi
    http_response_code(200);
    echo json_encode(['message' => 'Evento recibido correctamente']);
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
    // error_reporting(E_ALL);

    // Obtener ID del pedido desde los parámetros sanitizados
    $idPedido = $this->_getSanitizedParam('pedido_id');

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

    // Validar que exista el ID del pedido y que el estado del pedido sea válido
    // if (!$idPedido || $pedido->pedido_estado != 1) {
    if (!$idPedido || !$pedido) {
      Session::getInstance()->set("error_compra", "Error al continuar con la compra");
      header('Location: /page/comprar'); // Redirigir en caso de error
      return;
    }

    $pedido = $pedidosModel->getById($idPedido);
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$idPedido}'");

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

    $mailModel = new Core_Model_Sendingemail($this->_view);
    $mail = $mailModel->enviarCorreoTienda($pedido, $productos, $usuario);
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