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

            ha sido enviado exitosamente.
            <br>
            <!-- Por si piden la función de fecha y de envio -->
            <?php if (!empty($this->pedido->fecha_entrega_estimada)) : ?>
                Fecha estimada de entrega: <strong><?php echo $this->pedido->fecha_entrega_estimada; ?></strong>.
                <br>
            <?php endif; ?>
            <?php if (!empty($this->pedido->enlace_rastreo)) : ?>
                Puede rastrear su pedido haciendo clic en el siguiente enlace:
                <a href="<?php echo $this->pedido->enlace_rastreo; ?>" target="_blank">Rastrear pedido</a>.
            <?php endif; ?>
            <br>
            Si tiene alguna consulta o requiere asistencia, no dude en contactarnos.
            <br>
            Gracias por confiar en nosotros.
        </p>



        <div style="text-align: center; padding: 20px;  border-radius: 10px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">

        </div>
    </div>
</div>