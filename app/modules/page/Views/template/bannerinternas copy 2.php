<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<div class="slider-internas">

    <div id="carouselprincipal<?php echo $this->seccionbanner;  ?>" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">
            <?php foreach ($this->banners as $key => $banner) { ?>
                <div class="carousel-item <?php if ($key == 0) { ?>active <?php } ?>">

                    <?php if ($this->id_youtube($banner->publicidad_video) != false) { ?>
                        <!-- <div class="fondo-video-youtube">
                            <div class="banner-video-youtube" id="videobanner<?php echo $banner->publicidad_id; ?> " data-video="<?php echo $this->id_youtube($banner->publicidad_video); ?>"></div>
                        </div> -->
                        <?php if ($banner->publicidad_enlace) { ?>
                            <!--     <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="d-flex w-100">
                            <?php } ?> -->

                            <div class="fondo-imagen-interna fondo-imagen-interna-video">
                          
                            <a href="<?php echo $banner->publicidad_video; ?>?autoplay=1" data-fancybox="video-gallery">
                                     <!-- <img class="img-banner-interna img-video" src="/images/<?php echo $banner->publicidad_imagen; ?>" /> -->
                                    <!-- <div class="play-icon">▶️</div> -->
                                </a>
                            </div>
                            <!-- 
                            <?php if ($banner->publicidad_enlace) { ?>
                            </a>
                        <?php } ?> -->


                        <?php } else { ?>

                            <div class="fondo-imagen-interna d-none d-md-flex justify-content-end align-items-center">
                                <?php if ($banner->publicidad_enlace) { ?>
                                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="d-flex w-100">
                                    <?php } ?>

                                    <img src="/images/<?php echo $banner->publicidad_imagen; ?>" alt="Banner <?php echo $banner->publicidad_nombre; ?>" class="img-banner-interna">
                                    <?php if ($banner->mostrarinfo == 1) { ?>
                                        <div class="contenido-banner-internas">
                                            <?php echo $banner->publicidad_descripcion; ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($banner->publicidad_enlace) { ?>

                                    </a>
                                <?php } ?>

                            </div>

                            <div class="fondo-imagen-responsive d-md-none d-flex justify-content-center align-items-center">
                                <?php if ($banner->publicidad_enlace) { ?>
                                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="d-flex">
                                    <?php } ?>

                                    <img src="/images/<?php echo $banner->publicidad_imagenresponsive; ?>" alt="" class="img-banner-internas w-100">
                                    <h2 class="titulo-banner-internas"><?php echo $banner->publicidad_descripcion; ?></h2>
                                    <?php if ($banner->publicidad_enlace) { ?>

                                    </a>
                                <?php } ?>
                            </div>

                        <?php } ?>




                </div>
            <?php } ?>
        </div>
        <?php if (count($this->banners) > 1) { ?>

            <button type="button" class="carousel-control-prev" data-bs-target="#carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide="prev">
                <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                <i class="fa-solid fa-chevron-left carousel-control-prev-icono"></i>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide="next">
                <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                <i class="fa-solid fa-chevron-right carousel-control-next-icono"></i>
            </button>
        <?php } ?>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox]', {
        Html: {
            youtube: {
                controls: 0,
                rel: 0,
                fs: 0
            }
        }
    });
</script>