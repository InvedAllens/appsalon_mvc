
<h1 class="nombre-pagina">Registrarse</h1>
<p class="descripcion-pagina">Llene el siguiente formulario para crear una cuenta</p>
<?php 
    include __DIR__."/../templates/alertas.php";
?>
<form action="/registrarse" class="form" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Tu nombre" id="nombre" name="nombre" value="<?php echo s($usuario->nombre);?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" placeholder="Tu Apellido" id="apellido" name="apellido" value="<?php echo s($usuario->apellido);?>">
    </div>
    <div class="campo">
        <label for="nombre">Telefono</label>
        <input type="tel" placeholder="Tu telefono" id="telefono" name="telefono" value="<?php echo s($usuario->telefono);?>">
    </div>
    <div class="campo">
        <label for="nombre">Email</label>
        <input type="email" placeholder="Tu email" id="email" name="email" value="<?php echo s($usuario->email);?>">
    </div>
    <div class="campo">
        <label for="nombre">Password</label>
        <input type="password" placeholder="Tu Password" id="password" name="password" value="">
    </div>
    <input type="submit" class="boton" value="Registrarse">
</form>
<div class="acciones">
        <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
        <a href="/olvide">Recuperar mi password</a>
    </div>