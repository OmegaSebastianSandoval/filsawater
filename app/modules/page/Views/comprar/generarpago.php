<form action="https://checkout.wompi.co/p/" method="GET">

    <input type="hidden" name="public-key" value="<?= $this->publicKey ?>" />
    <input type="hidden" name="currency" value="<?= $this->moneda ?>" />
    <input type="hidden" name="amount-in-cents" value="<?= intval($this->pedido->pedido_total * 100) ?>" />
    <input type="hidden" name="reference" value="<?= $this->pedido->pedido_id ?>" />
    <input type="hidden" name="signature:integrity" value="<?= $this->cadenaHash ?>" />




    <input type="hidden" name="expiration-time" value="<?= $this->fechaExpiracion ?>" />
    <input type="hidden" name="tax-in-cents:vat" value="<?= intval($this->pedido->pedido_iva * 100)  ?>" />

    <input type="hidden" name="customer-data:email" value="<?= $this->pedido->pedido_correo ?>" />
    <input
        type="hidden"
        name="customer-data:full-name"
        value="<?= $this->pedido->pedido_nombre ?>" />
    <input
        type="hidden"
        name="customer-data:phone-number"
        value="<?= "+57".$this->pedido->pedido_telefono ?>" />
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
</form>

<!-- 

https://checkout.wompi.co/p/?public-key=pub_test_IgJV5KZuyaM9JRr037F84I12pgvKJ1T9&currency=COP&amount-in-cents=47600000&reference=13&signature%3Aintegrity=16ba46ace03e24b6941d40c1d97f2e2098234af0e9a597b27a23a71c51daeeb8&redirect-url=http%3A%2F%2F192.168.150.4%3A8043%2Fpage%2Fcomprar%2Frespuesta&expiration-time=2024-11-21T17%3A54%3A24-05%3A00&tax-in-cents%3Avat=7600000&customer-data%3Aemail=juansesdvsf%40gmail.com&customer-data%3Afull-name=Empresa+de+prueba+1&customer-data%3Aphone-number=3124624763&customer-data%3Alegal-id=900456689-6&customer-data%3Alegal-id-type=NIT&shipping-address%3Aaddress-line-1=BOGOT%C3%81%2C+D.C.%2C+Bogot%C3%A1+D.C.%2C+Calle+27+d+sur+%23+27+c+51&shipping-address%3Acountry=COL&shipping-address%3Aphone-number=3124624763&shipping-address%3Acity=Bogot%C3%A1+D.C.&shipping-address%3Aregion=BOGOT%C3%81%2C+D.C. -->
