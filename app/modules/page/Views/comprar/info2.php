<section class="resume shadow">


    <?php
    $total = 0;
    foreach ($this->carrito as $id => $producto) {
        $total += $producto['total'];
    ?>
        <div class="row g-2 py-1 border-bottom">


            <div class="col-3">

                <div class="mx-auto" style="max-width:100px">


                    <?php if ($producto['detalle']->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" .  $producto['detalle']->producto_imagen)) { ?>
                        <img src="/images/<?php echo $producto['detalle']->producto_imagen; ?>" alt="<?php echo $producto['detalle']->producto_nombre; ?>" class="w-100 img-fluid object-fit-contain img-carrito" alt="Imagen del producto">
                    <?php } else { ?>
                        <img src="/assets/imagenot.jpg" alt="<?php echo $producto['detalle']->producto_nombre; ?>" class="w-100 img-fluid object-fit-contain img-carrito" alt="Imagen del producto">


                    <?php } ?>

                    <span class="cantidad-direccion">
                        <?php echo $producto['cantidad']; ?>
                    </span>
                </div>
            </div>
            <div class="col-5 producto-direccion ps-2">


                <h5><?php echo $producto['detalle']->producto_nombre; ?></h5>
                <h6>Categoría: <span><?php echo $producto['detalle']->producto_categoriainfo->tienda_categoria_nombre; ?></span></h6>
            </div>

            <div class="col-4  producto-total text-end">
                <span class="total">
                    $<?php echo number_format(ceil($producto['total'])); ?>
                </span>

            </div>





        </div>


    <?php } ?>

    <div class="d-flex justify-content-between align-items-center py-3 resume-item">
        <span class="total-spam">Total:</span>
        <span class="total-precio">
            $<?php echo number_format(ceil($total)); ?>
        </span>
    </div>
    <button type="submit" form="form-direccion" class="btn btn-blue w-100 ">Continuar con la compra</button>


</section>