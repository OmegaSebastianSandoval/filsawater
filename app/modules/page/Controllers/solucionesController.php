<?php

class Page_solucionesController extends Page_mainController
{


  public $botonactivo  = 2;
  public $solucionId;

  public function init()
  {

    $this->solucionId =  $this->_getSanitizedParam("id");
    parent::init();
  }
  public function indexAction()
  {
    // Obtener el contenido y el banner de la sección 8
    $this->_view->contenido = $this->template->getContentseccion(8);
    $this->_view->banner = $this->template->banner(8);

    // Instanciar el modelo de 
    $solucionesModel = new Administracion_Model_DbTable_Soluciones();

    // Obtener y sanitizar el parámetro 'tag'
    $tag = $this->_getSanitizedParam("tag");

    // Definir el orden por defecto
    $order = "orden ASC";

    // Construir filtros basados en si existe o no un 'tag'
    $filters = "solucion_estado = 1 AND solucion_padre =''";
    if ($tag) {
      $filters = "solucion_estado = 1  AND solucion_padre ='' AND tags LIKE '%$tag%'";
      $this->_view->tag = $tag;
    }
    // Obtener la lista completa de  según los filtros y el orden
    $list = $solucionesModel->getList($filters, $order);

    // Configuración para la paginación
    $amount = 9; // Número de  por página
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
    $this->_view->soluciones = $solucionesModel->getListPages($filters, $order, $start, $amount);
  }

  public function solucionAction()
  {
    // Obtener el banner de la sección 8
    $this->_view->banner = $this->template->banner(8);

    // Instanciar el modelo de blogs
    $solucionesModel = new Administracion_Model_DbTable_Soluciones();


    // Obtener y sanitizar el parámetro 'id'
    $solucionId = $this->_getSanitizedParam("id");
    $this->_view->solucionId =  $solucionId;
    $padreId = $this->_getSanitizedParam("padre");

    // Obtener el blog por su ID
    $solucion = $solucionesModel->getById($solucionId);
    $this->_view->solucion = $solucion;

    if ($padreId) {
      $solucionPadre = $solucionesModel->getById($padreId);
      $this->_view->solucionPadre = $solucionPadre;
    }


    // traer las soluciones hijas
    $this->_view->contenidoHijo = $solucionesModel->getList("solucion_estado = 1 AND solucion_padre = $solucionId", "orden ASC");
   /*  echo "<pre>";
    print_r($this->_view->contenidoHijo );
    echo "</pre>"; */


    $this->_view->hayContenidoHijo = count($this->_view->contenidoHijo) >= 1 ? 1 : 0;



    // Traer imagenes del contenido

    $fotosModel = new Administracion_Model_DbTable_Fotos();
    $this->_view->fotos = $fotosModel->getList("foto_estado = 1 AND foto_solucion = $solucionId AND foto_album='' AND foto_producto = ''", "orden ASC");

    $this->_view->hayFotos = count($this->_view->fotos) >= 1 ? 1 : 0;


    //traer documentos

    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $documentos = $documentosModel->getList("documento_estado = 1 AND documento_solucion = $solucionId AND  (documento_padre IS NULL OR documento_padre='') ", "orden ASC");
    foreach ($documentos as $key => $documento) {
      $documento->documentosHijos = $documentosModel->getList("documento_estado = 1 AND documento_solucion = $solucionId AND documento_padre = " . $documento->documento_id, "orden ASC");
    }
    //traer los documentosNietos
    foreach ($documentos as $key => $documento) {
      foreach ($documento->documentosHijos as $key => $documentoHijo) {
        $documentoHijo->documentosNietos = $documentosModel->getList("documento_estado = 1 AND documento_solucion = $solucionId AND documento_padre = " . $documentoHijo->documento_id, "orden ASC");
      }
    }

    // echo "<pre>";
    // print_r($documentos);
    // echo "</pre>";
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
