<?php foreach ($this->contenidos as $key => $rescontenido) : ?>
	<?php $contenedor = $rescontenido['detalle'];
	?>

	<?php if ($contenedor->contenido_tipo == 1) { ?>
		<?php include(APP_PATH . "modules/page/Views/template/bannersimple.php"); ?>
	<?php } else if ($contenedor->contenido_tipo == 2 || $contenedor->contenido_tipo == 3 || ($contenedor->contenido_tipo == 5 && $contenedor->contenido_seccion == 14)) { ?>
		<?php include(APP_PATH . "modules/page/Views/template/seccion.php"); ?>
	<?php } else if ($contenedor->contenido_tipo == 15) { ?>
		<?php include(APP_PATH . "modules/page/Views/template/documentos.php"); ?>
	<?php } else if ($contenedor->contenido_tipo == 22) { ?>
		<?php include(APP_PATH . "modules/page/Views/template/formulario.php"); ?>
	<?php } ?>
<?php endforeach ?>