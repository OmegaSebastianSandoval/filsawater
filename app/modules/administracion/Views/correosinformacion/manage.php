
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->correo_informacion_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->correo_informacion_id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-7 form-group">
					<label for="correos_informacion_correo"  class="control-label">Correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->correos_informacion_correo; ?>" name="correos_informacion_correo" id="correos_informacion_correo" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="correos_informacion_fecha"  class="control-label">Fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
					<input type="text" value="<?php if($this->content->correos_informacion_fecha){ echo $this->content->correos_informacion_fecha; } else { echo date('Y-m-d'); } ?>" name="correos_informacion_fecha" id="correos_informacion_fecha" class="form-control"  required data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es"  >
					</label>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-2 form-group d-grid">
			<label   class="control-label">Activo (Si, No)</label>
				<input type="checkbox" name="correos_informacion_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'correos_informacion_estado') == 1) { echo "checked";} ?>   ></input>
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