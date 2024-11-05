<div class="container">
    <div class="row">
        <div class="col-12 col-md-4 d-flex align-items-center justify-content-center p-4">
            <img src="/assets/logo-light.png" alt="Logo Filsa" class="img-fluid d-block my-auto">
        </div>
        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col-12 col-md-6 order-1 order-md-1 d-flex justify-content-center d-md-block">

                    <div>
                        <h3>Links</h3>
                        <div class="d-flex gap-4 justify-content-start">
                            <ul class="list-unstyled">
                                <li><a href="/page/index">Sobre Nosotros</a></li>
                                <li><a href="/page/index/nosotros">Blog</a></li>
                                <li><a href="/page/index/servicios">Servicios</a></li>

                            </ul>
                            <ul class="list-unstyled">
                                <li><a href="/page/index/politicas">Políticas de Privacidad</a></li>
                                <li><a href="/page/index/terminos">Proyectos</a></li>
                                <li><a href="/page/contacto/">Contacto</a></li>

                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6 order-3 order-md-2 d-flex flex-column align-items-center justify-content-center d-md-block">

                    <h3>Recibe Más Información</h3>
                    <p>Recibe información de nuestros servicios y productos</p>

                </div>
                <div class="col-12 col-md-6 d-flex ali order-2 order-md-3 d-flex justify-content-center d-md-block">

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
                <div class="col-12 col-md-6 order-4 order-md-4 d-flex justify-content-center d-md-block">


                    <form action="/page/index/enviarcorreo" id="emailForm">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="TU EMAIL" aria-label="TU EMAIL" required>
                            <input type="text" name="name" style="display:none">
                            <input type="hidden" name="lastname">
                            <button class="btn btn-outline-secondary" type="submit" id="submit-form"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr>
            <span class="text-center d-block">Todos los derechos reservados</span>
        </div>

    </div>
</div>