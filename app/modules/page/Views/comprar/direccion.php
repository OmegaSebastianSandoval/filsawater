<section class="direccion-compra">
    <div class="container pt-1 pt-md-3 pb-5">
        <a class="btn-blue btn-outline gap-2  my-3" href="/page/comprar/?id=<?= $this->pedido->pedido_id ?>"> <i class="fa-regular fa-circle-left"></i> Volver</a>

        <!-- <h2>Dirección de envío</h2> -->
        <div class="line_box">
            <div class="text_circle done">
                <div class="circle">
                    <h4>Carrito</h4>

                </div>
                <span class="tvar shadow"><i class="fa-solid fa-check"></i></i></span>
            </div>
            <div class="text_circle done-partial">
                <div class="circle">
                    <h4>Envío</h4>

                </div>
                <span class="tvar shadow"><i class="fa-solid fa-truck"></i></span>
            </div>
            <div class="text_circle">
                <div class="circle">
                    <h4>Pago</h4>

                </div>
                <span class="tvar shadow"><i class="fa-solid fa-credit-card"></i></span>
            </div>
            <div class="text_circle">
                <div class="circle">
                    <h4>Finalización</h4>

                </div>
                <span class="tvar shadow"><i class="fa-solid fa-check"></i></span>
            </div>
        </div>

        <div class="row mt-3">
            <?php if ($this->error_compra) { ?>

                <div class="alert alert-warning w-100 text-center mt-4" role="alert">
                    <strong>¡Atención!</strong> <?= $this->error_compra ?>
                </div>
            <?php } ?>


            <div class="col-12 col-md-12 col-lg-8 container-profile">
                <form action="/page/comprar/continuar2" id="form-direccion" method="post" class="mt-3 form-contact desactivar-submit">
                    <input type="hidden" name="pedido-id" value="<?= $this->idPedido ?>">
                    <?php if (is_countable($this->direcciones) && count($this->direcciones) >= 1) { ?>
                        <span class="seleccion-direccion">Seleccione una dirección:</span>

                        <div class="radio-input">
                            <?php foreach ($this->direcciones as $direccion) { ?>

                                <label class="label">
                                    <input
                                        type="radio"
                                        id="value-<?= $direccion->direccion_id; ?>"
                                        class="radio"
                                        required
                                        name="direccion-radio"
                                        value="<?= $direccion->direccion_id; ?>" />

                                    <p class="text"> <?php echo $direccion->direccion_ciudad_nombre; ?>, <?php echo $direccion->direccion_departamento_nombre; ?> - <?php echo $direccion->direccion_direccion; ?></p>

                                </label>




                            <?php } ?>

                            <label class="label">
                                <input
                                    type="radio"
                                    id="value-otra"
                                    class="radio"
                                    required

                                    name="direccion-radio"
                                    value="otra" />

                                <p class="text"> Agregar nueva dirección</p>

                            </label>

                        </div>

                    <?php } else {
                        $mostrarFormulario = true;
                    } ?>

                    <div id="content-direccion" style="display:none">


                        <div id="content-form-direccion">



                            <div class="contenedor-nueva-direccion">
                                <div class="row">
                                    <div class="col-12">
                                        <?php if ($this->usuario) { ?>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch" name="guardar-direccion" id="check-agregar-direccion">
                                                <label class="form-check-label" for="check-agregar-direccion">Guardar dirección</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if (!$this->usuario) { ?>
                                        <div class="col-12 col-md-12 col-lg-6 form-group mb-4">
                                            <label>
                                                <input id="nombre" class="input requerido" type="text" name="nombre" required>
                                                <span>Nombre</span>
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-2 form-group mb-4">
                                            <label>
                                                <select name="tipo_documento" id="tipo_documento" class="input requerido" required>
                                                    <option value="" selected disabled></option>
                                                    <option value="NIT">NIT</option>
                                                    <option value="CC">CC</option>
                                                    <option value="CE">CE</option>
                                                    <option value="PP">Pasaporte</option>
                                                    <option value="TI">Tarjeta de identidad</option>
                                                    <option value="DNI">Documento Nacional de Identidad</option>
                                                    <option value="RG">arteira de Identidade / Registro Geral</option>
                                                    <option value="OTHER">Otro</option>

                                                </select>
                                                <span>Tipo</span>
                                            </label>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-4 form-group mb-4">
                                            <label>
                                                <input id="documento" class="input requerido" type="text" name="documento" required>
                                                <span>Documento</span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-8 form-group mb-4">
                                            <label>
                                                <input id="correo" class="input requerido" type="text" name="correo" required>
                                                <span>Correo</span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 form-group mb-4">
                                            <label>
                                                <input id="telefono" class="input requerido" type="text" name="telefono"
                                                    onkeypress="return soloNumeros(event)"
                                                    maxlength="10" minlength="10" pattern="^\d+$" required>
                                                <span>Teléfono</span>
                                            </label>
                                        </div>

                                    <?php } ?>



                                    <div class="col-12 col-md-12 col-lg-4 mb-4">
                                        <label>
                                            <select name="departamento" id="departamento" class="input requerido">
                                                <option value="" selected disabled></option>
                                                <?php foreach ($this->departamentos as $departamento) { ?>
                                                    <option value="<?= $departamento->id_departamento ?>"><?= $departamento->departamento ?></option>
                                                <?php } ?>
                                            </select>
                                            <span>Departamento</span>
                                        </label>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-4 mb-4">
                                        <label>
                                            <select name="municipio" id="municipio" class="input requerido">
                                                <option value="" selected disabled></option>
                                            </select>
                                            <span>Municipio</span>
                                        </label>
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-4 form-group mb-4">
                                        <label>
                                            <input id="direccion" class="input requerido" type="text" name="direccion">
                                            <span>Dirección</span>
                                        </label>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <label>
                                            <textarea name="observacion" id="observacion" class="input"></textarea>
                                            <span>Observación</span>
                                        </label>
                                    </div>


                                </div>

                            </div>

                </form>
            </div>
        </div>

    </div>
    <div class="col-12 col-md-12 col-lg-4">

        <div id="contenido_info2">

        </div>
    </div>


</section>
<?php if ($mostrarFormulario) { ?>
    <script>
        document.getElementById('content-direccion').style.display = 'block';
        $('.requerido').attr('required', true);
    </script>
<?php } ?>
<style>
    .main-general {
        background-color: #f5f5f5;
        min-height: auto;
    }

    .container-profile .form-contact {
        background-color: transparent;
        padding: 0;
    }

    .contenedor-nueva-direccion {
        background-color: var(--azul);
        padding: 20px;
        margin-top: 15px;
    }

    .content-carrito,
    .ocultar-carrito {
        display: none !important;
    }

    .container-profile .form-contact label .input {

        padding: 17px 05px 05px 10px;
    }

    .form-contact label .input {
        line-height: normal;
        font-size: 13px;
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

<script>
    document.addEventListener("DOMContentLoaded", () => {

        function traerinfo2() {
            fetch("/page/comprar/info2", {
                    method: "GET",
                    headers: {
                        "Content-Type": "text/html",
                    },
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Error en la solicitud");
                    }
                    return response.text(); // Procesa la respuesta como texto HTML
                })
                .then((html) => {
                    const contenedorInfo = document.getElementById("contenido_info2");
                    contenedorInfo.innerHTML = html; // Inserta el HTML en el contenedor


                })
                .catch((error) => {
                    console.error("Error al obtener el carrito:", error);
                });
        }

        traerinfo2();
    })
    const radios = document.querySelectorAll('.radio');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'otra') {
                document.getElementById('content-direccion').style.display = 'block';
                $('.requerido').attr('required', true);
            } else {
                document.getElementById('content-direccion').style.display = 'none';
                $('.requerido').attr('required', false);

            }
        });
    });





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
        selectMunicipio.innerHTML = '<option value="" selected disabled></option>';

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
</script>