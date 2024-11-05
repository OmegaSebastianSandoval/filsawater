<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-7 col-lg-8">
                <h2>Crear Cuenta</h2>
                <?php if ($this->error) : ?>
                    <div class="alert alert-danger">
                        <?php if ($this->error == 1) {
                            $error = "Las contraseñas no son iguales.";
                        } else if ($this->error == 2) {
                            $error = "Ya existe un usuario con ese correo registrado.";
                        } else if ($this->error == 3) {
                            $error = "Ya existe un usuario con esa cédula registrada.";
                        }
                        ?>
                        <strong>Error!</strong> <?= $error ?>
                    </div>
                <?php endif; ?>
                <div class="container-form-login shadow-sm p-4">

                    <form action="/page/login/crear" class="form-contact" autocomplete="">

                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="text" name="name" required autocomplete="new-text">
                                    <span>Nombre</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="text" name="cedula" required autocomplete="new-text" onkeypress="return soloNumeros(event)" maxlength="14" minlength="7" pattern="^\d+$">
                                    <span>Cédula</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="email" name="email" required autocomplete="new-text">
                                    <span>Correo electrónico</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">

                                <label>
                                    <input class="input" type="text" name="phone" required autocomplete="new-text" onkeypress="return soloNumeros(event)" maxlength="10" minlength="10" pattern="^\d+$">

                                    <span>Teléfono</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label class="container-password">
                                    <input class="input" type="password" name="password" id="password" required autocomplete="new-password">
                                    <span>Contraseña</span>
                                    <button type="button" class="toggle-password" data-target="password"><i class="fa-solid fa-eye"></i></button>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label class="container-password">
                                    <input class="input" type="password" name="re-password" id="re-password" required autocomplete="new-password">
                                    <span>Repetir contraseña</span>
                                    <button type="button" class="toggle-password" data-target="re-password"><i class="fa-solid fa-eye"></i></button>
                                </label>
                            </div>




                        </div>
                        <div class="col-12 my-2 alert-contrasenia" id="alert-contrasenia2" style="display: none;">
                            <div class="alert alert-danger" role="alert">
                                Las contraseñas no son iguales.
                            </div>
                        </div>
                        <div class="col-12 my-2 alert-contrasenia" id="alert-contrasenia" style="display: none;">
                            <div class="alert alert-danger text-start" role="alert">
                                La contraseña debe incluir al menos:
                                <ul id="requirements" class="pl-4">
                                    <li id="length" class="invalid">8 caracteres</li>
                                    <li id="lowercase" class="invalid">Una minuscula</li>
                                    <li id="uppercase" class="invalid">Una Mayuscula</li>
                                    <li id="number" class="invalid">Un Numero</li>
                                </ul>
                            </div>
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

                                    <button class="btn-blue px-4 py-2 border-white" id="submit-create" disabled>Enviar ahora</button>
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

    .alert-contrasenia {
        display: none;
    }

    .btn-blue:disabled {
        background-color: #ccc !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        const rePasswordInput = document.getElementById("re-password");
        const alertContrasenia = document.getElementById("alert-contrasenia");
        const alertContrasenia2 = document.getElementById("alert-contrasenia2");
        const submitBtn = document.getElementById("submit-create");


        passwordInput.addEventListener("keyup", function() {
            validarClave(passwordInput.value);
            compararClaves();
            toggleSubmitButton();
        });

        rePasswordInput.addEventListener("keyup", function() {
            compararClaves();
            toggleSubmitButton();
        });

        function compararClaves() {
            const clave = passwordInput.value;
            const clave2 = rePasswordInput.value;

            if (clave === clave2) {
                alertContrasenia2.style.display = "none";

            } else {
                alertContrasenia2.style.display = "block";

            }
        }

        function validarClave(contrasenna) {
            const lengthRequirement = document.getElementById("length");
            const lowercaseRequirement = document.getElementById("lowercase");
            const uppercaseRequirement = document.getElementById("uppercase");
            const numberRequirement = document.getElementById("number");

            const hasLength = contrasenna.length >= 8;
            const hasLowercase = /[a-z]/.test(contrasenna);
            const hasUppercase = /[A-Z]/.test(contrasenna);
            const hasNumber = /\d/.test(contrasenna);

            lengthRequirement.classList.toggle("valid", hasLength);
            lengthRequirement.classList.toggle("invalid", !hasLength);

            lowercaseRequirement.classList.toggle("valid", hasLowercase);
            lowercaseRequirement.classList.toggle("invalid", !hasLowercase);

            uppercaseRequirement.classList.toggle("valid", hasUppercase);
            uppercaseRequirement.classList.toggle("invalid", !hasUppercase);

            numberRequirement.classList.toggle("valid", hasNumber);
            numberRequirement.classList.toggle("invalid", !hasNumber);

            if (hasLength && hasLowercase && hasUppercase && hasNumber) {
                alertContrasenia.style.display = "none";

            } else {
                alertContrasenia.style.display = "block";

            }
        }

        function toggleSubmitButton() {
            const isValidPassword =
                document.querySelector("#length").classList.contains("valid") &&
                document.querySelector("#lowercase").classList.contains("valid") &&
                document.querySelector("#uppercase").classList.contains("valid") &&
                document.querySelector("#number").classList.contains("valid");
            const passwordsMatch = passwordInput.value === rePasswordInput.value;

            submitBtn.disabled = !(isValidPassword && passwordsMatch);
        }

       

    });
    function soloNumeros(event) {
            const charCode = event.keyCode ? event.keyCode : event.which;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
</script>