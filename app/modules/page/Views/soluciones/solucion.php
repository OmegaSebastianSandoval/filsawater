<?php
echo $this->banner;
?>
<div class="container pb-5 pt-4 containter-detail">

    <?php if ($this->solucionPadre) { ?>

        <a class="btn-blue btn-outline gap-2 rounded-0 my-3" href="/page/soluciones/solucion?id=<?= $this->solucionPadre->solucion_id ?>"> <i class="fa-regular fa-circle-left"></i> Volver</a>
    <?php } else { ?>
        <a class="btn-blue btn-outline gap-2 rounded-0 my-3" href="/page/soluciones"> <i class="fa-regular fa-circle-left"></i> Ver todas nuestras soluciones</a>
    <?php } ?>

    <div class="row g-3 ">

        <?php if ($this->hayContenidoHijo == 1 && !$this->solucionPadre) { ?>
            <div class="col-12 col-md-3 col-lg-3 order-2 order-md-1">
                <aside class="aside-recents">
                    <h3>Contenido</h3>
                    <div class="row g-0 content-importants-solucion">
                        <?php foreach ($this->contenidoHijo as $solucionHijo): ?>
                            <a href="/page/soluciones/solucion?id=<?= $solucionHijo->solucion_id ?>&padre=<?= $this->solucion->solucion_id ?>" class="mb-2" title="<?= $solucionHijo->solucion_titulo ?>">

                                <div class="content-important-solucion">
                                    <div class="content-image-important">
                                        <?php if ($solucionHijo->solucion_imagen) { ?>

                                            <img src="/images/<?= $solucionHijo->solucion_imagen ?>" alt="<?= $solucionHijo->solucion_titulo ?>" class="img-fluid">
                                        <?php } else { ?>
                                            <img src="/assets/imagenot.jpg" alt="<?= $solucionHijo->solucion_titulo ?>" class="img-fluid">

                                        <?php } ?>


                                    </div>
                                    <div class="content-info-important">
                                        <span class="title-important">
                                            <?= $solucionHijo->solucion_titulo ?>
                                        </span>


                                    </div>

                                </div>
                            </a>
                        <?php endforeach ?>
                    </div>

                </aside>
            </div>
        <?php } ?>

        <div class="col-12 <?php echo  $this->hayContenidoHijo == 1 ? 'col-md-9 col-lg-9' : 'col-md-12 col-lg-12' ?>   order-1 order-md-2">
            <article class="contaier-detail-solucion">
                <?php if ($this->solucion->solucion_imagen) { ?>
                    <div class="image-detail-solucion">
                        <img src="/images/<?= $this->solucion->solucion_imagen ?>" alt="<?= $this->solucion->solucion_titulo ?>" class="img-fluid">
                    </div>
                <?php } ?>

                <div class="content-detail-solucion">
                    <?php if (!$this->solucionPadre && $this->solucion->solucion_categoria) { ?>

                        <div class="content-info py-3 d-flex align-items-center justify-content-start gap-2">



                            <span class="category"><i class="fa-solid fa-layer-group"></i> Categoría: </span>
                            <a class="category-name" href="#"><?= $this->solucion->solucion_categoria ?></a>

                        </div>
                    <?php } ?>
                    <h1><?= $this->solucion->solucion_titulo ?></h1>

                    <?php if ($this->solucion->solucion_descripcion) { ?>
                        <div class="content-description">
                            <?= $this->solucion->solucion_descripcion ?>
                        </div>
                    <?php } ?>

                    <?php if ($this->solucion->solucion_introduccion) { ?>

                        <figure class="text-start">
                            <blockquote class="blockquote">
                                <?= $this->solucion->solucion_introduccion ?> </blockquote>
                            <figcaption class="blockquote-footer">
                                <cite title="Source Title"> <?= $this->solucion->solucion_autor ?></cite>
                            </figcaption>
                        </figure>
                    <?php } ?>

                    <?php if ($this->solucion->solucion_contenido) { ?>
                        <div class="content-description">
                            <?= $this->solucion->solucion_contenido ?>
                        </div>
                    <?php } ?>


                    <?php if ($this->solucion->solucion_tags) { ?>
                        <div class="content-tags d-flex gap-3 flex-wrap mt-2 mt-md-4">
                            <?php foreach (separarTags($this->solucion->solucion_tags) as $tag) : ?>
                                <a href="/page/solucion/index?tag=<?= $tag ?>" class="btn-blue border-0 rounded-0"><?= $tag ?></a>
                            <?php endforeach ?>
                        </div>
                    <?php } ?>

                    <div class="row g-2 mt-3">
                        <?php
                        if ($this->hayDocumentos == 1 && $this->hayFotos == 1) {
                            $columna = 'col-lg-6';
                        } elseif ($this->hayDocumentos == 1) {
                            $columna = 'col-lg-12';
                        } else {
                            $columna = 'col-lg-12';
                        }
                        ?>
                        <?php if ($this->documentos && $this->hayDocumentos == 1) { ?>
                            <div class="col-12 <?= $columna ?> ">
                                <h2 class="title-info">Documentos</h2>
                                <div class="container-docs">

                                    <?php echo $this->documentos ?>
                                </div>

                            </div>
                        <?php } ?>
                        <?php if ($this->hayFotos == 1 && is_countable($this->fotos) && count($this->fotos) >= 1) { ?>

                            <div class="col-12 <?= $columna ?>">
                                <h2 class="title-info">Imágenes</h2>

                                <?php if ($this->hayFotos == 1) { ?>
                                    <div class="content-photos mt-3 contenedorfotos" id="contenedorfotos">
                                        <?php if (is_countable($this->fotos) && count($this->fotos) >= 1) { ?>

                                            <div class="f-carousel" id="myCarousel">
                                                <?php foreach ($this->fotos as $foto) { ?>

                                                    <?php if ($foto->foto_foto && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $foto->foto_foto)) { ?>

                                                        <div class="f-carousel__slide" data-fancybox="gallery" data-src="/images/<?= $foto->foto_foto ?>" data-thumb-src="/images/<?= $foto->foto_foto ?>">


                                                            <img width="640" height="480" alt="" data-lazy-src="/images/<?= $foto->foto_foto ?>" />
                                                        </div>
                                                    <?php } else { ?>

                                                        <div class="f-carousel__slide" data-fancybox="gallery" data-src="/skins/page/images/Corte/imagenot.jpg" data-thumb-src="/skins/page/images/Corte/imagenot.jpg">


                                                            <img width="640" height="480" alt="" data-lazy-src="/skins/page/images/Corte/imagenot.jpg" />

                                                        </div>

                                                    <?php } ?>


                                                <?php } ?>
                                            </div>



                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>

            </article>


        </div>
    </div>
</div>
<?php
function separarTags($tags)
{
    $tags = explode(",", $tags);
    $tags = array_map('trim', $tags);
    return $tags;
}
?>
<style>
    .main-general {
        background-color: #f5f5f5;
        z-index: unset;

    }

    h2 {
        text-align: center !important;
    }

    h2::after {
        margin: 5px auto 0 auto !important;
    }

    h2.title-info {
        font-size: 1.3rem;
        font-weight: 500;
        color: var(--gris-medio)
    }

    h2.title-info::after {
        all: unset;
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
            Thumbs,
        }
    );
</script>