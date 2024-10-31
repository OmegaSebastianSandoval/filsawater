<div class="row mt-4">
  <?php
  // print_r($columna);
  if ($columna->contenido_titulo_ver == 1) {
    echo '<h2>' . $columna->contenido_titulo . '</h2>';
  }
  ?>
  <?php echo $columna->contenido_descripcion; ?>
  <div id="slider_<?php echo $columna->contenido_id; ?>" class="slider_<?php echo $columna->contenido_id; ?> col-sm-12 sliderCont w-100 ">
    <?php foreach ($slidercontent as $slider) : ?>
      <?php $slider = $slider["nietos"];
      // print_r($slider->contenido_descripcion);
      ?>

      <div class="itemSlider itemSlider_<?php echo $columna->contenido_id; ?>">

        <?php if ($slider->contenido_enlace) { ?>
          <a href="<?php echo $slider->contenido_enlace ?>" <?php if ($slider->contenido_enlace_abrir == '1') {
                                                              echo 'target="_blank"';
                                                            } ?>>
          <?php } ?>
          <?php if ($slider->contenido_imagen) { ?>

            <img class="img-slider" src="/images/<?php echo $slider->contenido_imagen; ?>" alt="<?php echo $slider->contenido_titulo; ?>">
          <?php } else {  ?>
            <img class="img-slider" src="/assets/pic7.jpg" alt="<?php echo $slider->contenido_titulo; ?>">

          <?php } ?>
          <div class="content-slider content-sli1der_<?php echo $columna->contenido_id; ?>">



            <?php if ($slider->contenido_descripcion != '') {  ?>
              <div class="descripcion-slider">

                <?php echo  $slider->contenido_descripcion; ?>
              </div>
            <?php  } ?>

            <?php if ($slider->contenido_titulo_ver == 1) {
              echo '<h3>' . $slider->contenido_titulo . '</h3>';
            } ?>

            <?php if ($slider->contenido_introduccion != '') {  ?>
              <div class="introduccion-slider">

                <?php echo  $slider->contenido_introduccion; ?>
              </div>
            <?php  } ?>
          </div>


          <?php if ($slider->contenido_enlace) { ?>

          </a>
        <?php } ?>

      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  console.log(<?php echo $columna->contenido_id; ?>);

  $('#slider_<?php echo $columna->contenido_id; ?>').slick({
    infinity: false,
    slidesToShow: <?php echo $columna->contenido_id == 14 ? 2 : 4 ?>,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    dots: <?php echo $columna->contenido_id == 14 ? 'true' : 'false' ?>,
    arrows: <?php echo $columna->contenido_id == 14 ? 'false' : 'true' ?>,

    responsive: [{
        breakpoint: 1200,
        settings: {
          infinity: false,

          slidesToShow: <?php echo $columna->contenido_id == 14 ? 2 : 3 ?>,
          slidesToScroll: 1,
          dots: <?php echo $columna->contenido_id == 14 ? 'true' : 'false' ?>,
          arrows: true
        }
      },
      {
        breakpoint: 900,
        settings: {
          slidesToShow: <?php echo $columna->contenido_id == 14 ? 2 : 2 ?>,
          slidesToScroll: 1,
          dots: <?php echo $columna->contenido_id == 14 ? 'true' : 'true' ?>,
          arrows: false
        }
      },
      {
        breakpoint: 770,
        settings: {
          slidesToShow: <?php echo $columna->contenido_id == 14 ? 1 : 2 ?>,
          slidesToScroll: 1,
          dots: <?php echo $columna->contenido_id == 14 ? 'true' : 'true' ?>,
          arrows: false
        }
      },
    ]
  });
  $(document).ready(function() {
    // Verificar si la resolución es mayor o igual a 765px
    if (window.innerWidth <= 765) {
      // Al cargar la página, agregar la clase a los slides visibles
      $('.slider_18 div.slick-active .content-slider').addClass('content-slider_18');

      // Escuchar el evento afterChange para cuando se cambien los slides
      $('.slider_18').on('afterChange', function(event, slick, currentSlide) {
        // Remover la clase 'content-slider_18' de todos los divs .content-slider
        $('.slider_18 div .content-slider').removeClass('content-slider_18');

        // Añadir la clase 'content-slider_18' solo a los slides visibles
        $('.slider_18 div.slick-active .content-slider').addClass('content-slider_18');
      });
    }
  })
</script>
