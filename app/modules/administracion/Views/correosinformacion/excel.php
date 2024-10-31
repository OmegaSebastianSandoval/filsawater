<table border="1" cellpadding="2">
    <thead>
        <tr>
            <td>correo</td>
            <td>fecha</td>
            <td>Activo</td>

        </tr>
    </thead>
    <tbody></tbody>
    <?php foreach ($this->lists as $content) { ?>
        <?php $id =  $content->correo_informacion_id; ?>
        <tr>
            <td><?= $content->correos_informacion_correo; ?></td>
            <td><?= $content->correos_informacion_fecha; ?></td>
            <td><?= $content->correos_informacion_estado == 1 ? 'Si' : 'No'; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>