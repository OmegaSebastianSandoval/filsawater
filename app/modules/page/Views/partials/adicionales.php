<?php
function formatearFechaEsp($fecha)
{
    // Crear un objeto DateTime a partir de la fecha proporcionada
    $date = new DateTime($fecha);

    // Array de meses en español
    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];

    // Formatear la fecha al formato 'F d, Y'
    $fechaFormateada = $date->format('F d, Y');

    // Reemplazar el mes en inglés por el mes en español
    $mesEnIngles = $date->format('F');
    $mesEnEspanol = $meses[$mesEnIngles];

    // Devolver la fecha con el mes en español
    return str_replace($mesEnIngles, $mesEnEspanol, $fechaFormateada);
}


?>

<!-- Modal PopUp -->
<?php if ($this->popup->publicidad_estado == 1) { ?>
    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style=" border: none;
    background-color: transparent;">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                <div class="modal-body">
                    <?php if ($this->popup->publicidad_video != "") { ?>
                        <div class="fondo-video-youtube">
                            <div class="banner-video-youtube" id="videobanner<?php echo $this->popup->publicidad_id; ?> " data-video="<?php echo $this->id_youtube($this->popup->publicidad_video); ?>"></div>
                        </div>
                    <?php } ?>
                    <?php if ($this->popup->publicidad_imagen != "") { ?>
                        <?php if ($this->popup->publicidad_enlace != "") { ?> <a href="<?php echo $this->popup->publicidad_enlace ?>" <?php if ($this->popup->publicidad_enlace == 1) {
                                                                                                                                            echo "target='_blank'";
                                                                                                                                        } ?>> <?php } ?><img class="w-100 img-fluid d-none d-md-block" src="/images/<?php echo $this->popup->publicidad_imagen ?>" alt="Imagen PopUp <?= $this->popup->publicidad_nombre ?>">
                            <img class="w-100 img-fluid d-block d-md-none" src="/images/<?php echo $this->popup->publicidad_imagenresponsive     ?>" alt="Imagen PopUp <?= $this->popup->publicidad_nombre ?>">
                            <?php if ($this->popup->publicidad_enlace != "") { ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal -->
<div class="modal fade modalPoliticas" id="modalPoliticas" tabindex="-1" aria-labelledby="modalPoliticasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none;background-color: transparent;">
            <div class="modal-header px-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body bg-white pb-1">
                <h1 class="modal-title fs-5" id="modalPoliticasLabel"><?php echo $this->infopage->info_pagina_titulo_legal ?></h1>
                <?php echo $this->infopage->info_pagina_descripcion_legal ?>
            </div>
            <div class="modal-footer bg-white border-0 pt-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary d-none">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="loader-bx">
    <span class="loader"></span>
</div>
<style>
    .loader-bx {
        display: none;
        position: fixed;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, .5);
        z-index: 99999;
        top: 0;
        left: 0;
        justify-content: center;
        align-items: center;
    }

    .loader-bx.show {
        display: flex;
    }

    .loader {
        width: 48px;
        height: 48px;
        display: block;
        margin: 15px auto;
        position: relative;
        color: #FFF;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        width: 24px;
        height: 24px;
        top: 50%;
        left: 50%;
        transform: scale(0.5) translate(0, 0);
        background-color: #FFF;
        border-radius: 50%;
        animation: animloader 1s infinite ease-in-out;
    }

    .loader::before {
        background-color: var(--azul);
        transform: scale(0.5) translate(-48px, -48px);
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes animloader {
        50% {
            transform: scale(1) translate(-50%, -50%);
        }
    }
</style>