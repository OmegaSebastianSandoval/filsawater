<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-6 col-lg-4">
                <h2>Iniciar Sesión</h2>

                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/index/enviarmessage" id="form-contact" class="form-contact">

                        <div class="row">
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


                        </div>

                        <input type="hidden" id="lastname" name="lastname">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input name="hash" type="hidden" value="<?php echo md5(date("Y-m-d")); ?>" />
                        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
                        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

                        <div class="row">

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
    </div>
</div>


<style>
    .main-general {
        min-height: auto;
        background-color: #f5f5f5;

        /* height: calc(100dvh - 400px); */
    }
</style>