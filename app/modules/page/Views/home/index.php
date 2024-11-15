<div class="container container-profile pt-3 ">
    <h2><i class="fa-regular fa-user"></i>Perfil</h2>
    <div class="d-flex align-items-start container-flex-home">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link  " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
            <i class="fa-solid fa-address-card"></i> Perfil</button>
            <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" disabled>Disabled</button>
            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
        </div>
        <div class="tab-content w-100 ps-0 ps-md-3" id="v-pills-tabContent">
            <div class="tab-pane fade  " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">...</div>
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                <?php if ($this->msg) { ?>
                    <div class="alert alert-success text-center">
                        Se ha actualizado correctamente.
                    </div>
                <?php } ?>

                <form action="/page/home/updateprofile" id="update-contact" class="form-contact" enctype="multipart/form-data" method="post" data-toggle="validator">
                    <input type="hidden" name="id" value="<?= $this->usuario->user_id ?>">

                    <div class="row ">
                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">

                            <label>
                                <input class="input" type="text" name="user_empresa" value="<?= $this->usuario->user_empresa ?>" required readonly disabled>
                                <span>Nombre</span>
                            </label>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">

                            <label>
                                <input class="input" type="number" name="documento" value="<?= $this->usuario->user_cedula ?>" required readonly disabled>
                                <span>Nit</span>
                            </label>
                        </div>
                        <!-- <div class="col-12 col-md-3 form-group">
					<label for="user_email" id="label-correo" class="control-label">correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-envelope"></i></span>
						</div>
						<input type="email" value="<?= $this->content->user_email; ?>" name="user_email" id="user_email" class="form-control" required data-remote="/core/user/validationemail?csrf=1&email=<?= $this->content->user_email; ?>">
					</label>
					<div class="help-block with-errors"></div>
				</div> -->
                        <div class="col-12 col-md-6 col-lg-3 form-group mb-4   ">
                            <label>
                                <input class="input" type="email" name="user_email" value="<?= $this->usuario->user_email ?>" required data-remote="/core/user/validationemail?csrf=1&email=<?= $this->usuario->user_email; ?>">
                                <span>Correo electrónico</span>
                            </label>
                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">
                            <label>
                                <input class="input" type="text" name="user_addres" value="<?= $this->usuario->user_addres ?>" required>
                                <span>Dirección</span>
                            </label>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">
                            <label>
                                <input class="input" type="number" name="phone" value="<?= $this->usuario->user_telefono ?>" required>
                                <span>Teléfono del cliente</span>
                            </label>
                        </div>
                   

                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">
                            <label>
                                <input class="input" type="text" name="nombres-contacto" value="<?= $this->usuario->user_contacto ?>" required>
                                <span>Nombre de Contácto</span>
                            </label>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3  mb-4 ">
                            <label>
                                <input class="input" type="input" name="phone-contacto" value="<?= $this->usuario->user_telefono_contacto ?>" onkeypress="return soloNumeros(event)" maxlength="10" minlength="10" pattern="^\d+$" required>
                                <span>Teléfono del Contácto</span>
                            </label>
                        </div>


                        <div class="d-flex justify-content-center justify-content-md-center">
                            <button type="submit" class="btn-blue px-4 py-2 border-white" id="submit-create">Actualizar</button>
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
</div>


<style>
     .btn-blue:disabled {
            background-color: #ccc !important;
        }
    .container-profile .form-contact label .input:disabled+span {
        top: 0;
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
</script>
<script src="/components/bootstrap-validator/dist/validator.min.js"></script>