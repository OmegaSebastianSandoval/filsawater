<?php 
/**
* clase que genera la insercion y edicion  de categor&iacute;as en la base de datos
*/
class Administracion_Model_DbTable_Tiendacategorias extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'tienda_categorias';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'tienda_categoria_id';

	/**
	 * insert recibe la informacion de un categor&iacute;a y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$tienda_categoria_estado = $data['tienda_categoria_estado'];
		$tienda_categoria_nombre = $data['tienda_categoria_nombre'];
		$tienda_categoria_imagen = $data['tienda_categoria_imagen'];
		$tienda_categoria_descripcion = $data['tienda_categoria_descripcion'];
		$tienda_categoria_padre = $data['tienda_categoria_padre'];
		$query = "INSERT INTO tienda_categorias( tienda_categoria_estado, tienda_categoria_nombre, tienda_categoria_imagen, tienda_categoria_descripcion, tienda_categoria_padre) VALUES ( '$tienda_categoria_estado', '$tienda_categoria_nombre', '$tienda_categoria_imagen', '$tienda_categoria_descripcion', '$tienda_categoria_padre')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un categor&iacute;a  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$tienda_categoria_estado = $data['tienda_categoria_estado'];
		$tienda_categoria_nombre = $data['tienda_categoria_nombre'];
		$tienda_categoria_imagen = $data['tienda_categoria_imagen'];
		$tienda_categoria_descripcion = $data['tienda_categoria_descripcion'];
		$tienda_categoria_padre = $data['tienda_categoria_padre'];
		$query = "UPDATE tienda_categorias SET  tienda_categoria_estado = '$tienda_categoria_estado', tienda_categoria_nombre = '$tienda_categoria_nombre', tienda_categoria_imagen = '$tienda_categoria_imagen', tienda_categoria_descripcion = '$tienda_categoria_descripcion', tienda_categoria_padre = '$tienda_categoria_padre' WHERE tienda_categoria_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}