<?php

class Page_confirmacionController extends Page_mainController
{



  public function indexAction()
  {

    // Responder a Wompi
    http_response_code(200);
    header("HTTP/1.1 200 OK");
    header('Status: 200');
    echo json_encode(array());
    echo json_encode(['message' => 'Evento recibido correctamente']);

    // Leer el cuerpo de la solicitud (JSON enviado por Wompi)
    $payload = file_get_contents('php://input');

    // Intentar decodificar el JSON
    $dataReceived = json_decode($payload, true);

    // Preparar el log
    $logData = [];

    if (!$dataReceived) {
      // Si no se pudo decodificar, registrar el cuerpo como texto
      $logData['log_log'] = $payload;
      $logData['log_tipo'] = 'CONFIRMACION (NO SE PUDO DECODIFICAR)';
      // Insertar el log en la base de datos
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($logData);
      return;
    }


    // Si se pudo decodificar, extraer los datos necesarios
    //verificar cadena
    $idTransaccion = $dataReceived["data"]["transaction"]["id"];
    $status = $dataReceived["data"]["transaction"]["status"];
    $amount = $dataReceived["data"]["transaction"]["amount_in_cents"];
    $timestamp = $dataReceived["timestamp"];
    $wompi = Payment_Wompi::getInstance()->getData();
    $events = $wompi["events"];

    $cadena = $idTransaccion . $status . $amount . $timestamp . $events;

    $cadenaHash =  hash("sha256", $cadena);

    if ($cadenaHash != $dataReceived["signature"]["checksum"]) {
      // Si la cadena no coincide, registrar el cuerpo como texto
      $logData['log_log'] = $payload;
      $logData['log_tipo'] = 'CONFIRMACION (CADENA NO COINCIDE)';
      // Insertar el log en la base de datos
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($logData);
      return;
    }



    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $estados = $this->getPedidoestado();
    $estadosTexto = $this->getListStatus();
    $idPedido = $dataReceived["data"]["transaction"]["reference"];

    if ($dataReceived["data"]["transaction"]["payment_method_type"] == 'CARD') {
      $entidadPedido = $dataReceived["data"]["transaction"]["payment_method"]["extra"]["brand"];
    } else {
      $entidadPedido = $dataReceived["data"]["transaction"]["payment_method_type"];
    }
    $estadoPedido = $estados[$dataReceived["data"]["transaction"]["status"]];
    $estadoPedidoTexto = $estadosTexto[$dataReceived["data"]["transaction"]["status"]];
    $validacionPedido = $dataReceived["data"]["transaction"]["status"];
    $mensajePedido = $dataReceived["data"]["transaction"]["status_message"];
    $documento = $dataReceived["data"]["transaction"]["customer_data"]["legal_id"];


    $pedido = $pedidosModel->getById($idPedido);
    if (
      ($pedido->pedido_estado == 5 ||
        $pedido->pedido_estado == 6 ||
        $pedido->pedido_estado == 7 ||
        $pedido->pedido_estado == 8 ||
        $pedido->pedido_estado == 9 ||
        $pedido->pedido_estado == 10) &&
      $pedido->pedido_identificador == $idTransaccion
    ) {
      return;
    }
    if ($pedido) {
      $pedidosModel->editField($idPedido, "pedido_estado", $estadoPedido);
      $pedidosModel->editField($idPedido, "pedido_identificador", $idTransaccion);
      $pedidosModel->editField($idPedido, "pedido_entidad", $entidadPedido);
      $pedidosModel->editField($idPedido, "pedido_respuesta", $mensajePedido);
      $pedidosModel->editField($idPedido, "pedido_validacion", $validacionPedido);
      $pedidosModel->editField($idPedido, "pedido_validacion_texto", $estadoPedidoTexto);

      $pedidosModel->editarResponse($idPedido,  json_encode($dataReceived));

      if ($estadoPedido != 5) {
        $this->retornarInventario($idPedido);
      }
      $mailModel = new Core_Model_Sendingemail($this->_view);
      $mail = $mailModel->enviarCorreoTienda($idPedido);
      //envio de correo
      $pedidosModel->editField($idPedido, "pedido_validacion2", $mail);
    }

    $logData['log_usuario'] =  $documento;


    // Si los datos son válidos, guardar lo recibido
    $logData['log_log'] = print_r($dataReceived, true);
    $logData['log_tipo'] = 'DATOS RECIBIDOS DE WOMPI';



    // Insertar el log en la base de datos
    $logModel = new Administracion_Model_DbTable_Log();
    $logModel->insert($logData);
  }


  public function retornarInventario($pedidoId)
  {

    $productoPedidoModel = new Administracion_Model_DbTable_Productosporpedido();
    $productosModel = new Administracion_Model_DbTable_Productos();
    $productos = $productoPedidoModel->getList("pedido_producto_pedido='{$pedidoId}'");

    foreach ($productos as $producto) {
      $productoDetalle = $productosModel->getById($producto->pedido_producto_producto);
      $nuevoStock = $productoDetalle->producto_stock + $producto->pedido_producto_cantidad;
      $productosModel->editField($producto->pedido_producto_producto, "producto_stock", $nuevoStock);
    }
  }


  public function getListStatus()
  {
    $data = [];
    $data["PENDING"] = "Transacción pendiente";
    $data["APPROVED"] = "Transacción aprobada";
    $data["DECLINED"] = "Transacción rechazada";
    $data["VOIDED"] = "Transacción anulada";
    $data["ERROR"] = "Error interno del método de pago respectivo";
    return $data;
  }

  public function getPedidoestado()
  {
    $array = array();
    $array["PENDING"] = 9;
    $array["APPROVED"] = 5;
    $array["DECLINED"] = 6;
    $array["VOIDED"] = 7;
    $array["ERROR"] = 8;

    return $array;
  }
}
