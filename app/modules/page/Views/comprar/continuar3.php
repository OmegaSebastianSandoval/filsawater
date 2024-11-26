<div style="background: #FFF; font-size: 15px;">
    <table style="width: 100%;max-width:700px; border: 0px solid #00b8c3; margin: auto; padding: 20px; background:#f5f5f5">
    <tr style="margin-bottom:15px;">
      <td colspan="2" style="border-bottom: 1px solid #192a4b1c; width:100%;">
        <img src="https://www.filsawater.com/images/FILSA%201.png" alt="Logo FILSA" height="80"  style="display:block; margin:auto; margin-bottom:10px">
      </td> 
    </tr>
    <tr style="">
            <td  style="vertical-align: baseline;" width="500px">
                <table>
                    <thead>
                        <tr>
                            <th style="font-family:Helvetica,Arial,sans-serif;font-style:normal;font-weight:bold;font-size:14px;letter-spacing:0.01em;color:#000;color:#4b4b50;text-transform:uppercase;box-sizing:border-box;line-height:1.25!important">Productos</th>
                            <th></th>

                        </tr>
                    </thead>


                    <tbody>


                        <?php
                        foreach ($this->productos as $producto) {
                        ?>

                            <tr style="height:140px;">
                                <td>



                                    <img src="<?php echo RUTA?>/images/<?php echo $producto->producto_imagen; ?>" alt="<?php echo $producto->producto_nombre; ?>" class="" alt="Imagen del producto" style="width:120px; height:120px; object-fit:contain; background:#FFF; border:1px solid #cbcbcb; border-radius:10px;">



                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td style="font-family:Helvetica,Arial,sans-serif;font-style:normal;font-weight:bold;font-size:14px;letter-spacing:0.01em;color:#000;color:#4b4b50;text-transform:uppercase;box-sizing:border-box;line-height:1.25!important">
                                                <?php echo $producto->pedido_producto_nombre; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:13.5px">
                                                Categoría: <span style="font-weight:700;"><?php echo $producto->producto_categoriainfo; ?></span>
                                            </td>
                                        </tr>


                                        <tr>

                                            <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">

                                                $<?php echo number_format($producto->pedido_producto_precio_final / $producto->pedido_producto_cantidad, 2); ?>

                                            </td>
                                        </tr>
                                        <tr>

                                            <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">

                                                <?php echo $producto->pedido_producto_cantidad; ?> Un.

                                            </td>
                                        </tr>
                                        <tr>

                                            <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">

                                                $<?php echo number_format($producto->pedido_producto_precio_final, 2); ?>

                                            </td>
                                        </tr>
                                    </table>

                                </td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </td>
            <td style="vertical-align: baseline;" width="30%">
                <table>
                    <tr>
                        <td style="font-family:Helvetica,Arial,sans-serif;font-style:normal;font-weight:bold;font-size:14px;letter-spacing:0.01em;color:#000;color:#4b4b50;text-transform:uppercase;box-sizing:border-box;line-height:1.25!important">
                            Resumen del pedido <b>#<?= $this->pedido->pedido_id ?></b>
                        </td>
                    </tr>
                    <tr style="height:20px;">
                        <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">
                            <?= $this->pedido->pedido_nombre ?>
                        </td>
                    </tr>
                    <tr style="height:20px;">
                        <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">
                            <?= $this->pedido->pedido_correo ?>
                        </td>
                    </tr>
                    <tr style="height:20px;">
                        <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">
                            <?= $this->pedido->pedido_telefono ?>
                        </td>
                    </tr>
                    <tr style="height:20px;">
                        <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">
                            <?= $this->pedido->departamento_nombre . ", " .
                                $this->pedido->ciudad_nombre . ", " .
                                $this->pedido->pedido_direccion ?>
                        </td>
                    </tr>
                    <?php if ($this->pedido->pedido_direccion_observacion) { ?>
                        <tr>
                            <td style="padding-top:2px;box-sizing:border-box;color:#777!important;font-size:12.5px">
                                <?= $this->pedido->pedido_direccion_observacion ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>

                        <td style="padding-bottom:5px;font-size:13.5px;color:#777!important;line-height:20px;box-sizing:border-box;border-collapse:collapse;vertical-align:top!important;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif">
                            <br>
                            <br>

                            Subtotal:
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:2px;box-sizing:border-box;font-size:12.5px;font-weight:700;">

                            $<?= number_format($this->pedido->pedido_subtotal, 2) ?>
                        </td>
                    </tr>
                    <tr>

                        <td style="padding-bottom:5px;font-size:13.5px;color:#777!important;line-height:20px;box-sizing:border-box;border-collapse:collapse;vertical-align:top!important;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif">
                            
                            Descuento:
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:2px;box-sizing:border-box;font-size:12.5px; font-weight:700;">
                            - $<?= number_format($this->pedido->pedido_descuento, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:5px;font-size:13.5px;color:#777!important;line-height:20px;box-sizing:border-box;border-collapse:collapse;vertical-align:top!important;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif">
                            
                            IVA:
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:2px;box-sizing:border-box;font-size:12.5px; font-weight:700;">
                            $<?= number_format($this->pedido->pedido_iva, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:5px;font-size:13.5px;color:#777!important;line-height:20px;box-sizing:border-box;border-collapse:collapse;vertical-align:top!important;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif">
                           
                            Total:
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:2px;box-sizing:border-box;font-size:12.5px; font-weight:700;">
                            $<?= number_format($this->pedido->pedido_total, 2) ?>
                        </td>
                    </tr>


                </table>

            </td>
        </tr>


    </table>
</div>