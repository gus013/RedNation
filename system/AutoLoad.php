<?php

class AutoLoad
{
    public function library($className)
    {
        $className  = ltrim($className, '\\');
        $fileName   = '';
        $nameSpace  = '';

        if ($lastNsPos = strpos($className, '\\')) {
            $nameSpace  = substr($className, 0, $lastNsPos);
            $className  = substr($className , $lastNsPos + 1);
            $fileName   = str_replace('\\', DS, $nameSpace) . DS;
        }

        $fileName = 'app' . DS . str_replace("_", DS, $className) . '.php';
        require_once $fileName;
    }
}