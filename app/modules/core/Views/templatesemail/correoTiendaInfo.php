<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top:20px; padding-bottom:20px;">
    <div style="width: 100%;max-width:500px; margin: auto; padding: 20px; background-color: #5475a1; border-radius: 10px; color: #f4f5f5;">
        <div style="text-align: center; padding: 20px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">
            <h1>Hola <?php echo $this->pedido->pedido_nombre ?>
            </h1>
        </div>
        <p>
            Estimado cliente,
            <br><br>
            Lamentamos informarle que su pedido, identificado con el número <strong>#<?php echo $this->pedido->pedido_id; ?></strong>,
            <br>
            <br>

            ha cambiado a un nuevo estado: <strong><?php echo $this->pedido->pedido_validacion_texto; ?></strong>.
            <br>
            <?php if (!empty($this->pedido->pedido_respuesta)) : ?>
                Detalles adicionales: <?php echo $this->pedido->pedido_respuesta; ?>
            <?php endif; ?>
            <br>
            <br>
            Si tiene alguna consulta o requiere asistencia, no dude en contactarnos.
        </p>


        <div style="text-align: center; padding: 20px;  border-radius: 10px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">

        </div>
    </div>
</div>