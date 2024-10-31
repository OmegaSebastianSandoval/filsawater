<?php 
/**
* clase que genera la insercion y edicion  de soluci&oacute;n en la base de datos
*/
class Administracion_Model_DbTable_Soluciones extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'soluciones';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'solucion_id';

	/**
	 * insert recibe la informacion de un soluci&oacute;n y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solucion_titulo = $data['solucion_titulo'];
		$solucion_categoria = $data['solucion_categoria'];
		$solucion_imagen = $data['solucion_imagen'];
		$solucion_descripcion = $data['solucion_descripcion'];
		$solucion_introduccion = $data['solucion_introduccion'];
		$solucion_contenido = $data['solucion_contenido'];
		$solucion_estado = $data['solucion_estado'];
		$solucion_padre = $data['solucion_padre'];
		$solucion_archivo = $data['solucion_archivo'];
		$solucion_tags = $data['solucion_tags'];
		$query = "INSERT INTO soluciones( solucion_titulo, solucion_categoria, solucion_imagen, solucion_descripcion, solucion_introduccion, solucion_contenido, solucion_estado, solucion_padre, solucion_archivo, solucion_tags) VALUES ( '$solucion_titulo', '$solucion_categoria', '$solucion_imagen', '$solucion_descripcion', '$solucion_introduccion', '$solucion_contenido', '$solucion_estado', '$solucion_padre', '$solucion_archivo', '$solucion_tags')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un soluci&oacute;n  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solucion_titulo = $data['solucion_titulo'];
		$solucion_categoria = $data['solucion_categoria'];
		$solucion_imagen = $data['solucion_imagen'];
		$solucion_descripcion = $data['solucion_descripcion'];
		$solucion_introduccion = $data['solucion_introduccion'];
		$solucion_contenido = $data['solucion_contenido'];
		$solucion_estado = $data['solucion_estado'];
		$solucion_padre = $data['solucion_padre'];
		$solucion_archivo = $data['solucion_archivo'];
		$solucion_tags = $data['solucion_tags'];
		$query = "UPDATE soluciones SET  solucion_titulo = '$solucion_titulo', solucion_categoria = '$solucion_categoria', solucion_imagen = '$solucion_imagen', solucion_descripcion = '$solucion_descripcion', solucion_introduccion = '$solucion_introduccion', solucion_contenido = '$solucion_contenido', solucion_estado = '$solucion_estado', solucion_padre = '$solucion_padre', solucion_archivo = '$solucion_archivo', solucion_tags = '$solucion_tags' WHERE solucion_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}