<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">

	<a href="<?php echo $this->route; ?>" class="btn btn-secondary mt-3 px-4">Volver</a>


	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">

			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->pedido_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->pedido_id; ?>" />
			<?php } ?>
			<div class="row mb-4">
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_documento" class="control-label">Documento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_documento; ?>" name="pedido_documento" id="pedido_documento" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-12 col-md-3 form-group">
					<label for="pedido_fecha" class="control-label">Fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_fecha; ?>" name="pedido_fecha" id="pedido_fecha" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_total" class="control-label">Total</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_total >= 1 ? "$ " . number_format(ceil($this->content->pedido_total)) : $this->content->pedido_total; ?>" name="pedido_total" id="pedido_total" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_subtotal" class="control-label">Subtotal</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_subtotal >= 1 ? "$ " . number_format(ceil($this->content->pedido_subtotal)) : $this->content->pedido_subtotal ?>" name="pedido_subtotal" id="pedido_subtotal" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_procentaje_descuento" class="control-label">Procentaje Descuento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_procentaje_descuento . " %"; ?>" name="pedido_procentaje_descuento" id="pedido_procentaje_descuento" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_descuento" class="control-label">Descuento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_descuento >= 1 ? "$ " . number_format(ceil($this->content->pedido_descuento)) : $this->content->pedido_descuento; ?>" name="pedido_descuento" id="pedido_descuento" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_porcentaje_iva" class="control-label">Porcentaje iva</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_porcentaje_iva . " %"; ?>" name="pedido_porcentaje_iva" id="pedido_porcentaje_iva" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_iva" class="control-label">Iva</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_iva >= 1 ? "$ " . number_format(ceil($this->content->pedido_iva)) : $this->content->pedido_iva; ?>" name="pedido_iva" id="pedido_iva" class="form-control" readonly disabled>
						<div class="help-block with-errors"></div>
				</div>

			</div>

			<div class="row mb-4">
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_nombre; ?>" name="pedido_nombre" id="pedido_nombre" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_correo" class="control-label">Correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_correo; ?>" name="pedido_correo" id="pedido_correo" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-12 col-md-3 form-group">
					<label for="pedido_telefono" class="control-label">Teléfono</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_telefono; ?>" name="pedido_telefono" id="pedido_telefono" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>



				<div class="col-12 col-md-3 form-group">
					<label for="pedido_departamento" class="control-label">Departamento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->list_direccion_departamento[$this->content->pedido_departamento]; ?>" name="pedido_departamento" id="pedido_departamento" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_ciudad" class="control-label">Ciudad</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->list_direccion_ciudad[$this->content->pedido_ciudad] ?>" name="pedido_ciudad" id="pedido_ciudad" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_direccion" class="control-label">Dirección</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_direccion; ?>" name="pedido_direccion" id="pedido_direccion" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-12 form-group">
					<label for="pedido_direccion_observacion" class="control-label">Dirección Observación</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<!-- <input type="text" value="<?= $this->content->pedido_direccion_observacion; ?>" name="pedido_direccion_observacion" id="pedido_direccion_observacion" class="form-control" readonly disabled> -->
						<textarea name="pedido_direccion_observacion" id="pedido_direccion_observacion" class="form-control" readonly disabled><?= $this->content->pedido_direccion_observacion; ?></textarea>
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_estado" class="control-label">Estado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->list_pedido_estado[$this->content->pedido_estado]; ?>" name="pedido_estado" id="pedido_estado" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_identificador" class="control-label">Identificador Wompi</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_identificador; ?>" name="pedido_identificador" id="pedido_identificador" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_validacion" class="control-label">Validación</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_validacion; ?>" name="pedido_validacion" id="pedido_validacion" class="form-control input-<?= $this->content->pedido_validacion ?>" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_validacion2" class="control-label">Alerta por correo enviada</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_validacion2 == 1 ? 'Si' : 'No'; ?>" name="pedido_validacion2" id="pedido_validacion2" class="form-control input-<?= $this->content->pedido_validacion2 == 1 ? 'APPROVED' : 'ERROR' ?>" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-3 form-group">
					<label for="pedido_entidad" class="control-label">Entidad</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pedido_entidad; ?>" name="pedido_entidad" id="pedido_entidad" class="form-control" readonly disabled>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<?php if ($this->content->pedido_respuesta) { ?>

					<div class="col-12 col-md-12 form-group">
						<label for="pedido_respuesta" class="control-label">Respuesta</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
							</div>
							<input type="text" value="<?= $this->content->pedido_respuesta; ?>" name="pedido_respuesta" id="pedido_respuesta" class="form-control" readonly disabled>
						</label>
						<div class="help-block with-errors"></div>
					</div>

				<?php } ?>



				<?php if ($this->content->pedido_response) { ?>
					<div class="accordion mt-4" id="accordionPanelsStayOpenExample">

						<div class="accordion-item">
							<h2 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
									Ver respuesta de Wompi
								</button>
							</h2>
							<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
								<div class="accordion-body">

									<div id="wrapper">

									</div>
								</div>
							</div>
						</div>

					</div>
				<?php } ?>
			</div>

			<?php if (is_countable($this->productosPedido) && count($this->productosPedido) > 0) { ?>

				<div class="row pedido-productos contendor-comprar">
					<table class="table-cart  ">
						<thead>
							<tr>
								<th width="70%">Producto</th>
								<th width="10%">Precio</th>
								<th width="10%">Cantidad</th>
								<th width="10%">Total</th>
							</tr>
						</thead>


						<tbody>
							<?php
							foreach ($this->productosPedido as $producto) {
							?>
								<tr>
									<td data-label="Producto">
										<div class="producto d-flex gap-2 align-items-center">


											<?php if ($producto->producto_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->producto_imagen)) { ?>
												<img src="/images/<?php echo $producto->producto_imagen; ?>" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">
											<?php } else { ?>
												<img src="/assets/imagenot.jpg" alt="<?php echo $producto->pedido_producto_nombre; ?>" class="w-100 img-fluid" alt="Imagen del producto" style="max-width:100px">


											<?php } ?>
											<div class="producto-info">
												<h5><?php echo $producto->pedido_producto_nombre; ?></h5>
												<h6>Categoría: <span><?php echo $producto->producto_categoriainfo; ?></span></h6>
											</div>
										</div>
									</td>
									<td data-label="Precio">
										<span class="precio">
											$<?php echo number_format(ceil($producto->pedido_producto_precio_final)); ?>
										</span>
									</td>
									<td data-label="Cantidad">
										<span class="cantidad">
											<?php echo $producto->pedido_producto_cantidad; ?>
										</span>
									</td>
									<td data-label="Total">
										<span class="total" id="total-producto">
											$<?php echo number_format(ceil($producto->pedido_producto_precio_final)); ?>
										</span>
									</td>
								</tr>
							<?php } ?>



						</tbody>
					</table>
				</div>
			<?php } ?>

		</div>
		<div class="botones-acciones">
			<!-- <button class="btn btn-guardar" type="submit">Guardar</button> -->
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Volver</a>
		</div>
	</form>
</div>

<style>
	#wrapper li {
		list-style: none;
	}
</style>

<?php if ($this->content->pedido_response) { ?>

	<script src="https://rawgit.com/summerstyle/jsonTreeViewer/master/libs/jsonTree/jsonTree.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Get DOM-element for inserting json-tree
			var wrapper = document.getElementById("wrapper");

			<?php

			$array = (json_decode($this->content->pedido_response)->data);
			$json  = json_encode($array)
			?>
			var tree = jsonTree.create(<?php echo $json ?>, wrapper);
		});
	</script>
<?php } ?>