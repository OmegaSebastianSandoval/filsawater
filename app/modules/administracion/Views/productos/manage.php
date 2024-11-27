<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<?php if ($this->error == 1) { ?>
				<div class="alert alert-danger">
					<strong>Advertencia:</strong> La referencia del producto ya existe.
				</div>
			<?php } ?>
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->producto_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->producto_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Activo (Si, No)</label>
					<input type="checkbox" name="producto_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'producto_estado') == 1) {
																													echo "checked";
																												} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-grid">
					<label class="control-label">Producto importante (Si, No)</label>
					<input type="checkbox" name="producto_importante" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'producto_importante') == 1) {
																														echo "checked";
																													} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">

				<div class="col-7 form-group">
					<label for="producto_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_nombre; ?>" name="producto_nombre" id="producto_nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="producto_precio" class="control-label">Precio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<!-- <input type="text" value="<?= $this->content->producto_precio; ?>" name="producto_precio" id="producto_precio" class="form-control" required> -->
						<input
							type="text"
							value="<?= number_format($this->content->producto_precio, 0, '', ','); ?>"
							name="producto_precio"
							id="producto_precio"
							class="form-control"
							required
							inputmode="numeric"
							autocomplete="off">

					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 form-group">
					<label for="producto_stock" class="control-label">Stock</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_stock; ?>" name="producto_stock" id="producto_stock" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 form-group">
					<label for="producto_referencia" class="control-label">Referencia</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_referencia; ?>" name="producto_referencia" id="producto_referencia" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-4 form-group">
					<label for="producto_imagen">Imagen</label>
					<input type="file" name="producto_imagen" id="producto_imagen" class="form-control  file-image" data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->producto_imagen) { ?>
						<div id="imagen_producto_imagen">
							<img src="/images/<?= $this->content->producto_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('producto_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>

				<div class="col-5 form-group">
					<label class="control-label">Categor&iacute;a</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  "><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="producto_categoria" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_producto_categoria as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "producto_categoria") == $key) {
											echo "selected";
										} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="producto_descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="producto_descripcion" id="producto_descripcion" class="form-control tinyeditor" rows="10"><?= $this->content->producto_descripcion; ?></textarea>
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
	document.addEventListener('DOMContentLoaded', () => {
		const inputPrecio = document.getElementById('producto_precio');

		// Formatear número al escribir
		inputPrecio.addEventListener('input', (e) => {
			const value = e.target.value.replace(/[,.]/g, ''); // Eliminar comas y puntos

			// Agregar formato de separación por miles
			e.target.value = formatNumber(value);
		});

		// Remover comas antes de enviar el formulario
		inputPrecio.closest('form').addEventListener('submit', (e) => {
			inputPrecio.value = inputPrecio.value.replace(/[,.]/g, ''); // Eliminar comas y puntos
		});

		// Función para formatear número con comas cada 3 dígitos
		function formatNumber(value) {
			return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
		}
	});
</script>