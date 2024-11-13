
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->nivel_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->nivel_id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-3 form-group">
					<label for="nivel_nivel"  class="control-label">nivel</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nivel_nivel; ?>" name="nivel_nivel" id="nivel_nivel" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="nivel_codigo"  class="control-label">código</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nivel_codigo; ?>" name="nivel_codigo" id="nivel_codigo" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="nivel_porcentaje"  class="control-label">porcentaje</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nivel_porcentaje; ?>" name="nivel_porcentaje" id="nivel_porcentaje"  class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-3 form-group d-grid">
			<label   class="control-label">Activo (Si, No)</label>
				<input type="checkbox" name="nivel_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'nivel_estado') == 1) { echo "checked";} ?>   ></input>
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