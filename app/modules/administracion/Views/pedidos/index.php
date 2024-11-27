<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
		<div class="content-dashboard">
			<div class="row">
				<div class="col-3">
					<label>Número de Pedido</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="pedido_id" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_id') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>Documento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="pedido_documento" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_documento') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>Cliente</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="pedido_nombre" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_nombre') ?>"></input>
					</label>
				</div>

				<div class="col-3">
					<label>Correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="pedido_correo" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_correo') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>Fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="date" class="form-control" name="pedido_fecha" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_fecha') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>Estado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<select class="form-control" name="pedido_estado">
							<option value="">Seleccione</option>
							<option value="Todos" <?= $this->getObjectVariable($this->filters, 'pedido_estado') == 'Todos' ? 'selected' : '' ?>>Todos</option>

							<?php foreach ($this->list_pedido_estado as $key => $value) { ?>
								<option value="<?php echo $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'pedido_estado') == $key) {
																		echo 'selected';
																	} ?>><?php echo $value; ?></option>
							<?php } ?>
						</select>
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
	<?php if ($this->message) { ?>
		<div class="alert alert-success text-center">
			<?php echo $this->message; ?>
		</div>
	<?php } ?>

	<div class="content-dashboard ">
		<div class="franja-paginas">
			<div class="row">
				<div class="col-5">
					<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
				</div>
				<div class="col-6 text-end">
					<div class="texto-paginas">Registros por pagina:</div>
				</div>
				<div class="col-1">
					<select class="form-control form-control-sm selectpagination">
						<option value="50" <?php if ($this->pages == 50) {
												echo 'selected';
											} ?>>50</option>
						<option value="100" <?php if ($this->pages == 100) {
												echo 'selected';
											} ?>>100</option>
						<option value="150" <?php if ($this->pages == 150) {
												echo 'selected';
											} ?>>150</option>
						<option value="200" <?php if ($this->pages == 200) {
												echo 'selected';
											} ?>>200</option>
					</select>
				</div>
				<!-- <div class="col-3">
					<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route . "\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
				</div> -->
			</div>
		</div>
		<div class="content-table">
			<table class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>Pedido</td>
						<td>Fecha</td>
						<td>Documento</td>
						<td>Cliente</td>
						<td>Total</td>
						<td>Estado</td>

						<td width="200"></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->lists as $content) { ?>
						<?php $id =  $content->pedido_id; ?>
						<tr>
							<td><?= $id ?></td>
							<td><?= $content->pedido_fecha ?></td>
							<td><?= $content->pedido_documento ?></td>
							<td><?= $content->pedido_nombre ?></td>
							<td><?= $content->pedido_total >= 1 ? "$ " . number_format(ceil($content->pedido_total)) : $content->pedido_total ?></td>
							<td><?= $this->list_pedido_estado[$content->pedido_estado] ?></td>
							<td class="text-end">
								<div>
									<a class="btn btn-azul btn-sm" href="<?php echo $this->route; ?>/info?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Ver"><i class="fa-solid fa-eye"></i></a>
									<?php if ($content->pedido_validacion2 == 2) { ?>
										<a class="btn btn-warning btn-sm" href="<?php echo $this->route; ?>/reenviarcorreo?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Reenviar Correo De Estado"><i class="fa-solid fa-envelope"></i></a>

									<?php } ?>

									<?php if ($content->pedido_estado == 5 || $content->pedido_estado == 9) { ?>
										<a class="btn btn-azul-claro btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
									<?php } ?>

									<!-- 	<span  data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm"  data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
 -->
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
		<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
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