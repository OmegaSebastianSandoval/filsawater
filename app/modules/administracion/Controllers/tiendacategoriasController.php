<?php
/**
* Controlador de Tiendacategorias que permite la  creacion, edicion  y eliminacion de los categor&iacute;as del Sistema
*/
class Administracion_tiendacategoriasController extends Administracion_mainController
{
	public $botonpanel = 8;

	/**
	 * $mainModel  instancia del modelo de  base de datos categor&iacute;as
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
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_tiendacategorias";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador tiendacategorias .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Tiendacategorias();
		$this->namefilter = "parametersfiltertiendacategorias";
		$this->route = "/administracion/tiendacategorias";
		$this->namepages ="pages_tiendacategorias";
		$this->namepageactual ="page_actual_tiendacategorias";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  categor&iacute;as con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de categor&iacute;as";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "orden ASC";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->tienda_categoria_padre = $this->_getSanitizedParam("tienda_categoria_padre");
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  categor&iacute;a  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_tiendacategorias_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->tienda_categoria_padre = $this->_getSanitizedParam("tienda_categoria_padre");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->tienda_categoria_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar categor&iacute;a";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear categor&iacute;a";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear categor&iacute;a";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un categor&iacute;a  y redirecciona al listado de categor&iacute;as.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if($_FILES['tienda_categoria_imagen']['name'] != ''){
				$data['tienda_categoria_imagen'] = $uploadImage->upload("tienda_categoria_imagen");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id,$id);
			$data['tienda_categoria_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR CATEGOR&IACUTE;A';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$tienda_categoria_padre = $this->_getSanitizedParam("tienda_categoria_padre");
		header('Location: '.$this->route.'?tienda_categoria_padre='.$tienda_categoria_padre.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un categor&iacute;a  y redirecciona al listado de categor&iacute;as.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->tienda_categoria_id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if($_FILES['tienda_categoria_imagen']['name'] != ''){
					if($content->tienda_categoria_imagen){
						$uploadImage->delete($content->tienda_categoria_imagen);
					}
					$data['tienda_categoria_imagen'] = $uploadImage->upload("tienda_categoria_imagen");
				} else {
					$data['tienda_categoria_imagen'] = $content->tienda_categoria_imagen;
				}
				$this->mainModel->update($data,$id);
			}
			$data['tienda_categoria_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR CATEGOR&IACUTE;A';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$tienda_categoria_padre = $this->_getSanitizedParam("tienda_categoria_padre");
		header('Location: '.$this->route.'?tienda_categoria_padre='.$tienda_categoria_padre.'');
	}

	/**
     * Recibe un identificador  y elimina un categor&iacute;a  y redirecciona al listado de categor&iacute;as.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadImage =  new Core_Model_Upload_Image();
					if (isset($content->tienda_categoria_imagen) && $content->tienda_categoria_imagen != '') {
						$uploadImage->delete($content->tienda_categoria_imagen);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR CATEGOR&IACUTE;A';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$tienda_categoria_padre = $this->_getSanitizedParam("tienda_categoria_padre");
		header('Location: '.$this->route.'?tienda_categoria_padre='.$tienda_categoria_padre.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Tiendacategorias.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['tienda_categoria_estado'] = $this->_getSanitizedParam("tienda_categoria_estado");
		$data['tienda_categoria_nombre'] = $this->_getSanitizedParam("tienda_categoria_nombre");
		$data['tienda_categoria_imagen'] = "";
		$data['tienda_categoria_descripcion'] = $this->_getSanitizedParamHtml("tienda_categoria_descripcion");
		$data['tienda_categoria_padre'] = $this->_getSanitizedParamHtml("tienda_categoria_padre");
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
		$tienda_categoria_padre= $this->_getSanitizedParam("tienda_categoria_padre");
		$filtros = $filtros." AND tienda_categoria_padre = '$tienda_categoria_padre' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->tienda_categoria_estado != '') {
                $filtros = $filtros." AND tienda_categoria_estado LIKE '%".$filters->tienda_categoria_estado."%'";
            }
            if ($filters->tienda_categoria_nombre != '') {
                $filtros = $filtros." AND tienda_categoria_nombre LIKE '%".$filters->tienda_categoria_nombre."%'";
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
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();
					$parramsfilter['tienda_categoria_estado'] =  $this->_getSanitizedParam("tienda_categoria_estado");
					$parramsfilter['tienda_categoria_nombre'] =  $this->_getSanitizedParam("tienda_categoria_nombre");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}