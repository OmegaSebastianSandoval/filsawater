<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

  protected $_csrf_section = "omega_index";
  public $botonactivo  = 1;


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
    $this->_view->banner = $this->template->bannerPrincipalInd(1);
    $this->_view->contenido = $this->template->getContentseccion(1);

    $blogsModel = new Administracion_Model_DbTable_Blogs();
    $blogs = $blogsModel->getList("blog_estado = 1", "blog_fecha ASC LIMIT 6");
    $this->_view->blogs = $blogs;

    $solucionesModel = new Administracion_Model_DbTable_Soluciones();
    $soluciones = $solucionesModel->getList("solucion_estado = 1 AND solucion_padre=''", "orden ASC LIMIT 6");
    $this->_view->soluciones = $soluciones;
  
  }
  public function enviarmessageAction()
  {

    //  error_reporting(E_ALL);

    // Inicia la sesión si no está ya iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }






    // Recibir los datos enviados en formato JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verificar si la decodificación fue exitosa y si se recibieron los datos esperados
    $name = $this->sanitizarEntrada($data['nombres']);
    $lastnames = $this->sanitizarEntrada($data['apellidos']);
    $phone = $this->sanitizarEntrada($data['phone']);
    $email = $this->sanitizarEntrada($data['correo']);
    $message = $this->sanitizarEntrada($data['asunto']);

    $lastname = $this->sanitizarEntrada($data['lastname']);



    $g_recaptcha_response = $this->sanitizarEntrada($data['g-recaptcha-response']);
    $hash = $this->sanitizarEntrada($data['hash']);
    $csrf = $this->sanitizarEntrada($data['csrf']);
    $csrf_section = $this->sanitizarEntrada($data['csrf_section']);
    $csrf_token = $this->sanitizarEntrada($data['csrf_token']);
    $hash2 = md5(date("Y-m-d"));
    $data2["name"] = $name;
    $data2["lastnames"] = $lastnames;
    $data2["phone"] = $phone;
    $data2["email"] = $email;
    $data2["message"] = $message;




    if (Session::getInstance()->get('csrf')[$csrf_section] != $csrf) {
      $res['error'] = "Token CSRF inválido";
      $res['status'] = "error";
      die(json_encode($res));
    }

    if (!isset($csrf_token) ||  $csrf_token !== $_SESSION['csrf_token']) {
      $res['error'] = "Token CSRF inválido";
      $res['status'] = "error";
      die(json_encode($res));
    }


    if (!$this->verifyCaptcha($g_recaptcha_response)) {
      $res['error'] = "Token CSRF inválido";
      $res['status'] = "error";
      die(json_encode($res));
    }

    if ($hash2 !== $hash) {
      $res['error'] = "Token CSRF inválido";
      $res['status'] = "error";
      die(json_encode($res));
    }


    if ($lastname == "") {
      if ($name != "" and $email != "" and $message != ""  and $lastnames != "" and $phone != "") {
        if (
          strpos($message, "@") === false &&
          strpos($name, "@") === false &&
          strpos($email, "mail4u.life") === false &&
          strpos($email, "zetetic.sbs") === false &&
          strpos($email, "zetetic.sbs") === false &&
          strpos($message, "<a") === false &&
          strpos($message, "'") === false &&
          strpos($message, "/") === false &&
          strpos($message, "//") === false &&
          strpos($message, "http") === false &&
          strpos($message, "@") === false &&
          strpos($message, ".co") === false &&

          strpos($message, "!") === false &&
          strpos($message, "Hi ") === false &&



          strpos($message, "\'") === false &&
          strpos($message, "`") === false &&
          strpos($message, "\\") === false

        ) {
          // No hay ning煤n enlace, script, ' o / o \ en $message
          $mail = new Core_Model_Sendingemail($this->_view);
          $mail_response = $mail->sendMailContact($data2);
        } else {
          $res['error'] = "Error de validación";
        }
      } else {
        $res['error'] = "Error campos";
      }
    } else {
      $res['error'] = "Error honey";
    }


    if ($mail_response == 1) {
      $res['status'] = "success";
    } else {
      $res['status'] = "error";
    }

    die(json_encode($res));
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

  public function enviarcorreoAction()
  {
    $this->setLayout('blanco');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Verificar si es una solicitud AJAX
      if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
        exit;
      }

      // Obtener los datos JSON del cuerpo de la solicitud
      $json = file_get_contents('php://input');
      $data = json_decode($json, true);

      $email = isset($data['email']) ? trim($data['email']) : '';
      $hiddenField = isset($data['name']) ? $data['name'] : '';
      $hiddenField2 = isset($data['lastname']) ? $data['lastname'] : '';


      // Validación del email en el lado del servidor
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Correo electrónico no válido.']);
        exit;
      }

      // Medidas anti-spam

      // 1. Honeypot: si el campo oculto tiene contenido, es spam
      if (!empty($hiddenField) || !empty($hiddenField2)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Detección de spam.']);
        exit;
      }

      // 2. Limitar la tasa de envíos por IP
      session_start();
      $currentTime = time();
      $ipAddress = $_SERVER['REMOTE_ADDR'];
      $timeout = 60; // Tiempo en segundos entre envíos permitidos

      if (isset($_SESSION['last_submit_time'][$ipAddress])) {
        $elapsedTime = $currentTime - $_SESSION['last_submit_time'][$ipAddress];
        if ($elapsedTime < $timeout) {
          http_response_code(429);
          echo json_encode(['success' => false, 'message' => 'Por favor, espera antes de enviar nuevamente.']);
          exit;
        }
      }
      $_SESSION['last_submit_time'][$ipAddress] = $currentTime;

      // 3. Implementar reCAPTCHA (opcional)

      // 4. Enviar correo o guardar el email en la base de datos
      // Aquí va tu lógica para manejar el email
      // Por ejemplo, enviar un correo de confirmación o guardar en la base de datos
      $correosIngresoModel = new Administracion_Model_DbTable_Correosinformacion();
      $correoExiste  = $correosIngresoModel->getList("correos_informacion_correo = '$email'");
      if (count($correoExiste) == 0) {
        $correosIngresoModel->insert([
          'correos_informacion_correo' => $email,
          'correos_informacion_fecha' => date('Y-m-d'),
          'correos_informacion_estado' => 1
        ]);
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Correo recibido.']);
      } else {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Correo ya registrado.']);
      }
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    }
  }
}
