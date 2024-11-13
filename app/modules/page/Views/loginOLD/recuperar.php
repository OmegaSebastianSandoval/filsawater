<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-7 col-lg-4">
                <h2>Recuperar Contraseña</h2>

                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/login/consultacorreo" id="form-recuperacion" class="form-contact" autocomplete="">

                        <div class="row">
                            <div class="col-12 mb-2">

                                <label>
                                    <input class="input" type="text" name="cedula" placeholder="" required autocomplete="new-text">
                                    <span>Cédula</span>
                                </label>
                            </div>
                        </div>
                        <div class="container-forget">
                            <a href="/page/login">Iniciar Sesión</a>
                        </div>
                       
                        <div class="row ">

                            <div class="col-12  mt-2 mt-xxl-0 ">
                                <div class="g-recaptcha mt-3 d-flex justify-content-center" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>


                                <div class="d-flex justify-content-center justify-content-md-center mt-3">

                                    <button class="btn-blue px-4 py-2 border-white" id="submit-recuperacion">Enviar ahora</button>
                                </div>
                                <div class="container-newaccount mt-2">
                                    <a href="/page/login/crearcuenta">Crear cuenta</a>
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
        min-height: auto;
        background-color: #f5f5f5;
    }

    @media (width >1400px) {
        .main-general {
            height: calc(100dvh - 400px);
        }
    }
</style>