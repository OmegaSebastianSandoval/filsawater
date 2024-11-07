<?php

/**
 * clase que genera la insercion y edicion  de producto en la base de datos
 */
class Administracion_Model_DbTable_Productos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'productos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'producto_id';

	/**
	 * insert recibe la informacion de un producto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$producto_estado = $data['producto_estado'];
		$producto_nombre = $data['producto_nombre'];
		$producto_referencia = $data['producto_referencia'];
		$producto_precio = $data['producto_precio'];
		$producto_imagen = $data['producto_imagen'];
		$producto_importante = $data['producto_importante'];
		$producto_stock = $data['producto_stock'];
		$producto_categoria = $data['producto_categoria'];
		$producto_descripcion = $data['producto_descripcion'];
		$query = "INSERT INTO productos( producto_estado, producto_nombre,producto_referencia, producto_precio, producto_imagen,producto_importante, producto_stock, producto_categoria, producto_descripcion) VALUES ( '$producto_estado', '$producto_nombre', '$producto_referencia','$producto_precio', '$producto_imagen', '$producto_importante','$producto_stock', '$producto_categoria', '$producto_descripcion')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un producto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$producto_estado = $data['producto_estado'];
		$producto_nombre = $data['producto_nombre'];
		$producto_referencia = $data['producto_referencia'];
		$producto_precio = $data['producto_precio'];
		$producto_imagen = $data['producto_imagen'];
		$producto_importante = $data['producto_importante'];

		$producto_stock = $data['producto_stock'];
		$producto_categoria = $data['producto_categoria'];
		$producto_descripcion = $data['producto_descripcion'];
		$query = "UPDATE productos SET  producto_estado = '$producto_estado', producto_nombre = '$producto_nombre', producto_referencia = '$producto_referencia',  producto_precio = '$producto_precio', producto_imagen = '$producto_imagen', producto_importante = '$producto_importante', producto_stock = '$producto_stock', producto_categoria = '$producto_categoria', producto_descripcion = '$producto_descripcion' WHERE producto_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
}
