<?php

/**
 * clase que genera la insercion y edicion  de blog en la base de datos
 */
class Administracion_Model_DbTable_Blogs extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'blogs';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'blog_id';

	/**
	 * insert recibe la informacion de un blog y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$blog_titulo = $data['blog_titulo'];
		$blog_imagen = $data['blog_imagen'];
		$blog_categoria_id = $data['blog_categoria_id'];
		// $blog_autor = $data['blog_autor'];
		$blog_autor = Session::getInstance()->get("kt_login_name");

		$blog_fecha = $data['blog_fecha'];
		$blog_estado = $data['blog_estado'];
		$blog_importante = $data['blog_importante'];
		$blog_nuevo = $data['blog_nuevo'];
		$blog_descripcion = $data['blog_descripcion'];
		$blog_introduccion = $data['blog_introduccion'];
		$blog_contenido = $data['blog_contenido'];
		$tags = $data['tags'];
		$query = "INSERT INTO blogs( blog_titulo, blog_imagen, blog_categoria_id, blog_autor, blog_fecha, blog_estado, blog_importante, blog_nuevo, blog_descripcion, blog_introduccion, blog_contenido, tags) VALUES ( '$blog_titulo', '$blog_imagen', '$blog_categoria_id', '$blog_autor', '$blog_fecha', '$blog_estado', '$blog_importante', '$blog_nuevo', '$blog_descripcion', '$blog_introduccion', '$blog_contenido', '$tags')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un blog  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$blog_titulo = $data['blog_titulo'];
		$blog_imagen = $data['blog_imagen'];
		$blog_categoria_id = $data['blog_categoria_id'];
		// $blog_autor = $data['blog_autor'];
		$blog_autor = Session::getInstance()->get("kt_login_name");

		$blog_fecha = $data['blog_fecha'];
		$blog_estado = $data['blog_estado'];
		$blog_importante = $data['blog_importante'];
		$blog_nuevo = $data['blog_nuevo'];

		$blog_descripcion = $data['blog_descripcion'];

		$blog_introduccion = $data['blog_introduccion'];
		$blog_contenido = $data['blog_contenido'];
		$tags = $data['tags'];
		$query = "UPDATE blogs SET  blog_titulo = '$blog_titulo', blog_imagen = '$blog_imagen', blog_categoria_id = '$blog_categoria_id', blog_autor = '$blog_autor', blog_fecha = '$blog_fecha', blog_estado = '$blog_estado', blog_importante = '$blog_importante', blog_nuevo = '$blog_nuevo', blog_descripcion = '$blog_descripcion', blog_introduccion = '$blog_introduccion',  blog_contenido = '$blog_contenido', tags = '$tags' WHERE blog_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
}
