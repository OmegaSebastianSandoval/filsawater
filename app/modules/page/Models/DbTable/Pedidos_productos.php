<?php 
/**
* clase que genera la insercion y edicion  de pedido_producto en la base de datos
*/
class Page_Model_DbTable_PedidosProductos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'pedidos_productos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'pedido_producto_id';

	/**
	 * insert recibe la informacion de un pedido_producto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$pedido_producto_pedido = $data['pedido_producto_pedido'];
		$pedido_producto_producto = $data['pedido_producto_producto'];
		$pedido_producto_nombre = $data['pedido_producto_nombre'];
		$pedido_producto_cantidad = $data['pedido_producto_cantidad'];
		$pedido_producto_valor = $data['pedido_producto_valor'];
		$pedido_producto_iva = $data['pedido_producto_iva'];
		$pedido_producto_valor_iva = $data['pedido_producto_valor_iva'];
		$pedido_producto_descuento = $data['pedido_producto_descuento'];
		$pedido_producto_valor_descuento = $data['pedido_producto_valor_descuento'];
		$pedido_producto_precio_final = $data['pedido_producto_precio_final'];
		$query = "INSERT INTO pedidos_productos( pedido_producto_pedido, pedido_producto_producto, pedido_producto_nombre, pedido_producto_cantidad, pedido_producto_valor, pedido_producto_iva, pedido_producto_valor_iva, pedido_producto_descuento, pedido_producto_valor_descuento, pedido_producto_precio_final) VALUES ( '$pedido_producto_pedido', '$pedido_producto_producto', '$pedido_producto_nombre', '$pedido_producto_cantidad', '$pedido_producto_valor', '$pedido_producto_iva', '$pedido_producto_valor_iva', '$pedido_producto_descuento', '$pedido_producto_valor_descuento', '$pedido_producto_precio_final')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	
}