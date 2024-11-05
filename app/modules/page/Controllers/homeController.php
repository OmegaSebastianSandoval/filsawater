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

  }
}
