<?php

class Page_productosController extends Page_mainController
{


  public $botonactivo  = 3;
  public $categoriaHeader;


  public function init()
  {

    $this->categoriaHeader =  $this->_getSanitizedParam("categoria");

    parent::init();
  }
  public function indexAction()
  {
    $productosModel = new Administracion_Model_DbTable_Productos();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la información del usuario actualmente logueado
    $usuario = $this->usuarioLogged();
    // Obtiene el nivel del cliente del usuario logueado para calcular el descuento
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje; // Porcentaje de descuento basado en el nivel del cliente

    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA
    $filters = "producto_estado = 1 AND producto_stock >= 1 AND producto_precio >= 500";
    $order = "orden ASC";
    $list = $productosModel->getList($filters, $order);

    // Configuración para la paginación
    $amount = 12; // Número de  por página
    $page = $this->_getSanitizedParam("page");

    if (!$page) {
      $start = 0;
      $page = 1;
    } else {
      $start = ($page - 1) * $amount;
    }

    // Calcular el total de páginas
    $this->_view->totalpages = ceil(count($list) / $amount);
    $this->_view->page = $page;

    // Obtener los blogs para la página actual
    $productos = $productosModel->getListPages($filters, $order, $start, $amount);

    // Recorre la lista de productos para aplicar el descuento y el IVA al precio de cada producto
    foreach ($productos as $key => $producto) {
      /*  // Aplica el IVA al precio del producto después de aplicar el descuento
      $producto->producto_precio *= 1 + $iva / 100;
      // Aplica el descuento al precio del producto
      $producto->producto_precio -= $producto->producto_precio * $descuento / 100; */
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

      //$precioFinal = $precioConDescuento;

      $producto->producto_precio = $precioFinal;
    }



    // Asigna la lista de productos modificados al atributo de vista
    $this->_view->productos = $productos;

    // Obtiene y asigna los productos destacados al atributo de vista
    $this->_view->productosDestacados = $this->template->productosDestacados();
  }
  public function categoriaAction()
  {
    // Obtiene el parámetro 'categoria' de la solicitud, asegurándose de que esté sanitizado para evitar inyecciones
    $categoriaId = $this->_getSanitizedParam("categoria");

    // Instancia de los modelos de categorías, productos y niveles de cliente
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $nivelesModel = new Administracion_Model_DbTable_Niveles();

    // Obtiene la información de la categoría seleccionada por su ID
    $categoria = $categoriaModel->getById($categoriaId);

    // Obtiene la lista de productos que pertenecen a la categoría seleccionada, 
    // filtrando por productos activos (estado = 1), ordenados por el campo 'orden' en orden ascendente.
    // Se comenta el filtrado por stock mínimo mayor o igual a 1, para que traiga todos los productos activos sin importar el stock



    $filters = "producto_categoria = '{$categoriaId}' AND producto_estado = 1 AND producto_stock >= 1 AND producto_precio >= 500";
    $order = "orden ASC";
    $list = $productosModel->getList($filters, $order);

    // Configuración para la paginación
    $amount = 12; // Número de  por página
    $page = $this->_getSanitizedParam("page");

    if (!$page) {
      $start = 0;
      $page = 1;
    } else {
      $start = ($page - 1) * $amount;
    }

    // Calcular el total de páginas
    $this->_view->totalpages = ceil(count($list) / $amount);
    $this->_view->page = $page;

    // Obtener los blogs para la página actual
    $productos = $productosModel->getListPages($filters, $order, $start, $amount);


    // Obtiene la información del usuario actualmente logueado
    $usuario = $this->usuarioLogged();

    // Obtiene el nivel del cliente del usuario logueado para calcular el descuento
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje; // Porcentaje de descuento basado en el nivel del cliente

    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
    $iva = $config->configuracion_iva; // Porcentaje de IVA

    // Recorre la lista de productos para aplicar el descuento y el IVA al precio de cada producto
    foreach ($productos as $key => $producto) {
      /*  // Aplica el IVA al precio del producto después de aplicar el descuento
      $producto->producto_precio *= 1 + $iva / 100;
      // Aplica el descuento al precio del producto
      $producto->producto_precio -= $producto->producto_precio * $descuento / 100; */
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
      //$precioFinal = $precioConDescuento;

      $producto->producto_precio = $precioFinal;
    }

    // Asigna la categoría obtenida al atributo de vista para su uso en la plantilla
    $this->_view->categoria = $categoria;

    // Asigna la lista de productos modificados al atributo de vista
    $this->_view->productos = $productos;

    // Obtiene y asigna los productos destacados al atributo de vista
    $this->_view->productosDestacados = $this->template->productosDestacados();
  }

  public function productoAction()
  {
    $productoId = $this->_getSanitizedParam("producto");
    $categoriaId = $this->_getSanitizedParam("categoria");

    $productosModel = new Administracion_Model_DbTable_Productos();
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();

    $fotosModel = new Administracion_Model_DbTable_Fotos();

    // Obtener los datos del producto
    $producto = $productosModel->getById($productoId);
    $categoria = $categoriaModel->getById($categoriaId);


    // Obtener las fotos asociadas al producto
    $fotos = $fotosModel->getList("foto_producto = '{$productoId}' AND foto_estado='1'", "orden ASC");

    // Crear un arreglo con la imagen principal al inicio y luego las fotos
    $productoImagen = (object)[
      "foto_id" => "principal",
      "foto_foto" => $producto->producto_imagen,
      "foto_nombre" => "Imagen principal del producto"
    ];

    if (!empty($fotos)) {

      // Combina la imagen principal con el resto de las fotos
      array_unshift($fotos, $productoImagen);

      // Asigna las fotos al producto
      $producto->fotos = $fotos;
    } else {
      $producto->fotos = [$productoImagen];
    }
    //
    //traer documentos

    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $documentos = $documentosModel->getList("documento_estado = 1 AND documento_producto = $productoId AND  (documento_padre IS NULL OR documento_padre='') ", "orden ASC");
    foreach ($documentos as $key => $documento) {
      $documento->documentosHijos = $documentosModel->getList("documento_estado = 1 AND documento_producto = $productoId AND documento_padre = " . $documento->documento_id, "orden ASC");
    }
    //traer los documentosNietos
    foreach ($documentos as $key => $documento) {
      foreach ($documento->documentosHijos as $key => $documentoHijo) {
        $documentoHijo->documentosNietos = $documentosModel->getList("documento_estado = 1 AND documento_producto = $productoId AND documento_padre = " . $documentoHijo->documento_id, "orden ASC");
      }
    }

    //ajuustar el precio del producto con el descuento 
    $nivelesModel = new Administracion_Model_DbTable_Niveles();
    // Obtiene la información del usuario actualmente logueado
    $usuario = $this->usuarioLogged();
    // Obtiene el nivel del cliente del usuario logueado para calcular el descuento
    $nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
    $descuento = $nivel->nivel_porcentaje; // Porcentaje de descuento basado en el nivel del cliente

    // Obtiene la configuración general del sistema para acceder al porcentaje de IVA
    $confifModel = new Administracion_Model_DbTable_Config();
    $config = $confifModel->getById(1);
     $iva = $config->configuracion_iva; // Porcentaje de IVA
     $producto->producto_precio *= 1 + $iva / 100;
    $producto->producto_precio -= $producto->producto_precio * $descuento / 100;
    // print_r($producto);
    // Muestra o envía el producto con sus fotos
    $this->_view->producto = $producto;
    $this->_view->categoria = $categoria;
    $this->_view->productosDestacados = $this->template->productosDestacados();
    $this->_view->documentos = $this->generarHTMLDocumentos($documentos);
    $this->_view->hayDocumentos = count($documentos) >= 1 ? 1 : 0;
  }

  public function generarHTMLDocumentos($documentos, $nivel = 0)
  {
    $accordionId = 'accordionNivel' . $nivel;
    $html = '<div class="accordion accordion-files" id="' . $accordionId . '">';
    foreach ($documentos as $index => $documento) {
      $collapseId = 'collapse' . $nivel . '-' . $index;
      if (empty($documento->documento_documento)) {
        // Es una carpeta
        $html .= '
                <div class="accordion-item">
                    <h4 class="accordion-header" id="heading' . $collapseId . '">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
                            <i class="fa-solid fa-folder"></i> ' . $documento->documento_nombre . '
                        </button>
                    </h4>
                    <div id="' . $collapseId . '" class="accordion-collapse collapse" aria-labelledby="heading' . $collapseId . '" data-bs-parent="#' . $accordionId . '">
                        <div class="accordion-body">';
        // Llamada recursiva para generar documentos hijos
        if (!empty($documento->documentosHijos) || !empty($documento->documentosNietos)) {
          $hijos = !empty($documento->documentosHijos) ? $documento->documentosHijos : $documento->documentosNietos;
          $html .= $this->generarHTMLDocumentos($hijos, $nivel + 1);
        }
        $html .= '</div></div></div>';
      } else {
        // Es un archivo
        $html .= '<div class="container-file"> <a href="/files/' . $documento->documento_documento . '" target="_blank"> <i class="fa-solid fa-file"></i> ' . $documento->documento_nombre . '</a></div>';
      }
    }
    $html .= '</div>';
    return $html;
  }
}
