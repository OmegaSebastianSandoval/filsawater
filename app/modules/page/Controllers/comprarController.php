<?php

class Page_comprarController extends Page_mainController
{

  public $botonactivo  = 15;

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
    error_reporting(E_ALL);
    $productoModel =  new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    $confifModel = new Administracion_Model_DbTable_Config();
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productosPedidosModel = new Administracion_Model_DbTable_Productosporpedido();

    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $usuario = $this->usuarioLogged();
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje;
    $carrito = $this->getCarrito();

    //insertar el pedido y los productos, para continuar con la compra
    /*
	pedido_documento	v
	pedido_fecha	
	pedido_total			
	pedido_subtotal	float		
  pedido_procentaje_descuento	float
	pedido_procentaje_iva	
	pedido_descuento	float			
	pedido_iva	float			
	pedido_estado	varchar(255)	
	pedido_ciudad	varchar(255)	
	1pedido_direccion	varchar(255)	
	1pedido_correo	varchar(255)	
	1pedido_nombre	varchar(255)	
	1pedido_telefono	varchar(255)	
	1pedido_respuesta	text	
	1pedido_validacion	varchar(255)	
	1pedido_validacion2	varchar(255)	
	1pedido_entidad	varchar(255)	
	1pedido_porcentaje_iv */

    $dataPedido = [];
    $dataPedido["pedido_documento"] = $usuario->user_cedula;
    $dataPedido["pedido_fecha"] = date('Y-m-d H:i:s');
    $dataPedido["pedido_nombre"] = $usuario->user_names;
    $dataPedido["pedido_telefono"] = $usuario->user_telefono;
    $dataPedido["pedido_correo"] = $usuario->user_email;

    $dataPedido["pedido_subtotal"] = $this->_getSanitizedParam('subtotal');
    $dataPedido["pedido_procentaje_descuento"] = $descuento;
    $dataPedido["pedido_porcentaje_iva"] = $iva;
    $dataPedido["pedido_descuento"] = $this->_getSanitizedParam('descuento');
    $dataPedido["pedido_iva"] = $this->_getSanitizedParam('iva');
    $dataPedido["pedido_total"] = $this->_getSanitizedParam('total');
    $dataPedido["pedido_estado"] = 1;


    $idPedido = $pedidosModel->insert($dataPedido);

    if (!$idPedido) {
      Session::getInstance()->set("error_compra", "Error al guardar el pedido");
      header('Location: /page/comprar');
      return;
    }


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

      $producto->producto_precio = $precioFinal;


      // Datos del producto
      $data[$id] = [];
      $data[$id]['detalle'] = $producto;
      $data[$id]['cantidad'] = (int)$cantidad;

      // Total por producto
      $data[$id]['total'] = $producto->producto_precio * $cantidad;

      $dataProductoPedido = [];
      $dataProductoPedido["pedido_producto_pedido"] = $idPedido;
      $dataProductoPedido["pedido_producto_producto"] = $producto->producto_id;
      $dataProductoPedido["pedido_producto_nombre"] = $producto->producto_nombre;
      $dataProductoPedido["pedido_producto_cantidad"] = (int)$cantidad;
      $dataProductoPedido["pedido_producto_valor"] = $precioOriginal;
      $dataProductoPedido["pedido_producto_iva"] = $iva;
      $dataProductoPedido["pedido_producto_valor_iva"] = $montoIva;
      $dataProductoPedido["pedido_producto_descuento"] = $descuento;
      $dataProductoPedido["pedido_producto_valor_descuento"] = $montoDescuento;
      $dataProductoPedido["pedido_producto_precio_final"] = (int)$cantidad * $precioFinal;

      $idPedidoProducto = $productosPedidosModel->insert($dataProductoPedido);
    }
    if (!$idPedidoProducto) {
      Session::getInstance()->set("error_compra", "Error al guardar el pedido");
      header('Location: /page/comprar');
      return;
    }
    header('Location: /page/comprar/direccion?id=' . $idPedido);
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
}
/* 
      $producto->producto_precio -= $producto->producto_precio * $descuento / 100;
      // Aplica el IVA al precio del producto después de aplicar el descuento
      $producto->producto_precio *= 1 + $iva / 100;
 */