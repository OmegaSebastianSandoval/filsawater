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
  public function indexAction() {
    $this->_view->msg = $this->_getSanitizedParam('msg');
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

    header("Location: /page/home/?msg=1");
  }
}
