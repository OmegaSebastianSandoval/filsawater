<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->configuracion_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->configuracion_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="configuracion_iva" class="control-label">Iva</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<!-- 	<input type="text" value="<?= $this->content->configuracion_iva; ?>" name="configuracion_iva" id="configuracion_iva" class="form-control"  required > -->
						<input type="number"
							value="<?= $this->content->configuracion_iva; ?>"
							name="configuracion_iva"
							id="configuracion_iva"
							class="form-control"
							min="0"
							max="100"
							step="0.1"
							required
							placeholder="Porcentaje de IVA">

					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>
<script>

</script>