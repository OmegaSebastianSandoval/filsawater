<?php 

/**
*
*/

class Page_carritoController extends Page_mainController
{

	public function indexAction()
	{
		// error_reporting(E_ALL);

		
		$this->setLayout("blanco");
		$productoModel =  new Administracion_Model_DbTable_Productos();
		$carrito = $this->getCarrito();

		$data = [];
		foreach ($carrito as $id => $cantidad) {
			$data[$id] = [];
			$data[$id]['detalle'] = $productoModel->getById($id);
			$data[$id]['cantidad'] = (int)$cantidad;
		}
		$this->_view->carrito = $data;
	}

	public function getCarrito(){
		if(Session::getInstance()->get("carrito")){
			return Session::getInstance()->get("carrito");
		} else {
			return [];
		}
	}


	public function additemAction(){
		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$cantidad =  $this->_getSanitizedParam("cantidad");

		$carrito = $this->getCarrito();
	

		if($carrito[$id]){
			//echo "entro";
			$carrito[$id] = $carrito[$id]+$cantidad;
		} else {
			$carrito[$id] = $cantidad;
		}
		$i = $carrito[$id];
		
		Session::getInstance()->set("carrito",$carrito);






	}

	public function deleteitemAction(){
		

		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$carrito = $this->getCarrito();
		// print_r($carrito);

		if($carrito[$id]){
			unset($carrito[$id]);
		}
		Session::getInstance()->set("carrito",$carrito);



	}

	public function changecantidadAction(){
		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$cantidad =  $this->_getSanitizedParam("cantidad");
		$carrito = $this->getCarrito();
		if($carrito[$id]){
			$carrito[$id] = $cantidad;
		}
		Session::getInstance()->set("carrito",$carrito);


	}

}