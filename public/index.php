<?php

    use Model\Propiedad;
    use MVC\Router;
    use Controllers\PropiedadController;
    use Controllers\VendedorController;
    use Controllers\PaginasController;
    use Controllers\LoginController;

    require_once __DIR__.'/../includes/app.php';
    $router=new Router();
    $router->comprobarRutas();