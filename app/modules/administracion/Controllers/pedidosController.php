<?php

/**
 * Controlador de Pedidos que permite la  creacion, edicion  y eliminacion de los pedido del Sistema
 */
class Administracion_pedidosController extends Administracion_mainController
{
	public $botonpanel;

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
		$this->namepages = "pages_pedidos";
		$this->namepageactual = "page_actual_pedidos";
		$routes = $this->getRoutes()->getAction();
		if ($routes == 'exportar') {
			$this->botonpanel = 13;
		} else {
			$this->botonpanel = 12;
		}
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 50;
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
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		// echo $filters;
		$order = "pedido_fecha DESC";
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
		$this->_view->list_direccion_departamento = $this->getDirecciondepartamento();
		$this->_view->list_direccion_ciudad = $this->getDireccionciudad();
		$this->_view->list_pedido_estado = $this->getPedidoestado();
		$this->_view->message = Session::getInstance()->get('message');
		Session::getInstance()->set('message', '');
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  pedido  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pedidos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		$this->_view->list_direccion_departamento = $this->getDirecciondepartamento();
		$this->_view->list_direccion_ciudad = $this->getDireccionciudad();
		$this->_view->list_pedido_estado = $this->getPedidoestado();
		$this->_view->list_pedido_estado_cambio = $this->getPedidoestadoCambio();
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->pedido_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear pedido";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}
	public function infoAction()
	{

		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pedidos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_direccion_departamento = $this->getDirecciondepartamento();
		$this->_view->list_direccion_ciudad = $this->getDireccionciudad();
		$this->_view->list_pedido_estado = $this->getPedidoestado();

		$id = $this->_getSanitizedParam("id");
		$title = "Información del pedido " . $id;
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;

		if ($id > 0) {
			$content = $this->mainModel->getById($id);



			$productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
			$productosModel = new Administracion_Model_DbTable_Productos();
			$tiendaCategoria = new Administracion_Model_DbTable_Tiendacategorias();
			$productosPedido = $productoPedidoModel->getList("pedido_producto_pedido = " . $id);
			foreach ($productosPedido as $producto) {

				$productoDetalle = $productosModel->getById($producto->pedido_producto_producto);
				$producto->producto_categoriainfo = $tiendaCategoria->getById($productoDetalle->producto_categoria)->tienda_categoria_nombre;
				$producto->producto_imagen = $productoDetalle->producto_imagen;
			}

			$this->_view->productosPedido = $productosPedido;
			$this->_view->content = $content;
		}
	}

	public function exportarAction()
	{
		$title = "Exportar pedidos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		// echo $filters;
		$order = "pedido_fecha DESC";
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
		$this->_view->list_direccion_departamento = $this->getDirecciondepartamento();
		$this->_view->list_direccion_ciudad = $this->getDireccionciudad();
		$this->_view->list_pedido_estado = $this->getPedidoestado();
	}

	public function exportarexcelAction()
	{
		$this->setLayout('blanco');
		$productosModel = new Administracion_Model_DbTable_Productos();
		$productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
		$tiendaCategoria = new Administracion_Model_DbTable_Tiendacategorias();
		$municipiosModel = new Administracion_Model_DbTable_Municipios();
		$departamentosModel = new Administracion_Model_DbTable_Departamentos();

		$excel = $this->_getSanitizedParam("excel");
		$this->filters();
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$filters = $this->getFilter();
		$order = "pedido_fecha DESC";

		$list = $this->mainModel->getList($filters, $order);
		foreach ($list as $pedido) {
			$productoPedido = $productoPedidoModel->getList("pedido_producto_pedido = " . $pedido->pedido_id);
			$pedido->productos = $productoPedido;
			$pedido->pedido_estado = $this->getPedidoestado()[$pedido->pedido_estado];
			$pedido->pedido_departamento = $departamentosModel->getById($pedido->pedido_departamento)->departamento;
			$pedido->pedido_ciudad = $municipiosModel->getById($pedido->pedido_ciudad)->municipio;
		}
		$this->_view->list = $list;

		if ($excel == 1) {
			$hoy = date("Y-m-d H:i:s");
			header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
			header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
			header("Content-Disposition: attachment; filename=pedidos_" . $hoy . ".xls");
		}
	}

	/**
	 * Inserta la informacion de un pedido  y redirecciona al listado de pedido.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$id = $this->mainModel->insert($data);

			$data['pedido_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un pedido  y redirecciona al listado de pedido.
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
			if ($content->pedido_id) {
				$data = $this->getData();
				if ($content->pedido_estado != $data['pedido_estado']) {
					$this->mainModel->editField($id, "pedido_estado", $data['pedido_estado']);
					//enviar correo
					$mailModel = new Core_Model_Sendingemail($this->_view);
					$mail = $mailModel->enviarCorreoTienda($id);
					$this->mainModel->editField($id, "pedido_validacion2", $mail);
					Session::getInstance()->set('message', 'Correo enviado correctamente');
				}
			}
			$data['pedido_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
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
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR PEDIDO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	public function reenviarcorreoAction()
	{
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$pedido = $this->mainModel->getById($id);
		$mailModel = new Core_Model_Sendingemail($this->_view);
		$mail = $mailModel->enviarCorreoTienda($id);
		$this->mainModel->editField($id, "pedido_validacion2", $mail);
		Session::getInstance()->set('message', 'Correo reenviado correctamente');
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Genera los valores del campo Estado.
	 *
	 * @return array cadena con los valores del campo Estado.
	 */
	private function getPedidoestado()
	{
		$array = array();
		$array[1] = 'Creado';
		$array[2] = 'Dirección pendiente';
		$array[3] = 'En espera de pago';
		$array[4] = 'Pago en proceso';
		$array[5] = 'Transacción aprobada';
		$array[6] = 'Transacción rechazada';
		$array[7] = 'Transacción anulada';
		$array[8] = 'Error interno del método de pago respectivo';
		$array[9] = 'Pedido enviado';
		$array[10] = 'Pedido entregado';


		return $array;
	}
	private function getPedidoestadoCambio()
	{
		$array = array();
		/* $array[1] = 'Creado';
		$array[2] = 'Dirección pendiente';
		$array[3] = 'En espera de pago';
		$array[4] = 'Pago en proceso'; */
		$array[5] = 'Transacción aprobada';
		/* $array[6] = 'Transacción rechazada';
		$array[7] = 'Transacción anulada';
		$array[8] = 'Error interno del método de pago respectivo'; */
		$array[9] = 'Pedido enviado';
		$array[10] = 'Pedido entregado';


		return $array;
	}


	/**
	 * Genera los valores del campo direccion_departamento.
	 *
	 * @return array cadena con los valores del campo direccion_departamento.
	 */
	private function getDirecciondepartamento()
	{
		$modelData = new Administracion_Model_DbTable_Dependdepartamentos();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id_departamento] = $value->departamento;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo direccion_ciudad.
	 *
	 * @return array cadena con los valores del campo direccion_ciudad.
	 */
	private function getDireccionciudad()
	{
		$modelData = new Administracion_Model_DbTable_Dependmunicipios();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id_municipio] = $value->municipio;
		}
		return $array;
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
		if ($this->_getSanitizedParam("pedido_total") == '') {
			$data['pedido_total'] = '0';
		} else {
			$data['pedido_total'] = $this->_getSanitizedParam("pedido_total");
		}
		if ($this->_getSanitizedParam("pedido_subtotal") == '') {
			$data['pedido_subtotal'] = '0';
		} else {
			$data['pedido_subtotal'] = $this->_getSanitizedParam("pedido_subtotal");
		}
		if ($this->_getSanitizedParam("pedido_procentaje_descuento") == '') {
			$data['pedido_procentaje_descuento'] = '0';
		} else {
			$data['pedido_procentaje_descuento'] = $this->_getSanitizedParam("pedido_procentaje_descuento");
		}
		if ($this->_getSanitizedParam("pedido_descuento") == '') {
			$data['pedido_descuento'] = '0';
		} else {
			$data['pedido_descuento'] = $this->_getSanitizedParam("pedido_descuento");
		}
		if ($this->_getSanitizedParam("pedido_iva") == '') {
			$data['pedido_iva'] = '0';
		} else {
			$data['pedido_iva'] = $this->_getSanitizedParam("pedido_iva");
		}
		$data['pedido_estado'] = $this->_getSanitizedParam("pedido_estado");
		$data['pedido_departamento'] = $this->_getSanitizedParam("pedido_departamento");
		$data['pedido_ciudad'] = $this->_getSanitizedParam("pedido_ciudad");
		$data['pedido_direccion'] = $this->_getSanitizedParam("pedido_direccion");
		$data['pedido_direccion_observacion'] = $this->_getSanitizedParam("pedido_direccion_observacion");
		$data['pedido_correo'] = $this->_getSanitizedParam("pedido_correo");
		$data['pedido_nombre'] = $this->_getSanitizedParam("pedido_nombre");
		$data['pedido_telefono'] = $this->_getSanitizedParam("pedido_telefono");
		$data['pedido_respuesta'] = $this->_getSanitizedParam("pedido_respuesta");
		$data['pedido_validacion'] = $this->_getSanitizedParam("pedido_validacion");
		$data['pedido_validacion2'] = $this->_getSanitizedParam("pedido_validacion2");
		$data['pedido_entidad'] = $this->_getSanitizedParam("pedido_entidad");
		if ($this->_getSanitizedParam("pedido_porcentaje_iva") == '') {
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
	/* $array[1] = 'Creado';
		$array[2] = 'Dirección pendiente';
		$array[3] = 'En espera de pago';
		$array[4] = 'Pago en proceso';
		$array[5] = 'Transacción aprobada';
		$array[6] = 'Transacción rechazada';
		$array[7] = 'Transacción anulada';
		$array[8] = 'Error interno del método de pago respectivo';
		$array[9] = 'Pedido enviado';
		$array[10] = 'Pedido entregado'; */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		$pedido_estado = $this->_getSanitizedParam("pedido_estado");
		if(!$pedido_estado) {
			$filtros = $filtros . " AND ( pedido_estado = '5' OR pedido_estado ='9' OR pedido_estado ='10') ";
		}
		
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->pedido_documento != '') {
				$filtros = $filtros . " AND pedido_documento LIKE '%" . $filters->pedido_documento . "%'";
			}
			if ($filters->pedido_nombre != '') {
				$filtros = $filtros . " AND pedido_nombre LIKE '%" . $filters->pedido_nombre . "%'";
			}
			if ($filters->pedido_id != '') {
				$filtros = $filtros . " AND pedido_id LIKE '%" . $filters->pedido_id . "%'";
			}
			if ($filters->pedido_correo != '') {
				$filtros = $filtros . " AND pedido_correo LIKE '%" . $filters->pedido_correo . "%'";
			}
			if ($filters->pedido_fecha != '' && $filters->pedido_fecha_fin == '') {
				$filtros = $filtros . " AND pedido_fecha LIKE '%" . $filters->pedido_fecha . "%'";
			}
			if ($filters->pedido_fecha != '' && $filters->pedido_fecha_fin != '') {
				$filters->pedido_fecha = $filters->pedido_fecha . " 00:00:00";
				$filters->pedido_fecha_fin = $filters->pedido_fecha_fin . " 23:59:59";
				$filtros = $filtros . " AND pedido_fecha BETWEEN '" . $filters->pedido_fecha . "' AND '" . $filters->pedido_fecha_fin . "'";
			}
			if ($filters->pedido_estado != '' && $filters->pedido_estado != 'Todos') {
				$filtros = $filtros . " AND pedido_estado = " . $filters->pedido_estado;
			}else if($filters->pedido_estado == 'Todos'){
				$filtros = $filtros . " AND  pedido_estado !='' ";
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
			$parramsfilter['pedido_documento'] =  $this->_getSanitizedParam("pedido_documento");
			$parramsfilter['pedido_nombre'] =  $this->_getSanitizedParam("pedido_nombre");
			$parramsfilter['pedido_id'] =  $this->_getSanitizedParam("pedido_id");
			$parramsfilter['pedido_correo'] =  $this->_getSanitizedParam("pedido_correo");
			$parramsfilter['pedido_fecha'] =  $this->_getSanitizedParam("pedido_fecha");
			$parramsfilter['pedido_fecha_fin'] =  $this->_getSanitizedParam("pedido_fecha_fin");
			$parramsfilter['pedido_estado'] =  $this->_getSanitizedParam("pedido_estado");


			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
