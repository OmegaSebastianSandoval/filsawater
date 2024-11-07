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
  public function indexAction() {}
  public function categoriaAction()
  {
    $categoriaId = $this->_getSanitizedParam("categoria");
    $categoriaModel = new Administracion_Model_DbTable_Tiendacategorias();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $categoria = $categoriaModel->getById($categoriaId);
    $productos = $productosModel->getList("producto_categoria = '{$categoriaId}' AND producto_estado = 1 AND producto_stock>=1", "orden ASC");
    $this->_view->categoria = $categoria;
    $this->_view->productos = $productos;
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
    // print_r($producto);
    // Muestra o envía el producto con sus fotos
    $this->_view->producto = $producto;
    $this->_view->categoria = $categoria;
  }
}
