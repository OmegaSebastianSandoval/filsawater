<?php
/**
* Controlador de Blogs que permite la  creacion, edicion  y eliminacion de los blog del Sistema
*/
class Administracion_blogsController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos blog
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
	protected $_csrf_section = "administracion_blogs";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador blogs .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Blogs();
		$this->namefilter = "parametersfilterblogs";
		$this->route = "/administracion/blogs";
		$this->namepages ="pages_blogs";
		$this->namepageactual ="page_actual_blogs";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  blog con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de blog";
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
		$this->_view->list_blog_categoria_id = $this->getBlogcategoriaid();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  blog  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_blogs_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_blog_categoria_id = $this->getBlogcategoriaid();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->blog_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar blog";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear blog";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear blog";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un blog  y redirecciona al listado de blog.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if($_FILES['blog_imagen']['name'] != ''){
				$data['blog_imagen'] = $uploadImage->upload("blog_imagen");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id,$id);
			$data['blog_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR BLOG';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un blog  y redirecciona al listado de blog.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->blog_id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if($_FILES['blog_imagen']['name'] != ''){
					if($content->blog_imagen){
						$uploadImage->delete($content->blog_imagen);
					}
					$data['blog_imagen'] = $uploadImage->upload("blog_imagen");
				} else {
					$data['blog_imagen'] = $content->blog_imagen;
				}
				$this->mainModel->update($data,$id);
			}
			$data['blog_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR BLOG';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un blog  y redirecciona al listado de blog.
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
					if (isset($content->blog_imagen) && $content->blog_imagen != '') {
						$uploadImage->delete($content->blog_imagen);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR BLOG';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Blogs.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['blog_titulo'] = $this->_getSanitizedParam("blog_titulo");
		$data['blog_imagen'] = "";
		$data['blog_categoria_id'] = $this->_getSanitizedParam("blog_categoria_id");
		$data['blog_autor'] = $this->_getSanitizedParam("blog_autor");
		$data['blog_fecha'] = $this->_getSanitizedParam("blog_fecha");
		$data['blog_estado'] = $this->_getSanitizedParam("blog_estado");
		$data['blog_importante'] = $this->_getSanitizedParam("blog_importante");
		$data['blog_nuevo'] = $this->_getSanitizedParam("blog_nuevo");
		$data['blog_introduccion'] = $this->_getSanitizedParamHtml("blog_introduccion");
		$data['blog_descripcion'] = $this->_getSanitizedParamHtml("blog_descripcion");

		$data['blog_contenido'] = $this->_getSanitizedParamHtml("blog_contenido");
		$data['tags'] = $this->_getSanitizedParam("tags");
		return $data;
	}

	/**
     * Genera los valores del campo categoria.
     *
     * @return array cadena con los valores del campo categoria.
     */
	private function getBlogcategoriaid()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategorias();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->categoria_id] = $value->categoria_nombre;
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
            if ($filters->blog_titulo != '') {
                $filtros = $filtros." AND blog_titulo LIKE '%".$filters->blog_titulo."%'";
            }
            if ($filters->blog_imagen != '') {
                $filtros = $filtros." AND blog_imagen LIKE '%".$filters->blog_imagen."%'";
            }
            if ($filters->blog_categoria_id != '') {
                $filtros = $filtros." AND blog_categoria_id LIKE '%".$filters->blog_categoria_id."%'";
            }
            if ($filters->blog_fecha != '') {
                $filtros = $filtros." AND blog_fecha LIKE '%".$filters->blog_fecha."%'";
            }
            if ($filters->blog_estado != '') {
                $filtros = $filtros." AND blog_estado LIKE '%".$filters->blog_estado."%'";
            }
            if ($filters->blog_importante != '') {
                $filtros = $filtros." AND blog_importante LIKE '%".$filters->blog_importante."%'";
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
					$parramsfilter['blog_titulo'] =  $this->_getSanitizedParam("blog_titulo");
					$parramsfilter['blog_imagen'] =  $this->_getSanitizedParam("blog_imagen");
					$parramsfilter['blog_categoria_id'] =  $this->_getSanitizedParam("blog_categoria_id");
					$parramsfilter['blog_fecha'] =  $this->_getSanitizedParam("blog_fecha");
					$parramsfilter['blog_estado'] =  $this->_getSanitizedParam("blog_estado");
					$parramsfilter['blog_importante'] =  $this->_getSanitizedParam("blog_importante");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}