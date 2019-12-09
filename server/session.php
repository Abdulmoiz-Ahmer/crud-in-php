<?php

if (isset($_SESSION["userObj"])) {
    $user = unserialize($_SESSION["userObj"]);
    if ($user->getType() == 1 && basename($_SERVER['PHP_SELF']) != "user.php") {
        header("Location: user.php?pageno=1");
    } else if ($user->getType() == 0 && (basename($_SERVER['PHP_SELF']) == "user.php" || basename($_SERVER['PHP_SELF']) == "login.php")) {
        header("Location: admin.php?pageno=1");
    }
} else if (basename($_SERVER['PHP_SELF']) != "login.php") {
    header("Location: login.php");
}
