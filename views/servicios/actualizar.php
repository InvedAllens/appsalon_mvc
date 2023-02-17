<?php 
    include __DIR__."/../templates/barra.php";
?>
<h1 class="nombre-pagina">Actualizar Servicios</h1>
<p class="descripcion-pagina">LLene el Formulario Para Actualizar un Servicio</p>

<?php 
    include __DIR__."/../templates/alertas.php"
?>

<form  class="form" method="POST">
    <?php 
        include_once __DIR__."/formulario.php";
        
    ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>