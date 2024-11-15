<?php

class Page_comprarController extends Page_mainController
{

  public $botonactivo  = 15;

  public function indexAction()
  {
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

    $this->_view->carrito = $data;
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


      //debug
      if ($_GET["prueba"] == 1) {
        echo "precio: " . $producto->producto_precio;
        echo "<br>";
        echo "descuento: " . $descuento;
        echo "<br>";
        echo "iva: " . $iva;
        echo "<br>";
        echo "precioOriginal: " . $precioOriginal;
        echo "<br>";
        echo "montoDescuento: " . $montoDescuento;
        echo "<br>";
        echo "precioConDescuento: " . $precioConDescuento;
        echo "<br>";
        echo "montoIva: " . $montoIva;
        echo "<br>";
        echo "precioFinal: " . $precioFinal;
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
      }

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