<?php

class Page_loginController extends Page_mainController
{
  // Método de inicialización
  public function init()
  {
    // Si existe un usuario activo, redirige al inicio
    if (Session::getInstance()->get('usuario')) {
      header("Location: /page/home");
    }
    // Llama al método init de la clase padre
    parent::init();
  }

  // Acción por defecto (vacía)
  public function indexAction() {}

  // Acción para mostrar la vista de creación de cuenta
  public function crearcuentaAction()
  {
    // Obtiene el error almacenado en la sesión, si existe
    $error = Session::getInstance()->get("error");
    $registrook = Session::getInstance()->get("registrook");
    // Pasa el error a la vista
    $this->_view->error = $error;
    $this->_view->registrook = $registrook;
 
    
    // Limpia el error de la sesión
    Session::getInstance()->set("registrook", null);
    Session::getInstance()->set("error", null);
  }





  
  public function enviardatosAction()
  {
    // Establece un layout vacío
    $this->setLayout('blanco');
    // Recibe los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Sanitiza y obtiene los datos necesarios
    $nit = $this->sanitizarEntrada($data['nit']);
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);
    $dataCorreo = [];
    $dataCorreo["phone-contact"] = $this->sanitizarEntrada($data['phone-contact']);
    $dataCorreo["phone"] = $this->sanitizarEntrada($data['phone']);
    $dataCorreo["email"] = $this->sanitizarEntrada($data['email']);
    $dataCorreo["address"] = $this->sanitizarEntrada($data['address']);
    $dataCorreo["name"] = $this->sanitizarEntrada($data['name']);
    $dataCorreo["nit"] = $nit;
    $dataCorreo["company"] = $this->sanitizarEntrada($data['company']);
    
  /*   
  $phone = $this->sanitizarEntrada($data['phone']);
    $email = $this->sanitizarEntrada($data['email']);
    $address = $this->sanitizarEntrada($data['address']);
    $name = $this->sanitizarEntrada($data['name']);
    $nit = $this->sanitizarEntrada($data['nit']);
    $company = $this->sanitizarEntrada($data['company']); 
    */



    // Verifica el captcha
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto',
        'message' => 'Captcha incorrecto'
      ];
      echo json_encode($response);
      return;
    }

    // Verifica que la cédula no esté vacía
    if (!$nit) {
      $response = [
        'status' => 'error',
        'message' => 'La cédula es requerida'
      ];
      echo json_encode($response);
      return;
    }





    // Crea una instancia del modelo de envío de correos y envía el correo de recuperación
    $mailModel = new Core_Model_Sendingemail($this->_view);
    $mail = $mailModel->enviardatos($dataCorreo);

    if ($mail == '1') {

      // Prepara la respuesta exitosa
      Session::getInstance()->set("registrook", "El correo ha sido enviado correctamente, pronto nos pondremos en contacto con usted");
      $response = [
        'status' => 'success',
        'message' => 'El correo ha sido enviado correctamente, pronto nos pondremos en contacto con usted',
           
      ];
    } else {
      // Prepara la respuesta de error en caso de fallo al enviar el correo
      Session::getInstance()->set("error", "Ha ocurrido un error al enviar el correo");
      $response = [
        'status' => 'error',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }

    echo json_encode($response);
    return;

  }















  // Acción para procesar la creación de una nueva cuenta
  public function crearAction()
  {
    // Obtiene y sanitiza los parámetros enviados por el usuario
    $name = $this->_getSanitizedParam('name');
    $cedula = $this->_getSanitizedParam('cedula');
    $email = $this->_getSanitizedParam('email');
    $phone = $this->_getSanitizedParam('phone');
    $password = $this->_getSanitizedParam('password');
    $repassword = $this->_getSanitizedParam('re-password');

    // Crea una instancia del modelo de usuario
    $modelUsuario = new Administracion_Model_DbTable_Usuario();

    // Verifica si las contraseñas coinciden
    if ($password !== $repassword) {
      // Almacena un error en la sesión y redirige a la página de creación de cuenta
      Session::getInstance()->set("error", 1);
      header('Location: /page/login/crearcuenta');
      return;
    }

    // Verifica si el correo ya está registrado
    $usuarioEmail = $modelUsuario->getList("user_email = '{$email}'");
    if ($usuarioEmail) {
      Session::getInstance()->set("error", 2);
      header('Location: /page/login/crearcuenta');
      return;
    }

    // Verifica si la cédula o usuario ya existe
    $usuarioCedula = $modelUsuario->getList("user_cedula = '{$cedula}' OR user_user = '{$cedula}'");
    if ($usuarioCedula) {
      Session::getInstance()->set("error", 3);
      header('Location: /page/login/crearcuenta');
      return;
    }

    // Prepara los datos para crear el nuevo usuario
    $data = [];
    $data['user_names'] = $name;
    $data['user_cedula'] = $cedula;
    $data['user_email'] = $email;
    $data['user_telefono'] = $phone;
    $data['user_user'] = $cedula;
    $data['user_password'] = $password; // Nota: Es recomendable encriptar la contraseña
    $data['user_level'] = 2;
    $data['user_state'] = 1;
    $data['user_date'] = date('Y-m-d');

    // Inserta el nuevo usuario en la base de datos
    $id = $modelUsuario->insert($data);
    if ($id) {
      // Obtiene el usuario recién creado y lo almacena en la sesión
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

  // Acción para validar las credenciales del usuario al iniciar sesión
  public function validarAction()
  {
    // Establece un layout vacío
    $this->setLayout('blanco');
    // Recibe los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Sanitiza y obtiene los datos necesarios
    $cedula = $this->sanitizarEntrada($data['cedula']);
    $password = $this->sanitizarEntrada($data['password']);
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);

    // Instancias de los modelos necesarios
    $modelUsuario = new Administracion_Model_DbTable_Usuario();
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    // Verifica el captcha
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      die(json_encode($response));
    }

    // Obtiene información de bloqueos anteriores
    $infoBloqueo = $bloqueosModel->getList(
      "bloqueo_usuario = '$cedula' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ",
      "bloqueo_id DESC"
    )[0];

    // Manejo de intentos fallidos
    $intentos = (int)$infoBloqueo->bloqueo_intentosfallidos;
    $fechaUltimoIntento = $infoBloqueo->bloqueo_fechaintento;
    $fechaUltimoIntento = new DateTime($fechaUltimoIntento);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->getTimestamp() - $fechaUltimoIntento->getTimestamp();

    // Bloquea al usuario si excede los intentos permitidos
    if ($intentos >= 3 && $diferencia <= 900) {
      $response = [
        'status' => 'error',
        'error' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
      ];
      die(json_encode($response));
    }

    // Registra el intento fallido
    $dataBloque = array();
    $dataBloque['bloqueo_usuario'] = $cedula;
    $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($cedula);
    $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
    $bloqueosModel->insert($dataBloque);

    // Busca al usuario en la base de datos
    $usuario = $modelUsuario->getList("user_user = '{$cedula}'")[0];

    if (!$usuario) {
      $res['error'] = "Usuario no encontrado";
      $res['status'] = "error";
      die(json_encode($res));
    }

    $userModel = new core_Model_DbTable_User();

    // Verifica si el usuario está activo
    if ($usuario->user_state != 1) {
      $res['error'] = "Usuario inactivo";
      $res['status'] = "error";
      die(json_encode($res));
    }

    // Autentica al usuario
    if (!$userModel->autenticateUser($cedula, $password)) {
      $res['error'] = "Contraseña incorrecta";
      $res['status'] = "error";
      die(json_encode($res));
    }

    // Resetea los intentos fallidos al iniciar sesión correctamente
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC");
    if (count($infoBloqueo) > 0) {
      foreach ($infoBloqueo as $info) {
        $bloqueosModel->deleteRegister($info->bloqueo_id);
      }
    }

    // Almacena al usuario en la sesión y redirige al inicio
    Session::getInstance()->set("usuario", $usuario);
    $res['status'] = "success";
    $res['redirect'] = "/page/home";
    die(json_encode($res));
  }

  // Acción para mostrar la vista de recuperación de contraseña
  public function recuperarAction()
  {
    $error = Session::getInstance()->get("error");
    $this->_view->error = $error;
    Session::getInstance()->set("error", null);
  }

  // Acción para procesar la solicitud de recuperación de contraseña
  public function consultacorreoAction()
  {
    // Establece un layout vacío
    $this->setLayout('blanco');
    // Recibe los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Sanitiza y obtiene los datos necesarios
    $cedula = $this->sanitizarEntrada($data['cedula']);
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);

    // Verifica el captcha
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      die(json_encode($response));
    }

    // Verifica que la cédula no esté vacía
    if (!$cedula) {
      $response = [
        'status' => 'error',
        'message' => 'La cédula es requerida'
      ];
      die(json_encode($response));
    }

    // Crea una instancia del modelo de usuarios y busca al usuario
    $usersModel = new Page_Model_DbTable_Usuario();
    $user = $usersModel->getList("user_user = '{$cedula}'", "")[0];

    // Si el usuario no existe, devuelve un error
    if (!$user) {
      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún usuario con esa cédula'
      ];
      die(json_encode($response));
    }

    // Enmascara parte del correo electrónico por seguridad
    $email = $user->user_email;
    $emailParts = explode('@', $email);
    $emailParts[0] = substr($emailParts[0], 0, 5) . '***';
    $emailMasked = implode('@', $emailParts);

    // Genera un token único y registra la fecha
    $token = md5(uniqid(rand(), true));
    $token_date = date('Y-m-d H:i:s');

    // Crea una instancia del modelo de envío de correos y envía el correo de recuperación
    $mailModel = new Core_Model_Sendingemail($this->_view);
    $mail = $mailModel->enviarrecuperacion($user, $token);

    if ($mail == '1') {
      // Actualiza el token y la fecha en la base de datos
      $usersModel->editField($user->user_id, 'user_code', $token);
      $usersModel->editField($user->user_id, 'user_codedate', $token_date);

      // Prepara la respuesta exitosa
      $response = [
        'status' => 'success',
        'message' => 'Se ha enviado un correo a ' . $emailMasked . ' con los pasos a seguir',
        'user' => $cedula,
        'email' => $emailMasked
      ];
    } else {
      // Prepara la respuesta de error en caso de fallo al enviar el correo
      $response = [
        'status' => 'errorMail',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }

    // Devuelve la respuesta en formato JSON
    die(json_encode($response));
  }

  // Acción para mostrar la vista de restablecimiento de contraseña
  public function recuperacionAction()
  {
    // Obtiene y sanitiza el token de la URL
    $token = $this->_getSanitizedParam('t');

    // Crea una instancia del modelo de usuarios y busca al usuario por el token
    $usersModel = new Page_Model_DbTable_Usuario();
    $user = $usersModel->getList("user_code = '$token'", "")[0];

    if ($user) {
      // Calcula la diferencia de tiempo desde que se generó el token
      $token_date = new DateTime($user->user_codedate);
      $now = new DateTime();
      $interval = $now->diff($token_date);

      // Si el token es válido (menos de 1 hora)
      if ($interval->h < 1) {
        $this->_view->error = false;
        $this->_view->user = $user;
      } else {
        // Si el token ha expirado
        $this->_view->error = true;
      }
    } else {
      // Si no se encuentra el usuario
      $this->_view->error = true;
    }
  }

  // Acción para procesar el restablecimiento de contraseña
  public function recuperarclaveAction()
  {
    // Recibe los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Sanitiza y obtiene los datos necesarios
    $captcha = $this->sanitizarEntrada($data['g-recaptcha-response']);
    $password = $this->sanitizarEntrada($data['password']);
    $password2 = $this->sanitizarEntrada($data['re-password']);

    // Verifica el captcha
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto'
      ];
      die(json_encode($response));
    }

    // Crea una instancia del modelo de usuarios y obtiene al usuario
    $usersModel = new Page_Model_DbTable_Usuario();
    $user_id = $this->sanitizarEntrada($data['user_id']);
    $user = $usersModel->getById($user_id);

    // Verifica si las contraseñas coinciden
    if ($password == $password2) {
      // Actualiza la contraseña y otros campos relacionados
      $usersModel->editField($user_id, 'user_password', password_hash($password, PASSWORD_DEFAULT));
      $usersModel->editField($user_id, 'user_code', '');
      $usersModel->editField($user_id, 'user_codedate', '');
      $usersModel->editField($user_id, 'user_state', 1);

      // Inicia sesión con el usuario actualizado
      Session::getInstance()->set("usuario", $user);

      // Prepara la respuesta exitosa
      $response = [
        'status' => 'success',
        'message' => 'Contraseña cambiada correctamente',
        'redirect' => '/page/home'
      ];
    } else {
      // Prepara la respuesta de error si las contraseñas no coinciden
      $response = [
        'status' => 'error',
        'message' => 'Las contraseñas no coinciden'
      ];
    }

    // Devuelve la respuesta en formato JSON
    die(json_encode($response));
  }



  // Método privado para verificar el captcha
  private function verifyCaptcha($response)
  {
    // Clave secreta de reCAPTCHA
    $secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';

    // URL de verificación de reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secretKey,
      'response' => $response
    );

    // Configuración de la solicitud HTTP POST
    $options = array(
      'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    // Realiza la solicitud y decodifica la respuesta
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // Devuelve true si el captcha es válido
    return $response->success;
  }

  // Método para obtener el número de intentos fallidos de un usuario
  public function getIntentos($cedula)
  {
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    // Obtiene el último registro de bloqueo del usuario
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC")[0];

    // Incrementa el contador de intentos fallidos
    $intento = $infoBloqueo->bloqueo_intentosfallidos ?? 0;
    $intento = $intento + 1;

    // Devuelve el número de intentos
    return $intento;
  }

  // Método para sanitizar las entradas del usuario
  public function sanitizarEntrada($value)
  {
    $currentValue = trim($value);
    $currentValue = stripslashes($currentValue);
    $currentValue = htmlspecialchars($currentValue, ENT_QUOTES, 'UTF-8');
    $currentValue = strip_tags($currentValue);
    $currentValue = preg_replace('/[\x00-\x1F\x7F]/u', '', $currentValue);
    return $currentValue;
  }

  // Acción para cerrar la sesión del usuario
  public function logoutAction()
  {
    // Elimina al usuario de la sesión
    Session::getInstance()->set("usuario", null);
    // Redirige a la página principal
    header('Location: /');
  }
}
