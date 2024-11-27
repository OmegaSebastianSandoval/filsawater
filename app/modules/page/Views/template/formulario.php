<section data-aos="" class="bg-gray-blue form-home">
    <div class="container">
        <div class="row py-1 py-md-5 g-0 justify-content-between">
            <div class="col-12 col-sm-6 content-description-form">
                <h2>Contáctenos</h2>
                <?php echo $this->infopage->info_pagina_informacion_contacto ?>

            </div>
            <div class="col-12 col-sm-6 bg-blue p-sm-2  ps-md-5 d-flex flex-column justify-content-center">
                <form action="/page/index/enviarmessage" id="form-contact" class="form-contact">

                    <div class="row ">
                        <div class="col-12 mb-2">

                            <label>
                                <input class="input" type="text" name="nombres" placeholder="" required>
                                <span>Nombres</span>
                            </label>
                        </div>
                        <div class="col-12 mb-2">

                            <label>
                                <input class="input" type="text" name="apellidos" placeholder="" required>
                                <span>Apellidos</span>
                            </label>
                        </div>
                        <div class="col-12 mb-2">

                            <label>
                                <input class="input" type="number" name="phone" placeholder="" required>
                                <span>Teléfono</span>
                            </label>
                        </div>
                        <div class="col-12 mb-2">

                            <label>
                                <input class="input" type="email" name="correo" placeholder="" required>
                                <span>Correo</span>
                            </label>
                        </div>

                        <div class="col-12 mb-2">

                            <label>
                                <textarea class="input" name="asunto" placeholder="" required></textarea>
                                <span>Cuentenos su proyecto o idea</span>
                            </label>

                        </div>
                    </div>

                    <input type="hidden" id="lastname" name="lastname">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input name="hash" type="hidden" value="<?php echo md5(date("Y-m-d")); ?>" />
                    <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
                    <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

                    <div class="row">
                        <div class="col-12 col-xxl-6 d-grid d-md-flex justify-content-center justify-content-md-between">
                            <div class="g-recaptcha" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>

                        </div>
                        <div class="col-12 col-xxl-6  d-grid mt-3 mt-xxl-0 ">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" required value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault" data-bs-toggle="modal" data-bs-target="#modalPoliticas" role="button">
                                    Aceptar términos y condiciones
                                </label>
                            </div>
                            <div class="d-flex justify-content-center justify-content-md-start">

                                <button class="btn-blue mt-2 px-4 py-2 border-white" id="submit-btn">Enviar ahora</button>
                            </div>

                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>
</section>