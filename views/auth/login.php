<div >
    <h1 class="nombre-pagina">Login</h1>
    <p class="descripcion-pagina">Inicia sesion con tus datos</p>
    <?php 
        include __DIR__."/../templates/alertas.php";
    ?>
    <form action="/login" class="form" method="POST"  >
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Tu email" name="email">
        </div>
        <div class="campo">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Tu Password" name="password">
        </div>
        <input type="submit" class="boton" value="Iniciar Sesión">
    </form>
    <div class="acciones">
        <a href="/registrarse">Registrarme</a>
        <a href="/olvide">Recuperar mi password</a>
    </div>

    
</div>