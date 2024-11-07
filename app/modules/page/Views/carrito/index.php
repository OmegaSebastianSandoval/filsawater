<div class="offcanvas-body">
    <?php if (is_countable($this->carrito) && count($this->carrito) >= 1) { ?>
        <ul>
            <?php foreach ($this->carrito as $key => $item) { ?>
                <?php
                $productoCarrito = $item["detalle"];
                $cantidad = $item["cantidad"];
                ?>
                <li>
                    <div class="row g-0 shadow-sm mb-2">
                        <div class="col-3">
                            <img src="/images/<?= $productoCarrito->producto_imagen ?>" alt="" class="w-100 img-fluid object-fit-contain">
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
                            <button class="btn btn-sm btn-danger" onclick="eliminarProducto(<?= $productoCarrito->producto_id ?>)"><i class="fa-solid fa-trash"></i></button>
                        </div>


                    </div>
                    <a href="/page/comprar" class="btn-blue rounded-0 mx-auto mt-3">Ir a Comprar</a>
                </li>


            <?php } ?>
        </ul>
    <?php } else { ?>
        <div class="alert alert-warning text-center">
            Sin productos en el carrito
        </div>
    <?php } ?>

</div>