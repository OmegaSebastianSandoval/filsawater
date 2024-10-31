<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->documento_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->documento_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activo (Si, No)</label>
					<input type="checkbox" name="documento_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'documento_estado') == 1) {
																													echo "checked";
																												} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">

				<div class="col-6 form-group">
					<label for="documento_nombre" class="control-label">nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->documento_nombre; ?>" name="documento_nombre" id="documento_nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-6 form-group">
					<label for="documento_documento">documento</label>
					<input type="file" name="documento_documento" id="documento_documento" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento_documento');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="documento_solucion" value="<?php if ($this->content->documento_solucion) {
																			echo $this->content->documento_solucion;
																		} else {
																			echo $this->documento_solucion;
																		} ?>">
				<input type="hidden" name="documento_padre" value="<?php if ($this->content->documento_padre) {
																		echo $this->content->documento_padre;
																	} else {
																		echo $this->documento_padre;
																	} ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?documento_solucion=<?php if ($this->content->documento_solucion) {
																		echo $this->content->documento_solucion;
																	} else {
																		echo $this->documento_solucion;
																	} ?>&documento_padre=<?php if ($this->content->documento_padre) {
																								echo $this->content->documento_padre;
																							} else {
																								echo $this->documento_padre;
																							} ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>