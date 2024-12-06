<section class="container-fluid">
    <form action="<?php echo $this->route; ?>/exportar" method="post">
        <div class="content-dashboard m-0 p-2 border-0">
            <div class="row">
                <div class="col-12 col-md-3">
                    <label>Número de Pedido</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pedido_id" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_id') ?>"></input>
                    </label>
                </div>
                <div class="col-12 col-md-3">
                    <label>Documento</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pedido_documento" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_documento') ?>"></input>
                    </label>
                </div>
                <div class="col-12 col-md-3">
                    <label>Fecha Inicio</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="date" class="form-control" name="pedido_fecha" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_fecha') ?>"></input>
                    </label>
                </div>
                <div class="col-12 col-md-3">
                    <label>Fecha Fin</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="date" class="form-control" name="pedido_fecha_fin" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_fecha_fin') ?>"></input>
                    </label>
                </div>
                <div class="col-12 col-md-3">
                    <label>Cliente</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pedido_nombre" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_nombre') ?>"></input>
                    </label>
                </div>

                <!-- <div class="col-12 col-md-3">
                    <label>Correo</label>
                    <label class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="pedido_correo" value="<?php echo $this->getObjectVariable($this->filters, 'pedido_correo') ?>"></input>
                    </label>
                </div> -->
               
                <div class="col-12 col-md-3">
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

                <div class="col-12 col-md-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-12 col-md-3">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>/exportar?cleanfilter=1"> <i class="fas fa-eraser"></i> Limpiar Filtro</a>
                </div>
            </div>
        </div>
    </form>
    <div class="d-flex justify-content-end align-items-center my-2">

        <a href="/administracion/pedidos/exportarexcel?excel=1" class="btn btn-success">
            <i class="fa-solid fa-file-excel"></i> Exportar</a>
    </div>
    <div class="content-table p-0 m-0">
        <table class=" table table-striped  table-hover table-administrator text-left">
            <thead>
                <tr>
                    <td>Pedido</td>
                    <td>Fecha</td>
                    <td>Documento</td>
                    <td>Cliente</td>
                    <td>Total</td>
                    <td>Estado</td>

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

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>