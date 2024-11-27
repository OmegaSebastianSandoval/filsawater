<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-10">
                <h2>Enviar Solicitud de Registro</h2>
                <?php if ($this->error) : ?>
                    <div class="alert alert-danger text-center">
                        <strong>Error!</strong> <?= $this->error ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->registrook) : ?>
                    <div class="alert alert-success text-center">
                        <?= $this->registrook ?>
                    </div>
                <?php endif; ?>
                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/login/enviardatos" id="form-enviardatos" class="form-contact" autocomplete="">

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-8 mb-2">

                                <label>
                                    <input class="input" type="text" name="company" required autocomplete="new-text">
                                    <span>Nombre de la empresa</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">

                                <label>
                                    <input class="input" type="text" name="nit" required autocomplete="new-text" onkeypress="return soloNumerosYGuion(event)" maxlength="15" minlength="8" pattern="^\d+(-\d+)*$" title="Ingrese solo números y guiones">
                                    <span>Nit</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">

                                <label>
                                    <input class="input" type="email" name="email" required autocomplete="new-text">
                                    <span>Correo electrónico</span>
                                </label>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-2">

                                <label>
                                    <input class="input" type="text" name="address" required autocomplete="new-text">
                                    <span>Dirección</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">

                                <label>
                                    <input class="input" type="text" name="phone" required autocomplete="new-text" onkeypress="return soloNumeros(event)" maxlength="10" minlength="10" pattern="^\d+$">

                                    <span>Teléfono</span>
                                </label>
                            </div>
                           

                            <div class="col-12 col-md-6 col-lg-8 mb-2">

                                <label>
                                    <input class="input" type="text" name="name" required autocomplete="new-text">
                                    <span>Contacto</span>
                                </label>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-2">

                                <label>
                                    <input class="input" type="text" name="phone-contact" required autocomplete="new-text" onkeypress="return soloNumeros(event)" maxlength="10" minlength="10" pattern="^\d+$">

                                    <span>Teléfono del contacto</span>
                                </label>
                            </div>
                            <!-- <div class="col-12 col-md-6 col-lg-4 mb-2">

                            <label>
                                <input class="input" type="text" name="cedula" required autocomplete="new-text" onkeypress="return soloNumeros(event)" maxlength="14" minlength="7" pattern="^\d+$">
                                <span>Cédula del contacto</span>
                            </label>
                        </div> -->








                        </div>


                        <div class="row mt-3">

                            <div class="col-12 d-grid mt-3 mt-xxl-0 ">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" required value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault" data-bs-toggle="modal" data-bs-target="#modalPoliticas" role="button">
                                        Aceptar términos y condiciones
                                    </label>
                                </div>

                                <div class="g-recaptcha mt-3 d-flex justify-content-start" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>


                                <div class="d-flex justify-content-center justify-content-md-center mt-4">

                                    <button class="btn-blue px-4 py-2 border-white" id="submit-create">Enviar datos</button>
                                </div>
                                <div class="container-newaccount mt-2">
                                    <span>¿Ya tienes cuenta? </span> <a href="/page/login">Iniciar Sesión</a>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .main-general {
        min-height: 56dvh;
        background-color: #f5f5f5;

        height: auto;
    }



    .btn-blue:disabled {
        background-color: #ccc !important;
    }
</style>

<script>
    function soloNumeros(event) {
        const charCode = event.keyCode ? event.keyCode : event.which;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    function soloNumerosYGuion(event) {
        const charCode = event.keyCode ? event.keyCode : event.which;

        // Permitir números (0-9) y el guion (-)
        if (
            charCode !== 45 && // Código ASCII del guion "-"
            (charCode < 48 || charCode > 57) // Números (0-9)
        ) {
            event.preventDefault();
            return false;
        }

        return true;
    }
</script>