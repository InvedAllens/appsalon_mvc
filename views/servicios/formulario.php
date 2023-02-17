<div class="campo">
    <label for="nombre">Nombre:</label>
    <input  type="text" 
            placeholder="Nombre Servicio" 
            name="nombre" 
            id="nombre" 
            value="<?php echo $servicio->nombre?>">
</div>
<div class="campo">
    <label for="precio">Precio:</label>
    <input  type="number" 
            step="0.01" 
            placeholder="Precio Servicio" 
            name="precio" 
            id="precio" 
            value="<?php echo $servicio->precio?>">
</div>