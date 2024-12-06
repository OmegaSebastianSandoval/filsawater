<div class="offcanvas-body">
    <?php if (is_countable($this->carrito) && count($this->carrito) >= 1) { ?>
        <ul>
            <?php foreach ($this->carrito as $key => $item) { ?>
                <?php
                $productoCarrito = $item["detalle"];
                $cantidad = $item["cantidad"];
                $total +=  $item["total"];
                ?>
                <li>
                    <div class="row g-1  mb-2 p-1">
                        <div class="col-3">
                            <?php if ($productoCarrito->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $productoCarrito->producto_imagen)) { ?>
                                <img src="/images/<?= $productoCarrito->producto_imagen ?>" alt="Imagen del producto <?= $productoCarrito->producto_nombre ?>" class="w-100 img-fluid object-fit-contain">
                            <?php } else { ?>
                                <img src="/assets/imagenot.jpg" alt="Imagen del producto <?= $productoCarrito->producto_nombre ?>" class="w-100 img-fluid object-fit-contain">
                            <?php } ?>
                        </div>
                        <div class="col-8">
                            <div>
                                <a class="enlace-cart" href="/page/productos/producto?producto=<?= $productoCarrito->producto_id ?>&categoria=<?= $productoCarrito->producto_categoria ?>"><?= $productoCarrito->producto_nombre ?></a>
                            </div>

                            <span class="price-cart">Valor: <?= number_format($productoCarrito->producto_precio * $cantidad) ?></span>


                            <div class="product-detail-cart mt-2" data-id="<?= $productoCarrito->producto_id ?>">
                                <div class="quantity-control-cart">
                                    <button class="btn-decrease-cart">-</button>
                                    <input type="number" value="<?= $cantidad ?>" min="1" max="<?= $productoCarrito->producto_stock > 5 ? 5 : intval($productoCarrito->producto_stock) ?>" class="quantity-cart" readonly>
                                    <button class="btn-increase-cart">+</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-sm btn-danger" title="Eliminar del carrito" onclick="eliminarProducto(<?= $productoCarrito->producto_id ?>)"><i class="fa-solid fa-trash"></i></button>
                        </div>


                    </div>

                </li>


            <?php } ?>


            <div class="content-subtotal mt-auto position-absolute bottom-0 w-100">

                <div class="d-flex justify-content-between">
                    <span>Total carrito </span>
                    <span class="total-cart">$<?= number_format($total) ?></span>
                </div>
                <span class="fw-lighte text-secondary text-end w-100 d-block" style="font-size:11px">Iva incluido</span>

                <a href="/page/comprar" class="btn-blue rounded-0 w-100 mt-3 py-3">Ir a Comprar</a>
            </div>




        </ul>
    <?php } else { ?>
        <div class="alert alert-warning text-center">
            Sin productos en el carrito
        </div>
    <?php } ?>

</div>