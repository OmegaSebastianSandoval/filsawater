
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id_municipio) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id_municipio; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="municipio"  class="control-label">municipio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->municipio; ?>" name="municipio" id="municipio" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-12 form-group d-grid">
			<label   class="control-label">estado</label>
				<input type="checkbox" name="estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'estado') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
				<div class="col-12 form-group">
					<label for="departamento_id"  class="control-label">departamento_id</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->departamento_id; ?>" name="departamento_id" id="departamento_id" class="form-control"   >
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