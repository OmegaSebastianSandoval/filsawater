<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->foto_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->foto_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activa (Si, No)</label>
					<input type="checkbox" name="foto_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'foto_estado') == 1) {
																												echo "checked";
																											} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-5 form-group">
					<label for="foto_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->foto_nombre; ?>" name="foto_nombre" id="foto_nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-5 form-group">
					<label for="foto_foto">Foto</label>
					<input type="file" name="foto_foto" id="foto_foto" class="form-control  file-image" data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png" <?php if (!$this->content->foto_id) {
																																																echo 'required';
																																															} ?>>
					<div class="help-block with-errors"></div>
					<?php if ($this->content->foto_foto) { ?>
						<div id="imagen_foto_foto">
							<img src="/images/<?= $this->content->foto_foto; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('foto_foto','<?php echo $this->route . "/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-12 form-group d-none">
					<label for="foto_descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="foto_descripcion" id="foto_descripcion" class="form-control tinyeditor" rows="10"><?= $this->content->foto_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="foto_album" value="<?php if ($this->content->foto_album) {
																	echo $this->content->foto_album;
																} else {
																	echo $this->foto_album;
																} ?>">
				<input type="hidden" name="foto_solucion" value="<?php if ($this->content->foto_solucion) {
																		echo $this->content->foto_solucion;
																	} else {
																		echo $this->foto_solucion;
																	} ?>">
				<input type="hidden" name="foto_producto" value="<?php if ($this->content->foto_producto) {
																		echo $this->content->foto_producto;
																	} else {
																		echo $this->foto_producto;
																	} ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?foto_album=<?php if ($this->content->foto_album) {
																echo $this->content->foto_album;
															} else {
																echo $this->foto_album;
															} ?>&foto_solucion=<?php if ($this->content->foto_solucion) {
																					echo $this->content->foto_solucion;
																				} else {
																					echo $this->foto_solucion;
																				} ?>&foto_producto=<?php if ($this->content->foto_producto) {
																																																				echo $this->content->foto_producto;
																																																			} else {
																																																				echo $this->foto_producto;
																																																			} ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>