<?php

class Page_homeController extends Page_mainController
{

  public $botonactivo  = 7;

  public function init()
  {
    //si no existe un usuario activo llevar al paso 1
    if (!Session::getInstance()->get('usuario')) {
      header("Location: /");
    }
    parent::init();
  }
  public function indexAction()
  {

    $this->_view->msg = Session::getInstance()->get('msg');
    $this->_view->tipo = Session::getInstance()->get('tipo');
    Session::getInstance()->set('msg', '');
    Session::getInstance()->set('tipo', '');


    $direccionesModel = new Administracion_Model_DbTable_Direcciones();
    $departamentosModel = new Administracion_Model_DbTable_Departamentos();
    $municipiosModel = new Administracion_Model_DbTable_Municipios();


    $usuario = $this->usuarioLogged();

    $direcciones = $direccionesModel->getList("direccion_cliente = '{$usuario->user_cedula}'");
    foreach ($direcciones  as $value) {
      $departamento = $departamentosModel->getById($value->direccion_departamento);
      $municipio = $municipiosModel->getById($value->direccion_ciudad);
      $value->departamento_nombre = $departamento->departamento;
      $value->municipio_nombre = $municipio->municipio;
    }
    $this->_view->direcciones = $direcciones;
    $departamentos = $departamentosModel->getList("", " departamento ASC");
    $this->_view->departamentos = $departamentos;
    $municipios = $municipiosModel->getList("", "municipio ASC");
    $this->_view->municipios = $municipios;



    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $productosPedidosModel = new Administracion_Model_DbTable_Productosporpedido();
    $pedidos = $pedidosModel->getList("pedido_documento = '{$usuario->user_cedula}'", "pedido_fecha DESC");

    foreach ($pedidos as $pedido) {
      $productos = $productosPedidosModel->getList("pedido_producto_pedido = '{$pedido->pedido_id}'");
      foreach ($productos as $producto) {
        $producto->producto_imagen = $productosModel->getById($producto->pedido_producto_producto)->producto_imagen;
      }
      $pedido->productos = $productos;
    }
    /*  echo "<pre>";
    print_r($pedidos);
    echo "</pre>"; */
    $this->_view->pedidos = $pedidos;
    $this->_view->pedidoestado = $this->getPedidoestado();
    $this->_view->list_direccion_departamento = $this->getDirecciondepartamento();
    $this->_view->list_direccion_ciudad = $this->getDireccionciudad();
    $this->_view->list_pedido_estado = $this->getPedidoestado();
  }
  /* stdClass Object ( [user_id] => 7 [user_date] => 2024-11-01 [user_names] => Juan Sebastán Sandoval Vargas [user_cedula] => 1100973339 [user_email] => juansesdvsf@gmail.com [user_telefono] => 3124624763 [user_level] => 2 [user_state] => 1 [user_user] => 1100973339 [user_password] => $2y$10$eEsFqweqmOL5egCTQVMS7eVVAZB6Rol1siVamzWkT8sQoi9om6Yxy [user_delete] => 0 [user_current_user] => 0 [user_code] => [user_codedate] => 0000-00-00 00:00:00 [user_empresa] => )  */
  public function updateprofileAction()
  {
    $email = $this->_getSanitizedParam('user_email');
    $phone = $this->_getSanitizedParam('phone');
    $addres = $this->_getSanitizedParam('user_addres');
    $nombresContacto = $this->_getSanitizedParam('nombres-contacto');
    $phoneContacto = $this->_getSanitizedParam('phone-contacto');





    $id = $this->_getSanitizedParam('id');


    $usuarioModel = new Page_Model_DbTable_Usuario();


    $usuarioModel->editField($id, 'user_email', $email);
    $usuarioModel->editField($id, 'user_telefono', $phone);
    $usuarioModel->editField($id, 'user_addres', $addres);
    $usuarioModel->editField($id, 'user_contacto', $nombresContacto);
    $usuarioModel->editField($id, 'user_telefono_contacto', $phoneContacto);
    $usuario = $usuarioModel->getById($id);
    Session::getInstance()->set('usuario', $usuario);

    Session::getInstance()->set('msg', 'Datos actualizados correctamente');
    Session::getInstance()->set('tipo', 'success');


    header("Location: /page/home");
  }
  public function addaddresAction()
  {



    $data = [];
    $data["direccion_cliente"] = $this->usuarioLogged()->user_cedula;
    $data["direccion_departamento"] = $this->_getSanitizedParam('departamento');
    $data["direccion_ciudad"] = $this->_getSanitizedParam('municipio');
    $data["direccion_direccion"] = $this->_getSanitizedParam('direccion');
    $data["direccion_observacion"] = $this->_getSanitizedParam('observacion');
    $data["direccion_estado"] = 1;

    $direccionesModel = new Administracion_Model_DbTable_Direcciones();

    $idDireccion = $direccionesModel->insert($data);

    if ($idDireccion) {
      Session::getInstance()->set('msg', 'Dirección agregada correctamente');
      Session::getInstance()->set('tipo', 'success');
      header("Location: /page/home#v-pills-addres-tab");
    }
  }

  public function editaddresAction()
  {
    $data = [];
    $data["direccion_cliente"] = $this->usuarioLogged()->user_cedula;
    $data["direccion_departamento"] = $this->_getSanitizedParam('departamento');
    $data["direccion_ciudad"] = $this->_getSanitizedParam('municipio');
    $data["direccion_direccion"] = $this->_getSanitizedParam('direccion');
    $data["direccion_observacion"] = $this->_getSanitizedParam('observacion');
    $data["direccion_estado"] = 1;
    $id = $this->_getSanitizedParam('id');
    $direccionesModel = new Administracion_Model_DbTable_Direcciones();
    $direccionesModel->update($data, $id);
    Session::getInstance()->set('msg', 'Dirección editada correctamente');
    Session::getInstance()->set('tipo', 'success');
    header("Location: /page/home#v-pills-addres-tab");
  }

  public function eliminardireccionAction()
  {
    $id = $this->_getSanitizedParam('id');
    $direccionesModel = new Administracion_Model_DbTable_Direcciones();
    $direccionesModel->deleteRegister($id);
    Session::getInstance()->set('msg', 'Dirección eliminada correctamente');
    Session::getInstance()->set('tipo', 'danger');
    header("Location: /page/home#v-pills-addres-tab");
  }

  /**
   * Genera los valores del campo Estado.
   *
   * @return array cadena con los valores del campo Estado.
   */
  public function getPedidoestado()
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
}
