<div
  data-aos=""
  class="row mt-4">
  <?php
  // print_r($columna);
  if ($columna->contenido_titulo_ver == 1) {
    echo '<h2>' . $columna->contenido_titulo . '</h2>';
  }
  ?>
  <?php echo $columna->contenido_descripcion; ?>
  <div class="contenedor-fotos contenedor-fotos-<?php echo $columna->contenido_id; ?>" id="contenedorfotos-<?php echo $columna->contenido_id; ?>">
    <?php if (is_countable($galeriacontent) && count($galeriacontent) >= 1) { ?>

      <div class="f-carousel" id="myCarousel<?php echo $columna->contenido_id; ?>">
        <?php foreach ($galeriacontent as $contenido) { ?>
          <?php $contenido = $contenido["nietos"];
          // print_r($slider->contenido_descripcion);
          ?>
          <?php if ($contenido->contenido_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $contenido->contenido_imagen)) { ?>

            <div class="f-carousel__slide" data-fancybox="gallery" data-src="/images/<?= $contenido->contenido_imagen ?>" data-thumb-src="/images/<?= $contenido->contenido_imagen ?>">


              <img width="640" height="480" alt="<?= $contenido->contenido_imagen ?>" data-lazy-src="/images/<?= $contenido->contenido_imagen ?>" />
            </div>
          <?php } else { ?>
            <div class="f-carousel__slide" data-fancybox="gallery" data-src="/assets/imagenot.jpg" data-thumb-src="/assets/imagenot.jpg">


              <img width="640" height="480" alt="<?= $contenido->contenido_imagen ?>" data-lazy-src="/assets/imagenot.jpg" />
            </div>
          <?php } ?>

        <?php } ?>
      </div>



    <?php } ?>
  </div>
</div>

<style>
  .contenedor-fotos {
    max-width: 1000px;
    margin: 0 auto;
    width: 100%;
  }

  .contenedor-fotos img {
    width: 100%;
    object-fit: contain;
    cursor: pointer;
  }
</style>
<script>
  ;

  // Configurar Fancybox
  Fancybox.bind("[data-fancybox]", {
    initialSize: "fit",
  });
  new Carousel(
    document.getElementById("myCarousel<?php echo $columna->contenido_id; ?>"), {
      // Your custom options
      Dots: false,

    }, {
      Thumbs
    }
  );
</script>