<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if ($this->popup->publicidad_estado == 1) { ?>
            const popup = document.getElementById("popup");
            if (popup) {
                const modal = new bootstrap.Modal(popup);
                modal.show();
            }
        <?php } ?>
    });
</script>
<?php echo $this->banner ?>

<div class="contenido-home ">
    <?php echo $this->contenido ?>

   <!--  <section id="secton-blogs" class="contenedor-seccion section-blogs bg-gray">
        <div class="container">
            <h2 class="text-center">Conoce nuestras soluciones</h2>
            <div id="slider_blogs" class="slider_blogs pt-1 pt-md-1">
                <?php foreach ($this->blogs as $blog) : ?>
                    <a href="/page/blog/detalle?id=<?= $blog->blog_id ?>">
                        <div class="content-blog-home mx-2">
                            <div class="image-content">
                                <img src="/images/<?= $blog->blog_imagen ?>"
                                    alt="<?= $blog->blog_titulo ?>"
                                    class="img-fluid">
                            </div>
                            <div class="content-info py-3 d-flex align-items-center justify-content-start gap-4">
                                <?= formatearFechaEsp($blog->blog_fecha) ?>
                                <?php if ($blog->blog_nuevo == 1) { ?>
                                    <div class="vr"></div>
                                    <span>Nuevo</span>                                   
                                <?php } ?>
                            </div>
                            <div class="content-title">
                                <h4><?= $blog->blog_titulo ?></h4>
                            </div>
                            <div class="content-description">
                                <?= $blog->blog_descripcion ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>

    </section> -->
    <section data-aos="" id="secton-blogs" class="contenedor-seccion section-blogs bg-gray">
        <div class="container">

            <h2 class="text-center">Conoce nuestras soluciones</h2>
            <div id="slider_blogs" class="slider_blogs pt-1 pt-md-1">
                <?php foreach ($this->soluciones as $solucion) : ?>
                    <a href="/page/soluciones/solucion?id=<?= $solucion->solucion_id  ?>">

                        <div class="content-blog-home mx-2">

                            <div class="image-content">
                                <img src="/images/<?= $solucion->solucion_imagen ?>"
                                    alt="<?= $solucion->solucion_titulo ?>"
                                    class="img-fluid">

                            </div>
                           
                            <div class="content-title">
                                <h4><?= $solucion->solucion_titulo ?></h4>
                            </div>
                            <div class="content-description">
                                <?= $solucion->solucion_descripcion ?>

                            </div>


                        </div>
                    </a>


                <?php endforeach ?>
            </div>

        </div>

    </section>
</div>

<script>
    $('#slider_blogs').slick({
        infinity: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: false,
        arrows: true,

        responsive: [{
                breakpoint: 1200,
                settings: {
                    infinity: false,

                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                }
            },
        ]
    });
</script>