<div class="caja-carrito">
    <div class="btn-cerrar-carrito">
        <i class="fas fa-times-circle"></i>
    </div>
    <div class="detalle-carrito">
        <h2>Carrito de Compras</h2>
        <?php $valortotal = 0; ?>
        <?php foreach ($this->carrito as $key => $carrito) { ?>
            <?php
                $producto = $carrito['detalle'];
                $valor = $carrito['cantidad']*$producto->productos_precio;
                $valortotal = $valortotal+$valor;
            ?>

            <?php
                $max = 20;
                if($producto->productos_cantidad<$max){
                    $max  =$producto->productos_cantidad;
                }
                if($producto->productos_limite_pedido!="" and $producto->productos_limite_pedido<$max){
                    $max=$producto->productos_limite_pedido;
                }
            ?>

            <div class="row item-carrito">
                <div class="col-sm-2">
                    <img src="/images/<?php echo $producto->productos_imagen;?>">
                </div>
                <div class="col-sm-6">
                    <h4 class="titulo-product-carrito"><?php echo $producto->productos_nombre; ?></h4>
                    <div>$<?php echo number_format($producto->productos_precio); ?></div>
                    <div class="inptt col-sm-7" align="left">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary btn-minus" data-id="<?php echo $producto->productos_id; ?>" type="button" id="button-addon2"><i class="fas fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control" id="cantidad<?php echo $producto->productos_id; ?>" placeholder="" value="<?php echo $carrito['cantidad']; ?>" min="0" max="<?php echo $max; ?>" style="widht: 30%;" disabled >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-plus" data-id="<?php echo $producto->productos_id; ?>" type="button" id="button-addon1"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <a class="btn-eliminar-carrito" data-id="<?php echo $producto->productos_id; ?>"><i class="fas fa-trash-alt"></i></a>
                    <div class="precio-product-carrito" align="center"><span id="valortotal<?php echo $producto->productos_id; ?>">$ <?php echo number_format($carrito['cantidad']*$producto->productos_precio);  ?></span></div>
                </div>
            </div>
                <input type="hidden" id="valorunitario<?php echo $producto->productos_id; ?>" value="<?php echo $producto->productos_precio; ?>">  
            </div>
        <?php } ?>
        <div class="row total-carrito">
            <div class="col-sm-12">Total a Pagar</div>
            <div class="col-sm-12 valor" id="totalpagar">$ <?php echo number_format($valortotal); ?></div>
        </div>
    </div>
</div>