<section data-aos="" class="important-products">
    <div class="container">
        <h2 class="mb-4">Más Productos</h2>

        <div class="product-carousel">
            <?php foreach ($this->productosImportantes as $productoImportante) { ?>
                <article class="product-item  px-3">
                    <figure class="product-image">

                        <?php if ($productoImportante->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $productoImportante->producto_imagen)) { ?>
                            <img src="/images/<?= $productoImportante->producto_imagen ?>"
                                alt="Imagen del producto <?= htmlspecialchars($productoImportante->producto_nombre) ?>">
                        <?php } else { ?>
                            <img src="/assets/imagenot.jpg"
                                alt="Imagen del producto <?= htmlspecialchars($productoImportante->producto_nombre) ?>">
                        <?php } ?>
                    </figure>
                    <div class="content-info-important">
                        <a href="/page/productos/producto?producto=<?= $productoImportante->producto_id ?>&categoria=<?= $productoImportante->producto_categoria ?>">

                            <h3 class="product-title"><?= htmlspecialchars($productoImportante->producto_nombre) ?></h3>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    $('.product-carousel').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        responsive: [

            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 765,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>