<section class="header-up py-2">
    <div class="container">
        <div class="d-none d-md-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3 ">
                <?php if ($this->infopage->info_pagina_correos_contacto) { ?>
                    <span class="info-footer d-flex gap-2 align-items-center">
                        <i class="fa-regular fa-envelope"></i>
                        <?php echo $this->infopage->info_pagina_correos_contacto ?>
                    </span>



                <?php } ?>
                <div class="vr"></div>

                <div class="icons-red d-flex gap-3">

                    <?php if ($this->infopage->info_pagina_youtube) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_youtube ?>" target="_blank">
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                    <?php } ?>
                    <?php if ($this->infopage->info_pagina_facebook) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_facebook ?>" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>


                    <?php } ?>

                    <?php if ($this->infopage->info_pagina_x) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_x ?>" target="_blank">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>


                    <?php } ?>
                    <?php if ($this->infopage->info_pagina_linkedin) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_linkedin ?>" target="_blank">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>


                    <?php } ?>
                    <?php if ($this->infopage->info_pagina_instagram) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_instagram ?>" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>


                    <?php } ?>
                    <?php if ($this->infopage->info_pagina_pinterest) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_pinterest ?>" target="_blank">
                            <i class="fa-brands fa-pinterest-p"></i>
                        </a>


                    <?php } ?>

                    <?php if ($this->infopage->info_pagina_flickr) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_flickr ?>" target="_blank">
                            <i class="fa-brands fa-flickr"></i>
                        </a>


                    <?php } ?>
                    <?php if ($this->infopage->info_pagina_tiktok) { ?>
                        <a href="<?php echo $this->infopage->info_pagina_tiktok ?>" target="_blank">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>


                    <?php } ?>
                </div>
            </div>
            <div>

                <div class="d-flex gap-3">
                    <a href="#" class="login">
                        <i class="fa-regular fa-user"></i>
                        Login
                    </a>
                    <div class="vr"></div>

                    <span>
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span id="count-carrito">0</span>
                    </span>
                </div>

            </div>


        </div>
    </div>
</section>
<section class="header-down py-4">

    <div class="container">
        <nav>
            <input type="checkbox" id="nav-toggle">
            <div class="logo">
                <a href="/">
                    <img src="/assets/FilsaLogo.png" alt="">
                </a>
            </div>
            <ul class="links">
                <li><a href="#home" class="link <?php echo $this->botonactivo == 1 ? 'active' : '' ?>">Inicio</a></li>
                <!--  <li><a href="#about" class="link">Plantas</a></li>
                <li><a href="#work" class="link">Servicios</a></li>
                <li><a href="#projects" class="link">Proyectos</a></li>
                <li><a href="/page/blog" class="link <?php echo $this->botonactivo == 5 ? 'active' : '' ?>">Blog</a></li> -->

                <li class="nav-item dropdown">
                    <a class="link <?php echo $this->botonactivo == 2 ? 'active' : '' ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Nuestras Soluciones 
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/page/soluciones/">Todas</a></li>
                        <li class="d-block"><hr class="dropdown-divider"></li>
                        <?php foreach ($this->list_blog_categoria_id as $key => $category) { ?>
                            <li><a class="dropdown-item <?= $key == $this->solucionId ? 'active' : ''?>" href="/page/soluciones/solucion?id=<?= $key  ?>"><?= $category  ?></a></li>
                        <?php } ?>

                    </ul>
                </li>

                <li><a href="/page/filtercaps" class="link <?php echo $this->botonactivo == 6 ? 'active' : '' ?>">Filter caps</a></li>
                <li><a href="/page/contacto" class="btn-blue">Contacto</a></li>

                <div class="d-grid d-md-none w-100 p-2">
                    <div class="d-grid align-items-center gap-3 ">
                        <?php if ($this->infopage->info_pagina_correos_contacto) { ?>
                            <span class="info-footer d-flex gap-2 align-items-center mt-2 text-white">
                                <i class="fa-regular fa-envelope"></i>
                                <?php echo $this->infopage->info_pagina_correos_contacto ?>
                            </span>



                        <?php } ?>


                        <div class="icons-red d-flex gap-3">

                            <?php if ($this->infopage->info_pagina_youtube) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_youtube ?>" target="_blank">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>

                            <?php } ?>
                            <?php if ($this->infopage->info_pagina_facebook) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_facebook ?>" target="_blank">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>


                            <?php } ?>

                            <?php if ($this->infopage->info_pagina_x) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_x ?>" target="_blank">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>


                            <?php } ?>
                            <?php if ($this->infopage->info_pagina_linkedin) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_linkedin ?>" target="_blank">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>


                            <?php } ?>
                            <?php if ($this->infopage->info_pagina_instagram) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_instagram ?>" target="_blank">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>


                            <?php } ?>
                            <?php if ($this->infopage->info_pagina_pinterest) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_pinterest ?>" target="_blank">
                                    <i class="fa-brands fa-pinterest-p"></i>
                                </a>


                            <?php } ?>

                            <?php if ($this->infopage->info_pagina_flickr) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_flickr ?>" target="_blank">
                                    <i class="fa-brands fa-flickr"></i>
                                </a>


                            <?php } ?>
                            <?php if ($this->infopage->info_pagina_tiktok) { ?>
                                <a href="<?php echo $this->infopage->info_pagina_tiktok ?>" target="_blank">
                                    <i class="fa-brands fa-tiktok"></i>
                                </a>


                            <?php } ?>
                        </div>
                    </div>
                    <div class="mt-2">

                        <div class="d-flex gap-4">
                            <a href="#" class="login">
                                <i class="fa-regular fa-user"></i>
                                Login
                            </a>


                            <span>
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span id="count-carrito">0</span>
                            </span>
                        </div>

                    </div>


                </div>
            </ul>
            <label for="nav-toggle" class="icon-burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </label>


            <label for="nav-toggle" class="icon-burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </label>

        </nav>

    </div>
</section>