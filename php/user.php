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
    <link href="../css/vendors/fontawesome-free-5.11.2-web/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <div class="main-container">
        <?php
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        include("MySql.php");
        $user = unserialize($_SESSION["userObj"]);
        // $user->setCategory(($user->getSubCategory())[0]);
        $crud = new MySql();
        ?>

        <div class="table-container">
          
            <table class="table">

                <tbody>
                    <?php
                    if ($crud->create_instance() == "ok") {
                        $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 0, $user->getId());
                        if (count($res) > 0) {
                            echo " <thead class='table-head'>";
                            echo "<tr><th colspan='4'>Active Colleagues</th></tr>";
                            echo "<tr>";
                            echo "<th class='row-head'>ID</th>";
                            echo "<th class='row-head'>Name</th>";
                            echo "<th class='row-head'>Occupation</th>";
                            echo "<th class='row-head'>Account Status</th>";
                            echo "</tr>";
                            echo "</thead>";
                            foreach ($res as $row) {
                                echo "<tr class='row'>";
                                echo "<td class='cell'>" . $row["userId"] . "</td>";
                                echo "<td class='cell'>" . $row["userName"] . "</td>";
                                echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                                echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "Something Went Wrong!";
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <div class="table-container">
            <table class="table">

                <tbody>
                    <?php
                    if ($crud->create_instance() == "ok") {
                        $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 1, $user->getId());
                        if (count($res) > 0) {
                            echo " <thead class='table-head'>";
                            echo "<tr>";
                            echo "<th class='row-head'>ID</th>";
                            echo "<th class='row-head'>Name</th>";
                            echo "<th class='row-head'>Occupation</th>";
                            echo "<th class='row-head'>Account Status</th>";
                            echo "</tr>";
                            echo "</thead>";
                            foreach ($res as $row) {
                                echo "<tr class='row'>";
                                echo "<td class='cell'>" . $row["userId"] . "</td>";
                                echo "<td class='cell'>" . $row["userName"] . "</td>";
                                echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                                echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "Something Went Wrong!";
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <div class="table-container">
            <table class="table">

                <tbody>
                    <?php
                    if ($crud->create_instance() == "ok") {
                        $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $status = 2, $user->getId());
                        if (count($res) > 0) {
                            echo " <thead class='table-head'>";
                            echo "<tr>";
                            echo "<th class='row-head'>ID</th>";
                            echo "<th class='row-head'>Name</th>";
                            echo "<th class='row-head'>Occupation</th>";
                            echo "<th class='row-head'>Account Status</th>";
                            echo "</tr>";
                            echo "</thead>";
                            foreach ($res as $row) {
                                echo "<tr class='row'>";
                                echo "<td class='cell'>" . $row["userId"] . "</td>";
                                echo "<td class='cell'>" . $row["userName"] . "</td>";
                                echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                                echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "Something Went Wrong!";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    <script src="../scripts/login.js"></script>
</body>

</html>