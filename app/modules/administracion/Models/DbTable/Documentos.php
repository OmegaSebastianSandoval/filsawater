<?php 
/**
* clase que genera la insercion y edicion  de documento en la base de datos
*/
class Administracion_Model_DbTable_Documentos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'documentos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'documento_id';

	/**
	 * insert recibe la informacion de un documento y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$documento_estado = $data['documento_estado'];
		$documento_nombre = $data['documento_nombre'];
		$documento_documento = $data['documento_documento'];
		$documento_solucion = $data['documento_solucion'];
		$documento_producto = $data['documento_producto'];
		$documento_padre = $data['documento_padre'];
		$query = "INSERT INTO documentos( documento_estado, documento_nombre, documento_documento, documento_solucion,documento_producto, documento_padre) VALUES ( '$documento_estado', '$documento_nombre', '$documento_documento', '$documento_solucion','$documento_producto', '$documento_padre')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un documento  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$documento_estado = $data['documento_estado'];
		$documento_nombre = $data['documento_nombre'];
		$documento_documento = $data['documento_documento'];
		$documento_solucion = $data['documento_solucion'];
		$documento_producto = $data['documento_producto'];
		$documento_padre = $data['documento_padre'];
		$query = "UPDATE documentos SET  documento_estado = '$documento_estado', documento_nombre = '$documento_nombre', documento_documento = '$documento_documento', documento_solucion = '$documento_solucion', documento_producto = '$documento_producto', documento_padre = '$documento_padre' WHERE documento_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}