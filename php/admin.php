<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
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
        if ($user->getType() == 1) {
            header("Location: user.php");
        }
        ?>

        <div class="table-container">
            <?php
            if ($crud->create_instance() == "ok") {


                $res = $crud->allUsersDataForAdmin(0, 10, 0);
                if (is_array($res)) {
                    if (count($res) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='table-head'>";
                        echo "<tr><th colspan='7' class='row-head'>Employees</th></tr>";
                        echo "<tr>";
                        echo "<th class='row-head'>ID</th>";
                        echo "<th class='row-head'>Name</th>";
                        echo "<th class='row-head'>Password</th>";
                        echo "<th class='row-head'>Occupation</th>";
                        echo "<th class='row-head'>Account Status</th>";
                        echo "<th class='row-head' colspan='2'>Operations</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($res as $row) {
                            echo "<tr class='row'>";
                            echo "<td class='cell'>" . $row["userId"] . "</td>";
                            echo "<td class='cell'>" . $row["userName"] . "</td>";
                            echo "<td class='cell'>" . $row["password"] . "</td>";
                            echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                            echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                            echo "<td class='cell'> <button class='btn update-btn btn--ud' value='" . $row["userId"] . "' type='submit'>Update</button></td>";
                            echo "<td class='cell'> <button class='btn delete-btn btn--ud' type='submit' value='" . $row["userId"] . "'>Delete</button></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "<tfoot>";
                        echo "<tr class='row table-foot'>";
                        echo "<td class='cell'></td>";
                        echo "<td class='cell'>" . "<div class='text-box'>
                        <div class='field-container'><input type='text' name='username' class='fields' placeholder=' Username'></div>
                        </div>" . "</td>";
                        echo "<td class='cell'>" .  "<div class='text-box'>
                        <div class='field-container'><input type='password' name='password' class='fields' placeholder=' Password'></div></div>";
                        echo  "</td>";
                        echo "<td class='cell'> <div class='text-box'>" . "<select class='decorated' name='categories'>";

                        $categories = $crud->fetchCategories();

                        if (is_array($categories) && count($categories) > 0) {
                            foreach ($categories as $category) {
                                echo "<option value='" . $category['categoryId'] . "'>" . $category['categoryName'] . "</option>";
                            }
                        } else {
                            echo "<option value='no-value'>" . "loading!" . "</option>";
                        }
                        echo "</select></div>" . "</td>";
                        echo "<td class='cell'><div class='text-box'>" . "<select class='decorated' name='categories'>";

                        $statuses = $crud->fetchStatuses();

                        if (is_array($statuses) && count($statuses) > 0) {
                            foreach ($statuses as $stat) {
                                echo "<option value='" . $stat['statusId'] . "'>" . $stat['statusValue'] . "</option>";
                            }
                        } else {
                            echo "<option value='no-value'>" . "loading!" . "</option>";
                        }
                        echo "</select></div>" . "</td>";
                        echo "<td class='cell'  colspan='2'><button class='btn login-btn' type='submit'>Insert</button></td>";
                        echo "</tr>";
                        echo "</tfoot>";
                        echo " </table>";
                    }
                } else {
                    echo $res;
                }
            } else {
                echo "Something Went Wrong!";
            }
            ?>
        </div>




    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>

</body>

</html>