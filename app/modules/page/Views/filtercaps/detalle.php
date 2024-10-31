<?php
echo $this->banner;
?>
<div class="container pb-5 pt-4 containter-detail">
    <a class="btn-blue btn-outline gap-2 rounded-0 my-3" href="/page/blog"> <i class="fa-regular fa-circle-left"></i> Volver</a>
    <div class="row g-3 ">


        <div class="col-12 col-md-3 col-lg-3">
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
        <div class="col-12 col-md-9 col-lg-9">
            <article class="contaier-detail-blog">
                <div class="image-detail-blog">
                    <img src="/images/<?= $this->blog->blog_imagen ?>" alt="<?= $this->blog->blog_titulo ?>" class="img-fluid">
                </div>
                <div class="content-detail-blog">
                    <div class="content-info py-4 d-flex align-items-center justify-content-start gap-2">

                        <span class="date"><i class="fa-solid fa-calendar"></i> <?= formatearFechaEsp($this->blog->blog_fecha) ?></span>
                        <div class="vr"></div>
                        <span class="category"><i class="fa-solid fa-layer-group"></i> Categoría: </span>
                        <a class="category-name" href="/page/blog?category=<?= $this->blog->blog_categoria_id ?>"><?= $this->list_blog_categoria_id[$this->blog->blog_categoria_id] ?></a>
                        <?php if ($this->blog->blog_nuevo == 1) { ?>
                            <div class="vr"></div>
                            <span class="new">Nuevo</span>
                        <?php } ?>
                    </div>
                    <h1><?= $this->blog->blog_titulo ?></h1>

                    <div class="content-description">
                        <?= $this->blog->blog_descripcion ?>
                    </div>
                    <figure class="text-start">
                        <blockquote class="blockquote">
                            <?= $this->blog->blog_introduccion ?> </blockquote>
                        <figcaption class="blockquote-footer">
                            <cite title="Source Title"> <?= $this->blog->blog_autor ?></cite>
                        </figcaption>
                    </figure>

                    <div class="content-description">
                        <?= $this->blog->blog_contenido ?>
                    </div>

                    <div class="content-tags d-flex gap-3 flex-wrap mt-2 mt-md-4">
                        <?php foreach (separarTags($this->blog->tags) as $tag) : ?>
                            <a href="/page/blog/index?tag=<?= $tag ?>" class="btn-blue border-0 rounded-0"><?= $tag ?></a>
                        <?php endforeach ?>
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
    }

    h2 {
        text-align: center !important;
    }

    h2::after {
        margin: 5px auto 0 auto !important;
    }
</style>