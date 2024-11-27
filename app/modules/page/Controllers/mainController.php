<?php

/**
 *
 */

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{
		$this->setLayout('page_page');
		$this->_view->botonactivo = $this->botonactivo;
		$this->_view->solucionId = $this->solucionId;
		$this->_view->categoriaHeader = $this->categoriaHeader;

		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();
		$categoriasModel = new Administracion_Model_DbTable_Tiendacategorias();
		

		$this->_view->categoriasHeader = $categoriasModel->getList("tienda_categoria_estado='1'", "orden ASC");

		$this->_view->usuario = $this->usuarioLogged();

		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;

		// Obtener la lista de categorías de blog
		$this->_view->list_blog_categoria_id = $this->getCategoriasSoluciones();
		$publicidadModel = new Page_Model_DbTable_Publicidad();


		$this->_view->botonesFlotantes = $publicidadModel->getList("publicidad_seccion='100' AND publicidad_estado='1'", "orden ASC");

		$this->_view->carrito = $this->_view->getRoutPHP('modules/page/Views/carrito/index.php');

		// $this->getcartlist();
		$this->getLayout()->setData("meta_description", "$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords", "$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts", "$informacion->info_pagina_scripts");
		$this->_view->botones = $publicidadModel->getList("publicidad_seccion='3' AND publicidad_estado='1'", "orden ASC");
		$this->_view->popup = $publicidadModel->getList("publicidad_seccion='101' AND publicidad_estado=1", "")[0];

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);
		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("", "orden ASC");
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);
		$adicionales = $this->_view->getRoutPHP('modules/page/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales", $adicionales);
		$carrito = $this->_view->getRoutPHP('modules/page/Views/partials/carrito.php');
		$this->getLayout()->setData("carrito", $carrito);
		$this->usuario();
	}


	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
	}
	public function usuarioLogged()
	{
		$usuario = Session::getInstance()->get("usuario");

		if ($usuario->user_id) {
			$usuarioModel = new Administracion_Model_DbTable_Usuario();
			$usuario = $usuarioModel->getById($usuario->user_id);
			Session::getInstance()->set("usuario", $usuario);

			return $usuario;
		}
	}


	/**
	 * Genera un array con los valores del campo categoría.
	 *
	 * @return array Arreglo con los IDs y nombres de las categorías.
	 */
	public function getCategoriasSoluciones()
	{
		// Instanciar el modelo de categorías
		$modelData = new Administracion_Model_DbTable_Soluciones();

		// Obtener la lista de categorías
		$data = $modelData->getList("solucion_estado = 1 AND solucion_padre =''", "orden ASC");

		// Crear un array asociativo [categoria_id => categoria_nombre]
		$array = array_column($data, 'solucion_categoria', 'solucion_id');

		return $array;
	}

	public function getCarrito()
	{
		if (Session::getInstance()->get("carrito")) {
			return Session::getInstance()->get("carrito");
		} else {
			return [];
		}
	}
	public function getcartAction()
	{

		$this->setLayout("blanco");


		$productoModel =  new Administracion_Model_DbTable_Productos();
		$nivelesModel = new Administracion_Model_DbTable_Niveles();
		$usuario = $this->usuarioLogged();
		$nivel = $nivelesModel->getById($usuario->user_nivel_cliente);
		$descuento = $nivel->nivel_porcentaje;
		$carrito = $this->getCarrito();



		$data = [];
		foreach ($carrito as $id => $cantidad) {

			$producto = $productoModel->getById($id);
			$producto->producto_precio -= $producto->producto_precio * $descuento / 100;

			$data[$id] = [];
			$data[$id]['detalle'] = $producto;
			$data[$id]['cantidad'] = (int)$cantidad;
		}
		// print_r($data);
		$this->_view->carrito = $data;
		echo json_encode($data);
	}
	public function getcartlist()
	{



		$productoModel =  new Administracion_Model_DbTable_Productos();
		$carrito = $this->getCarrito();


		$data = [];
		foreach ($carrito as $id => $cantidad) {
			$data[$id] = [];
			$data[$id]['detalle'] = $productoModel->getById($id);
			$data[$id]['cantidad'] = (int)$cantidad;
		}
		// print_r($data);
		$this->_view->carrito = $data;
	}

	public function additemAction()
	{
		$this->setLayout("blanco");


		// Recibir y decodificar el JSON desde la solicitud
		$data = json_decode(file_get_contents("php://input"), true);
		$productId = $data['productId'];
		$quantity = $data['quantity'];

		// Obtener el carrito actual desde la sesión
		$carrito = $this->getCarrito();
		$productoModel =  new Administracion_Model_DbTable_Productos();
		$producto = $productoModel->getById($productId);

		// Actualizar la cantidad en el carrito
		if (isset($carrito[$productId])) {
			//validar stock
			if ($producto->producto_stock < $carrito[$productId] + $quantity) {
				echo json_encode([
					"icon" => "error",
					"text" => "No hay suficiente stock",
					"carrito" => $carrito
				]);
				return;
			}
			if ($carrito[$productId] + $quantity > 50) {
				echo json_encode([
					"icon" => "error",
					"text" => "No puedes agregar más de 50 unidades",
					"carrito" => $carrito
				]);
				return;
			}
			$carrito[$productId] += $quantity;
		} else {
			$carrito[$productId] = $quantity;
		}
		//  print_r($carrito);

		// Guardar el carrito actualizado en la sesión
		Session::getInstance()->set("carrito", $carrito);

		// Devolver una respuesta JSON para confirmar
		echo json_encode([
			"icon" => "success",
			"text" => "Producto añadido al carrito",
			"carrito" => $carrito
		]);
	}
	public function additemcartAction()
	{
		$this->setLayout("blanco");


		// Recibir y decodificar el JSON desde la solicitud
		$data = json_decode(file_get_contents("php://input"), true);
		$productId = $data['productId'];
		$quantity = $data['quantity'];

		// Obtener el carrito actual desde la sesión
		$carrito = $this->getCarrito();
		$productoModel =  new Administracion_Model_DbTable_Productos();
		$producto = $productoModel->getById($productId);
		if (!$productId || !$quantity) {

			echo json_encode([
				"icon" => "error",
				"text" => "Error al actualizar el carrito",
				"carrito" => $carrito
			]);
			return;
		}




		//validar stock
		if ($carrito[$productId] == 1 && $quantity == 1) {
			unset($carrito[$productId]);
			Session::getInstance()->set("carrito", $carrito);
			echo json_encode([
				"icon" => "success",
				"text" => "Producto eliminado del carrito",
				"carrito" => $carrito
			]);
			return;
		}
		if ($carrito[$productId] === $quantity && $quantity != 1) {
			echo json_encode([
				"icon" => "error",
				"text" => "No hay suficiente stock 1",
				"carrito" => $carrito
			]);
			return;
		}
		if ($quantity > $producto->producto_stock) {
			echo json_encode([
				"icon" => "error",
				"text" => "No hay suficiente stock",
				"carrito" => $carrito
			]);
			return;
		}
		$carrito[$productId] = $quantity;



		//  print_r($carrito);

		// Guardar el carrito actualizado en la sesión
		Session::getInstance()->set("carrito", $carrito);

		// Devolver una respuesta JSON para confirmar
		echo json_encode([
			"icon" => "success",
			"text" => "Carrito Actualizado",
			"carrito" => $carrito
		]);
		return;
	}

	public function deleteitemAction()
	{
		$this->setLayout("blanco");

		// Recibir y decodificar el JSON desde la solicitud
		$data = json_decode(file_get_contents("php://input"), true);
		$productId = $data['id'] ?? null;

		if ($productId !== null) {
			// Obtener el carrito actual desde la sesión
			$carrito = $this->getCarrito();

			// Eliminar el producto del carrito si existe
			if (isset($carrito[$productId])) {
				unset($carrito[$productId]);
			}

			// Guardar el carrito actualizado en la sesión
			Session::getInstance()->set("carrito", $carrito);

			// Devolver una respuesta JSON para confirmar
			echo json_encode([
				"icon" => "success",
				"text" => "Producto eliminado del carrito",
				"carrito" => $carrito
			]);
		} else {
			// Manejar el caso donde `productId` no se proporciona correctamente
			echo json_encode([
				"icon" => "error",
				"text" => "ID del producto no válido"
			]);
		}
	}


	public function changecantidadAction()
	{
		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$cantidad =  $this->_getSanitizedParam("cantidad");
		$carrito = $this->getCarrito();
		if ($carrito[$id]) {
			$carrito[$id] = $cantidad;
		}
		Session::getInstance()->set("carrito", $carrito);
	}
}
