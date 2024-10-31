<?php 
/**
* clase que genera la insercion y edicion  de foto en la base de datos
*/
class Administracion_Model_DbTable_Fotos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'fotos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'foto_id';

	/**
	 * insert recibe la informacion de un foto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$foto_estado = $data['foto_estado'];
		$foto_nombre = $data['foto_nombre'];
		$foto_foto = $data['foto_foto'];
		$foto_descripcion = $data['foto_descripcion'];
		$foto_album = $data['foto_album'];
		$foto_solucion = $data['foto_solucion'];
		$foto_producto = $data['foto_producto'];
		$query = "INSERT INTO fotos( foto_estado, foto_nombre, foto_foto, foto_descripcion, foto_album, foto_solucion, foto_producto) VALUES ( '$foto_estado', '$foto_nombre', '$foto_foto', '$foto_descripcion', '$foto_album', '$foto_solucion', '$foto_producto')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un foto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$foto_estado = $data['foto_estado'];
		$foto_nombre = $data['foto_nombre'];
		$foto_foto = $data['foto_foto'];
		$foto_descripcion = $data['foto_descripcion'];
		$foto_album = $data['foto_album'];
		$foto_solucion = $data['foto_solucion'];
		$foto_producto = $data['foto_producto'];
		$query = "UPDATE fotos SET  foto_estado = '$foto_estado', foto_nombre = '$foto_nombre', foto_foto = '$foto_foto', foto_descripcion = '$foto_descripcion', foto_album = '$foto_album', foto_solucion = '$foto_solucion', foto_producto = '$foto_producto' WHERE foto_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}