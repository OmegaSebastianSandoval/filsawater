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


    $nombres = $this->_getSanitizedParam('nombres');
    $email = $this->_getSanitizedParam('email');
    $phone = $this->_getSanitizedParam('phone');
    $password = $this->_getSanitizedParam('password');
    $password2 = $this->_getSanitizedParam('re-password');
    $id = $this->_getSanitizedParam('id');
    $usuarioModel = new Page_Model_DbTable_Usuario();

    if ($password != '') {
      if ($password === $password2) {
        $usuarioModel->editField($id, 'user_password', password_hash($password, PASSWORD_DEFAULT));
      } else {
        $error = 1;
      }
    }    
    if($error){
      header("Location: /page/home/?error=1");
      exit;
    }

    $usuarioModel->editField($id, 'user_names', $nombres);
    $usuarioModel->editField($id, 'user_email', $email);
    $usuarioModel->editField($id, 'user_telefono', $phone);
    $usuario = $usuarioModel->getById($id);
    Session::getInstance()->set('usuario', $usuario);

    header("Location: /page/home/?msg=1");
  }
}
