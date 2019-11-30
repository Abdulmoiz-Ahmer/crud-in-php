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
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <div class="main-container">
        <?php
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        include("MySql.php");
        $user = unserialize($_SESSION["userObj"]);
        $crud = new MySql();
        if($user->getType()==0){
            header("Location: admin.php");
        }
        ?>

        <div class="table-container">
            <?php
            if ($crud->create_instance() == "ok") {
                $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 0, $user->getId());
                if (count($res) > 0) {
                    echo "<table class='table'>";
                    echo "<thead class='table-head'>";
                    echo "<tr><th colspan='4' class='row-head'>Active Colleagues</th></tr>";
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

        <div class="table-container">

            <?php
            if ($crud->create_instance() == "ok") {
                $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 1, $user->getId());
                if (count($res) > 0) {
                    echo "<table class='table'>";
                    echo "<thead class='table-head'>";
                    echo "<tr><th colspan='4' class='row-head'>Deleted Colleagues</th></tr>";
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

        <div class="table-container">
            <?php
            if ($crud->create_instance() == "ok") {
                $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 2, $user->getId());
                if (count($res) > 0) {
                    echo "<table class='table'>";
                    echo "<thead class='table-head'>";
                    echo "<tr><th colspan='4' class='row-head'>Inactive Colleagues</th></tr>";
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

</body>

</html>