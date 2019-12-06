<?php
require("session.php");
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

    function name_validity($data)
    {
        if (preg_match("/[^a-zA-Z]/", $data)) {
            return "Please insert a valid name!";
        } else {
            return "ok";
        }
    }

    function password_validity($data)
    {
        if (strlen($data) >= 6 && preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/", $data)) {
            return "ok";
        } else {
            return "Please insert a valid password!";
        }
    }
}

class Validate2 extends Validate
{
    function proceed2($data)
    {
        return empty($data) ? "Required!" : "ok";
    }
    function password_validity($data)
    {
        parent::password_validity($data);
    }

    function dropdown_validity_category($data)
    {
        if (!is_numeric($data))
            return "Required!";
        else if ($data >= 4 && $data <= 14)
            return "ok";
        else
            return "Required!";
    }


    function dropdown_validity_status($data)
    {
        if (!is_numeric($data))
            return "Required!";
        else if ($data >= 0 && $data <= 2)
            return "ok";

        else
            return "Required!";
    }
}
