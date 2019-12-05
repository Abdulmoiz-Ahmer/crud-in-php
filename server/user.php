<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
    <script src="../css/vendors/jquery.growl/javascripts/jquery.growl.js" type="text/javascript"></script>
    <link href="../css/vendors/jquery.growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <div class="main-container tab">
        <?php
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        require("my_sql.php");
        require("session.php");


        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        $limit = 10;
        $offset = ($pageno - 1) * $limit;
        $crud = new MySql();

        ?>
        <script type="text/javascript">
            var msg = "<?php echo isset($_SESSION['show_hello_message']) ? $_SESSION['show_hello_message'] : "null" ?>";
            console.log(msg);
            if (msg != "null") {
                $.growl.notice({
                    title: "Success",
                    message: "Hello " + msg
                });
                msg = "<?php echo $_SESSION['show_hello_message'] = 'null'  ?>";
            }
        </script>

        <?php

        if (isset($_POST["logout-btn"])) {
            unset($_SESSION["userObj"]);

            // // session_destroy();
            $_SESSION['show_hello_message'] = 'logout';
            header("Location: login.php");
        }
        ?>
        <div>
            <div>
                <form action="" method="post">
                    <?php require("../html/logoutbtn.html") ?>
                </form>
            </div>
            <div class="table-container">
                <?php
                if ($crud->create_instance() == "ok") {
                    $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $user->getId());
                    if (count($res) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='table-head'>";
                        echo "<tr><th colspan='4' class='row-head'>Colleagues</th></tr>";
                        echo "<tr>";
                        echo "<th class='row-head'>ID</th>";
                        echo "<th class='row-head'>Name</th>";
                        echo "<th class='row-head'>Occupation</th>";
                        echo "<th class='row-head'>Account Status</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($res as $row) {
                            echo "<tr class='row'>";
                            echo "<td class='cell'>" . $row["userId"] . "</td>";
                            echo "<td class='cell'>" . $row["userName"] . "</td>";
                            echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                            echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo " </table>";
                    }
                } else {
                    echo "Something Went Wrong!";
                }
                ?>

            </div>

        </div>
    </div>

</body>

</html>