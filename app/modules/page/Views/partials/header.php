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

                <div class="d-flex gap-3 align-items-center">
                    <?php if ($this->usuario) { ?>
                        <a href="/page/home" class="login <?php echo $this->botonactivo == 7 ? 'active' : '' ?>">
                            <i class="fa-regular fa-user"></i>
                            <?= $this->usuario->user_empresa ?>
                        </a>
                    <?php } else { ?>
                        <a href="/page/login" class="login <?php echo $this->botonactivo == 7 ? 'active' : '' ?>">
                            <i class="fa-regular fa-user"></i>
                            Login
                        </a>
                    <?php } ?>
               
                        <div class="vr"></div>

                        <span class="content-carrito  d-none d-md-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="count-carrito"></span>
                        </span>
                        <?php if ($this->usuario) { ?>
                        <div class="vr ocultar-carrito"></div>
                        <a href="/page/login/logout" class="login-out">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Salir
                        </a>
                    <?php } ?>


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
                <li><a href="/" class="link <?php echo $this->botonactivo == 1 ? 'active' : '' ?>">Inicio</a></li>

                <li class="nav-item dropdown">
                    <a class="link <?php echo $this->botonactivo == 2 ? 'active' : '' ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Nuestras Soluciones
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/page/soluciones/">Todas</a></li>
                        <li class="d-block">
                            <hr class="dropdown-divider">
                        </li>
                        <?php foreach ($this->list_blog_categoria_id as $key => $category) { ?>
                            <li><a class="dropdown-item <?= $key == $this->solucionId ? 'active' : '' ?>" href="/page/soluciones/solucion?id=<?= $key  ?>"><?= $category  ?></a></li>
                        <?php } ?>

                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="link <?php echo $this->botonactivo == 3 ? 'active' : '' ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu">

                        <?php foreach ($this->categoriasHeader as $key => $categoriaHeader) { ?>
                            <li><a class="dropdown-item <?= $categoriaHeader->tienda_categoria_id  == $this->categoriaHeader ? 'active' : '' ?>" href="/page/productos/categoria?categoria=<?= $categoriaHeader->tienda_categoria_id  ?>"><?= $categoriaHeader->tienda_categoria_nombre  ?></a></li>
                        <?php } ?>

                    </ul>
                </li>

                <li><a href="/page/filtercaps" class="link <?php echo $this->botonactivo == 6 ? 'active' : '' ?>">Filter caps</a></li>
                <li><a href="/page/contacto" class="btn-blue">Contáctenos</a></li>

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
                        <?php if ($this->usuario) { ?>
                            <a href="/page/home" class="login <?php echo $this->botonactivo == 7 ? 'active' : '' ?>">
                                <i class="fa-regular fa-user"></i>
                                <?= $this->usuario->user_empresa ?>
                            </a>
                            <div>
                                <?php if ($this->usuario) { ?>

                                    <a href="/page/login/logout" class="login-out login">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        Salir
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <a href="/page/login" class="login <?php echo $this->botonactivo == 7 ? 'active' : '' ?>">
                                <i class="fa-regular fa-user"></i>
                                Login
                            </a>
                        <?php } ?>






                    </div>


                </div>
            </ul>
       
                <span class="content-carrito d-block d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="count-carrito-responsive"></span>
                </span>
          
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