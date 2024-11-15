<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route . "?foto_album=" . $this->foto_album . "" . "&foto_solucion=" . $this->foto_solucion . "" . "&foto_producto=" . $this->foto_producto . ""; ?>" method="post">
		<div class="content-dashboard">
			<?php if ($this->foto_solucion) { ?>
				<div class="d-flex gap-4 mb-2">
					
						<a href="/administracion/soluciones/?padre=<?= $this->solucion->solucion_padre ?>" class="btn btn-outline-success px-4"><i class="fa-solid fa-circle-arrow-left"></i> Volver</a>
					
				</div>
			<?php } ?>
			<?php if ($this->foto_producto) { ?>
				<div class="d-flex gap-4 mb-2">
					
						<a href="/administracion/productos" class="btn btn-outline-success px-4"><i class="fa-solid fa-circle-arrow-left"></i> Volver</a>
					
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-3">
					<label>Activa (Si, No)</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_estado" value="<?php echo $this->getObjectVariable($this->filters, 'foto_estado') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_nombre" value="<?php echo $this->getObjectVariable($this->filters, 'foto_nombre') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>foto</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_foto" value="<?php echo $this->getObjectVariable($this->filters, 'foto_foto') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>foto_album</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_album" value="<?php echo $this->getObjectVariable($this->filters, 'foto_album') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>foto_solucion</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_solucion" value="<?php echo $this->getObjectVariable($this->filters, 'foto_solucion') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>foto_producto</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="foto_producto" value="<?php echo $this->getObjectVariable($this->filters, 'foto_producto') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
				</div>
				<div class="col-3">
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
					echo '<li class="page-item" ><a class="page-link"  href="' . $url . '?page=' . ($this->page - 1) . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '">' . $i . '</a></li>  ';
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '">Siguiente &raquo;</a></li>';
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
					<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route . "\manage" . "?foto_album=" . $this->foto_album . "" . "&foto_solucion=" . $this->foto_solucion . "" . "&foto_producto=" . $this->foto_producto . ""; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
				</div>
			</div>
		</div>
		<div class="content-table">
			<table class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>Activa (Si, No)</td>
						<td>nombre</td>
						<td>foto</td>
						<?php if ($this->foto_album) { ?>
							<td>album</td>
						<?php } ?>
						<?php if ($this->foto_solucion) { ?>
							<td>solucion</td>
						<?php } ?>
						<?php if ($this->foto_producto) { ?>
							<td>producto</td>
						<?php } ?>

						<td width="100">Orden</td>
						<td width="100"></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->lists as $content) { ?>
						<?php $id =  $content->foto_id; ?>
						<tr>
							<td><?= $content->foto_estado; ?></td>
							<td><?= $content->foto_nombre; ?></td>
							<td>
								<?php if ($content->foto_foto) { ?>
									<img src="/images/<?= $content->foto_foto; ?>" class="img-thumbnail thumbnail-administrator" />
								<?php } ?>
								<div><?= $content->foto_foto; ?></div>
							</td>
							<?php if ($this->foto_album) { ?>
								<td><?= $content->foto_album; ?></td>
							<?php } ?>
							<?php if ($this->foto_solucion) { ?>
								<td><?= $content->foto_solucion; ?></td>
							<?php } ?>
							<?php if ($this->foto_producto) { ?>
								<td><?= $this->productos_list[$content->foto_producto]; ?></td>
							<?php } ?>



							<td>
								<input type="hidden" id="<?= $id; ?>" value="<?= $content->orden; ?>"></input>
								<button class="up_table btn btn-primary btn-sm"><i class="fas fa-angle-up"></i></button>
								<button class="down_table btn btn-primary btn-sm"><i class="fas fa-angle-down"></i></button>
							</td>
							<td class="text-end">
								<div>
									<a class="btn btn-azul btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
									<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt"></i></a></span>
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
												<a class="btn btn-danger" href="<?php echo $this->route; ?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf; ?><?php echo '' . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto; ?>">Eliminar</a>
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
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page - 1) . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '">' . $i . '</a></li>  ';
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '&foto_album=' . $this->foto_album . '&foto_solucion=' . $this->foto_solucion . '&foto_producto=' . $this->foto_producto . '">Siguiente &raquo;</a></li>';
			}
			?>
		</ul>
	</div>
</div>