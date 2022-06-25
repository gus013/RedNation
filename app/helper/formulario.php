<?php
    /**
     * setValue
     *
     * @param string $key 
     * @param array $dados 
     * @param mixed $default 
     * @return mixed
     */
    function setValue($key, $dados = [], $default = "")
    {
        if (isset($dados[$key])) {
            return $dados[$key];
        } else {
            return $default;
        }
    }

    /**
     * setDisable
     *
     * @param string $action 
     * @return string
     */
    function setDisable($action)
    {
        return $action === 'view' || $action === 'delete' ? 'disabled' : '';
    }

    /**
     * setSelected
     *
     * @param mixed $value 
     * @param mixed $option 
     * @return string
     */
    function setSelected($value, $option)
    {
        return $value == $option ? 'selected' : '';
    }