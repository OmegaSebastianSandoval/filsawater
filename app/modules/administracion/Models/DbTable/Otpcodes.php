<?php 
/**
* clase que genera la insercion y edicion  de Códigos OTP en la base de datos
*/
class Administracion_Model_DbTable_Otpcodes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'otp_codes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un Códigos OTP y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$user = $data['user'];
		$code = $data['code'];
		$date = $data['date'];
		$query = "INSERT INTO otp_codes( user, code, date) VALUES ( '$user', '$code', '$date')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Códigos OTP  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$user = $data['user'];
		$code = $data['code'];
		$date = $data['date'];
		$query = "UPDATE otp_codes SET  user = '$user', code = '$code', date = '$date' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}