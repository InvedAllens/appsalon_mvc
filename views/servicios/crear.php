<?php 
    include __DIR__."/../templates/barra.php";
?>
<h1 class="nombre-pagina">Crear Servicio</h1>
<p class="descripcion-pagina">LLene el Formulario Para Crear un Nuevo Servicio</p>

<?php 
    include __DIR__."/../templates/alertas.php"
?>

<form action="/servicios/crear" class="form" method="POST">
    <?php 
        include_once __DIR__."/formulario.php";
        
    ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>