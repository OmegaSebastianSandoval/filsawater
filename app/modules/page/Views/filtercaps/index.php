<?php
echo $this->banner;
?>
<div class="container pb-5 pt-4 containter-detail">
    <div class="row g-3 ">


        <div class="col-12 col-md-3 col-lg-3 d-none">
            <aside class="aside-recents">
                <h3>Recientes</h3>
                <div class="row g-0 content-importants-blog">
                    <?php foreach ($this->blogsImportantes as $blogImportante): ?>
                        <a href="/page/blog/detalle?id=<?= $blogImportante->blog_id ?>" class="mb-3">

                            <div class="content-important-blog">
                                <div class="content-image-important">
                                    <img src="/images/<?= $blogImportante->blog_imagen ?>" alt="<?= $blogImportante->blog_titulo ?>" class="img-fluid">
                                </div>
                                <div class="content-info-important">
                                    <span class="title-important">
                                        <?= $blogImportante->blog_titulo ?>
                                    </span>
                                    <span class="date-important">
                                        <i class="fa-solid fa-calendar"></i> <?= formatearFechaEsp($blogImportante->blog_fecha) ?>
                                    </span>

                                </div>

                            </div>
                        </a>
                    <?php endforeach ?>
                </div>

            </aside>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <?php echo $this->contenido ?>



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