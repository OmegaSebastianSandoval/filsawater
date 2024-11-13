<?php

class Page_loginController extends Page_mainController
{

  public $botonactivo  = 7;

  public function init()
  {
    //si no existe un usuario activo llevar al paso 1
    if (Session::getInstance()->get('usuario')) {
      header("Location: /page/home");
    }
    parent::init();
  }
  public function indexAction() {}
  public function crearcuentaAction()
  {
    $error =  Session::getInstance()->get("error");
    $this->_view->error = $error;
    Session::getInstance()->set("error", null);
  }

  public function crearAction()
  {

    $name = $this->_getSanitizedParam('name');
    $cedula = $this->_getSanitizedParam('cedula');
    $email = $this->_getSanitizedParam('email');
    $phone = $this->_getSanitizedParam('phone');
    $password = $this->_getSanitizedParam('password');
    $repassword = $this->_getSanitizedParam('re-password');

    $modelUsuario = new Administracion_Model_DbTable_Usuario();

    if ($password !== $repassword) {
      Session::getInstance()->set("error", 1);
      header('Location: /page/login/crearcuenta');
      return;
    }
    //Validar si ya existe el correo y el usuario
    $usuarioEmail = $modelUsuario->getList("user_email = '{$email}'");
    if ($usuarioEmail) {
      Session::getInstance()->set("error", 2);
      header('Location: /page/login/crearcuenta');
      return;
    }

    $usuarioCedula = $modelUsuario->getList("user_cedula = '{$cedula}' OR user_user = '{$cedula}'");
    if ($usuarioCedula) {
      Session::getInstance()->set("error", 3);
      header('Location: /page/login/crearcuenta');
      return;
    }

    $data = [];
    $data['user_names'] = $name;
    $data['user_cedula'] = $cedula;
    $data['user_email'] = $email;
    $data['user_telefono'] = $phone;
    $data['user_user'] = $cedula;
    $data['user_password'] = $password;
    $data['user_level'] = 2;
    $data['user_state'] = 1;
    $data['user_date'] = date('Y-m-d');

    $id = $modelUsuario->insert($data);
    if ($id) {
      $usuario = $modelUsuario->getById($id);
      Session::getInstance()->set("usuario", $usuario);
      header('Location: /page/home');
      return;
    } else {
      Session::getInstance()->set("error", 4);
      header('Location: /page/login/crearcuenta');
      return;
    }
  }

  public function validarAction()
  {
    // error_reporting(E_ALL);
    $this->setLayout('blanco');
    // Recibir los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verificar si la decodificación fue exitosa y si se recibieron los datos esperados
    $cedula = $this->sanitizarEntrada($data['cedula']);
    $password = $this->sanitizarEntrada($data['password']);
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);

    $modelUsuario = new Administracion_Model_DbTable_Usuario();
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }

    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ", "bloqueo_id DESC")[0];

    $intentos = (int)$infoBloqueo->bloqueo_intentosfallidos;
    $fechaUltimoIntento = $infoBloqueo->bloqueo_fechaintento;
    // Convertir la fecha del último intento a un objeto DateTime
    $fechaUltimoIntento = new DateTime($fechaUltimoIntento);
    // Obtener la fecha y hora actual
    $fechaActual = new DateTime();


    // Calcular la diferencia entre las fechas
    $diferencia = $fechaActual->getTimestamp() - $fechaUltimoIntento->getTimestamp();

    if ($intentos >= 3 && $diferencia <= 900) {


      $response = [
        'status' => 'error',
        'error' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }

    $dataBloque = array();
    $dataBloque['bloqueo_usuario'] = $cedula;
    $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($cedula);
    $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];

    $bloqueosModel->insert($dataBloque);

    $usuario = $modelUsuario->getList("user_user = '{$cedula}'")[0];



    if (!$usuario) {
      $res['error'] = "Usuario no encontrado";
      $res['status'] = "error";
      die(json_encode($res));
    }
    $userModel = new core_Model_DbTable_User();

    if ($usuario->user_state != 1) {
      $res['error'] = "Usuario inactivo";
      $res['status'] = "error";
      die(json_encode($res));
    }


    if (!$userModel->autenticateUser($cedula, $password)) {
      $res['error'] = "Contraseña incorrecta";
      $res['status'] = "error";
      die(json_encode($res));
    }

    //borrar registros de bloqueo para iniciar desde 0 la proxima vez que se equivoque
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC");
    if (count($infoBloqueo) > 0) {
      foreach ($infoBloqueo as $info) {
        $bloqueosModel->deleteRegister($info->bloqueo_id);
      }
    }
    Session::getInstance()->set("usuario", $usuario);
    $res['status'] = "success";
    $res['redirect'] = "/page/home";
    die(json_encode($res));
  }

  public function recuperarAction()
  {
    $error =  Session::getInstance()->get("error");
    $this->_view->error = $error;
    Session::getInstance()->set("error", null);
  }

  public function consultacorreoAction()
  {

    // error_reporting(E_ALL);
    $this->setLayout('blanco');
    // Recibir los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verificar si la decodificación fue exitosa y si se recibieron los datos esperados
    $cedula = $this->sanitizarEntrada($data['cedula']);
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);

    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }

    if (!$cedula) {
      $response = [
        'status' => 'error',
        'message' => 'La cédula es requerida'
      ];
      // Devolver la respuesta como JSON y finalizar el script
      die(json_encode($response));
    }

    // Crear una instancia del modelo de usuarios
    $usersModel = new Page_Model_DbTable_Usuario();
    // Obtener información del usuario por su cédula
    $user = $usersModel->getList("user_user = '{$cedula}'", "")[0];

    // Si no se encuentra ningún usuario con esa cédula
    if (!$user) {
      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún usuario con esa cédula'
      ];
      // Devolver la respuesta como JSON y finalizar el script
      die(json_encode($response));
    }



    // Ocultar parte del correo electrónico por motivos de seguridad
    $email = $user->user_email;
    $email = explode('@', $email);
    $email[0] = substr($email[0], 0, 5) . '***';
    $email = implode('@', $email);

    // Generar un token único y una fecha de token
    $token = md5(uniqid(rand(), true));
    $token_date = date('Y-m-d H:i:s');

    // Crear una instancia del modelo de envío de correo electrónico
    $mailModel = new Core_Model_Sendingemail($this->_view);

    // Enviar correo de recuperación y almacenar el resultado
    $mail = $mailModel->enviarrecuperacion($user, $token);

    // Si el correo se envió correctamente
    if ($mail == '1') {
      // Actualizar el token y la fecha de token del usuario en la base de datos
      $usersModel->editField($user->user_id, 'user_code', $token);
      $usersModel->editField($user->user_id, 'user_codedate', $token_date);

      // Preparar la respuesta exitosa
      $response = [
        'status' => 'success',
        'message' => 'Se ha enviado un correo a ' . $email . ' con los pasos a seguir',
        'user' => $cedula,
        'email' => $email
      ];
    } else {
      // Preparar la respuesta en caso de error en el envío de correo
      $response = [
        'status' => 'errorMail',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }

    // Devolver la respuesta como JSON
    die(json_encode($response));
  }



  public function recuperacionAction()
  {
    // Obtener el token del parámetro de la URL y sanearlo
    $token = $this->_getSanitizedParam('t');

    // Crear una instancia del modelo de usuarios
    $usersModel = new Page_Model_DbTable_Usuario();

    // Obtener información del usuario por su token
    $user = $usersModel->getList("user_code = '$token'", "")[0];

    // Si se encuentra un usuario con ese token
    if ($user) {
      // Convertir la fecha de token almacenada en el usuario a un objeto DateTime
      $token_date = new DateTime($user->user_codedate);

      // Obtener la fecha y hora actual
      $now = new DateTime();

      // Calcular la diferencia de tiempo entre la fecha de token y la fecha actual
      $interval = $now->diff($token_date);

      // Si la diferencia de horas es menor que 1 hora
      if ($interval->h < 1) {

        // Configurar la vista para mostrar el formulario de registro
        $this->_view->error = false;
        $this->_view->user = $user;
      } else {

        // Configurar la vista para mostrar un error de expiración de token
        $this->_view->error = true;
      }
    } else {
      // Configurar la vista para mostrar un error si no se encuentra ningún usuario con ese token
      $this->_view->error = true;
    }
  }

  public function recuperarclaveAction()
  {

    // Recibir los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Obtener y sanear los parámetros de contraseña


    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);
    $password = $this->sanitizarEntrada($data['password']);
    $password2 = $this->sanitizarEntrada($data['re-password']);


    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }

    // Crear una instancia del modelo de usuarios
    $usersModel = new Page_Model_DbTable_Usuario();

    // Obtener el ID de usuario de los parámetros de la solicitud y obtener información del usuario
    $user_id = $this->sanitizarEntrada($data['user_id']);

    $user = $usersModel->getById($user_id);

    // Verificar si las contraseñas coinciden
    if ($password == $password2) {
      // Cambiar la contraseña del usuario y actualizar otros campos relacionados
      $usersModel->editField($user_id, 'user_password', password_hash($password, PASSWORD_DEFAULT));
      $usersModel->editField($user_id, 'user_code', '');
      $usersModel->editField($user_id, 'user_codedate', '');
      $usersModel->editField($user_id, 'user_state', 1);

      // Iniciar sesión del usuario
      Session::getInstance()->set("usuario", $user);


      // Preparar la respuesta de éxito
      $response = [
        'status' => 'success',
        'message' => 'Contraseña cambiada correctamente',
        'redirect' => '/page/home'
      ];
    } else {
      // Preparar la respuesta de error si las contraseñas no coinciden
      $response = [
        'status' => 'error',
        'message' => 'Las contraseñas no coinciden'
      ];
    }

    // Devolver la respuesta como JSON
    die(json_encode($response));
  }






















  private function verifyCaptcha($response)
  {
    $secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secretKey,
      'response' => $response
    );

    $options = array(
      'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    return $response->success;
  }

  public function getIntentos($cedula)
  {
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC")[0];

    $intento = $infoBloqueo->bloqueo_intentosfallidos ?? 0;

    $intento = $intento + 1;

    // Devolver el consecutivo obtenido
    return $intento;
  }


  public function sanitizarEntrada($value)
  {

    $currentValue = trim($value);
    $currentValue = stripslashes($currentValue);
    $currentValue = htmlspecialchars($currentValue, ENT_QUOTES, 'UTF-8');
    $currentValue = strip_tags($currentValue);
    $currentValue = preg_replace('/[\x00-\x1F\x7F]/u', '', $currentValue);
    return $currentValue;
  }

  public function logoutAction()
  {
    Session::getInstance()->set("usuario", null);
    header('Location: /');
  }
}
