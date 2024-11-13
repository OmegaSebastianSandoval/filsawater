<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-6 col-lg-5">
                <h2>Iniciar Sesión</h2>

                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/login/validar" id="form-login" class="form-contact" autocomplete="">

                        <div class="row">
                            <div class="col-12 mb-2">

                                <label>
                                    <input class="input" type="text" name="cedula" placeholder="" required autocomplete="new-text">
                                    <span>Cédula</span>
                                </label>
                            </div>

                            <div class="col-12  mb-2">
                                <label class="container-password">
                                    <input class="input" type="password" name="password" placeholder="" required autocomplete="new-password">
                                    <span>Contraseña</span>
                                    <button type="button" class="toggle-password" data-target="re-password"><i class="fa-solid fa-eye"></i></button>
                                </label>
                            </div>



                        </div>
                        <div class="container-forget">
                            <a href="/page/login/recuperar">¿Olvidó su contraseña?</a>
                        </div>



                        <div class="row mt-3">

                            <div class="col-12  mt-2 mt-xxl-0 ">
                                <div class="g-recaptcha mt-3 d-flex justify-content-center" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>




                                <div class="d-flex justify-content-center justify-content-md-center mt-3">

                                    <button class="btn-blue px-4 py-2 border-white" id="submit-login">Iniciar Sesión</button>
                                </div>
                                <div class="container-newaccount mt-2">
                                    <a href="/page/login/crearcuenta">Crear cuenta</a>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7">

                <div class="container-banner-login">
                    <h1>¿Quieres ser distribuidor de Filsa Water?</h1>

                    <p class="m-0 text-center">Únete a nuestra red de distribuidores y disfruta de todos los beneficios exclusivos.
                        <br>
                        <br>
                        <div class="">
                            <a href="/page/login/registro" class="btn-blue mx-auto">Contáctenos</a>
                        </div>
                    </p>
                </div>
            </div>


        </div>
    </div>
</div>


<style>
    .main-general {
        min-height: auto;
        background-color: #f5f5f5;

        /* height: calc(100dvh - 400px); */
    }

    @media (width >1500px) {
        .main-general {
            /* height: calc(100dvh - 400px); */
        }


    }
</style>