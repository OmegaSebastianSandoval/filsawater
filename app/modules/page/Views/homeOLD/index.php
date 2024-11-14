<div class="container container-profile pt-3 ">
    <h2><i class="fa-regular fa-user"></i>Perfil</h2>
    <div class="d-flex align-items-start container-flex-home">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link  " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Perfil</button>
            <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" disabled>Disabled</button>
            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
        </div>
        <div class="tab-content w-100" id="v-pills-tabContent">
            <div class="tab-pane fade  " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">...</div>
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                <?php if($this->msg){?>
                <div class="alert alert-success text-center">
                    Se ha actualizado correctamente.
                </div>
                <?php } ?>
               
                <form action="/page/home/updateprofile" id="update-contact" class="form-contact">
                    <input type="hidden" name="id" value="<?= $this->usuario->user_id ?>">

                    <div class="row ">
                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">

                            <label>
                                <input class="input" type="text" name="nombres" value="<?= $this->usuario->user_names ?>" required>
                                <span>Nombres</span>
                            </label>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">

                            <label>
                                <input class="input" type="number" name="documento" value="<?= $this->usuario->user_cedula ?>" required readonly disabled>
                                <span>Documento</span>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">
                            <label>
                                <input class="input" type="email" name="email" value="<?= $this->usuario->user_email ?>" required>
                                <span>Correo electrónico</span>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">
                            <label>
                                <input class="input" type="number" name="phone" value="<?= $this->usuario->user_telefono ?>" required>
                                <span>Teléfono</span>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">
                            <label class="container-password">
                                <input class="input" type="password" name="password" id="password" autocomplete="new-password">
                                <span>Contraseña</span>
                                <button type="button" class="toggle-password" data-target="password"><i class="fa-solid fa-eye"></i></button>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4  mb-2 ">
                            <label class="container-password">
                                <input class="input" type="password" name="re-password" id="re-password" autocomplete="new-password">
                                <span>Repetir contraseña</span>
                                <button type="button" class="toggle-password" data-target="re-password"><i class="fa-solid fa-eye"></i></button>
                            </label>
                        </div>

                        <div class="d-flex justify-content-center justify-content-md-center mt-4">
                            <button class="btn-blue px-4 py-2 border-white" id="submit-create">Actualizar</button>
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
                </form>
                <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
            </div>
        </div>
    </div>


    <style>
        .alert-contrasenia {
            display: none;
        }

        .btn-blue:disabled {
            background-color: #ccc !important;
        }

        .container-profile .form-contact label .input:disabled+span {
            top: 0;
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

                if (clave === "" && clave2 === "") {
                    alertContrasenia2.style.display = "none";
                    return;
                }

                if (clave === clave2) {
                    alertContrasenia2.style.display = "none";
                } else {
                    alertContrasenia2.style.display = "block";
                }
            }

            function validarClave(contrasenna) {
                if (contrasenna === "") {
                    alertContrasenia.style.display = "none";
                    return;
                }

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

                // Enable submit button if both fields are empty or if they are valid and match
                submitBtn.disabled = !(isValidPassword && passwordsMatch) && (passwordInput.value !== "" || rePasswordInput.value !== "");
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