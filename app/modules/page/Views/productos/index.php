<div class="container pt-4 pb-2 contenedor-categorias">
    <h2>PRODUCTOS</h2>

    <?php
    // print_r($this->usuario);
    ?>

    <div data-aos="" class="row mt-4">
        <?php if (is_countable($this->productos) && count($this->productos) >= 1) { ?>
            <?php foreach ($this->productos as $producto): ?>
                <div data-aos="" class="col-6 col-md-4 col-lg-3 mb-3">
                    <a href="/page/productos/producto?producto=<?= $producto->producto_id ?>&categoria=<?=$producto->producto_categoria  ?>" class="product-link" aria-label="Ver detalles del producto <?= $producto->producto_nombre ?>">
                        <article class="product-card">
                            <figure class="content-image-product">
                                <?php if ($producto->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->producto_imagen)) { ?>
                                    <img src="/images/<?= $producto->producto_imagen ?>" alt="<?= $producto->producto_nombre ?>" class="img-fluid w-100">
                                <?php } else { ?>
                                    <img src="/assets/imagenot.jpg" alt="<?= $producto->producto_nombre ?>" class="img-fluid w-100">


                                <?php } ?>

                                <figcaption class="sr-only"><?= $producto->producto_nombre ?></figcaption>

                                <div class="add-cart-content">
                                    <?php if ( $producto->producto_precio > 1  && $producto->producto_stock >= 1) { ?>

                                        <button class="btn-add-cart" data-id="<?= $producto->producto_id ?>" aria-label="Agregar <?= $producto->producto_nombre ?> al carrito" title="Agregar al carrito">
                                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>

                                        </button>
                                    <?php } else { ?>

                                        <button class="btn-view mt-2" aria-label="Ver info <?= $producto->producto_nombre ?> " title="Ver mas información">
                                            <i class="fa-solid fa-eye"></i>

                                        </button>
                                    <?php } ?>

                                </div>



                            </figure>
                            <div class="content-info-product">
                                <h3 class="product-title"><?= $producto->producto_nombre ?></h3>
                                <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between mt-1">
                                    <h5 class="product-reference"><span>Ref: </span><?= $producto->producto_referencia ?></h5>

                                    <?php if ( $producto->producto_precio && $producto->producto_precio > 1) { ?>
                                        <p class="product-price">$<?= number_format($producto->producto_precio) ?></p>
                                    <?php } ?>


                                </div>
                            </div>

                        </article>
                    </a>
                </div>

            <?php endforeach; ?>
            <div class=" d-flex gap-5 mt-5 mb-2 justify-content-center">
                <ul class="pagination justify-content-center">

                    <?php
                    $url = '/page/productos';
                    $min = $this->page - 10;
                    if ($min < 0) {
                        $min = 1;
                    }
                    $max = $this->page + 10;
                    if ($this->totalpages > 1) {
                        if ($this->page != 1)
                            echo '<li class="page-item"><a class="page-link text-pagination" href="' . $url . '?page=' . ($this->page - 1) . '"> &laquo; Anterior </a></li>';
                        for ($i = 1; $i <= $this->totalpages; $i++) {
                            if ($this->page == $i) {
                                echo '<li class="page-item  fondo-pagination active"><a class="page-link  text-pagination">' . $this->page . '</a></li>';
                            } else {
                                if ($i <= $max and $i >= $min) {
                                    echo '<li class="page-item fondo-pagination"><a class="page-link text-pagination" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>  ';
                                }
                            }
                        }
                        if ($this->page != $this->totalpages)
                            echo '<li class="page-item"><a class="page-link text-pagination" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
                    }
                    ?>
                </ul>

            </div>
        <?php } else { ?>
            <div class="col-12 mt-4">
                <div class="alert alert-warning text-center" role="alert">
                    No hay productos en esta categoría
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php echo $this->productosDestacados ?>
<style>
    .main-general {
        background-color: #f5f5f5;
    }
</style>