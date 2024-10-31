<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-7 col-lg-8">
                <h2>Crear Cuenta</h2>

                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/index/enviarmessage" id="form-contact" class="form-contact" autocomplete="">

                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="text" name="name" placeholder="" required autocomplete="new-text">
                                    <span>Nombre</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="text" name="cedula" placeholder="" required autocomplete="new-text">
                                    <span>Cédula</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="email" name="email" placeholder="" required autocomplete="new-text">
                                    <span>Correo electrónico</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="number" name="phone" placeholder="" required autocomplete="new-text">
                                    <span>Teléfono</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label class="container-password">
                                    <input class="input" type="password" name="password" placeholder="" required autocomplete="new-password">
                                    <span>Contraseña</span>
                                    <button type="button" class="toggle-password" data-target="password"><i class="fa-solid fa-eye"></i></button>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label class="container-password">
                                    <input class="input" type="password" name="re-password" placeholder="" required autocomplete="new-password">
                                    <span>Repetir contraseña</span>
                                    <button type="button" class="toggle-password" data-target="re-password"><i class="fa-solid fa-eye"></i></button>
                                </label>
                            </div>




                        </div>
                        <div class="container-forget">
                            <a href="#">¿Olvidó su contraseña?</a>
                        </div>



                        <div class="row mt-3">

                            <div class="col-12 d-grid mt-3 mt-xxl-0 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" required value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault" data-bs-toggle="modal" data-bs-target="#modalPoliticas" role="button">
                                        Aceptar términos y condiciones
                                    </label>
                                </div>



                                <div class="d-flex justify-content-center justify-content-md-center mt-4">

                                    <button class="btn-blue px-4 py-2 border-white" id="submit-btn">Enviar ahora</button>
                                </div>
                                <div class="container-newaccount mt-2">
                                    <a href="#">Crear cuenta</a>
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
</style>