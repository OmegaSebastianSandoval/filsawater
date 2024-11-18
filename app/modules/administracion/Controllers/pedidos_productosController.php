<?php
/**
* Controlador de Pedidos_productos que permite la  creacion, edicion  y eliminacion de los pedido_producto del Sistema
*/
class Administracion_pedidos_productosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos pedido_producto
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
	protected $_csrf_section = "administracion_pedidos_productos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador pedidos_productos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Pedidos_productos();
		$this->namefilter = "parametersfilterpedidos_productos";
		$this->route = "/administracion/pedidos_productos";
		$this->namepages ="pages_pedidos_productos";
		$this->namepageactual ="page_actual_pedidos_productos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  pedido_producto con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de pedido_producto";
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
		$this->_view->list_pedido_producto_pedido = $this->getPedidoproductopedido();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  pedido_producto  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pedidos_productos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_pedido_producto_pedido = $this->getPedidoproductopedido();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->pedido_producto_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar pedido_producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear pedido_producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear pedido_producto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un pedido_producto  y redirecciona al listado de pedido_producto.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['pedido_producto_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PEDIDO_PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un pedido_producto  y redirecciona al listado de pedido_producto.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->pedido_producto_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['pedido_producto_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PEDIDO_PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un pedido_producto  y redirecciona al listado de pedido_producto.
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
					$data['log_tipo'] = 'BORRAR PEDIDO_PRODUCTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Pedidos_productos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['pedido_producto_pedido'] = $this->_getSanitizedParam("pedido_producto_pedido");
		$data['pedido_producto_producto'] = $this->_getSanitizedParam("pedido_producto_producto");
		$data['pedido_producto_nombre'] = $this->_getSanitizedParam("pedido_producto_nombre");
		if($this->_getSanitizedParam("pedido_producto_cantidad") == '' ) {
			$data['pedido_producto_cantidad'] = '0';
		} else {
			$data['pedido_producto_cantidad'] = $this->_getSanitizedParam("pedido_producto_cantidad");
		}
		if($this->_getSanitizedParam("pedido_producto_valor") == '' ) {
			$data['pedido_producto_valor'] = '0';
		} else {
			$data['pedido_producto_valor'] = $this->_getSanitizedParam("pedido_producto_valor");
		}
		if($this->_getSanitizedParam("pedido_producto_iva") == '' ) {
			$data['pedido_producto_iva'] = '0';
		} else {
			$data['pedido_producto_iva'] = $this->_getSanitizedParam("pedido_producto_iva");
		}
		if($this->_getSanitizedParam("pedido_producto_valor_iva") == '' ) {
			$data['pedido_producto_valor_iva'] = '0';
		} else {
			$data['pedido_producto_valor_iva'] = $this->_getSanitizedParam("pedido_producto_valor_iva");
		}
		if($this->_getSanitizedParam("pedido_producto_descuento") == '' ) {
			$data['pedido_producto_descuento'] = '0';
		} else {
			$data['pedido_producto_descuento'] = $this->_getSanitizedParam("pedido_producto_descuento");
		}
		if($this->_getSanitizedParam("pedido_producto_valor_descuento") == '' ) {
			$data['pedido_producto_valor_descuento'] = '0';
		} else {
			$data['pedido_producto_valor_descuento'] = $this->_getSanitizedParam("pedido_producto_valor_descuento");
		}
		if($this->_getSanitizedParam("pedido_producto_precio_final") == '' ) {
			$data['pedido_producto_precio_final'] = '0';
		} else {
			$data['pedido_producto_precio_final'] = $this->_getSanitizedParam("pedido_producto_precio_final");
		}
		return $data;
	}

	/**
     * Genera los valores del campo pedido_producto_pedido.
     *
     * @return array cadena con los valores del campo pedido_producto_pedido.
     */
	private function getPedidoproductopedido()
	{
		$modelData = new Administracion_Model_DbTable_Dependpedidos();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->pedido_id] = $value->pedido_id;
		}
		return $array;
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
            if ($filters->pedido_producto_pedido != '') {
                $filtros = $filtros." AND pedido_producto_pedido LIKE '%".$filters->pedido_producto_pedido."%'";
            }
            if ($filters->pedido_producto_producto != '') {
                $filtros = $filtros." AND pedido_producto_producto LIKE '%".$filters->pedido_producto_producto."%'";
            }
            if ($filters->pedido_producto_cantidad != '') {
                $filtros = $filtros." AND pedido_producto_cantidad LIKE '%".$filters->pedido_producto_cantidad."%'";
            }
            if ($filters->pedido_producto_precio_final != '') {
                $filtros = $filtros." AND pedido_producto_precio_final LIKE '%".$filters->pedido_producto_precio_final."%'";
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
					$parramsfilter['pedido_producto_pedido'] =  $this->_getSanitizedParam("pedido_producto_pedido");
					$parramsfilter['pedido_producto_producto'] =  $this->_getSanitizedParam("pedido_producto_producto");
					$parramsfilter['pedido_producto_cantidad'] =  $this->_getSanitizedParam("pedido_producto_cantidad");
					$parramsfilter['pedido_producto_precio_final'] =  $this->_getSanitizedParam("pedido_producto_precio_final");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}