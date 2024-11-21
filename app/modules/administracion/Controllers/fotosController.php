<?php

/**
 * Controlador de Fotos que permite la  creacion, edicion  y eliminacion de los foto del Sistema
 */
class Administracion_fotosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos foto
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
	protected $_csrf_section = "administracion_fotos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador fotos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Fotos();
		$this->namefilter = "parametersfilterfotos";
		$this->route = "/administracion/fotos";
		$this->namepages = "pages_fotos";
		$this->namepageactual = "page_actual_fotos";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  foto con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de foto";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
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
		$this->_view->foto_album = $this->_getSanitizedParam("foto_album");
		$this->_view->foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$this->_view->foto_producto = $this->_getSanitizedParam("foto_producto");

		if ($this->_view->foto_solucion) {
			$solucionesModel = new Administracion_Model_DbTable_Soluciones();
			$solucion = $solucionesModel->getById($this->_view->foto_solucion);
			$this->_view->solucion = $solucion;
		}

		$this->_view->productos_list = $this->getProducts();
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  foto  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_fotos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->foto_album = $this->_getSanitizedParam("foto_album");
		$this->_view->foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$this->_view->foto_producto = $this->_getSanitizedParam("foto_producto");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->foto_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar foto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear foto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear foto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un foto  y redirecciona al listado de foto.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if ($_FILES['foto_foto']['name'] != '') {
				$data['foto_foto'] = $uploadImage->upload("foto_foto");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id, $id);
			$data['foto_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR FOTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$foto_album = $this->_getSanitizedParam("foto_album");
		$foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$foto_producto = $this->_getSanitizedParam("foto_producto");
		header('Location: ' . $this->route . '?foto_album=' . $foto_album . '&foto_solucion=' . $foto_solucion . '&foto_producto=' . $foto_producto . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un foto  y redirecciona al listado de foto.
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
			if ($content->foto_id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if ($_FILES['foto_foto']['name'] != '') {
					if ($content->foto_foto) {
						$uploadImage->delete($content->foto_foto);
					}
					$data['foto_foto'] = $uploadImage->upload("foto_foto");
				} else {
					$data['foto_foto'] = $content->foto_foto;
				}
				$this->mainModel->update($data, $id);
			}
			$data['foto_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR FOTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$foto_album = $this->_getSanitizedParam("foto_album");
		$foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$foto_producto = $this->_getSanitizedParam("foto_producto");
		header('Location: ' . $this->route . '?foto_album=' . $foto_album . '&foto_solucion=' . $foto_solucion . '&foto_producto=' . $foto_producto . '');
	}

	/**
	 * Recibe un identificador  y elimina un foto  y redirecciona al listado de foto.
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
					$uploadImage =  new Core_Model_Upload_Image();
					if (isset($content->foto_foto) && $content->foto_foto != '') {
						$uploadImage->delete($content->foto_foto);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR FOTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		$foto_album = $this->_getSanitizedParam("foto_album");
		$foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$foto_producto = $this->_getSanitizedParam("foto_producto");
		header('Location: ' . $this->route . '?foto_album=' . $foto_album . '&foto_solucion=' . $foto_solucion . '&foto_producto=' . $foto_producto . '');
	}

	public function cargamasivaAction()
	{

		
		$this->getLayout()->setTitle("Carga masiva de fotos");

		$this->_view->foto_solucion = $this->_getSanitizedParam("foto_solucion");
		if ($this->_view->foto_solucion) {
			$solucionesModel = new Administracion_Model_DbTable_Soluciones();
			$solucion = $solucionesModel->getById($this->_view->foto_solucion);
			$this->_view->solucion = $solucion;
		}
		$this->_view->foto_producto = $this->_getSanitizedParam("foto_producto");
	}

	public function uploadfotosAction()
	{
		$this->setLayout('blanco');
		$foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$foto_producto = $this->_getSanitizedParam("foto_producto");

		$data = [];

		$uploadImage =  new Core_Model_Upload_Image();
		if ($_FILES['fotos-file']['name'] != '') {
			$data['foto_foto'] = $uploadImage->upload("fotos-file");
		}
		if ($foto_solucion) {
			$data['foto_solucion'] = $foto_solucion;
		}
		if ($foto_producto) {
			$data['foto_producto'] = $foto_producto;
		}
		$data['foto_estado'] = 1;
		$data['foto_nombre'] = $this->removeExtension($data['foto_foto']);

		$response['ok'] = 1;
		$response['carga'] = $data['foto_foto'];


		$id = $this->mainModel->insert($data);
		$this->mainModel->changeOrder($id, $id);


		echo (json_encode($response));
	}

	public function removeExtension($filename)
	{
		return pathinfo($filename, PATHINFO_FILENAME);
	}

	public function getProducts()
	{
		$model = new Administracion_Model_DbTable_Productos();
		$products = $model->getList("producto_estado = 1", "producto_nombre ASC");
		$data = [];
		foreach ($products as $product) {
			$data[$product->producto_id] = $product->producto_nombre;
		}
		return $data;
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Fotos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['foto_estado'] = $this->_getSanitizedParam("foto_estado");
		$data['foto_nombre'] = $this->_getSanitizedParam("foto_nombre");
		$data['foto_foto'] = "";
		$data['foto_descripcion'] = $this->_getSanitizedParamHtml("foto_descripcion");
		$data['foto_album'] = $this->_getSanitizedParamHtml("foto_album");
		$data['foto_solucion'] = $this->_getSanitizedParamHtml("foto_solucion");
		$data['foto_producto'] = $this->_getSanitizedParamHtml("foto_producto");
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
		$foto_album = $this->_getSanitizedParam("foto_album");
		$filtros = $filtros . " AND foto_album = '$foto_album' ";
		$foto_solucion = $this->_getSanitizedParam("foto_solucion");
		$filtros = $filtros . " AND foto_solucion = '$foto_solucion' ";
		$foto_producto = $this->_getSanitizedParam("foto_producto");
		$filtros = $filtros . " AND foto_producto = '$foto_producto' ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->foto_estado != '') {
				$filtros = $filtros . " AND foto_estado LIKE '%" . $filters->foto_estado . "%'";
			}
			if ($filters->foto_nombre != '') {
				$filtros = $filtros . " AND foto_nombre LIKE '%" . $filters->foto_nombre . "%'";
			}
			if ($filters->foto_foto != '') {
				$filtros = $filtros . " AND foto_foto LIKE '%" . $filters->foto_foto . "%'";
			}
			if ($filters->foto_album != '') {
				$filtros = $filtros . " AND foto_album LIKE '%" . $filters->foto_album . "%'";
			}
			if ($filters->foto_solucion != '') {
				$filtros = $filtros . " AND foto_solucion LIKE '%" . $filters->foto_solucion . "%'";
			}
			if ($filters->foto_producto != '') {
				$filtros = $filtros . " AND foto_producto LIKE '%" . $filters->foto_producto . "%'";
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
			$parramsfilter['foto_estado'] =  $this->_getSanitizedParam("foto_estado");
			$parramsfilter['foto_nombre'] =  $this->_getSanitizedParam("foto_nombre");
			$parramsfilter['foto_foto'] =  $this->_getSanitizedParam("foto_foto");
			$parramsfilter['foto_album'] =  $this->_getSanitizedParam("foto_album");
			$parramsfilter['foto_solucion'] =  $this->_getSanitizedParam("foto_solucion");
			$parramsfilter['foto_producto'] =  $this->_getSanitizedParam("foto_producto");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
