<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tabs = document.querySelectorAll('[data-bs-toggle="pill"]');
        // Función para activar la pestaña basada en el hash de la URL
        function activateTabFromHash() {
            const hash = window.location.hash;
            if (hash) {
                const targetTab = document.querySelector(hash + '[data-bs-toggle="pill"]');
                if (targetTab) {
                    const tab = new bootstrap.Tab(targetTab);
                    tab.show();
                    toggleSections(targetTab.id);
                }
            }
        }
        // Activar la pestaña correcta al cargar la página
        activateTabFromHash();
    });
</script>
<div class="container container-profile py-3 ">
    <h2><i class="fa-regular fa-user me-2"></i>Perfil</h2>
    <div class="d-flex mt-3 align-items-start container-flex-home">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link  active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa-solid fa-house"></i> Home</button>
            <button class="nav-link " id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                <i class="fa-solid fa-address-card"></i> Actualizar perfil</button>
            <button class="nav-link" id="v-pills-addres-tab" data-bs-toggle="pill" data-bs-target="#v-pills-addres" type="button" role="tab" aria-controls="v-pills-addres" aria-selected="false">
                <i class="fa-solid fa-map-location"></i> Direcciones de envío</button>
            <button class="nav-link " id="v-pills-pedido-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pedido" type="button" role="tab" aria-controls="v-pills-pedido" aria-selected="false"><i class="fa-solid fa-boxes-stacked"></i> Pedidos</button>
        </div>
        <div class="tab-content w-100 ps-0 ps-md-3" id="v-pills-tabContent">
            <div class="tab-pane fade   show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                <?php if ($this->msg) { ?>
                    <div class="alert alert-<?= $this->tipo ?> text-center">
                        <?= $this->msg ?>
                    </div>
                <?php } ?>
                <div class="contenedor-perfil bg-white shadow rounded p-3 p-md-5">
                    <div class="row mb-4">
                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Nombre</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_empresa ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Documento</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_cedula ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Correo</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_email ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Teléfono</label>
                            <label class="input-group">
                                <span><?= $this->usuario->user_telefono ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Dirección</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_addres ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>



                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Contacto</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_contacto ?></span>


                            </label>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="col-12 col-md-12 form-group">
                            <label for="pedido_documento" class="control-label">Teléfono de la persona de contacto</label>
                            <label class="input-group">


                                <span><?= $this->usuario->user_telefono_contacto ?></span>

                            </label>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">


                <form action="/page/home/updateprofile" id="update-contact" class="form-contact bg-  shadow rounded" enctype="multipart/form-data" method="post" data-toggle="validator">
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
                                <input class="input" type="text" name="documento" value="<?= $this->usuario->user_cedula ?>" required readonly disabled>
                                <span>Nit</span>
                            </label>
                        </div>
                        <!-- <div class="col-12 col-md-3 form-group">
					<label for="user_email" id="label-correo" class="control-label">correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-envelope"></i></span>
						</div>
						<input type="email" value="<?= $pedido->user_email; ?>" name="user_email" id="user_email" class="form-control" required data-remote="/core/user/validationemail?csrf=1&email=<?= $pedido->user_email; ?>">
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
            </div>
            <div class="tab-pane fade" id="v-pills-addres" role="tabpanel" aria-labelledby="v-pills-addres-tab" tabindex="0">

                <?php if ($this->msg) { ?>
                    <div class="alert alert-<?= $this->tipo ?> text-center">
                        <?= $this->msg ?>
                    </div>
                <?php } ?>

                <?php if (is_countable($this->direcciones) && count($this->direcciones) >= 1) { ?>
                    <button data-bs-toggle="modal" data-bs-target="#direcciones-modal" class="btn-blue px-4 py-2 ms-auto mb-2 border-white">Agregar dirección</button>
                    <div class="contendor-comprar">


                        <table class="table-info   tabla-pedidos-perfil table-cart shadow">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Dirección</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->direcciones as $direccion) { ?>
                                    <?php $id = $direccion->direccion_id ?>
                                    <tr>
                                        <td data-label="Departamento"><?= $direccion->departamento_nombre ?></td>
                                        <td data-label="Municipio"><?= $direccion->municipio_nombre ?></td>
                                        <td data-label="Dirección"><?= $direccion->direccion_direccion ?></td>
                                        <td data-label="Acciones">
                                            <div class="d-flex justify-content-center gap-2">

                                                <button
                                                    data-id="<?= $id ?>"
                                                    data-departamento="<?= $direccion->direccion_departamento ?>"
                                                    data-municipio="<?= $direccion->direccion_ciudad ?>"
                                                    data-direccion="<?= $direccion->direccion_direccion ?>"
                                                    data-observacion="<?= $direccion->direccion_observacion ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#direcciones-modal"

                                                    class=" btn btn-warning btn-sm"
                                                    title="Editar dirección"><i class="fa-solid fa-pen-to-square"></i></button>

                                                <button
                                                    data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"
                                                    class=" btn btn-danger btn-sm"
                                                    title="Eliminar dirección"><i class="fa-solid fa-trash"></i></button>
                                            </div>


                                        </td>
                                    </tr>
                                    <div class="modal fade text-left" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="">¿Esta seguro de eliminar este registro?</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a class="btn btn-danger" href="/page/home/eliminardireccion?id=<?= $id ?>">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>

                    <div class="alert alert-info text-center">
                        No hay direcciones registradas. <span data-bs-toggle="modal" data-bs-target="#direcciones-modal" class="text-primary " role="button">Agregar dirección</span>
                    </div>
                <?php } ?>



                <!-- Modal -->
                <div class="modal fade modal-transparente" id="direcciones-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de dirección -->
                                <form action="/page/home/addaddres" id="update-addres" class="form-contact" enctype="multipart/form-data" method="post">
                                    <!-- Campo oculto para el ID de la dirección -->
                                    <input type="hidden" name="id" id="direccion-id">
                                    <input type="hidden" name="user_id" value="<?= $this->usuario->user_id ?>">

                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-4 mb-4">
                                            <label>
                                                <select name="departamento" id="departamento" class="input">
                                                    <option value="" selected disabled>Seleccione un departamento</option>
                                                    <?php foreach ($this->departamentos as $departamento) { ?>
                                                        <option value="<?= $departamento->id_departamento ?>"><?= $departamento->departamento ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span>Departamento</span>
                                            </label>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-4 mb-4">
                                            <label>
                                                <select name="municipio" id="municipio" class="input">
                                                    <option value="" selected disabled>Seleccione un municipio</option>
                                                </select>
                                                <span>Municipio</span>
                                            </label>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-4 form-group mb-4">
                                            <label>
                                                <input id="direccion" class="input" type="text" name="direccion" required>
                                                <span>Dirección</span>
                                            </label>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label>
                                                <textarea name="observacion" id="observacion" class="input"></textarea>
                                                <span>Observación</span>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn-blue px-4 py-2 border-white" id="addres-create">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <div class="tab-pane fade" id="v-pills-pedido" role="tabpanel" aria-labelledby="v-pills-pedido-tab" tabindex="0">
                <?php if (is_countable($this->pedidos) && count($this->pedidos) >= 1) { ?>


                    <section class="contendor-comprar">


                        <table class="table-info  tabla-pedidos-perfil table-cart shadow">
                            <thead>
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->pedidos as $pedido) { ?>
                                    <tr>
                                        <td data-label="Pedido #" class="identificador"><?= $pedido->pedido_id ?></td>
                                        <td data-label="Fecha"><?= $pedido->pedido_fecha ?></td>
                                        <td data-label="Total"><?= $pedido->pedido_total >= 1 ? "$ " . number_format(ceil($pedido->pedido_total)) : $pedido->pedido_total ?></td>
                                        <td data-label="Estado"><?= $this->pedidoestado[$pedido->pedido_estado] ?></td>
                                        <td data-label="Acciones">
                                            <button class="btn-blue border-0 p-2" data-bs-toggle="modal" data-bs-target="#modalPedido<?= $pedido->pedido_id ?>"><i class="fa-solid fa-eye"></i></button>
                                            <!-- Modal -->
                                            <div class="modal fade modal-transparente" id="modalPedido<?= $pedido->pedido_id ?>" tabindex="-1" aria-labelledby="modalPedido<?= $pedido->pedido_id ?>Label" aria-hidden="true">
                                                <div class="modal-dialog modal-xl ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title text-white fs-3" id="exampleModalLabel">Pedido #<?= $pedido->pedido_id ?> </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-white p-4">
                                                            <div class="row mb-4">
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_documento" class="control-label">Documento</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_documento; ?>" name="pedido_documento" id="pedido_documento" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>

                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_fecha" class="control-label">Fecha</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_fecha; ?>" name="pedido_fecha" id="pedido_fecha" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_total" class="control-label">Total</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_total >= 1 ? "$ " . number_format(ceil($pedido->pedido_total)) : $pedido->pedido_total; ?>" name="pedido_total" id="pedido_total" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_subtotal" class="control-label">Subtotal</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_subtotal >= 1 ? "$ " . number_format(ceil($pedido->pedido_subtotal)) : $pedido->pedido_subtotal ?>" name="pedido_subtotal" id="pedido_subtotal" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_procentaje_descuento" class="control-label">Procentaje Descuento</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_procentaje_descuento . " %"; ?>" name="pedido_procentaje_descuento" id="pedido_procentaje_descuento" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_descuento" class="control-label">Descuento</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_descuento >= 1 ? "$ " . number_format(ceil($pedido->pedido_descuento)) : $pedido->pedido_descuento; ?>" name="pedido_descuento" id="pedido_descuento" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_porcentaje_iva" class="control-label">Porcentaje iva</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_porcentaje_iva . " %"; ?>" name="pedido_porcentaje_iva" id="pedido_porcentaje_iva" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_iva" class="control-label">Iva</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_iva >= 1 ? "$ " . number_format(ceil($pedido->pedido_iva)) : $pedido->pedido_iva; ?>" name="pedido_iva" id="pedido_iva" class="form-control" readonly disabled>
                                                                        <div class="help-block with-errors"></div>
                                                                </div>

                                                            </div>

                                                            <div class="row mb-4">
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_nombre" class="control-label">Nombre</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_nombre; ?>" name="pedido_nombre" id="pedido_nombre" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_correo" class="control-label">Correo</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_correo; ?>" name="pedido_correo" id="pedido_correo" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>

                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_telefono" class="control-label">Teléfono</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_telefono; ?>" name="pedido_telefono" id="pedido_telefono" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>



                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_departamento" class="control-label">Departamento</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $this->list_direccion_departamento[$pedido->pedido_departamento]; ?>" name="pedido_departamento" id="pedido_departamento" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_ciudad" class="control-label">Ciudad</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $this->list_direccion_ciudad[$pedido->pedido_ciudad] ?>" name="pedido_ciudad" id="pedido_ciudad" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_direccion" class="control-label">Dirección</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_direccion; ?>" name="pedido_direccion" id="pedido_direccion" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-12 form-group">
                                                                    <label for="pedido_direccion_observacion" class="control-label">Dirección Observación</label>
                                                                    <label class="input-group">

                                                                        <!-- <input type="text" value="<?= $pedido->pedido_direccion_observacion; ?>" name="pedido_direccion_observacion" id="pedido_direccion_observacion" class="form-control" readonly disabled> -->
                                                                        <textarea name="pedido_direccion_observacion" id="pedido_direccion_observacion" class="form-control" readonly disabled><?= $pedido->pedido_direccion_observacion; ?></textarea>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_estado" class="control-label">Estado</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $this->list_pedido_estado[$pedido->pedido_estado]; ?>" name="pedido_estado" id="pedido_estado" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_identificador" class="control-label">Identificador Wompi</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_identificador; ?>" name="pedido_identificador" id="pedido_identificador" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_validacion" class="control-label">Validación</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_validacion; ?>" name="pedido_validacion" id="pedido_validacion" class="form-control input-<?= $pedido->pedido_validacion ?>" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_validacion2" class="control-label">Alerta por correo enviada</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_validacion2 == 1 ? 'Si' : 'No'; ?>" name="pedido_validacion2" id="pedido_validacion2" class="form-control input-<?= $pedido->pedido_validacion2 == 1 ? 'APPROVED' : 'ERROR' ?>" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <div class="col-12 col-md-3 form-group">
                                                                    <label for="pedido_entidad" class="control-label">Entidad</label>
                                                                    <label class="input-group">

                                                                        <input type="text" value="<?= $pedido->pedido_entidad; ?>" name="pedido_entidad" id="pedido_entidad" class="form-control" readonly disabled>
                                                                    </label>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                <?php if ($this->content->pedido_respuesta) { ?>

                                                                    <div class="col-12 col-md-12 form-group">
                                                                        <label for="pedido_respuesta" class="control-label">Respuesta</label>
                                                                        <label class="input-group">

                                                                            <input type="text" value="<?= $pedido->pedido_respuesta; ?>" name="pedido_respuesta" id="pedido_respuesta" class="form-control" readonly disabled>
                                                                        </label>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                <?php } ?>



                                                            </div>

                                                            <table class="table-cart tabla-pedidos-perfil  table-cart">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="70%">Producto</th>
                                                                        <th width="10%">Precio</th>
                                                                        <th width="10%">Cantidad</th>
                                                                        <th width="10%">Total</th>
                                                                    </tr>
                                                                </thead>


                                                                <tbody>
                                                                    <?php
                                                                    foreach ($pedido->productos as $producto) {
                                                                    ?>
                                                                        <tr>
                                                                            <td data-label="Producto">
                                                                                <div class="producto d-flex gap-2 align-items-center">


                                                                                    <?php if ($producto->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->producto_imagen)) { ?>
                                                                                        <img src="/images/<?php echo $producto->producto_imagen; ?>" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">
                                                                                    <?php } else { ?>
                                                                                        <img src="/assets/imagenot.jpg" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">


                                                                                    <?php } ?>
                                                                                    <div class="producto-info">
                                                                                        <h5><?php echo $producto->pedido_producto_nombre; ?></h5>
                                                                                        <h6>Categoría: <span><?php echo $producto->producto_categoriainfo; ?></span></h6>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td data-label="Precio">
                                                                                <span class="precio">
                                                                                    $<?php echo number_format(ceil($producto->pedido_producto_precio_final)); ?>
                                                                                </span>
                                                                            </td>
                                                                            <td data-label="Cantidad">
                                                                                <span class="cantidad">
                                                                                    <?php echo $producto->pedido_producto_cantidad; ?>
                                                                                </span>
                                                                            </td>
                                                                            <td data-label="Total">
                                                                                <span class="total" id="total-producto">
                                                                                    $<?php echo number_format(ceil($producto->pedido_producto_precio_final)); ?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                <?php } else { ?>

                    <div class="alert alert-info text-center">
                        No hay pedidos registrados.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>



<style>
    .main-general {
        background-color: #f5f5f5;
        z-index: initial;
        /* min-height: auto; */
    }

    .btn-blue:disabled {
        background-color: #ccc !important;
    }

    .container-profile .form-contact label .input:disabled+span {
        top: 0;
    }

    .container-profile .form-contact label input.input,
    .container-profile .form-contact label select.input {
        height: 42px;
    }
    .container-profile .form-contact input:disabled{
        background-color: #d1d1d1;
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
<script>
    // Obtenemos los elementos select del DOM
    const selectDepartamento = document.getElementById('departamento');
    const selectMunicipio = document.getElementById('municipio');

    // Obtenemos los municipios desde PHP y los pasamos a JavaScript
    const municipios = [
        <?php foreach ($this->municipios as $municipio) { ?> {
                id: '<?= $municipio->id_municipio ?>',
                nombre: '<?= $municipio->municipio ?>',
                departamentoId: '<?= $municipio->departamento_id ?>'
            },
        <?php } ?>
    ];

    function actualizarMunicipios(departamentoId, municipioId = '') {
        // Limpiamos las opciones actuales del select de municipios
        selectMunicipio.innerHTML = '<option value="" selected disabled>Seleccione un municipio</option>';

        // Filtramos los municipios que pertenecen al departamento seleccionado
        const municipiosFiltrados = municipios.filter(
            municipio => municipio.departamentoId === departamentoId
        );

        // Agregamos las opciones filtradas al select de municipios
        municipiosFiltrados.forEach(municipio => {
            const option = document.createElement('option');
            option.value = municipio.id;
            option.textContent = municipio.nombre;

            // Si el municipio coincide con el seleccionado, lo seleccionamos
            if (municipio.id === municipioId) {
                option.selected = true;
            }

            selectMunicipio.appendChild(option);
        });
    }

    // Evento para actualizar los municipios al cambiar el departamento
    selectDepartamento.addEventListener('change', function() {
        const departamentoId = this.value;
        actualizarMunicipios(departamentoId);
    });
    // Función para llenar el formulario al editar
    function llenarFormulario(id, departamentoId, municipioId, direccion, observacion) {
        // Llenamos los campos del formulario
        document.getElementById('direccion-id').value = id;
        selectDepartamento.value = departamentoId;

        // Actualizamos los municipios y seleccionamos el correspondiente
        actualizarMunicipios(departamentoId, municipioId);

        document.getElementById('direccion').value = direccion;
        document.getElementById('observacion').value = observacion;
    }

    // Listener para los botones de editar
    document.querySelectorAll('.btn-warning').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const departamentoId = button.getAttribute('data-departamento');
            const municipioId = button.getAttribute('data-municipio');
            const direccion = button.getAttribute('data-direccion');
            const observacion = button.getAttribute('data-observacion');

            // Llenamos el formulario con los datos obtenidos
            llenarFormulario(id, departamentoId, municipioId, direccion, observacion);

            // Cambiamos el texto del botón y la acción del formulario
            const form = document.getElementById('update-addres');
            const submitButton = document.getElementById('addres-create');
            submitButton.textContent = 'Actualizar';
            form.setAttribute('action', `/page/home/editaddres?id=${id}`);
        });
    });
</script>



<!-- < script>
        document.addEventListener('DOMContentLoaded', () => {
            // Seleccionamos todos los botones de editar
            const editButtons = document.querySelectorAll('.btn-warning');
            const form = document.getElementById('update-addres');
            const submitButton = document.getElementById('addres-create');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Obtenemos los datos del botón
                    const id = button.getAttribute('data-id');
                    const departamento = button.getAttribute('data-departamento');
                    const municipio = button.getAttribute('data-municipio');
                    const direccion = button.getAttribute('data-direccion');
                    const observacion = button.getAttribute('data-observacion');

                    // Llenamos el formulario con los datos
                    document.getElementById('direccion-id').value = id;
                    document.getElementById('departamento').value = departamento;
                    document.getElementById('municipio').value = municipio;
                    document.getElementById('direccion').value = direccion;
                    document.getElementById('observacion').value = observacion;

                    // Cambiamos el texto del botón
                    submitButton.textContent = 'Actualizar';

                    // Cambiamos la acción del formulario
                    form.setAttribute('action', `/page/home/editaddres?id=${id}`);
                });
            });
        });
</script> -->