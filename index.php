<?php
    session_start();

    date_default_timezone_set('America/Sao_Paulo');

    require_once 'app/config/config.php';

    // Instanciando a classe Autoload
    $AutoLoad = new AutoLoad();

    // Registrando o autoload com o spl
    spl_autoload_register([$AutoLoad , "library"]);

    // Criando o controller
    $myController = Routes::rota($_GET);
    
    // chama o método do controller a ser executado
    $metodo = $myController->dados['metodo'];

    $myController->$metodo();