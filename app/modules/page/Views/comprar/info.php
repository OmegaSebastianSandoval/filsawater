<section class="resume shadow">
    <h3>Resumen</h3>
    <div class="resume-content">
        <div class="resume-item d-flex justify-content-between">
            <span>Subtotal</span>
            <span id="subtotal">$ <?= number_format($this->subtotalSinIva, 2) ?></span>
        </div>
        <div class="resume-item d-flex justify-content-between">
            <span>Descuento</span>
            <span id="descuento">$<?= number_format($this->totalDescuento, 2) ?></span>
        </div>
        <div class="resume-item d-flex justify-content-between">
            <span>IVA</span>
            <span id="iva">$ <?= number_format($this->totalIva, 2) ?></span>
        </div>
       
        <div class="resume-item d-flex justify-content-between">
            <span class="total-spam">Total</span>
            <span id="total">$<?= number_format($this->totalConIvaYDescuento, 2) ?></span>
        </div>
    </div>
    <a href="/page/continuar" class="btn btn-blue w-100 mt-3">Continuar con la compra</a>
</section>