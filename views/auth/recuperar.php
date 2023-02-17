<h1 class="nombre-pagina">Restablecer Password</h1>
    <p class="descripcion-pagina">Introduzca su nuevo password</p>
    <?php 
        include __DIR__.'/../templates/alertas.php';
        if(!$error): //en caso de que no exista el token error es true y no muestra el formulario 
    ?>

    <form  class="form" method="POST"  >
        <div class="campo">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Tu Nuevo password" name="password">
        </div>
        <input type="submit" value="Restablecer Password" class="boton">
    </form>
    <div class="acciones">
        <a href="/registrarse">Registrarme</a>
        <a href="/login">¿Ya tienes una cuenta? Inicie sessión</a>
    </div>
    <?php 
        endif;
    ?>