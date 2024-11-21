<div class="container contendor-comprar h-100 contendor-pago  pt-2 pb-5">
    <a class="btn-blue btn-outline gap-2  my-3" href="/page/comprar/direccion?id=<?= $this->pedido->pedido_id ?>"> <i class="fa-regular fa-circle-left"></i> Volver</a>

    <!-- <h2>Resumen</h2> -->
    <div class="line_box">
        <div class="text_circle done">
            <div class="circle">
                <h4>Carrito</h4>

            </div>
            <span class="tvar shadow"><i class="fa-solid fa-check"></i></span>
        </div>
        <div class="text_circle done">
            <div class="circle">
                <h4>Envío</h4>

            </div>
            <span class="tvar shadow"><i class="fa-solid fa-check"></i></span>
        </div>
        <div class="text_circle done-partial">
            <div class="circle">
                <h4>Pago</h4>

            </div>
            <span class="tvar shadow"><i class="fa-solid fa-credit-card"></i></span>
        </div>
        <div class="text_circle">
            <div class="circle">
                <h4>Finalización</h4>

            </div>
            <span class="tvar shadow"><i class="fa-solid fa-check"></i></span>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-8">
            <table class="table-cart shadow ">
                <thead>
                    <tr>
                        <th width="70%">Producto</th>
                        <th width="10%">Precio</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                    foreach ($this->productos as $producto) {
                    ?>
                        <tr>
                            <td  data-label="Producto">
                                <div class="producto d-flex gap-2 align-items-center">
                                   

                                    <?php if ($producto->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->producto_imagen)) { ?>
                                        <img src="/images/<?php echo $producto->producto_imagen; ?>" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">
                                    <?php } else { ?>
                                        <img src="/assets/imagenot.jpg" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">


                                    <?php } ?>
                                    <div class="producto-info">
                                        <h5><?php echo $producto->pedido_producto_nombre; ?></h5>
                                        <h6>Categoría: <span><?php echo $producto->producto_categoriainfo; ?></span></h6>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Precio">
                                <span class="precio">
                                    <?php $precioProducto = $producto->pedido_producto_precio_final/$producto->pedido_producto_cantidad?>
                                    $<?php echo number_format($precioProducto, 2); ?>
                                </span>
                            </td>
                            <td data-label="Cantidad">
                                <span class="cantidad">
                                    <?php echo $producto->pedido_producto_cantidad; ?>
                                </span>
                            </td>
                            <td data-label="Total">
                                <span class="total" id="total-producto">
                                    $<?php echo number_format($producto->pedido_producto_precio_final, 2); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>



                </tbody>
            </table>
        </div>
        <div class="col-12 col-lg-4">
            <div class="resume-pago">

                <section class="resume shadow mt-2 mt-lg-0">


                    <h3>Resumen</h3>
                    <div class="resume-content">
                        <div class="resume-item d-flex justify-content-between align-items-center my-2 border-bottom">
                            <span class="w-25 d-block">Nombre:</span>
                            <span class="w-75  text-end info"> <?= $this->pedido->pedido_nombre ?></span>
                        </div>
                        <div class="resume-item d-flex justify-content-between align-items-center my-2 border-bottom">
                            <span class="w-25 d-block">Correo:</span>
                            <span class="w-75 text-end  info"> <?= $this->pedido->pedido_correo ?></span>
                        </div>
                        <div class="resume-item d-flex justify-content-between align-items-center my-2 border-bottom">
                            <span class="w-25 d-block">Teléfono:</span>
                            <span class="w-75 text-end   info"> <?= $this->pedido->pedido_telefono ?></span>
                        </div>

                        <div class="resume-item d-flex justify-content-between align-items-center my-2 border-bottom">
                            <span class="w-25 d-block">Dirección:</span>
                            <span class="w-75 text-end info"> <?= $this->pedido->departamento_nombre . ", " .
                                                                    $this->pedido->ciudad_nombre . ", " .
                                                                    $this->pedido->pedido_direccion ?></span>
                        </div>
                        <?php if ($this->pedido->pedido_direccion_observacion) { ?>
                            <div class="resume-item d-flex justify-content-between align-items-center  my-2">
                                <span>Observaciones:</span>
                            </div>
                            <div class="resume-item d-flex justify-content-between align-items-center border-bottom  my-2">
                                <span class="info"> <?= $this->pedido->pedido_direccion_observacion ?></span>
                            </div>


                        <?php } ?>

                        <div class="resume-item d-flex justify-content-between align-items-center">
                            <span>Subtotal</span>
                            <span class="info">$ <?= number_format($this->pedido->pedido_subtotal, 2) ?></span>
                        </div>
                        <div class="resume-item d-flex justify-content-between align-items-center">
                            <span>Descuento</span>
                            <span class="info"> - $<?= number_format($this->pedido->pedido_descuento, 2) ?></span>
                        </div>
                        <div class="resume-item d-flex justify-content-between align-items-center">
                            <span>IVA</span>
                            <span class="info">$ <?= number_format($this->pedido->pedido_iva, 2) ?></span>
                        </div>

                        <div class="resume-item d-flex justify-content-between align-items-center">
                            <span class="total-spam">Total</span>
                            <span id="total">$<?= number_format($this->pedido->pedido_total, 2) ?></span>
                        </div>
                    </div>
                    <form action="/page/comprar/generarpago" id="comprar-continuar" method="POST" class="desactivar-submit">

                        <input type="hidden" name="total" value="<?= $this->pedido->pedido_total ?>">
                        <input type="hidden" name="pedido_id" value="<?= $this->pedido->pedido_id ?>">
                        <input type="hidden" name="pedido_nombre" value="<?= $this->pedido->pedido_nombre ?>">
                        <input type="hidden" name="pedido_correo" value="<?= $this->pedido->pedido_correo ?>">
                        <input type="hidden" name="pedido_telefono" value="<?= $this->pedido->pedido_telefono ?>">
                        <input type="hidden" name="pedido_direccion" value="<?= $this->pedido->pedido_direccion . " " . $this->pedido->pedido_direccion_observacion ?>">


                        <button type="submit" class="btn btn-blue w-100 mt-3">Proceder al Pago</button>

                    </form>
                </section>
            </div>

        </div>
    </div>

</div>
<style>
    .main-general {
        background-color: #f5f5f5;
        /* min-height: auto; */
    }

    .content-carrito,
    .ocultar-carrito {
        display: none !important;
    }
</style>