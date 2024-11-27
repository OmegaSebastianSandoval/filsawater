<div class="slider-principal" data-aos="">
  <div id="carouselprincipal<?php echo $this->seccionbanner; ?>" class="carousel slide carousel-fade">

    <?php if (count($this->banners) >= 2) { ?>

      <div class="carousel-indicators">
        <?php foreach ($this->banners as $key => $banner) { ?>

          <button type="button" data-bs-target="##carouselprincipal<?php echo $this->seccionbanner; ?>" data-bs-slide-to="<?php echo $key ?>" <?php if (
                                                                                                                                                $key == 0
                                                                                                                                              ) { ?>class="active" <?php } ?> aria-current="true" aria-label="Slide <?php echo $key ?>"></button>

        <?php } ?>

      </div>
    <?php } ?>

    <div class="carousel-inner">
      <?php foreach ($this->banners as $key => $banner) { ?>
        <div class="carousel-item <?php if ($key == 0) { ?>active <?php } ?>">

          <?php if ($this->id_youtube($banner->publicidad_video) != false) { ?>
            <!--  <div class="fondo-video-youtube">
              <div class="banner-video-youtube" id="videobanner<?php echo $banner->publicidad_id; ?> " data-video="<?php echo $this->id_youtube($banner->publicidad_video); ?>"></div>
            </div> -->


            <div class="fondo-imagen-interna fondo-imagen-interna-video">

              <a href="<?php echo $banner->publicidad_video; ?>" data-fancybox="video-gallery">


                <img src="/images/<?php echo $banner->publicidad_imagen; ?>" alt="<?php echo $banner->publicidad_nombre; ?>" class="d-none d-md-block">
                <img src="/images/<?php echo $banner->publicidad_imagenresponsive; ?>" alt="<?php echo $banner->publicidad_nombre; ?>" class="d-block d-md-none">
                <div class="play-icon">▶️</div>
              </a>
            </div>

          <?php } else { ?>

            <div class="fondo-imagen d-none d-lg-flex justify-content-start align-items-center">

              <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="w-100">

                <?php } ?>

                <img src="/images/<?php echo $banner->publicidad_imagen; ?>" alt="">



                <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                </a>
              <?php } ?>
              <?php if ($banner->mostrarinfo == 1) { ?>

                <div class="contenido-banner">

                  <!-- <h4> <?php echo ($banner->publicidad_nombre);  ?></h4> -->
                  <?php echo $banner->publicidad_descripcion; ?>
                  <?php if ($banner->publicidad_enlace) { ?>
                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="btn-blue">
                      <?php echo $banner->publicidad_texto_enlace ? $banner->publicidad_texto_enlace : 'Ver más'; ?>

                    </a>
                  <?php } ?>

                </div>
              <?php } ?>
            </div>

            <div class="fondo-imagen-responsive d-lg-none d-flex justify-content-center align-items-center">
              <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="w-100">

                <?php } ?>

                <img src="/images/<?php echo $banner->publicidad_imagenresponsive; ?>" alt="" class="img-responsive-principal">
                <?php if ($banner->mostrarinfo != 1 && $banner->publicidad_enlace) { ?>
                </a>
              <?php } ?>

              <!-- <?php if ($banner->mostrarinfo == 1) { ?>

                <div class="contenido-banner">

                  <h4>
                    <?php echo $banner->publicidad_nombre; ?>
                  </h4>
                  <?php echo $banner->publicidad_descripcion; ?>
                  <?php if ($banner->publicidad_enlace) { ?>
                    <a href="<?php echo $banner->publicidad_enlace; ?>" <?php echo $banner->publicidad_tipo_enlace == 1 ? 'target="_blank"' : ''; ?> class="btn-verde">
                      <?php echo $banner->publicidad_texto_enlace ? $banner->publicidad_texto_enlace : 'Ver más'; ?>

                    </a>
                  <?php } ?>

                </div>
              <?php } ?> -->
            </div>

          <?php } ?>



        </div>
      <?php } ?>
    </div>
    <?php if (count($this->banners) >= 2) { ?>

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

<script>
  Fancybox.bind('[data-fancybox]', {
    Html: {
      youtube: {
        controls: 1,
        rel: 1,
        fs: 1
      }
    }
  });
</script>