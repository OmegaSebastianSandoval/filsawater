<?php 
/**
* clase que genera la insercion y edicion  de config en la base de datos
*/
class Administracion_Model_DbTable_Config extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'configuraciones';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'configuracion_id';

	/**
	 * insert recibe la informacion de un config y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$configuracion_iva = $data['configuracion_iva'];
		$query = "INSERT INTO configuraciones( configuracion_iva) VALUES ( '$configuracion_iva')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un config  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$configuracion_iva = $data['configuracion_iva'];
		$query = "UPDATE configuraciones SET  configuracion_iva = '$configuracion_iva' WHERE configuracion_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}