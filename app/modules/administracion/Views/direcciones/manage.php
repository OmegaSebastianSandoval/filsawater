
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->direccion_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->direccion_id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-12 form-group">
					<label class="control-label">direccion_departamento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="direccion_departamento"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_direccion_departamento AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"direccion_departamento") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label class="control-label">direccion_ciudad</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="direccion_ciudad"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_direccion_ciudad AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"direccion_ciudad") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="direccion_direccion"  class="control-label">direccion_direccion</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->direccion_direccion; ?>" name="direccion_direccion" id="direccion_direccion" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="direccion_observacion" class="form-label" >direccion_observacion</label>
					<textarea name="direccion_observacion" id="direccion_observacion"   class="form-control tinyeditor" rows="10"   ><?= $this->content->direccion_observacion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="direccion_cliente"  class="control-label">direccion_cliente</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->direccion_cliente; ?>" name="direccion_cliente" id="direccion_cliente" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="direccion_codigopostal"  class="control-label">direccion_codigopostal</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->direccion_codigopostal; ?>" name="direccion_codigopostal" id="direccion_codigopostal" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-12 form-group d-grid">
			<label   class="control-label">direccion_estado</label>
				<input type="checkbox" name="direccion_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'direccion_estado') == 1) { echo "checked";} ?>   ></input>
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