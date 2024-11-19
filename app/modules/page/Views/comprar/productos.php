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
        $total = 0;
        foreach ($this->carrito as $id => $producto) {
            $total += $producto['total'];
        ?>
            <tr>
                <td>
                    <div class="producto d-flex gap-2 align-items-center">

                        <?php if ($producto['detalle']->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto['detalle']->producto_imagen)) { ?>
                            <img src="/images/<?php echo $producto['detalle']->producto_imagen; ?>" alt="<?php echo $producto['detalle']->producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">
                        <?php } else { ?>
                            <img src="/assets/imagenot.jpg" alt="<?php echo $producto['detalle']->producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">


                        <?php } ?>
                        <div class="producto-info">
                            <h5><?php echo $producto['detalle']->producto_nombre; ?></h5>
                            <h6>Categoría: <span><?php echo $producto['detalle']->producto_categoriainfo->tienda_categoria_nombre; ?></span></h6>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="precio">
                        $<?php echo number_format($producto['detalle']->producto_precio, 2); ?>
                    </span>
                </td>
                <td>
                    <span class="cantidad">


                        <div class="product-detail-cart-shop mt-2" id="checkout-section" data-shop-id="<?= $producto['detalle']->producto_id ?>">
                            <div class="quantity-control-cart-shop">
                                <button class="btn-decrease-cart-shop">-</button>
                                <input type="number" value="<?php echo $producto['cantidad']; ?>" min="1" max="<?= $producto['detalle']->producto_stock > 5 ? 5 : intval($producto['detalle']->producto_stock) ?>" class="quantity-cart-shop" readonly>
                                <button class="btn-increase-cart-shop">+</button>
                            </div>

                        </div>
                    </span>
                </td>
                <td>
                    <span class="total" id="total-producto">
                        $<?php echo number_format($producto['total'], 2); ?>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <!--  <tr>
                            <td colspan="3" class="text-right">Total:</td>
                            <td>$<?php echo number_format($total, 2); ?></td>
                        </tr> -->
    </tbody>
</table>