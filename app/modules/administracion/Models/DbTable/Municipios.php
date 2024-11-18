<?php 
/**
* clase que genera la insercion y edicion  de municipio en la base de datos
*/
class Administracion_Model_DbTable_Municipios extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'municipios';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id_municipio';

	/**
	 * insert recibe la informacion de un municipios y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$municipio = $data['municipio'];
		$estado = $data['estado'];
		$departamento_id = $data['departamento_id'];
		$query = "INSERT INTO municipios( municipio, estado, departamento_id) VALUES ( '$municipio', '$estado', '$departamento_id')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un municipios  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$municipio = $data['municipio'];
		$estado = $data['estado'];
		$departamento_id = $data['departamento_id'];
		$query = "UPDATE municipios SET  municipio = '$municipio', estado = '$estado', departamento_id = '$departamento_id' WHERE id_municipio = '".$id."'";
		$res = $this->_conn->query($query);
	}
}