<h1 class="nombre-pagina">Restablecer Password</h1>
    <p class="descripcion-pagina">Introduzca su email para restablecer su password</p>
    <?php 
        include __DIR__.'/../templates/alertas.php';
    ?>
    <form action="/olvide" class="form" method="POST"  >
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Tu email" name="email">
        </div>
        <input type="submit" value="Enviar Instrucciones" class="boton">
    </form>
    <div class="acciones">
        <a href="/registrarse">Registrarme</a>
        <a href="/login">¿Ya tienes una cuenta? Inicie sessión</a>
    </div>