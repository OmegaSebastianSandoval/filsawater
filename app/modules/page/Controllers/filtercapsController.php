<?php

class Page_filtercapsController extends Page_mainController
{

  public $botonactivo  = 6;

  public function indexAction()
  {
    // Obtener el banner de la sección 8
    $this->_view->banner = $this->template->banner(9);
    $this->_view->contenido = $this->template->getContentseccion(9);


    // Instanciar el modelo de blogs
    $blogModel = new Administracion_Model_DbTable_Blogs();

    // Obtener y sanitizar el parámetro 'id'
    $blogId = $this->_getSanitizedParam("id");



    // Obtener blogs importantes, excluyendo el actual
    $blogsImportantes = $blogModel->getList(
      "blog_importante = 1 AND blog_estado = 1 ",
      "orden ASC LIMIT 4"
    );

    // Asignar los blogs importantes a la vista
    $this->_view->blogsImportantes = $blogsImportantes;

    
  }



}
