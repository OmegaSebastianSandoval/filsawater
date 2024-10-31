<?php if ($contenido->contenido_enlace) { ?>
	<a href="<?php echo $contenido->contenido_enlace; ?>" class="enlace-link" <?php if ($contenido->contenido_enlace_abrir == 1) { ?> target="blank"
		<?php } ?>>
	<?php } ?>
	<div class="caja-contenido-simple design-two-links"
		style="background-color: <?php if ($contenido->contenido_fondo_color) {
										echo  $contenido->contenido_fondo_color;
									} else if ($colorfondo) {
										echo $colorfondo;
									}   ?>">

		<div class="row">

			<div class="col-sm-6">
				<?php if ($contenido->contenido_titulo_ver == 1) { ?>
					<h2><?php echo $contenido->contenido_titulo; ?></h2>
				<?php } ?>
				<?php if ($contenido->contenido_descripcion) { ?>

					<div class="descripcion">
						<?php echo $contenido->contenido_descripcion; ?>
					</div>
				<?php } ?>



			</div>

			<div class="col-sm-6">
				<img src="/assets/Flecha1.png">
				<!-- <i class="fa-solid fa-arrow-right-long" style="font-size: 40px; transform: scaleX(1.5);"></i> -->

			</div>

		</div>

	</div>
	<?php if ($contenido->contenido_enlace) { ?>
	</a>
<?php } ?>