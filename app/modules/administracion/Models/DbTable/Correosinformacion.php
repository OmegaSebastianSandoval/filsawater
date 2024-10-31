<?php 
/**
* clase que genera la insercion y edicion  de correo informaci&oacute;n en la base de datos
*/
class Administracion_Model_DbTable_Correosinformacion extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'correos_informacion';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'correo_informacion_id';

	/**
	 * insert recibe la informacion de un correo informaci&oacute;n y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$correos_informacion_correo = $data['correos_informacion_correo'];
		$correos_informacion_fecha = $data['correos_informacion_fecha'];
		$correos_informacion_estado = $data['correos_informacion_estado'];
		$query = "INSERT INTO correos_informacion( correos_informacion_correo, correos_informacion_fecha, correos_informacion_estado) VALUES ( '$correos_informacion_correo', '$correos_informacion_fecha', '$correos_informacion_estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un correo informaci&oacute;n  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$correos_informacion_correo = $data['correos_informacion_correo'];
		$correos_informacion_fecha = $data['correos_informacion_fecha'];
		$correos_informacion_estado = $data['correos_informacion_estado'];
		$query = "UPDATE correos_informacion SET  correos_informacion_correo = '$correos_informacion_correo', correos_informacion_fecha = '$correos_informacion_fecha', correos_informacion_estado = '$correos_informacion_estado' WHERE correo_informacion_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}