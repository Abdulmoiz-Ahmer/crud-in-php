<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
require("my_sql.php");
require("logging.php");
require("session.php");
$crud = new MySql();
$name_error = "";
$password_error = "";
$user_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new Validate();
    // $resultName = $validator->proceed($_POST["username"]);
    // $resultName == "ok" ? $username_value = $validator->crossScriptingRemoval($_POST["username"]) : $name_error = $resultName;

    if (($resultName = $validator->proceed($_POST["username"])) == "ok" && ($resultName = $validator->name_validity($validator->crossScriptingRemoval($_POST["username"]))) == "ok") {
        $username_value = $validator->crossScriptingRemoval($_POST["username"]);
    } else {
        $name_error = $resultName;
    }

    // if (($resultPass = $validator->proceed($_POST["password"])) == "ok" && ($resultPass = $validator->password_validity($validator->crossScriptingRemoval($_POST["password"]))) == "ok") {
    //     $resultPass = $validator->crossScriptingRemoval($_POST["password"]);
    //     echo $resultPass;
    // } else {
    //     echo $resultPass;

    //     $password_error = $resultPass;
    // };
    // echo $validator->password_validity($_POST["password"]);
    if (($resultPass = $validator->proceed($_POST["password"])) == "ok"  && ($resultPass = $validator->password_validity($validator->crossScriptingRemoval($_POST["password"]))) == "ok") {
        $password_value = $validator->crossScriptingRemoval($_POST["password"]);
    } else {
        $password_error = $resultPass;
    }
    // echo $resultName ." ".$resultPass;

    if ($resultPass == "ok" && $resultName == "ok") {

        $crud = new Mysql();
        if ($crud->create_instance() == "ok") {
            $res = $crud->login($username_value, $password_value);
            if ($res instanceof UserObj) {
                if ($res->getStatus() == 3) {

                    $_SESSION["userObj"] =  serialize($res);
                    $_SESSION["show_hello_message"] = $username_value;
                    $res->getType() == 0 ? header("Location: admin.php") : header("Location: user.php");
                } else if ($res->getStatus() == 1) {
                    $user_error = "Contact Admin: Account Suspended!";
                } else {
                    $user_error = "Contact Admin: Account Inactive!";
                }
            } else if (is_array($res) && count($res) < 1) {
                $user_error = "Either username or password is incorrect!";
            }
        } else {
            echo "Something Went Wrong!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap" rel="stylesheet">
    <link href="../css/vendors/fontawesome-free-5.11.2-web/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
    <script src="../css/vendors/jquery.growl/javascripts/jquery.growl.js" type="text/javascript"></script>
    <link href="../css/vendors/jquery.growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/main.css">

</head>

<body>
    <div class="container">
        <div class="container__form">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" name="login">
                <div class="text-box">
                    <div class="icons-container"> <i class="fas fa-user icon"></i></div>
                    <div class="field-container"><input type="text" name="username" id="username" class="fields" placeholder=" Username"></div>
                </div>
                <span class="error-username errors"><?php echo $name_error ?></span>
                <div class="text-box">
                    <div class="icons-container"> <i class="fas fa-lock icon"></i></div>
                    <div class="field-container"><input type="password" name="password" id="password" class="fields" placeholder=" Password"></div>
                </div>
                <span class="error-password errors"><?php echo $password_error  ?></span>
                <div>
                    <button class="btn login-btn" id="login-btn" type="submit">Login</button>
                </div>
                <span class="error-user errors error--custom"><?php echo $user_error ?></span>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    <script src="../scripts/login.js"></script>
    <script type="text/javascript">
        var msg = "<?php echo isset($_SESSION['show_hello_message']) ? $_SESSION['show_hello_message'] : "null" ?>";
        console.log(msg);
        if (msg == 'logout') {
            $.growl.warning({
                title: "Logged Out",
                message: "Hope to see you again!"
            });
            msg = "<?php echo $_SESSION['show_hello_message'] = 'null'  ?>";
        }
    </script>
</body>

</html>