<div class="container  py-5">

    <?php if (!$this->response) { ?>
        <div class="alert alert-danger my-4 text-center">
            Lo sentimos, ocurrió un error, contacte con el administrador
        </div>

    <?php } else { ?>
        <div class="container-respuesta shadow p-2 p-md-5">

            <h2 class=" text-center">
                Resumen de la compra
            </h2>
            <div class="row  mt-3">

                <div class="col-12 col-md-12  p-3 ">
                    <span class="info ">
                        Estado del pago:
                    </span>
                    <span class="response estado estado-<?= $this->response->status ?>">
                        <?= $this->getListStatus[$this->response->status] ?>

                    </span>
                </div>
                <div class="col-12 col-md-12  p-3 ">
                    <span class="info">
                        ID del pago:
                    </span>
                    <span class="response">
                        <?= $this->response->id ?>

                    </span>
                </div>
                <div class="col-12 col-md-12  p-3 ">
                    <span class="info">
                        Referencia del pedido:
                    </span>
                    <span class="response">
                        <?= $this->response->reference ?>

                    </span>
                </div>
                <div class="col-12 col-md-12  p-3 ">
                    <span class="info">
                        Método de pago:
                    </span>
                    <span class="response">
                        <?= $this->response->payment_method_type ?>

                    </span>
                </div>
                <div class="col-12 col-md-12  p-3 ">
                    <span class="info">
                        Moneda:
                    </span>
                    <span class="response">
                        <?= $this->response->currency ?>

                    </span>
                </div>
                <div class="col-12 col-md-12  p-3 ">
                    <span class="info">
                        Valor del pago:
                    </span>
                    <span class="response">
                        $<?= number_format(intval($this->response->amount_in_cents) / 100) ?>

                    </span>
                </div>

            </div>
            <div class="d-flex justify-content-center gap-3">

                <a href="/page/productos" class="btn-blue btn-outline py-2 mt-3">Volver a comprar</a>
                <?php if ($this->usuario) { ?>
                    <a href="/page/home#v-pills-pedido-tab" class="btn-blue  py-2 mt-3">Ver mis pedidos</a>
                <?php } ?>
            </div>
        </div>

    <?php } ?>
</div>

<style>
    .main-general {
        background-color: #f5f5f5;
        min-height: auto;
    }
</style>