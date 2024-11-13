<?php 
/**
* clase que genera la insercion y edicion  de nivel en la base de datos
*/
class Administracion_Model_DbTable_Niveles extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'niveles';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'nivel_id';

	/**
	 * insert recibe la informacion de un nivel y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$nivel_nivel = $data['nivel_nivel'];
		$nivel_codigo = $data['nivel_codigo'];
		$nivel_porcentaje = $data['nivel_porcentaje'];
		$nivel_estado = $data['nivel_estado'];
		$query = "INSERT INTO niveles( nivel_nivel, nivel_codigo, nivel_porcentaje, nivel_estado) VALUES ( '$nivel_nivel', '$nivel_codigo', '$nivel_porcentaje', '$nivel_estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un nivel  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$nivel_nivel = $data['nivel_nivel'];
		$nivel_codigo = $data['nivel_codigo'];
		$nivel_porcentaje = $data['nivel_porcentaje'];
		$nivel_estado = $data['nivel_estado'];
		$query = "UPDATE niveles SET  nivel_nivel = '$nivel_nivel', nivel_codigo = '$nivel_codigo', nivel_porcentaje = '$nivel_porcentaje', nivel_estado = '$nivel_estado' WHERE nivel_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}