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
    // $productos = $productosModel->getList("producto_categoria = '{$categoriaId}' AND producto_estado = 1 AND producto_stock>=1", "orden ASC");
    $productos = $productosModel->getList("producto_categoria = '{$categoriaId}' AND producto_estado = 1 ", "orden ASC");

    $this->_view->categoria = $categoria;
    $this->_view->productos = $productos;
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
        $html .= '<div class="container-file"> <a href="/files/' . $documento->documento_documento . '" target="_blank"> <i class="fa-solid fa-file"></i> ' . $documento->documento_nombre . ' - ' . $documento->documento_documento . '</a></div>';
      }
    }
    $html .= '</div>';
    return $html;
  }
}
