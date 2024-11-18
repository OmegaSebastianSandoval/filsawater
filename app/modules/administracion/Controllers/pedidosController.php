<?php
/**
* Controlador de Pedidos que permite la  creacion, edicion  y eliminacion de los pedido del Sistema
*/
class Administracion_pedidosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos pedido
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
	protected $_csrf_section = "administracion_pedidos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador pedidos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Pedidos();
		$this->namefilter = "parametersfilterpedidos";
		$this->route = "/administracion/pedidos";
		$this->namepages ="pages_pedidos";
		$this->namepageactual ="page_actual_pedidos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  pedido con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de pedido";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
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
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  pedido  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pedidos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->pedido_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear pedido";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un pedido  y redirecciona al listado de pedido.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['pedido_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un pedido  y redirecciona al listado de pedido.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->pedido_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['pedido_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un pedido  y redirecciona al listado de pedido.
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
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR PEDIDO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Pedidos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['pedido_documento'] = $this->_getSanitizedParam("pedido_documento");
		$data['pedido_fecha'] = $this->_getSanitizedParam("pedido_fecha");
		if($this->_getSanitizedParam("pedido_total") == '' ) {
			$data['pedido_total'] = '0';
		} else {
			$data['pedido_total'] = $this->_getSanitizedParam("pedido_total");
		}
		if($this->_getSanitizedParam("pedido_subtotal") == '' ) {
			$data['pedido_subtotal'] = '0';
		} else {
			$data['pedido_subtotal'] = $this->_getSanitizedParam("pedido_subtotal");
		}
		if($this->_getSanitizedParam("pedido_procentaje_descuento") == '' ) {
			$data['pedido_procentaje_descuento'] = '0';
		} else {
			$data['pedido_procentaje_descuento'] = $this->_getSanitizedParam("pedido_procentaje_descuento");
		}
		if($this->_getSanitizedParam("pedido_procentaje_iva") == '' ) {
			$data['pedido_procentaje_iva'] = '0';
		} else {
			$data['pedido_procentaje_iva'] = $this->_getSanitizedParam("pedido_procentaje_iva");
		}
		if($this->_getSanitizedParam("pedido_descuento") == '' ) {
			$data['pedido_descuento'] = '0';
		} else {
			$data['pedido_descuento'] = $this->_getSanitizedParam("pedido_descuento");
		}
		if($this->_getSanitizedParam("pedido_iva") == '' ) {
			$data['pedido_iva'] = '0';
		} else {
			$data['pedido_iva'] = $this->_getSanitizedParam("pedido_iva");
		}
		$data['pedido_estado'] = $this->_getSanitizedParam("pedido_estado");
		$data['pedido_ciudad'] = $this->_getSanitizedParam("pedido_ciudad");
		$data['pedido_direccion'] = $this->_getSanitizedParam("pedido_direccion");
		$data['pedido_correo'] = $this->_getSanitizedParam("pedido_correo");
		$data['pedido_nombre'] = $this->_getSanitizedParam("pedido_nombre");
		$data['pedido_telefono'] = $this->_getSanitizedParam("pedido_telefono");
		$data['pedido_respuesta'] = $this->_getSanitizedParam("pedido_respuesta");
		$data['pedido_validacion'] = $this->_getSanitizedParam("pedido_validacion");
		$data['pedido_validacion2'] = $this->_getSanitizedParam("pedido_validacion2");
		$data['pedido_entidad'] = $this->_getSanitizedParam("pedido_entidad");
		if($this->_getSanitizedParam("pedido_porcentaje_iva") == '' ) {
			$data['pedido_porcentaje_iva'] = '0';
		} else {
			$data['pedido_porcentaje_iva'] = $this->_getSanitizedParam("pedido_porcentaje_iva");
		}
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
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
            $parramsfilter = array();Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}