<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table border="1" cellpadding="2">
    <thead>

        <tr>
            <td>Id</td>
            <td>Documento</td>
            <td>Fecha</td>
            <td>Total</td>
            <td>Subtotal</td>
            <td>Porcentaje de Descuento</td>
            <td>Descuento</td>
            <td>Iva</td>
            <td>Estado</td>
            <td>Departamento</td>
            <td>Ciudad</td>
            <td>Dirección</td>
            <td>Observación</td>
            <td>Correo</td>
            <td>Nombre</td>
            <td>Teléfono</td>
            <td>Respuesta</td>
            <td>Validación</td>
            <td>Validación 2</td>
            <td>Validación Texto</td>
            <td>Entidad</td>
            <td>Identificador</td>
            <!-- <td>Response</td> -->
            <td>Porcentaje Iva</td>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->list as $pedido) { ?>
            <tr>
                <td><?= $pedido->pedido_id ?></td>
                <td><?= $pedido->pedido_documento ?></td>
                <td><?= $pedido->pedido_fecha ?></td>
                <td>$<?= $pedido->pedido_total >= 1 ? (($pedido->pedido_total)) : $pedido->pedido_total  ?></td>
                <td>$<?= $pedido->pedido_subtotal >= 1 ? ($pedido->pedido_subtotal) : $pedido->pedido_subtotal  ?></td>
                <td><?= $pedido->pedido_procentaje_descuento ?>%</td>
                
                <td>$<?= $pedido->pedido_descuento >= 1 ? ($pedido->pedido_descuento) : $pedido->pedido_descuento  ?></td>
                <td>$<?= $pedido->pedido_iva >= 1 ? ($pedido->pedido_iva) : $pedido->pedido_iva  ?></td>
                <td><?= $pedido->pedido_estado ?></td>
                <td><?= $pedido->pedido_departamento ?></td>
                <td><?= $pedido->pedido_ciudad ?></td>
                <td><?= $pedido->pedido_direccion ?></td>
                <td><?= $pedido->pedido_direccion_observacion ?></td>
                <td><?= $pedido->pedido_correo ?></td>
                <td><?= $pedido->pedido_nombre ?></td>
                <td><?= $pedido->pedido_telefono ?></td>
                <td><?= $pedido->pedido_respuesta ?></td>
                <td><?= $pedido->pedido_validacion ?></td>
                <td><?= $pedido->pedido_validacion2 ?></td>
                <td><?= $pedido->pedido_validacion_texto ?></td>
                <td><?= $pedido->pedido_entidad ?></td>
                <td><?= $pedido->pedido_identificador ?></td>
                <!-- <td><?= $pedido->pedido_response ?></td> -->
                <td><?= $pedido->pedido_porcentaje_iva ?></td>
            </tr>
            <?php if (is_countable($pedido->productos) && count($pedido->productos) >= 1) { ?>
                <?php $total = 0 ?>
                <?php foreach ($pedido->productos as $producto) { ?>
                    <tr style="background-color: gainsboro;">
                        <td colspan="6">Producto: <?= $producto->pedido_producto_nombre ?></td>
                        <td colspan="2">Precio: $<?= $producto->pedido_producto_precio_final / $producto->pedido_producto_cantidad >= 1 ? number_format(($producto->pedido_producto_precio_final / $producto->pedido_producto_cantidad)) : $producto->pedido_producto_precio_final / $producto->pedido_producto_cantidad ?></td>
                        <td colspan="2">Cantidad: <?= $producto->pedido_producto_cantidad ?></td>
                        <td colspan="4">Total: $<?= $producto->pedido_producto_precio_final >= 1 ? number_format(($producto->pedido_producto_precio_final)) : $producto->pedido_producto_precio_final ?></td>
                        <td colspan="9"></td>
                    </tr>
                    <?php $total += $producto->pedido_producto_precio_final ?>

                <?php } ?>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="13">Total: $<?= $total >= 1 ? number_format(($total)) : $total ?></td>


                </tr>
                <tr  style="background-color:#5475a1">
                    <td colspan="23" style="height:35px"></td>
                </tr>

            <?php } ?>

        <?php } ?>
    </tbody>
</table>