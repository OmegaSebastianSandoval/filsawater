<?php

class Page_blogController extends Page_mainController
{

  protected $_csrf_section = "omega_index";
  public $botonactivo  = 5;

  public function indexAction()
  {
    // Obtener el contenido y el banner de la sección 8
    $this->_view->contenido = $this->template->getContentseccion(8);
    $this->_view->banner = $this->template->banner(8);

    // Instanciar el modelo de blogs
    $blogModel = new Administracion_Model_DbTable_Blogs();

    // Obtener y sanitizar el parámetro 'tag'
    $tag = $this->_getSanitizedParam("tag");

    // Definir el orden por defecto
    $order = "orden ASC";

    // Construir filtros basados en si existe o no un 'tag'
    $filters = "blog_estado = 1";
    if ($tag) {
      $filters = "blog_estado = 1 AND tags LIKE '%$tag%'";
      $this->_view->tag = $tag;
    }
    // Obtener la lista completa de blogs según los filtros y el orden
    $list = $blogModel->getList($filters, $order);

    // Configuración para la paginación
    $amount = 9; // Número de blogs por página
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
    $this->_view->blogs = $blogModel->getListPages($filters, $order, $start, $amount);

    // Obtener la lista de categorías de blog
    // $this->_view->list_blog_categoria_id = $this->getBlogcategoriaid();
  }


  public function detalleAction()
  {
    // Obtener el banner de la sección 8
    $this->_view->banner = $this->template->banner(8);

    // Instanciar el modelo de blogs
    $blogModel = new Administracion_Model_DbTable_Blogs();

    // Obtener y sanitizar el parámetro 'id'
    $blogId = $this->_getSanitizedParam("id");

    // Obtener el blog por su ID
    $blog = $blogModel->getById($blogId);
    $this->_view->blog = $blog;

    // Obtener blogs importantes, excluyendo el actual
    $blogsImportantes = $blogModel->getList(
      "blog_importante = 1 AND blog_estado = 1 AND blog_id != '{$blogId}'",
      "orden ASC LIMIT 4"
    );

    // Asignar los blogs importantes a la vista
    $this->_view->blogsImportantes = $blogsImportantes;

    // Obtener la lista de categorías de blog
    // $this->_view->list_blog_categoria_id = $this->getBlogcategoriaid();
  }


}
