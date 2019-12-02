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

    function password_validity($data)
    {
        return strlen($data) < 6 ? "Minimum 6 characters required!" : "ok";
    }
}

class Validate2 extends Validate
{
    function proceed($data)
    {
        return empty($data) ? "Required!" : "ok";
    }

    function password_validity($data)
    {
        parent::password_validity($data);
    }

    function dropdown_validity($data)
    {
        $data === "Select" ? "Required!" : "ok";
    }
}
