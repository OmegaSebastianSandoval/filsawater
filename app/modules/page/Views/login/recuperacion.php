<div class="container-login">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-7 col-lg-4">
                <h2>Recuperar Contraseña</h2>

                <div class="container-form-login shadow-sm p-4">
                    <?php if ($this->error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Token no valido.</strong> Tu token ha expirado o no es valido, por favor solicita uno nuevo.
                        </div>
                    <?php } else { ?>
                        <form action="/page/login/recuperarclave" id="form-recuperarclave" class="form-contact" autocomplete="">

                        <span class="text-white mt-2">Usuario: </span>
                        <span class="text-white fw-bold mt-2"><?= $this->user->user_user ?></span>
                            <input type="hidden" value="<?php echo $this->user->user_id  ?>" name="user_id">

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="container-password">
                                        <input class="input" type="password" name="password" id="password" required autocomplete="new-password">
                                        <span>Contraseña</span>
                                        <button type="button" class="toggle-password" data-target="password"><i class="fa-solid fa-eye"></i></button>
                                    </label>
                                </div>
                                <div class="col-12 mb-2">
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

                            <div class="container-forget d-none">
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

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .main-general {
        min-height: auto;
        /* height: calc(100dvh - 400px); */
        background-color: #f5f5f5;
    }

    @media (width >1400px) {
        .main-general {
            min-height: auto;

        }
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
        const submitBtn = document.getElementById("submit-recuperacion");


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
</script>