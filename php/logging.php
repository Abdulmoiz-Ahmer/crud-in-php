<?php

class Validate
{
    function crossScriptingRemoval($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function proceed($data)
    {
        return empty($data) ? "This field is required!" : "ok";
    }

    function password_validity($data){
        return strlen($data)<6?"Minimum 6 characters required!":"ok";
    }
}

?>