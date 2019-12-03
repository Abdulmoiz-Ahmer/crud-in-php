<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
session_start();
$name_error = "";
$password_error = "";
$user_error = "";
$category_error = "";
$stat_error = "";
$db_error = "";
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
    <div class="main-container">

        <?php
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        require("MySql.php");
        require("logging.php");
        if (isset($_SESSION["userObj"])) {
            $user = unserialize($_SESSION["userObj"]);
            if ($user->getType() == 1) {
                header("Location: user.php");
            }
        } else {
            header("Location: login.php");
        }
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
        $crud = new MySql();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST["insert-btn"])) {
                $validator = new Validate2();
                $resultName = $validator->proceed($_POST["username"]);
                $resultName == "ok" ? $username_value = $validator->crossScriptingRemoval($_POST["username"]) : $name_error = $resultName;
                $resultCategory = $validator->dropdown_validity_category($validator->crossScriptingRemoval($_POST["categories"]));
                if ($resultCategory != "ok") {
                    $category_error = $resultCategory;
                } else {
                    $category_value = $validator->crossScriptingRemoval($_POST["categories"]);
                }


                $resultStatuses = $validator->dropdown_validity_status($validator->crossScriptingRemoval($_POST["statuses"]));
                if ($resultStatuses != "ok") {
                    $stat_error = $resultStatuses;
                } else {
                    $status_value = $validator->crossScriptingRemoval($_POST["statuses"]);
                }


                $resultPass = $validator->proceed($_POST["password"]);
                $validator->crossScriptingRemoval($_POST["password"]);
                $password_value = $validator->crossScriptingRemoval($_POST["password"]);
                if ($resultPass != "ok") {
                    $password_error = $resultPass;
                }

                if ($resultName == ($resultCategory == ($resultStatuses == ($resultPass == "ok")))) {
                    if ($crud->create_instance() == "ok") {
                        $result = $crud->insertRecord($username_value, $password_value, $category_value, $status_value);
                        $db_error = $result;
                    }
                }
            } else if (isset($_POST["delete-btn"])) {
                if ($crud->create_instance() == "ok") {
                    $result = $crud->deleteRecord($_POST["delete-btn"]);
                    $db_error = $result;
                }
            } else if (isset($_POST["update-btn"])) {
                echo "update clicked";
            } else if (isset($_POST["logout-btn"])) {
                unset($_SESSION["userObj"]);
                // session_destroy();
                $_SESSION['show_hello_message'] = 'logout';
                header("Location: login.php");
            }
        }


        ?>

        <div class="table-container">
            <?php
            if ($crud->create_instance() == "ok") {
                $res = $crud->allUsersDataForAdmin(0, 10, 0);
                if (is_array($res)) {
                    if (count($res) > 0) {

                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" name="admin">



                            <table class="table">
                                <thead class="table-head">

                                    <tr>
                                        <th class="row-head" colspan='7'>
                                            <table style="width:100%">
                                                <tr>
                                                    <td> Employees</td>
                                                    <td><button name='logout-btn' class='btn logout-btn' value='' type='submit'>Log Out</button></td>
                                                </tr>
                                            </table>


                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="row-head">ID</th>
                                        <th class="row-head">Name</th>
                                        <th class="row-head">Password</th>
                                        <th class="row-head">Occupation</th>
                                        <th class="row-head">Account Status</th>
                                        <th class="row-head" colspan="2">Operations</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                                foreach ($res as $row) {
                                                    echo "<tr class='row'>";
                                                    echo "<td class='cell'>" . $row["userId"] . "</td>";
                                                    echo "<td class='cell'>" . $row["userName"] . "</td>";
                                                    echo "<td class='cell'>" . $row["password"] . "</td>";
                                                    echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                                                    echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                                                    echo "<td class='cell'> <button name='update-btn' class='btn update-btn btn--ud' value='" . $row["userId"] . "' type='submit'>Update</button></td>";
                                                    echo "<td class='cell'> <button name='delete-btn' class='btn delete-btn btn--ud' type='submit' value='" . $row["userId"] . "'>Delete</button></td>";
                                                    echo "</tr>";
                                                }

                                                ?>

                                </tbody>
                                <tfoot>

                                    <tr class="row table-foot">
                                        <td class="cell"></td>
                                        <td class="cell">
                                            <div class="text-box">

                                                <div class="field-container"><input type="text" name="username" class="fields" placeholder=" Username"></div>
                                            </div>
                                            <span class="error-username errors"><?php echo $name_error ?></span>

                                        </td>
                                        <td class="cell">
                                            <div class="text-box">

                                                <div class="field-container"><input id="pass_field" type="password" name="password" class="fields" placeholder=" Password"></div>
                                            </div>
                                            <span class="error-password errors"><?php echo $password_error  ?></span>

                                        </td>

                                        <td class="cell">
                                            <div class="text-box">

                                                <div class="field-container">
                                                    <select class='decorated' name='categories'>
                                                        <?php
                                                                    $categories = $crud->fetchCategories();

                                                                    if (is_array($categories) && count($categories) > 0) {
                                                                        echo "<option value=''>Select</option>";
                                                                        foreach ($categories as $category) {
                                                                            echo "<option value='" . $category['categoryId'] . "'>" . $category['categoryName'] . "</option>";
                                                                        }
                                                                    } else {
                                                                        echo "<option value='no-value'>" . "loading!" . "</option>";
                                                                    }
                                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="error-category errors"><?php echo $category_error  ?></span>
                                        </td>
                                        <td class="cell">
                                            <div class="text-box">

                                                <div class="field-container">
                                                    <select class='decorated' name='statuses'>
                                                        <?php
                                                                    $statuses = $crud->fetchStatuses();

                                                                    if (is_array($statuses) && count($statuses) > 0) {
                                                                        echo "<option value=''>Select</option>";
                                                                        foreach ($statuses as $stat) {
                                                                            echo "<option value='" . $stat['statusId'] . "'>" . $stat['statusValue'] . "</option>";
                                                                        }
                                                                    } else {
                                                                        echo "<option value='no-value'>" . "loading!" . "</option>";
                                                                    }
                                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="error-status errors"><?php echo $stat_error  ?></span>
                                        </td>

                                        <td class="cell" colspan="2"> <button name="insert-btn" class='btn login-btn' type='submit' id="login-btn">Insert</button></td>

                                    </tr>
                                    <tr class="row table-foot">

                                        <td colspan="7" class="cell">
                                            <?php echo $db_error ?>
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                        </form>

            <?php
                    }
                }
            }
            ?>

        </div>





        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>

        <script src="../scripts/admin.js"></script>



</body>

</html>