<?php

class Page_contactoController extends Page_mainController
{

  protected $_csrf_section = "omega_index";
  public $botonactivo  = 7;
  public function init()
  {


    // Inicia la sesión si no está ya iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // Genera un token CSRF
    if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    parent::init();
  }
  public function indexAction()
  {
    $this->_view->home = $this->template->getContentseccion("1");
    $this->_view->banner = $this->template->banner(3);


    $this->_csrf_section = "omega_index" . date("YmdHis");
    $this->_csrf->generateCode($this->_csrf_section);
    $csrf_section = $this->_csrf_section;
    $csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

    $this->_view->formulario = $this->template->getFormulario($csrf_section, $csrf);
  }
}
