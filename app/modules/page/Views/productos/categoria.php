<div class="container pt-4 pb-2 contenedor-categorias">
    <h2>PRODUCTOS</h2>

    <h3 class="category-title">
        <?= $this->categoria->tienda_categoria_nombre ?>
    </h3>

    <div class="row mt-4">
        <?php if (is_countable($this->productos) && count($this->productos) >= 1) { ?>
            <?php foreach ($this->productos as $producto): ?>
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <a href="/page/productos/producto?producto=<?= $producto->producto_id ?>&categoria=<?= $this->categoria->tienda_categoria_id ?>" class="product-link" aria-label="Ver detalles del producto <?= $producto->producto_nombre ?>">
                        <article class="product-card">
                            <figure class="content-image-product">
                                <img src="/images/<?= $producto->producto_imagen ?>" alt="<?= $producto->producto_nombre ?>" class="img-fluid w-100">
                                <figcaption class="sr-only"><?= $producto->producto_nombre ?></figcaption>
                                <div class="add-cart-content">
                                    <button class="btn-add-cart" data-id="<?= $producto->producto_id ?>" aria-label="Agregar <?= $producto->producto_nombre ?> al carrito" title="Agregar al carrito">
                                        <i class="fas fa-shopping-cart" aria-hidden="true"></i>

                                    </button>
                                </div>
                            </figure>
                            <div class="content-info-product">
                                <h3 class="product-title"><?= $producto->producto_nombre ?></h3>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <h5 class="product-reference"><span>Ref: </span><?= $producto->producto_referencia ?></h5>
                                    <?php if ($producto->producto_precio && $producto->producto_precio > 1) { ?>
                                        <p class="product-price">$<?= number_format($producto->producto_precio) ?></p>
                                    <?php } ?>

                                </div>
                            </div>

                        </article>
                    </a>
                </div>

            <?php endforeach; ?>
        <?php } else { ?>
            <div class="col-12 mt-4">
                <div class="alert alert-warning text-center" role="alert">
                    No hay productos en esta categoría
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<style>
    .main-general {
        background-color: #f5f5f5;
    }
</style>