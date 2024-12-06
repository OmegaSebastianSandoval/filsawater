<div class="container contenedor-detail-producto pt-3">

    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/page/productos/categoria?categoria=<?= $this->categoria->tienda_categoria_id ?>"><?= $this->categoria->tienda_categoria_nombre ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->producto->producto_nombre ?></li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12 col-lg-5 order-2 order-lg-1">


            <div class="content-photos contenedorfotos resume-pago" id="contenedorfotos">
                <?php if (is_countable($this->producto->fotos) && count($this->producto->fotos) >= 1) { ?>

                    <div class="f-carousel" id="myCarousel">
                        <?php foreach ($this->producto->fotos as $foto) { ?>

                            <?php if ($foto->foto_foto && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $foto->foto_foto)) { ?>

                                <div class="f-carousel__slide" data-fancybox="gallery" data-src="/images/<?= $foto->foto_foto ?>" data-thumb-src="/images/<?= $foto->foto_foto ?>">


                                    <img width="640" height="480" alt="<?= $foto->foto_nombre ?>" data-lazy-src="/images/<?= $foto->foto_foto ?>" />
                                </div>
                            <?php } else { ?>
                                <div class="f-carousel__slide" data-fancybox="gallery" data-src="/assets/imagenot.jpg" data-thumb-src="/assets/imagenot.jpg">


                                    <img width="640" height="480" alt="<?= $foto->foto_nombre ?>" data-lazy-src="/assets/imagenot.jpg" />
                                </div>
                            <?php } ?>

                        <?php } ?>
                    </div>



                <?php } ?>
            </div>

        </div>
        <div class="col-12  col-lg-7 order-1 order-lg-2">
            <h2><?= $this->producto->producto_nombre ?></h2>

            <?php if ( $this->producto->producto_precio && $this->producto->producto_precio >= 1) { ?>
                <h3 class="price-product">$<?= number_format($this->producto->producto_precio) ?></h3>
            <?php } ?>

            <h4 class="reference-producto">Ref: <span><?= $this->producto->producto_referencia ?></span></h4>

            <h4 class="category-producto">Categoría: <a href="/page/productos/categoria?categoria=<?= $this->categoria->tienda_categoria_id ?>"><?= $this->categoria->tienda_categoria_nombre ?></a></h4>






            <div class="disponibility-producto">
                <?php if ($this->producto->producto_stock && $this->producto->producto_stock >= 1) { ?>
                    <span class="stock-producto"> Disponibilidad: <span class="in-stock"><?= $this->producto->producto_stock ?> unidades</span></span>
                <?php } else { ?>
                    <span class="stock-producto">Disponibilidad: <span class="not-stock">Agotado en el momento</span></span>
                <?php } ?>
            </div>



            <div class="product-description">
                <?= $this->producto->producto_descripcion ?>
            </div>
            <?php if ($this->documentos && $this->hayDocumentos == 1) { ?>
                <div class="col-12 ">
                    <h2 class="title-info">Documentos</h2>
                    <div class="container-docs">

                        <?php echo $this->documentos ?>
                    </div>

                </div>
            <?php } ?>
            <?php if ($this->producto->producto_stock >= 1 && $this->producto->producto_precio >= 1) { ?>
                <div class="product-detail mt-4 ">
                    <div class="quantity-control">
                        <button class="btn-decrease">-</button>
                        <input type="number" value="1" min="1" max="<?= $this->producto->producto_stock > 50 ? 50 : intval($this->producto->producto_stock) ?>" class="quantity" readonly>
                        <button class="btn-increase">+</button>
                    </div>
                    <button
                        class="btn-add-cart btn-add-to-cart btn-blue rounded-0 border-0"
                        data-id="<?= $this->producto->producto_id ?>" aria-label="Agregar <?= $this->producto->producto_nombre ?> al carrito" title="Agregar al carrito">Agregar al carrito</button>
                </div>
            <?php } ?>

        </div>


    </div>
</div>
<?php echo $this->productosDestacados ?>

<style>
    .main-general {
        background-color: #f5f5f5;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const contenedorfotos = document.getElementById('contenedorfotos');
        contenedorfotos.classList.add('fadein');


    });

    // Configurar Fancybox
    Fancybox.bind("[data-fancybox]", {
        initialSize: "fit",
    });
    new Carousel(
        document.getElementById("myCarousel"), {
            // Your custom options
            Dots: false,

        }, {
            Thumbs
        }
    );
</script>