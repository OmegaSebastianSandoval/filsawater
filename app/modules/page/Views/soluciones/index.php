<?php
echo $this->banner;
?>
<div data-aos="" class="container container-categorias pb-3">
    <?php echo $this->contenido ?>

    <?php if ($this->tag) { ?>
        <div class="container-tags d-flex gap-3 align-items-center mb-3">
            <span>Filtrando por: </span>


            <a href="/page/soluciones" class="btn-blue btn-outline rounded-0 d-flex align-items-center gap-2">
                <?= $this->tag ?>
                <i class="fa-solid fa-circle-xmark"></i>
            </a>

        </div>

    <?php } ?>

    <div data-aos="" class="row g-5">
        <?php foreach ($this->soluciones as $solucion) : ?>
            <div  data-aos="" class="col-12 col-md-6 col-lg-4 container-solucion">

                <a href="/page/soluciones/solucion?id=<?= $solucion->solucion_id ?>">

                    <div class="content-solucion-home mx-2">

                        <div class="image-content">
                            <img src="/images/<?= $solucion->solucion_imagen ?>"
                                alt="<?= $solucion->solucion_titulo ?>"
                                class="img-fluid">

                        </div>
                        <div class="content-info py-2 d-flex align-items-center justify-content-start gap-2 d-none">
                            

                            <?php if ($blog->blog_nuevo == 1) { ?>
                                <div class="vr"></div>
                                <span>Nuevo</span>

                            <?php } ?>

                        </div>
                        <div class="content-title">
                            <h4><?= $solucion->solucion_titulo ?></h4>
                        </div>
                        <div class="content-description">
                            <?= $solucion->solucion_descripcion ?>

                        </div>


                    </div>

                </a>
            </div>


        <?php endforeach ?>
        <div class=" d-flex gap-5 mt-5 mb-2 justify-content-center">
            <ul class="pagination justify-content-center">

                <?php
                $url = '/page/blog';
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
    </div>
</div>

<style>
    .main-general {
        background-color: #f5f5f5;
    }

    h2 {
        text-align: center !important;
    }

    h2::after {
        margin: 5px auto 0 auto !important;
    }
</style>