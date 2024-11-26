<?php 
/**
* clase que genera la insercion y edicion  de pedido en la base de datos
*/
class Administracion_Model_DbTable_Pedidos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'pedidos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'pedido_id';

	/**
	 * insert recibe la informacion de un pedido y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$pedido_documento = $data['pedido_documento'];
		$pedido_fecha = $data['pedido_fecha'];
		$pedido_total = $data['pedido_total'];
		$pedido_subtotal = $data['pedido_subtotal'];
		$pedido_procentaje_descuento = $data['pedido_procentaje_descuento'];
		$pedido_descuento = $data['pedido_descuento'];
		$pedido_iva = $data['pedido_iva'];
		$pedido_estado = $data['pedido_estado'];
		$pedido_departamento = $data['pedido_departamento'];
		$pedido_ciudad = $data['pedido_ciudad'];
		$pedido_direccion = $data['pedido_direccion'];
		$pedido_direccion_observacion = $data['pedido_direccion_observacion'];
		$pedido_correo = $data['pedido_correo'];
		$pedido_nombre = $data['pedido_nombre'];
		$pedido_telefono = $data['pedido_telefono'];
		$pedido_respuesta = $data['pedido_respuesta'];
		$pedido_validacion = $data['pedido_validacion'];
		$pedido_validacion2 = $data['pedido_validacion2'];
		$pedido_entidad = $data['pedido_entidad'];
		$pedido_porcentaje_iva = $data['pedido_porcentaje_iva'];
		$query = "INSERT INTO pedidos( pedido_documento, pedido_fecha, pedido_total, pedido_subtotal, pedido_procentaje_descuento, pedido_descuento, pedido_iva, pedido_estado, pedido_departamento, pedido_ciudad, pedido_direccion, pedido_direccion_observacion, pedido_correo, pedido_nombre, pedido_telefono, pedido_respuesta, pedido_validacion, pedido_validacion2, pedido_entidad, pedido_porcentaje_iva) VALUES ( '$pedido_documento', '$pedido_fecha', '$pedido_total', '$pedido_subtotal', '$pedido_procentaje_descuento', '$pedido_descuento', '$pedido_iva', '$pedido_estado', '$pedido_departamento', '$pedido_ciudad', '$pedido_direccion', '$pedido_direccion_observacion', '$pedido_correo', '$pedido_nombre', '$pedido_telefono', '$pedido_respuesta', '$pedido_validacion', '$pedido_validacion2', '$pedido_entidad', '$pedido_porcentaje_iva')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un pedido  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$pedido_documento = $data['pedido_documento'];
		$pedido_fecha = $data['pedido_fecha'];
		$pedido_total = $data['pedido_total'];
		$pedido_subtotal = $data['pedido_subtotal'];
		$pedido_procentaje_descuento = $data['pedido_procentaje_descuento'];
		$pedido_descuento = $data['pedido_descuento'];
		$pedido_iva = $data['pedido_iva'];
		$pedido_estado = $data['pedido_estado'];
		$pedido_departamento = $data['pedido_departamento'];
		$pedido_ciudad = $data['pedido_ciudad'];
		$pedido_direccion = $data['pedido_direccion'];
		$pedido_direccion_observacion = $data['pedido_direccion_observacion'];
		$pedido_correo = $data['pedido_correo'];
		$pedido_nombre = $data['pedido_nombre'];
		$pedido_telefono = $data['pedido_telefono'];
		$pedido_respuesta = $data['pedido_respuesta'];
		$pedido_validacion = $data['pedido_validacion'];
		$pedido_validacion2 = $data['pedido_validacion2'];
		$pedido_entidad = $data['pedido_entidad'];
		$pedido_porcentaje_iva = $data['pedido_porcentaje_iva'];
		$query = "UPDATE pedidos SET  pedido_documento = '$pedido_documento', pedido_fecha = '$pedido_fecha', pedido_total = '$pedido_total', pedido_subtotal = '$pedido_subtotal', pedido_procentaje_descuento = '$pedido_procentaje_descuento', pedido_descuento = '$pedido_descuento', pedido_iva = '$pedido_iva', pedido_estado = '$pedido_estado', pedido_departamento = '$pedido_departamento', pedido_ciudad = '$pedido_ciudad', pedido_direccion = '$pedido_direccion', pedido_direccion_observacion = '$pedido_direccion_observacion', pedido_correo = '$pedido_correo', pedido_nombre = '$pedido_nombre', pedido_telefono = '$pedido_telefono', pedido_respuesta = '$pedido_respuesta', pedido_validacion = '$pedido_validacion', pedido_validacion2 = '$pedido_validacion2', pedido_entidad = '$pedido_entidad', pedido_porcentaje_iva = '$pedido_porcentaje_iva' WHERE pedido_id = '".$id."'";
		$res = $this->_conn->query($query);
	}


	//editar response
	public function editarResponse($id, $value)
	{
		 $query = 'UPDATE ' . $this->_name . ' SET pedido_response = \'' . $value . '\' WHERE ' . $this->_id . ' = "' . $id . '"';

		$res = $this->_conn->query($query);
	}
}