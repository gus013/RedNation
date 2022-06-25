<?php

namespace App\Library;

class Session
{
    /**
     * set - Seta um valor para sessão
     *
     * @param string $key 
     * @param mixed $value 
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get - Recupera o valor de uma sessão indicada em $key
     *
     * @param string $key 
     * @return void
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    /**
     * destroy - exclui uma sessão indicada na chave $key
     *
     * @param string $key 
     * @return void
     */
    public static function destroy($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * getDestroy - Recupera, exclui e retorna os dados de uma sessão
     *
     * @param string $key 
     * @return void
     */
    public static function getDestroy($key)
    {
        $ret = Session::get($key);
        Session::destroy($key);

        return $ret;
    }
}