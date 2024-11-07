<?php
/**
* Controlador de Productos que permite la  creacion, edicion  y eliminacion de los producto del Sistema
*/
class Administracion_productosController extends Administracion_mainController
{
	public $botonpanel = 9;

	/**
	 * $mainModel  instancia del modelo de  base de datos producto
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
	protected $_csrf_section = "administracion_productos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador productos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Productos();
		$this->namefilter = "parametersfilterproductos";
		$this->route = "/administracion/productos";
		$this->namepages ="pages_productos";
		$this->namepageactual ="page_actual_productos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  producto con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de producto";
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
		$this->_view->list_producto_categoria = $this->getProductocategoria();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  producto  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_productos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_producto_categoria = $this->getProductocategoria();
		$this->_view->error = $this->_getSanitizedParam("error");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->producto_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear producto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un producto  y redirecciona al listado de producto.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if($_FILES['producto_imagen']['name'] != ''){
				$data['producto_imagen'] = $uploadImage->upload("producto_imagen");
			}

			// referencia existe?
			$producto = $this->mainModel->getList("producto_referencia = '".$data['producto_referencia']."'");
			if($producto){
				header('Location: '.$this->route.'/manage?error=1'.'');
				exit();
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id,$id);
			$data['producto_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un producto  y redirecciona al listado de producto.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->producto_id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if($_FILES['producto_imagen']['name'] != ''){
					if($content->producto_imagen){
						$uploadImage->delete($content->producto_imagen);
					}
					$data['producto_imagen'] = $uploadImage->upload("producto_imagen");
				} else {
					$data['producto_imagen'] = $content->producto_imagen;
				}
				$this->mainModel->update($data,$id);
			}
			$data['producto_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un producto  y redirecciona al listado de producto.
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
					if (isset($content->producto_imagen) && $content->producto_imagen != '') {
						$uploadImage->delete($content->producto_imagen);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR PRODUCTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Productos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['producto_estado'] = $this->_getSanitizedParam("producto_estado");
		$data['producto_importante'] = $this->_getSanitizedParam("producto_importante");
		$data['producto_nombre'] = $this->_getSanitizedParam("producto_nombre");
		$data['producto_referencia'] = $this->_getSanitizedParam("producto_referencia");
		if($this->_getSanitizedParam("producto_precio") == '' ) {
			$data['producto_precio'] = '0';
		} else {
			$data['producto_precio'] = $this->_getSanitizedParam("producto_precio");
		}
		$data['producto_imagen'] = "";
		if($this->_getSanitizedParam("producto_stock") == '' ) {
			$data['producto_stock'] = '0';
		} else {
			$data['producto_stock'] = $this->_getSanitizedParam("producto_stock");
		}
		$data['producto_categoria'] = $this->_getSanitizedParam("producto_categoria");
		$data['producto_descripcion'] = $this->_getSanitizedParamHtml("producto_descripcion");
		return $data;
	}

	/**
     * Genera los valores del campo categor&iacute;a.
     *
     * @return array cadena con los valores del campo categor&iacute;a.
     */
	private function getProductocategoria()
	{
		$modelData = new Administracion_Model_DbTable_Dependtiendacategorias();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->tienda_categoria_id] = $value->tienda_categoria_nombre;
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
            if ($filters->producto_estado != '') {
                $filtros = $filtros." AND producto_estado LIKE '%".$filters->producto_estado."%'";
            }
            if ($filters->producto_nombre != '') {
                $filtros = $filtros." AND producto_nombre LIKE '%".$filters->producto_nombre."%'";
            }
			if ($filters->producto_referencia != '') {
				$filtros = $filtros." AND producto_referencia LIKE '%".$filters->producto_referencia."%'";
			}
            if ($filters->producto_precio != '') {
                $filtros = $filtros." AND producto_precio LIKE '%".$filters->producto_precio."%'";
            }
            if ($filters->producto_imagen != '') {
                $filtros = $filtros." AND producto_imagen LIKE '%".$filters->producto_imagen."%'";
            }
            if ($filters->producto_stock != '') {
                $filtros = $filtros." AND producto_stock LIKE '%".$filters->producto_stock."%'";
            }
            if ($filters->producto_categoria != '') {
                $filtros = $filtros." AND producto_categoria LIKE '%".$filters->producto_categoria."%'";
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
					$parramsfilter['producto_estado'] =  $this->_getSanitizedParam("producto_estado");
					$parramsfilter['producto_nombre'] =  $this->_getSanitizedParam("producto_nombre");
					$parramsfilter['producto_referencia'] =  $this->_getSanitizedParam("producto_referencia");
					$parramsfilter['producto_precio'] =  $this->_getSanitizedParam("producto_precio");
					$parramsfilter['producto_imagen'] =  $this->_getSanitizedParam("producto_imagen");
					$parramsfilter['producto_stock'] =  $this->_getSanitizedParam("producto_stock");
					$parramsfilter['producto_categoria'] =  $this->_getSanitizedParam("producto_categoria");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}