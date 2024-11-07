<form class="dropzone" id="cargarFotos">
</form>

<div class="container">

    <?php if ($this->foto_solucion) { ?>
        <div class="row mb-2 justify-content-end">
            <div class="col-3">
                <a href="/administracion/soluciones/?padre=<?= $this->solucion->solucion_padre ?>" class="btn btn-outline-success d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-arrow-left"></i> Volver</a>
            </div>
        </div>
    <?php } ?>

    
    <?php if ($this->foto_producto) { ?>
        <div class="row mb-2 justify-content-end">
            <div class="col-3">
                <a href="/administracion/productos" class="btn btn-outline-success d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-arrow-left"></i> Volver</a>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    Dropzone.autoDiscover = false;


    var myDropzone = new Dropzone("#cargarFotos", {
        paramName: "fotos-file", // The name that will be used to transfer the file
        maxFilesize: 8, // MB,
        dictDefaultMessage: '<i class="fas fa-folder-plus"></i><h3>Seleccione o arrastre las imágenes a subir',
        dictInvalidFileType: 'Formato no compatible',
        acceptedFiles: '.png, .jpg, .jpeg, gif, webp',
        dictMaxFilesExceeded: 'Solo puede ser cargado un archivo',
        autoProcessQueue: false,
        url: "/administracion/fotos/uploadfotos",
        autoProcessQueue: true,
        parallelUploads: 1,
        params: {
            <?php if ($this->foto_solucion) { ?>
                foto_solucion: <?= $this->foto_solucion ?>
            <?php } ?>

            <?php if ($this->foto_producto) { ?>
                foto_producto: <?= $this->foto_producto ?>
            <?php } ?>
        },


    })
</script>

<style>
    :root {
        --negro: #0000;
        --blanco: #FFFFFF;
        --naranja: #ff9f00;

        --azul: #5475a1;
        --azulclaro: #0d97be;
        --azulclaro2: #00b8c3;

        --gris-claro: #f7f7f7;
        --gris-oscuro: #333333;
        --gris-medio: #595959;
    }



    .dropzone {
        height: 250px;
        background: var(--azul);
        border: 1px solid var(--azul);
        cursor: pointer;
        position: relative;
        padding: 20px;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        width: 98%;
        margin: 0 auto;
        border: 1px solid #FFF;
        margin-top: 30px;
        margin-bottom: 30px;
        transition: all 300ms ease-in-out;
        overflow-x: scroll;
    }

    .dropzone:hover {
        background-color: var(--azulclaro2);
        transition: 300ms;
    }

    .dropzone::before {
        content: '';
        height: 110%;
        position: absolute;
        z-index: -1;
        background-color: var(--azul);
        display: block;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .dropzone .dz-button {
        border: none;
        background: transparent;
        color: #FFF !important;
        font-family: 'Avenir Book';
        font-size: 18px;
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .dz-preview {
        background-color: transparent !important;
        padding: 5px;
        border: 1px solid #FFF;
    }

    .dropzone .dz-button i {
        font-size: 50px;
    }

    .dropzone .dz-button:focus {
        outline: none;
    }

    .dz-remove {
        color: #FFF;
    }

    .dz-remove span {
        color: #FFF;
        text-decoration: none;
        cursor: pointer;
    }

    .dz-remove:hover {
        color: #FFF;
        text-decoration: none;
        cursor: pointer;
    }

    .files-cotizador label {
        color: var(--azul);
        font-size: 18px;
        font-family: 'Avenir Book';
        font-weight: 300;
        padding: 0 15px;
        border: 1px solid var(--azul);
        cursor: pointer;
    }

    .files-cotizador label.active {
        color: #FFF;
        background-color: var(--azul);
    }

    .files-cotizador .title {
        color: var(--azul);
    }

    .files-cotizador .text {
        color: var(--azulclaro2);
        font-size: 18px;
    }

    .files-cotizador .terminos,
    .files-cotizador .terminos a {
        color: var(--azul);
        font-size: 18px;
        font-family: 'Avenir Book';
        font-weight: 300;
        text-align: center;
    }

    .files-cotizador .terminos a {
        font-family: 'Avenir Roman';
        font-weight: 600;
    }

    .dropzone .dz-preview .dz-error-message {
        top: 100%;
    }
</style>