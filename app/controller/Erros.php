<?php

use App\Library\ControllerMain;

class Erros extends ControllerMain
{
    public function controllerNotFound()
    {
        echo "Controller não Localizado.";
    }

    public function methodNotFound()
    {
        echo "Método não Localizado no controller.";
    }
}