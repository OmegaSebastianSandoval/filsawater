<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->tienda_categoria_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->tienda_categoria_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activa (Si, No)</label>
					<input type="checkbox" name="tienda_categoria_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'tienda_categoria_estado') == 1) {
																															echo "checked";
																														} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
		
				<div class="col-10 form-group">
					<label for="tienda_categoria_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->tienda_categoria_nombre; ?>" name="tienda_categoria_nombre" id="tienda_categoria_nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-6 form-group d-none">
					<label for="tienda_categoria_imagen">imagen</label>
					<input type="file" name="tienda_categoria_imagen" id="tienda_categoria_imagen" class="form-control  file-image" data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->tienda_categoria_imagen) { ?>
						<div id="imagen_tienda_categoria_imagen">
							<img src="/images/<?= $this->content->tienda_categoria_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('tienda_categoria_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-12 form-group  d-none">
					<label for="tienda_categoria_descripcion" class="form-label">descripci&oacute;n</label>
					<textarea name="tienda_categoria_descripcion" id="tienda_categoria_descripcion" class="form-control tinyeditor" rows="10"><?= $this->content->tienda_categoria_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="tienda_categoria_padre" value="<?php if ($this->content->tienda_categoria_padre) {
																				echo $this->content->tienda_categoria_padre;
																			} else {
																				echo $this->tienda_categoria_padre;
																			} ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?tienda_categoria_padre=<?php if ($this->content->tienda_categoria_padre) {
																			echo $this->content->tienda_categoria_padre;
																		} else {
																			echo $this->tienda_categoria_padre;
																		} ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>