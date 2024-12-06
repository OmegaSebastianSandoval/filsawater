<?php if (is_countable($this->carrito) && count($this->carrito) >= 1) { ?>

    <section class="resume shadow">
        <h3>Resumen</h3>
        <div class="resume-content">
            <div class="resume-item d-flex justify-content-between">
                <span>Precio original</span>
                <span id="subtotal">$<?= number_format(ceil($this->totalSinIva)) ?></span>
            </div>

            <?php if ($this->usuario && $this->totalDescuento && $this->totalDescuento >= 1) { ?>
                <div class="resume-item d-flex justify-content-between">
                    <span>Descuento</span>
                    <span id="descuento">-$<?= number_format(ceil($this->totalDescuento)) ?></span>
                </div>
            <?php } ?>

            <div class="resume-item d-flex justify-content-between">
                <span>IVA</span>
                <span id="iva">$<?= number_format(ceil($this->totalIva)) ?></span>
            </div>
            <div class="resume-item d-flex justify-content-between">
                <span>Subtotal</span>
                <span id="subtotal">$<?= number_format(ceil($this->subtotalSinIva)) ?></span>
            </div>

            <hr>

            <div class="resume-item d-flex justify-content-between">
                <span class="total-spam">Total</span>
                <span id="total">$<?= number_format(ceil($this->totalConIvaYDescuento)) ?></span>
            </div>
        </div>
        <form action="/page/comprar/continuar" id="comprar-continuar" class="desactivar-submit" method="POST">
            <input type="hidden" name="subtotal" value="<?= $this->subtotalSinIva ?>">
            <input type="hidden" name="descuento" value="<?= $this->totalDescuento ?>">
            <input type="hidden" name="iva" value="<?= $this->totalIva ?>">
            <input type="hidden" name="total" value="<?= $this->totalConIvaYDescuento ?>">
            <div class="d-flex flex-column flex-xl-row align-items-center justify-content-between gap-2">
                <a href="/page/productos" class="btn btn-blue btn-outline w-100 mt-3">Continuar comprando</a>

                <button type="submit" class="btn btn-blue w-100 mt-3">Ir a pagar</button>
            </div>

        </form>
    </section>
<?php } ?>