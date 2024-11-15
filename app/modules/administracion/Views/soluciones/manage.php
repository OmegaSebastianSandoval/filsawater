<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->solucion_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->solucion_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activo(S&iacute;, No)</label>
					<input type="checkbox" name="solucion_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'solucion_estado') == 1) {
																													echo "checked";
																												} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="row">

				<div class="col-4 form-group">
					<label for="solucion_titulo" class="control-label">Título</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->solucion_titulo; ?>" name="solucion_titulo" id="solucion_titulo" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<?php if (!$this->padre) { ?>
					<div class="col-4 form-group">
						<label for="solucion_categoria" class="control-label">Categor&iacute;a</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
							</div>
							<input type="text" value="<?= $this->content->solucion_categoria; ?>" name="solucion_categoria" id="solucion_categoria" class="form-control">
						</label>
						<div class="help-block with-errors"></div>
					</div>
				<?php } ?>
				<div class="col-4 form-group">
					<label for="solucion_imagen">Imagen</label>
					<input type="file" name="solucion_imagen" id="solucion_imagen" class="form-control  file-image" data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png, image/webp">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->solucion_imagen) { ?>
						<div id="imagen_solucion_imagen">
							<img src="/images/<?= $this->content->solucion_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('solucion_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-3 form-group d-none">
					<label for="solucion_archivo">Archivo</label>
					<input type="file" name="solucion_archivo" id="solucion_archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('solucion_archivo');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="solucion_descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="solucion_descripcion" id="solucion_descripcion" class="form-control tinyeditor" rows="10"><?= $this->content->solucion_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="solucion_introduccion" class="form-label">Introducci&oacute;n</label>
					<textarea name="solucion_introduccion" id="solucion_introduccion" class="form-control tinyeditor" rows="10"><?= $this->content->solucion_introduccion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="solucion_contenido" class="form-label">Contenido</label>
					<textarea name="solucion_contenido" id="solucion_contenido" class="form-control tinyeditor" rows="10"><?= $this->content->solucion_contenido; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>

				<input type="hidden" name="solucion_padre" value="<?php if ($this->content->solucion_padre) {
																		echo $this->content->solucion_padre;
																	} else {
																		echo $this->padre;
																	} ?>">

				<div class="col-4 form-group d-none">
					<label for="solucion_tags" class="control-label">Tags</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->solucion_tags; ?>" name="solucion_tags" id="solucion_tags" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?padre=<?php if ($this->content->solucion_padre) {
															echo $this->content->solucion_padre;
														} else {
															echo $this->padre;
														} ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>