<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->blog_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->blog_id; ?>" />
			<?php } ?>
			<div class="row">
				
			</div>

			<div class="row">

				<div class="col-4 col-mg-3 col-lg-9 form-group">
					<label for="blog_titulo" class="control-label">titulo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->blog_titulo; ?>" name="blog_titulo" id="blog_titulo" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 col-mg-3 col-lg-3 form-group">
					<label for="blog_imagen">imagen</label>
					<input type="file" name="blog_imagen" id="blog_imagen" class="form-control  file-image" data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png" <?php if (!$this->content->blog_id) {
																																																	echo 'required';
																																																} ?>>
					<div class="help-block with-errors"></div>
					<?php if ($this->content->blog_imagen) { ?>
						<div id="imagen_blog_imagen">
							<img src="/images/<?= $this->content->blog_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('blog_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activo (Si, No)</label>
					<input type="checkbox" name="blog_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'blog_estado') == 1) {
																												echo "checked";
																											} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 form-group d-grid">
					<label class="control-label">Importante (Si, No)</label>
					<input type="checkbox" name="blog_importante" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'blog_importante') == 1) {
																													echo "checked";
																												} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 form-group d-grid">
					<label class="control-label">Nuevo (Si, No)</label>
					<input type="checkbox" name="blog_nuevo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'blog_nuevo') == 1) {
																													echo "checked";
																												} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 col-mg-3 col-lg-3 form-group">
					<label class="control-label">categoria</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  "><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="blog_categoria_id" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_blog_categoria_id as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "blog_categoria_id") == $key) {
											echo "selected";
										} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-4 col-mg-3 col-lg-3 form-group">
					<label for="blog_fecha" class="control-label">fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-calendar-alt"></i></span>
						</div>
						<input type="text" value="<?php if ($this->content->blog_fecha) {
														echo $this->content->blog_fecha;
													} else {
														echo date('Y-m-d');
													} ?>" name="blog_fecha" id="blog_fecha" class="form-control" required data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-12 form-group">
					<label for="tags" class="control-label">tags</label>
					<label class="input-group no-wrap">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->tags; ?>" name="tags" id="tags" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="blog_descripcion" class="form-label">descripci&oacute;n</label>
					<textarea name="blog_descripcion" id="blog_descripcion" class="form-control tinyeditor" rows="10"><?= $this->content->blog_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="blog_introduccion" class="form-label">introducci&oacute;n</label>
					<textarea name="blog_introduccion" id="blog_introduccion" class="form-control tinyeditor" rows="10"><?= $this->content->blog_introduccion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="blog_contenido" class="form-label">contenido</label>
					<textarea name="blog_contenido" id="blog_contenido" class="form-control tinyeditor" rows="10"><?= $this->content->blog_contenido; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-4 col-mg-3 col-lg-2 form-group d-none">
					<label for="blog_autor" class="control-label">autor</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->blog_autor; ?>" name="blog_autor" id="blog_autor" class="form-control">
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
<link rel="stylesheet" href="/components/tags/tags.css">

<script src="/components/tags/tags.js"></script>


<script>
	$('#tags').tagsInput({
		'defaultText': 'Escribe los tags del blog'
	});
</script>

<style>
	.no-wrap{
		flex-wrap: nowrap !important;
	}
	div.tagsinput{
		width: 97% !important;
		height: auto !important;
		min-height: auto !important;
	}
	div.tagsinput input{
		width: 100% !important;
	}
</style>