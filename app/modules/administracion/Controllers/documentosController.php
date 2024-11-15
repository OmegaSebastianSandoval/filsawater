<?php

/**
 * Controlador de Documentos que permite la  creacion, edicion  y eliminacion de los documento del Sistema
 */
class Administracion_documentosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos documento
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_documentos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador documentos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Documentos();
		$this->namefilter = "parametersfilterdocumentos";
		$this->route = "/administracion/documentos";
		$this->namepages = "pages_documentos";
		$this->namepageactual = "page_actual_documentos";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  documento con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de documento";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		// echo $filters;
		$order = "orden ASC";
		$list = $this->mainModel->getList($filters, $order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
			$page = Session::getInstance()->get($this->namepageactual);
			$start = ($page - 1) * $amount;
		} else if (!$page) {
			$start = 0;
			$page = 1;
			Session::getInstance()->set($this->namepageactual, $page);
		} else {
			Session::getInstance()->set($this->namepageactual, $page);
			$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list) / $amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->documento_solucion = $this->_getSanitizedParam("documento_solucion");
		$this->_view->documento_padre = $this->_getSanitizedParam("documento_padre");
		$this->_view->documento_producto = $this->_getSanitizedParam("documento_producto");
		if ($this->_view->documento_solucion) {
			$solucionesModel = new Administracion_Model_DbTable_Soluciones();
			$solucion = $solucionesModel->getById($this->_view->documento_solucion);
			// print_r($solucion);
			$this->_view->solucion = $solucion;
		}
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  documento  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_documentos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->documento_solucion = $this->_getSanitizedParam("documento_solucion");
		$this->_view->documento_padre = $this->_getSanitizedParam("documento_padre");
		$this->_view->documento_producto = $this->_getSanitizedParam("documento_producto");

		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->documento_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar documento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear documento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear documento";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un documento  y redirecciona al listado de documento.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if ($_FILES['documento_documento']['name'] != '') {
				$data['documento_documento'] = $uploadDocument->upload("documento_documento");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id, $id);
			$data['documento_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR DOCUMENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$documento_solucion = $this->_getSanitizedParam("documento_solucion");
		$documento_padre = $this->_getSanitizedParam("documento_padre");
		$documento_producto = $this->_getSanitizedParam("documento_producto");

		header('Location: ' . $this->route . '?documento_solucion=' . $documento_solucion . '&documento_padre=' . $documento_padre . '&documento_producto=' . $documento_producto . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un documento  y redirecciona al listado de documento.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->documento_id) {
				$data = $this->getData();
				$uploadDocument =  new Core_Model_Upload_Document();
				if ($_FILES['documento_documento']['name'] != '') {
					if ($content->documento_documento) {
						$uploadDocument->delete($content->documento_documento);
					}
					$data['documento_documento'] = $uploadDocument->upload("documento_documento");
				} else {
					$data['documento_documento'] = $content->documento_documento;
				}
				$this->mainModel->update($data, $id);
			}
			$data['documento_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR DOCUMENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$documento_solucion = $this->_getSanitizedParam("documento_solucion");
		$documento_padre = $this->_getSanitizedParam("documento_padre");
		$documento_producto = $this->_getSanitizedParam("documento_producto");

		header('Location: ' . $this->route . '?documento_solucion=' . $documento_solucion . '&documento_padre=' . $documento_padre . '&documento_producto=' . $documento_producto . '');
	}

	/**
	 * Recibe un identificador  y elimina un documento  y redirecciona al listado de documento.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->documento_documento) && $content->documento_documento != '') {
						$uploadDocument->delete($content->documento_documento);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR DOCUMENTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		$documento_solucion = $this->_getSanitizedParam("documento_solucion");
		$documento_padre = $this->_getSanitizedParam("documento_padre");
		$documento_producto = $this->_getSanitizedParam("documento_producto");

		header('Location: ' . $this->route . '?documento_solucion=' . $documento_solucion . '&documento_padre=' . $documento_padre . '&documento_producto=' . $documento_producto . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Documentos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['documento_estado'] = $this->_getSanitizedParam("documento_estado");
		$data['documento_nombre'] = $this->_getSanitizedParam("documento_nombre");
		$data['documento_documento'] = "";
		$data['documento_solucion'] = $this->_getSanitizedParamHtml("documento_solucion");
		$data['documento_producto'] = $this->_getSanitizedParamHtml("documento_producto");
		$data['documento_padre'] = $this->_getSanitizedParamHtml("documento_padre");
		return $data;
	}
	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		$documento_solucion = $this->_getSanitizedParam("documento_solucion");
		if ($documento_solucion) {

			$filtros = $filtros . " AND documento_solucion = '$documento_solucion' ";
		}
		$documento_producto = $this->_getSanitizedParam("documento_producto");
		if ($documento_producto) {
			$filtros = $filtros . " AND documento_producto = '$documento_producto' ";
		}
		$documento_padre = $this->_getSanitizedParam("documento_padre");
		if ($documento_padre) {
			$filtros = $filtros . " AND documento_padre = '$documento_padre' ";
		} else {
			$filtros = $filtros . " AND (documento_padre IS NULL OR documento_padre = '') ";
		}

		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->documento_estado != '') {
				$filtros = $filtros . " AND documento_estado LIKE '%" . $filters->documento_estado . "%'";
			}
			if ($filters->documento_nombre != '') {
				$filtros = $filtros . " AND documento_nombre LIKE '%" . $filters->documento_nombre . "%'";
			}
			if ($filters->documento_documento != '') {
				$filtros = $filtros . " AND documento_documento LIKE '%" . $filters->documento_documento . "%'";
			}
		}
		return $filtros;
	}

	/**
	 * Recibe y asigna los filtros de este controlador
	 *
	 * @return void
	 */
	protected function filters()
	{
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			$parramsfilter['documento_estado'] =  $this->_getSanitizedParam("documento_estado");
			$parramsfilter['documento_nombre'] =  $this->_getSanitizedParam("documento_nombre");
			$parramsfilter['documento_documento'] =  $this->_getSanitizedParam("documento_documento");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
