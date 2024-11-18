<?php 
/**
* clase que genera la insercion y edicion  de dirección en la base de datos
*/
class Administracion_Model_DbTable_Direcciones extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'direcciones';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'direccion_id';

	/**
	 * insert recibe la informacion de un dirección y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$direccion_departamento = $data['direccion_departamento'];
		$direccion_ciudad = $data['direccion_ciudad'];
		$direccion_direccion = $data['direccion_direccion'];
		$direccion_observacion = $data['direccion_observacion'];
		$direccion_cliente = $data['direccion_cliente'];
		$direccion_codigopostal = $data['direccion_codigopostal'];
		$direccion_estado = $data['direccion_estado'];
		$query = "INSERT INTO direcciones( direccion_departamento, direccion_ciudad, direccion_direccion, direccion_observacion, direccion_cliente, direccion_codigopostal, direccion_estado) VALUES ( '$direccion_departamento', '$direccion_ciudad', '$direccion_direccion', '$direccion_observacion', '$direccion_cliente', '$direccion_codigopostal', '$direccion_estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un dirección  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$direccion_departamento = $data['direccion_departamento'];
		$direccion_ciudad = $data['direccion_ciudad'];
		$direccion_direccion = $data['direccion_direccion'];
		$direccion_observacion = $data['direccion_observacion'];
		$direccion_cliente = $data['direccion_cliente'];
		$direccion_codigopostal = $data['direccion_codigopostal'];
		$direccion_estado = $data['direccion_estado'];
		$query = "UPDATE direcciones SET  direccion_departamento = '$direccion_departamento', direccion_ciudad = '$direccion_ciudad', direccion_direccion = '$direccion_direccion', direccion_observacion = '$direccion_observacion', direccion_cliente = '$direccion_cliente', direccion_codigopostal = '$direccion_codigopostal', direccion_estado = '$direccion_estado' WHERE direccion_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}