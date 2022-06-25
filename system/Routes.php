<?php

class Routes
{
    public static function rota($aPar)
    {
        $aParGet    = (isset($aPar['parametros']) ? $aPar['parametros'] : "Home" );
        $controller = "";
        $metodo     = "index";
        $acao       = "";
        $id         = null;
        $outrosPar  = [];

        if (substr_count($aParGet, "/") > 0) {

            $aParam     = explode("/", $aParGet);
            $controller = $aParam[0];
            $metodo     = $aParam[1];

            // Pega a ação a ser executa e o ID
            if (isset($aParam[2])) {
                if (in_array($aParam[2], ['insert', 'update', 'delete', 'view'])) {
                    $acao   = (isset($aParam[2]) ? $aParam[2] : "");
                    $id     = (isset($aParam[3]) ? $aParam[3] : 0);
                } else {
                    $acao   = (isset($aParam[2]) ? $aParam[2] : "");    
                }
            }

            // Outros parâmetros
            if (isset($aParam[4])) {
                for ($rrr = 4 ; $rrr < count($aParam); $rrr++) {
                    $outrosPar[] = $aParam[$rrr];
                }
            }

            //

        } else {
            $controller = $aParGet;
        }

        // Carrega o controller

        if (!file_exists('app/controller/'. $controller . ".php")) {
            $controller = "Erros";
            $metodo     = "controllerNotFound";
        } 

        // carregando o controller
        require_once 'app/controller/'. $controller . ".php";

        // Verificar se não método existe no controller e direciona para controller error

        if (!method_exists($controller, $metodo)) {
            $controller = "Erros";
            $metodo     = "methodNotFound";
            // carregando o controller
            require_once 'app/controller/'. $controller . ".php";
        }

        return new $controller([
            "controller"        => $controller,
            "metodo"            => $metodo,
            "acao"              => $acao,
            "id"                => $id,
            "outrosParametros"  => $outrosPar,
            "model"             => $controller,
            "get"               => $_GET,
            "post"              => $_POST
        ]);
    }
}