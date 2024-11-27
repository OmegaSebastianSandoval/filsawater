<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top:20px; padding-bottom:20px;">
    <div style="width: 100%;max-width:630px; margin: auto; padding: 20px; background-color: #5475a1; border-radius: 10px; color: #f4f5f5;">
        <div style="text-align: center; padding: 20px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">
            <h1>Hola <?php echo $this->pedido->pedido_nombre ?>
            </h1>
        </div>
        <p style="font-size: 16px;">
            Estimado cliente,
            <br><br>
            Nos complace informarle que su pedido, identificado con el número <strong>#<?php echo $this->pedido->pedido_id; ?></strong>,
            <br>
            <br>
            ha sido entregado exitosamente en la dirección indicada.
            <br><br>
            Esperamos que su experiencia haya sido satisfactoria y que disfrute de su compra.
            <br>
            <!-- si solicitan -->
            <?php if (!empty($this->pedido->detalles_entrega)) : ?>
                Detalles de la entrega: <?php echo $this->pedido->detalles_entrega; ?>
            <?php endif; ?>
            <br>
            <br>
            Si tiene algún comentario, necesita asistencia adicional o desea dejarnos una reseña, no dude en contactarnos.
            <br><br>
            Gracias por elegirnos. ¡Esperamos volver a servirle pronto!
        </p>




        <div style="text-align: center; padding: 20px;  border-radius: 10px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">

        </div>
    </div>
</div>