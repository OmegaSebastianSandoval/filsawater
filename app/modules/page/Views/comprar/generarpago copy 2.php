<!-- <form action="https://checkout.wompi.co/p/" method="GET">
 
    <input type="hidden" name="public-key" value="<?= $this->publicKey ?>" />
    <input type="hidden" name="currency" value="<?= $this->moneda ?>" />
    <input type="hidden" name="amount-in-cents" value="<?= intval($this->pedido->pedido_total) ?>" />
    <input type="hidden" name="reference" value="<?= $this->pedido->pedido_id ?>" />
    <input type="hidden" name="signature:integrity" value="<?= $this->cadenaHash ?>" />
   



    <input type="hidden" name="redirect-url" value="<?= $this->redirectUrl ?>" />
    <input type="hidden" name="expiration-time" value="<?= $this->fechaExpiracion ?>" />
    <input type="hidden" name="tax-in-cents:vat" value="<?= intval($this->pedido->pedido_iva) * 100 ?>" />
  
    <input type="hidden" name="customer-data:email" value="<?= $this->pedido->pedido_correo ?>" />
    <input
        type="hidden"
        name="customer-data:full-name"
        value="<?= $this->pedido->pedido_nombre ?>" />
    <input
        type="hidden"
        name="customer-data:phone-number"
        value="<?= $this->pedido->pedido_telefono ?>" />
    <input
        type="hidden"
        name="customer-data:legal-id"
        value="<?= $this->pedido->pedido_documento ?>" />
    <input
        type="hidden"
        name="customer-data:legal-id-type"
        value="<?= $this->pedido->pedido_tipo_documento ?>" />
    <input
        type="hidden"
        name="shipping-address:address-line-1"
        value="<?= $this->pedido->departamento_nombre . ", " . $this->pedido->ciudad_nombre . ", " . $this->pedido->pedido_direccion ?>" />
    <input type="hidden" name="shipping-address:country" value="<?= $this->pedido->pedido_pais ?>" />
    <input
        type="hidden"
        name="shipping-address:phone-number"
        value="<?= $this->pedido->pedido_telefono ?>" />
    <input type="hidden" name="shipping-address:city" value="<?= $this->pedido->ciudad_nombre ?>" />
    <input type="hidden" name="shipping-address:region" value="<?= $this->pedido->departamento_nombre ?>" />
    <button type="submit">Pagar con Wompi</button>
</form> -->
<br>
<br>
total: <?= intval($this->pedido->pedido_total*100) ?>
<form>
  <script
    src="https://checkout.wompi.co/widget.js"
    data-render="button"
    data-public-key="pub_test_IgJV5KZuyaM9JRr037F84I12pgvKJ1T9"
    data-currency="COP"
     data-expiration-time="<?= $this->fechaExpiracion ?>"
    data-amount-in-cents="<?= intval($this->pedido->pedido_total*100) ?>"
    data-reference="<?= $this->pedido->pedido_id ?>"
    data-signature:integrity="<?= $this->cadenaHash ?>"
  ></script>
</form>