<?php 
    include __DIR__."/../templates/barra.php";
?>
<h1 class="nombre-pagina">Servicios</h1>
<ul>
<?php 
    foreach($servicios as $servicio):?>
    <li class="servicio">
        <div class="contenedor-datos">
            <p>Servicio: <span><?php echo $servicio->nombre;?></span></p>
            <p>Precio: $<span><?php echo $servicio->precio;?></span></p>
        </div>
        
        <div class="acciones">
            <a class="boton actualizar" href="/servicios/actualizar?id=<?php echo $servicio->idservicio; ?>">Actualizar</a>
            <form action="/servicios/eliminar" method="POST">
                <input type="hidden" name="idservicio" id="idservicio" value="<?php echo $servicio->idservicio; ?>">
                <input type="submit" value="Eliminar" class="boton-rojo">
            </form>
            
        </div>
    </li>
    <?php
    endforeach;
?>

</ul>