<?php 
    include __DIR__."/../templates/barra.php"
?>
<h1 class="nombre-pagina">Citas</h1>
<p class="descripcion-pagina">Elija el servicio que desea reservar</p>
<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="texto-centrado">Elije tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="texto-centrado">Coloca tus datos y fecha para tu cita</p>
        <form class="form">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" name="nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora">
            </div>
            <input type="hidden" id="idusuario" value="<?php echo $idusuario?>">

        </form>

    </div>
    <div id="paso-3" class="seccion seccion-resumen">
        <h2>Resumen</h2>
        <p class="texto-centrado">Verifique los datos de su cita</p>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo;Anterior</button>
        <button id="siguiente" class="boton">Siguiente&raquo;</button>

    </div>
</div>
<?php 
    $script="
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/bundle.min.js'></script>
    ";
?>