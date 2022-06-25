<?php

// constante que define a base URL
define("SITEURL", "http://{$_SERVER['HTTP_HOST']}/");

// Constantes utilizadas no AutoLoad
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", __FILE__);

// Definir as constants de conexão com a base de dados
define("DB_DRIVE"   , 'mysql');
define('DB_HOST'    , 'localhost');
define('DB_PORT'    , '3306');
define('DB_USER'    , 'root');
define('DB_PASSWORD', '');
define("DB_BDADOS"  , 'rednation');

// Controller base
define("CONTROLLERBASE", "Home");

// Controllers não autenticados
define("CONTROLLER_SEM_AUTENTICACAO", ['Home', 'Login']); 