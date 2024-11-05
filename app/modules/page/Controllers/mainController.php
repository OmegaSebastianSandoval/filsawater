<?php

/**
 *
 */

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{
		$this->setLayout('page_page');
		$this->_view->botonactivo = $this->botonactivo;
		$this->_view->solucionId = $this->solucionId;

		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();

		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;

		// Obtener la lista de categorías de blog
		$this->_view->list_blog_categoria_id = $this->getCategoriasSoluciones();

		$usuario = Session::getInstance()->get("usuario");
		$this->_view->usuario = $usuario;
		

		$this->getLayout()->setData("meta_description", "$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords", "$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts", "$informacion->info_pagina_scripts");
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		$this->_view->botones = $publicidadModel->getList("publicidad_seccion='3' AND publicidad_estado='1'", "orden ASC");
		$this->_view->popup = $publicidadModel->getList("publicidad_seccion='101' AND publicidad_estado=1", "")[0];

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);
		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("", "orden ASC");
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);
		$adicionales = $this->_view->getRoutPHP('modules/page/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales", $adicionales);
		$this->usuario();
	}


	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
	}

	/**
	 * Genera un array con los valores del campo categoría.
	 *
	 * @return array Arreglo con los IDs y nombres de las categorías.
	 */
	public function getCategoriasSoluciones()
	{
		// Instanciar el modelo de categorías
		$modelData = new Administracion_Model_DbTable_Soluciones();

		// Obtener la lista de categorías
		$data = $modelData->getList("solucion_estado = 1 AND solucion_padre =''", "orden ASC");

		// Crear un array asociativo [categoria_id => categoria_nombre]
		$array = array_column($data, 'solucion_categoria', 'solucion_id');

		return $array;
	}
}
