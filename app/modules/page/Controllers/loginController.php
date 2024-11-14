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

  // Acción para validar las credenciales del usuario al iniciar sesión
  public function validarAction()
  {
    // Establece un layout vacío
    $this->setLayout('blanco');
    // Recibe los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Sanitiza y obtiene los datos necesarios
    $email = $this->sanitizarEntrada($data['email']);

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
      echo json_encode($response);
      return;
    }

    // Obtiene información de bloqueos anteriores
    $infoBloqueo = $bloqueosModel->getList(
      "bloqueo_usuario = '$email' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ",
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
      echo json_encode($response);
      return;
    }

    // Registra el intento fallido
    $dataBloque = array();
    $dataBloque['bloqueo_usuario'] = $email;
    $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($email);
    $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
    $bloqueosModel->insert($dataBloque);


    // Busca al usuario en la base de datos
    $usuario = $modelUsuario->getList("user_email = '{$email}'")[0];

    if (!$usuario) {
      $response['error'] = "Usuario no encontrado";
      $response['status'] = "error";
      echo json_encode($response);
      return;
    }


    // Verifica si el usuario está activo
    if ($usuario->user_state != 1) {
      $response['error'] = "Usuario inactivo";
      $response['status'] = "error";
      echo json_encode($response);
      return;
    }

    // Autentica al usuario

    // Verifica si el usuario está activo
    if ($usuario->user_state != 1) {
      $response['error'] = "Usuario inactivo";
      $response['status'] = "error";
      echo json_encode($response);
      return;
    }
    $otp = $this->generateOTP();
    $otpModel = new Administracion_Model_DbTable_Otpcodes();
    $otpData = array(
      'user' => $email,
      'code' => $otp,
      'date' => date('Y-m-d H:i:s')
    );
    $otpId = $otpModel->insert($otpData);

    if (!$otpId) {
      $response['error'] = "Error al generar OTP";
      $response['status'] = "error";
      echo json_encode($response);
    }

    $mailModel = new Core_Model_Sendingemail($this->_view);
    $boolMail = $mailModel->enviarOTP($usuario, $otp);
    if ($boolMail) {
      $response = [
        'status' => 'success',
        'message' => 'Se ha enviado un correo con el código OTP',
        'email' => base64_encode($usuario->user_email),
      ];
    } else {
      $response = [
        'status' => 'error',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }


    // Resetea los intentos fallidos al iniciar sesión correctamente
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$email'", "bloqueo_id DESC");
    if (count($infoBloqueo) > 0) {
      foreach ($infoBloqueo as $info) {
        $bloqueosModel->deleteRegister($info->bloqueo_id);
      }
    }


    echo json_encode($response);
    return;
  }

  public function otpAction()
  {
    $email = base64_decode($this->_getSanitizedParam('e'));

    $this->_view->emailHidden = $this->_getSanitizedParam('e');
    //Ocultar caracteres de correo
    $email = explode('@', $email);
    $email[0] = substr($email[0], 0, 5) . '***';
    $email = implode('@', $email);
    $this->_view->email = $email;
  }
  public function login2Action()
  {
    $this->setLayout('blanco');
    $response = [];
    $otp = '';
    for ($i = 1; $i <= 6; $i++) {
      $otp .= $this->_getSanitizedParam('otp' . $i);
    }
    $email = base64_decode($this->_getSanitizedParam('email'));

    $otpModel = new Administracion_Model_DbTable_Otpcodes();
    $otpData = $otpModel->getList("code = '$otp' AND date >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)", "");

    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();
    // Obtiene información de bloqueos anteriores
    $infoBloqueo = $bloqueosModel->getList(
      "bloqueo_usuario = '$email' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ",
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
        'message' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
      ];
      echo json_encode($response);
      return;
    }

    if (!$otpData) {

      // Registra el intento 
      $dataBloque = array();
      $dataBloque['bloqueo_usuario'] = $email;
      $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($email);
      $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
      $bloqueosModel->insert($dataBloque);

      $response = [
        'status' => 'error',
        'message' => 'Código OTP inválido o expirado',
        'email' => $email
      ];
      echo json_encode($response);
      return;
    }


    $email = $otpData[0]->user;
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList("user_email = '$email'")[0];

    if (!$usuario) {
      // Registra el intento 
      $dataBloque = array();
      $dataBloque['bloqueo_usuario'] = $email;
      $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($email);
      $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
      $bloqueosModel->insert($dataBloque);

      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún usuario con ese correo'
      ];
      echo json_encode($response);
      return;
    }

    // Resetea los intentos fallidos al iniciar sesión correctamente
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$email'", "bloqueo_id DESC");
    if (count($infoBloqueo) > 0) {
      foreach ($infoBloqueo as $info) {
        $bloqueosModel->deleteRegister($info->bloqueo_id);
      }
    }

    Session::getInstance()->set("usuario", $usuario);


    $response = [
      'status' => 'success',
      'message' => 'Inicio de sesión exitoso',
      'user' => $email,
      'name' => $usuario->user_names,
    ];

    echo json_encode($response);
    return;
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
  public function getIntentos($email)
  {
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    // Obtiene el último registro de bloqueo del usuario
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$email'", "bloqueo_id DESC")[0];

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

  private function generateOTP($length = 6)
  {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
      $otp .= random_int(0, 9);
    }
    return $otp;
  }

  // Acción para cerrar la sesión del usuario
  public function logoutAction()
  {
    // Elimina al usuario de la sesión
    Session::getInstance()->set("usuario", null);
    Session::getInstance()->set("usuario", []);
    session_destroy();
   
    // Redirige a la página principal
    header('Location: /');
  }
}
