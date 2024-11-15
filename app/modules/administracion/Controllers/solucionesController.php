<?php
/**
* Controlador de Soluciones que permite la  creacion, edicion  y eliminacion de los soluci&oacute;n del Sistema
*/
class Administracion_solucionesController extends Administracion_mainController
{

	public $botonpanel = 7;

	/**
	 * $mainModel  instancia del modelo de  base de datos soluci&oacute;n
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
	protected $_csrf_section = "administracion_soluciones";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador soluciones .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Soluciones();
		$this->namefilter = "parametersfiltersoluciones";
		$this->route = "/administracion/soluciones";
		$this->namepages ="pages_soluciones";
		$this->namepageactual ="page_actual_soluciones";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  soluci&oacute;n con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de soluci&oacute;n";
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
		$this->_view->padre = $this->_getSanitizedParam("padre");
		if($this->_getSanitizedParam("padre")){
			$this->_view->padreContenido = $this->mainModel->getById($this->_getSanitizedParam("padre"));
		}
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  soluci&oacute;n  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_soluciones_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->padre = $this->_getSanitizedParam("padre");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->solucion_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar soluci&oacute;n";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear soluci&oacute;n";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear soluci&oacute;n";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un soluci&oacute;n  y redirecciona al listado de soluci&oacute;n.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if($_FILES['solucion_imagen']['name'] != ''){
				$data['solucion_imagen'] = $uploadImage->upload("solucion_imagen");
			}
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['solucion_archivo']['name'] != ''){
				$data['solucion_archivo'] = $uploadDocument->upload("solucion_archivo");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id,$id);
			$data['solucion_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SOLUCI&OACUTE;N';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$padre = $this->_getSanitizedParam("solucion_padre");
		header('Location: '.$this->route.'?padre='.$padre.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un soluci&oacute;n  y redirecciona al listado de soluci&oacute;n.
     *
     * @return void.
     */
	public function updateAction(){
		//error_reporting(E_ALL);	
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->solucion_id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if($_FILES['solucion_imagen']['name'] != ''){
					// print_r($_FILES);
					

					if($content->solucion_imagen){

						$uploadImage->delete($content->solucion_imagen);
					}
					
					$data['solucion_imagen'] = $uploadImage->upload("solucion_imagen");
				} else {

					$data['solucion_imagen'] = $content->solucion_imagen;
				}
				$uploadDocument =  new Core_Model_Upload_Document();
				if($_FILES['solucion_archivo']['name'] != ''){
					if($content->solucion_archivo){
						$uploadDocument->delete($content->solucion_archivo);
					}
					$data['solucion_archivo'] = $uploadDocument->upload("solucion_archivo");
				} else {
					$data['solucion_archivo'] = $content->solucion_archivo;
				}
				// print_r($data);
				$this->mainModel->update($data,$id);
			}
			$data['solucion_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR SOLUCI&OACUTE;N';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$padre = $this->_getSanitizedParam("solucion_padre");
		header('Location: '.$this->route.'?padre='.$padre.'');
	}

	/**
     * Recibe un identificador  y elimina un soluci&oacute;n  y redirecciona al listado de soluci&oacute;n.
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
					if (isset($content->solucion_imagen) && $content->solucion_imagen != '') {
						$uploadImage->delete($content->solucion_imagen);
					}
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->solucion_archivo) && $content->solucion_archivo != '') {
						$uploadDocument->delete($content->solucion_archivo);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR SOLUCI&OACUTE;N';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$padre = $this->_getSanitizedParam("padre");
		header('Location: '.$this->route.'?padre='.$padre.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Soluciones.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['solucion_titulo'] = $this->_getSanitizedParam("solucion_titulo");
		$data['solucion_categoria'] = $this->_getSanitizedParam("solucion_categoria");
		$data['solucion_imagen'] = "";
		$data['solucion_descripcion'] = $this->_getSanitizedParamHtml("solucion_descripcion");
		$data['solucion_introduccion'] = $this->_getSanitizedParamHtml("solucion_introduccion");
		$data['solucion_contenido'] = $this->_getSanitizedParamHtml("solucion_contenido");
		$data['solucion_estado'] = $this->_getSanitizedParam("solucion_estado");
		$data['solucion_padre'] = $this->_getSanitizedParamHtml("solucion_padre");
		$data['solucion_archivo'] = "";
		$data['solucion_tags'] = $this->_getSanitizedParam("solucion_tags");
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
		$padre= $this->_getSanitizedParam("padre");
		$filtros = $filtros." AND solucion_padre = '$padre' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->solucion_titulo != '') {
                $filtros = $filtros." AND solucion_titulo LIKE '%".$filters->solucion_titulo."%'";
            }
            if ($filters->solucion_categoria != '') {
                $filtros = $filtros." AND solucion_categoria LIKE '%".$filters->solucion_categoria."%'";
            }
            if ($filters->solucion_estado != '') {
                $filtros = $filtros." AND solucion_estado LIKE '%".$filters->solucion_estado."%'";
            }
            if ($filters->solucion_padre != '') {
                $filtros = $filtros." AND solucion_padre LIKE '%".$filters->solucion_padre."%'";
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
					$parramsfilter['solucion_titulo'] =  $this->_getSanitizedParam("solucion_titulo");
					$parramsfilter['solucion_categoria'] =  $this->_getSanitizedParam("solucion_categoria");
					$parramsfilter['solucion_estado'] =  $this->_getSanitizedParam("solucion_estado");
					$parramsfilter['solucion_padre'] =  $this->_getSanitizedParam("solucion_padre");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}