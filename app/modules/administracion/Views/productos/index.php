<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
		<div class="content-dashboard">
			<div class="row">
				<div class="col-3 col-lg-2">
					<label>Activo (Si, No)</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<!-- <input type="text" class="form-control" name="producto_estado" value="<?php echo $this->getObjectVariable($this->filters, 'producto_estado') ?>"></input> -->
						<select class="form-control" name="producto_estado">
							<option value="">Todas</option>
							<option value="1" <?php if ($this->getObjectVariable($this->filters, 'producto_estado') == 1) {
													echo "selected";
												} ?>>Si</option>
							<option value="0" <?php if ($this->getObjectVariable($this->filters, 'producto_estado') == 0) {
													echo "selected";
												} ?>>No</option>
						</select>
					</label>
				</div>
				<div class="col-2">
					<label>Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="producto_nombre" value="<?php echo $this->getObjectVariable($this->filters, 'producto_nombre') ?>"></input>
					</label>
				</div>
				<div class="col-3 col-lg-2">
					<label>Referencia</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="producto_referencia" value="<?php echo $this->getObjectVariable($this->filters, 'producto_referencia') ?>"></input>
					</label>
				</div>
				<!-- <div class="col-3 col-lg-3">
					<label>precio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="producto_precio" value="<?php echo $this->getObjectVariable($this->filters, 'producto_precio') ?>"></input>
					</label>
				</div> -->
				<!-- <div class="col-3">
					<label>imagen</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="producto_imagen" value="<?php echo $this->getObjectVariable($this->filters, 'producto_imagen') ?>"></input>
					</label>
				</div> -->
				<!-- <div class="col-3">
					<label>stock</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="producto_stock" value="<?php echo $this->getObjectVariable($this->filters, 'producto_stock') ?>"></input>
					</label>
				</div> -->
				<div class="col-2">
					<label>categor&iacute;a</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="producto_categoria">
							<option value="">Todas</option>
							<?php foreach ($this->list_producto_categoria as $key => $value) : ?>
								<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'producto_categoria') ==  $key) {
																	echo "selected";
																} ?>><?= $value; ?></option>
							<?php endforeach ?>
						</select>
					</label>
				</div>
				<div class="col-2">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
				</div>
				<div class="col-2">
					<label>&nbsp;</label>
					<a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1"> <i class="fas fa-eraser"></i> Limpiar Filtro</a>
				</div>
			</div>
		</div>
	</form>
	<div align="center">
		<ul class="pagination justify-content-center">
			<?php
			$url = $this->route;
			if ($this->totalpages > 1) {
				if ($this->page != 1)
					echo '<li class="page-item" ><a class="page-link"  href="' . $url . '?page=' . ($this->page - 1) . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>  ';
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
			}
			?>
		</ul>
	</div>
	<div class="content-dashboard">
		<div class="franja-paginas">
			<div class="row">
				<div class="col-5">
					<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
				</div>
				<div class="col-3 text-end">
					<div class="texto-paginas">Registros por pagina:</div>
				</div>
				<div class="col-1">
					<select class="form-control form-control-sm selectpagination">
						<option value="20" <?php if ($this->pages == 20) {
												echo 'selected';
											} ?>>20</option>
						<option value="30" <?php if ($this->pages == 30) {
												echo 'selected';
											} ?>>30</option>
						<option value="50" <?php if ($this->pages == 50) {
												echo 'selected';
											} ?>>50</option>
						<option value="100" <?php if ($this->pages == 100) {
												echo 'selected';
											} ?>>100</option>
					</select>
				</div>
				<div class="col-3">
					<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route . "\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
				</div>
			</div>
		</div>
		<div class="content-table">
			<table class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>Activo (Si, No)</td>
						<td>nombre</td>
						<td>referencia</td>
						<td>precio</td>
						<td>imagen</td>
						<td>stock</td>
						<td>categor&iacute;a</td>
						<td width="100">Orden</td>
						<td width="300"></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->lists as $content) { ?>
						<?php $id =  $content->producto_id; ?>
						<tr>
						
							<td><?= $content->producto_estado == 1 ? 'Si' : 'No'; ?></td>
							<td><?= $content->producto_nombre; ?></td>
							<td><?= $content->producto_referencia; ?></td>
							<td><?=
								$content->producto_precio >= 1 ? '$' . number_format($content->producto_precio) : 'Sin Precio';
								?></td>
							<td>
								<?php if ($content->producto_imagen) { ?>
									<img src="/images/<?= $content->producto_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
								<?php } ?>
								<div><?= $content->producto_imagen; ?></div>
							</td>
							<td><?= $content->producto_stock; ?></td>
							<td><?= $this->list_producto_categoria[$content->producto_categoria]; ?>
							<td>
								<input type="hidden" id="<?= $id; ?>" value="<?= $content->orden; ?>"></input>
								<button class="up_table btn btn-primary btn-sm"><i class="fas fa-angle-up"></i></button>
								<button class="down_table btn btn-primary btn-sm"><i class="fas fa-angle-down"></i></button>
							</td>
							<td class="text-end">
								<div>

									<a class="btn btn-warning btn-sm" href="/administracion/fotos/?foto_producto=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Imagenes"><i class="fa-regular fa-image"></i></a>
									<a class="btn btn-rosado btn-sm" href="/administracion/documentos/?documento_producto=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Documentos"><i class="fa-solid fa-file"></i></a>


									<a class="btn btn-verde btn-sm" href="/administracion/fotos/cargamasiva/?foto_producto=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Imagenes Carga Masiva"><i class="fa-regular fa-images"></i></a>

									<a class="btn btn-azul btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>



									<!-- <span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt"></i></a></span> -->
								</div>
								<!-- Modal -->
								<div class="modal fade text-left" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											</div>
											<div class="modal-body">
												<div class="">¿Esta seguro de eliminar este registro?</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
												<a class="btn btn-danger" href="<?php echo $this->route; ?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf; ?><?php echo ''; ?>">Eliminar</a>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="order-route" value="<?php echo $this->route; ?>/order"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
	</div>
	<div align="center">
		<ul class="pagination justify-content-center">
			<?php
			$url = $this->route;
			if ($this->totalpages > 1) {
				if ($this->page != 1)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page - 1) . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>  ';
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
			}
			?>
		</ul>
	</div>
</div>