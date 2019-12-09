<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
require("my_sql.php");
require("logging.php");
require("session.php");



// function scrollToBottom()
// {
// //    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>';
//     echo "<script type='text/javascript'>
// $(document).ready(function() { 
// $(document).scrollTop($(document).height()); 
// });
// </script>";
// }

$name_error = "";
$password_error = "";
$user_error = "";
$category_error = "";
$stat_error = "";
$db_error = "";
$updateName = "";
$updateCategory = "";
$updateStatus = "";
$buttonText = "Insert";
$buttonValue = "insert-btn";

$crud = new MySql();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["delete-btn"])) {
        // echo "triggered " . $_POST["delete-btn"];
        if ($crud->create_instance() == "ok") {
            $result = $crud->deleteRecord($_POST["delete-btn"]);
            $db_error = $result;
        }
    } else if (isset($_POST["update-btn"])) {

        if ($crud->create_instance() == "ok") {
            $result = $crud->searchParticularRecord($_POST["update-btn"], 0);
            if (is_array($result) && count($result) > 0) {
                $updateName = $result[0]["userName"];
                $updateCategory = $result[0]["categoryId"];
                $updateStatus = $result[0]["statusId"];
                $buttonText = "Update";
                $buttonValue = "update-btn-bottom";
                // $updateId = $result[0]["userId"];
                $_SESSION["updateId"] = $result[0]["userId"];

                // echo "updateIdHere:" . $updateId;
            }
            // var_dump($result);
            // var_dump($_POST["update-btn"]);
            // $db_error = $result;
        }
    } else if (isset($_POST["insert-btn"])) {
        // echo "insert bottom";

        $validator = new Validate2();
        $resultName = $validator->proceed($_POST["username"]);

        if (($resultName = $validator->proceed($_POST["username"])) == "ok" && ($resultName = $validator->name_validity($validator->crossScriptingRemoval($_POST["username"]))) == "ok") {
            $username_value = $validator->crossScriptingRemoval($_POST["username"]);
        } else {
            $name_error = $resultName;
        }

        if (($resultPass = $validator->proceed($_POST["password"])) == "ok"  && ($resultPass = $validator->password_validity($validator->crossScriptingRemoval($_POST["password"]))) == "ok") {
            $password_value = $validator->crossScriptingRemoval($_POST["password"]);
        } else {
            $password_error = $resultPass;
        }

        if (($resultCategory = $validator->proceed($_POST["categories"])) == "ok" && ($resultCategory = $validator->dropdown_validity_category($validator->crossScriptingRemoval($_POST["categories"]))) == "ok") {
            $category_value = $validator->crossScriptingRemoval($_POST["categories"]);
        } else {
            $category_error = $resultCategory;
        }

        if (($resultStatuses = $validator->proceed($_POST["statuses"])) == "ok" && ($resultStatuses = $validator->dropdown_validity_status($validator->crossScriptingRemoval($_POST["statuses"]), false)) == "ok") {
            $status_value = $validator->crossScriptingRemoval($_POST["statuses"]);
            // echo "here";
        } else {
            // echo "hereeee";
            $stat_error = $resultStatuses;
        }
        // echo "status" . $_POST["statuses"] . "emptymsg" . $validator->proceed($_POST["statuses"]);

        if ($resultName == "ok" && $resultCategory == "ok" && $resultStatuses == "ok" && $resultPass == "ok") {
            if ($crud->create_instance() == "ok") {
                $result = $crud->insertRecord($username_value, $password_value, $category_value, $status_value);
                $db_error = $result;
            }
        }
        // scrollToBottom();
    } else if (isset($_POST["update-btn-bottom"])) {
        // echo "update bottom";
        $validator = new Validate2();
        $resultName = $validator->proceed($_POST["username"]);

        if (($resultName = $validator->proceed($_POST["username"])) == "ok" && ($resultName = $validator->name_validity($validator->crossScriptingRemoval($_POST["username"]))) == "ok") {
            $username_value = $validator->crossScriptingRemoval($_POST["username"]);
        } else {
            $name_error = $resultName;
        }

        if (($resultCategory = $validator->proceed($_POST["categories"])) == "ok" && ($resultCategory = $validator->dropdown_validity_category($validator->crossScriptingRemoval($_POST["categories"]))) == "ok") {
            $category_value = $validator->crossScriptingRemoval($_POST["categories"]);
        } else {
            $category_error = $resultCategory;
        }

        if (($resultStatuses = $validator->proceed($_POST["statuses"])) == "ok" && ($resultStatuses = $validator->dropdown_validity_status($validator->crossScriptingRemoval($_POST["statuses"]), false)) == "ok") {
            $status_value = $validator->crossScriptingRemoval($_POST["statuses"]);
        } else {
            $stat_error = $resultStatuses;
        }

        if ($resultName == "ok" && $resultCategory == "ok" && $resultStatuses == "ok") {
            if ($crud->create_instance() == "ok") {
                $result = $crud->updateRecord($_SESSION["updateId"], $username_value, $category_value, $status_value);
                $db_error = $result;
            }
        }

        $updateName = "";
        $updateCategory = "";
        $updateStatus = "";
        $buttonText = "Insert";
        $buttonValue = "insert-btn";
    } else if (isset($_POST["logout-btn"])) {
        echo "logout";
        unset($_SESSION["userObj"]);
        $_SESSION['show_hello_message'] = 'logout';
        header("Location: login.php");
    }
}
if ($crud->create_instance() == "ok") {
    $total = $crud->totalRecords(0);
    if ($total != 0) {
        $limit = 5;
        $pages = ceil($total / $limit);
        if (isset($_GET['pageno'])) {
            if ($_GET['pageno'] < 1 || $_GET['pageno'] > $pages)
                $current_page = 1;
            else
                $current_page = $_GET['pageno'];
        } else {
            $current_page = 1;
        }
        $offset = ($current_page - 1)  * $limit;
        $res = $crud->fetchAllRecordsOfUsers($limit, $offset, 0);

        if (is_array($res)) {
            if (count($res) > 0) {
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

                        <div class="table-container">

                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?pageno=' . $_GET['pageno'] ?>" method="post" name="admin">

                                <table class="table">
                                    <?php require("../html/logoutbtn.html") ?>
                                    <thead class="table-head">

                                        <tr>
                                            <th class="row-head" colspan='7'>
                                                Employee
                                            </th>
                                        </tr>
                                        <tr>

                                            <th class="row-head">Name</th>
                                            <th class="row-head">Occupation</th>
                                            <th class="row-head">Account Status</th>
                                            <th class="row-head" colspan="2">Operations</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                                        foreach ($res as $row) { ?>

                                            <tr class='row'>
                                                <td class='cell'><?php echo $row["userName"] ?> </td>
                                                <td class='cell'><?php echo $row["categoryName"] ?></td>
                                                <td class='cell'><?php echo  $row["statusValue"] ?></td>
                                                <?php
                                                                    if ($row["statusValue"] == "Active") {
                                                                        ?>
                                                    <td class='cell'> <button name='update-btn' class='btn update-btn btn--ud' value='<?php echo $row["userId"] ?>' type='submit'>Update</button></td>
                                                    <td class='cell'> <button name='delete-btn' onClick='return confirm("Are you sure you want to delete?")' class='btn delete-btn btn--ud' type='submit' value='<?php echo $row["userId"] ?>'>Delete</button></td>
                                                <?php
                                                                    } else if ($row["statusValue"] == "Inactive") { ?>
                                                    <td class='cell'> <button name='update-btn' class='btn update-btn btn--ud' value='<?php $row["userId"] ?>' type='submit'>Update</button></td>
                                                    <td class='cell' style=' text-decoration:  line-through;'>delete</td>
                                                <?php     } else { ?>
                                                    <td class='cell' style=' text-decoration:  line-through;'>update</td>
                                                    <td class='cell' style=' text-decoration:  line-through;'>delete</td>
                                                <?php
                                                                    } ?>
                                            </tr>
                                        <?php
                                                        }

                                                        ?>

                                    </tbody>
                                    <tfoot>

                                        <tr class="row table-foot" id="bottom">
                                            <td class="cell">
                                                <div class="text-box">

                                                    <div class="field-container"><input id="username" type="text" name="username" class="fields" placeholder=" Username" value="<?php echo $updateName ?>"></div>
                                                </div>
                                                <span class="error-username errors"><?php echo $name_error ?></span>

                                            </td>


                                            <td class="cell">
                                                <div class="text-box">

                                                    <div class="field-container">
                                                        <select class='decorated' name='categories' id="category-select">
                                                            <?php
                                                                            $categories = $crud->fetchCategories();

                                                                            if (is_array($categories) && count($categories) > 0) {
                                                                                ?>
                                                                <option value='' disabled="disabled">Select</option>
                                                            <?php
                                                                                foreach ($categories as $category) {
                                                                                    if ($updateCategory == $category['categoryId']) {
                                                                                        echo "<option selected='true' value='" . $category['categoryId'] . "'>" . $category['categoryName'] . "</option>";
                                                                                    } else {
                                                                                        echo "<option value='" . $category['categoryId'] . "'>" . $category['categoryName'] . "</option>";
                                                                                    }
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
                                                        <select class='decorated' name='statuses' id="status-select">
                                                            <?php
                                                                            $statuses = $crud->fetchStatuses();

                                                                            if (is_array($statuses) && count($statuses) > 0) {
                                                                                ?>
                                                                <option value='' disabled="disabled">Select</option>
                                                            <?php
                                                                                foreach ($statuses as $stat) {
                                                                                    if ($updateStatus == $stat['statusId']) {
                                                                                        echo "<option selected='true' value='" . $stat['statusId'] . "'>" . $stat['statusValue'] . "</option>";
                                                                                    } else  if ($updateStatus == "") {

                                                                                        if ($stat['statusValue'] != "Delete") {
                                                                                            echo "<option value='" . $stat['statusId'] . "'>" . $stat['statusValue'] . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        echo "<option value='" . $stat['statusId'] . "'>" . $stat['statusValue'] . "</option>";
                                                                                    }
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


                                            <td class="cell">

                                                <?php
                                                                if ($buttonText == "Insert") {
                                                                    ?>

                                                    <div class="text-box">

                                                        <div class="field-container"><input id="pass_field" type="password" name="password" class="fields" placeholder=" Password"></div>
                                                    </div>
                                                    <span class="error-password errors"><?php $password_error ?></span>
                                                <?php
                                                                } else if ($buttonText == "Update") {
                                                                    ?>
                                                    <button name='cancel-btn' class='btn delete-btn btn--ud' type='submit' id='cancel-btn'>Cancel</button>
                                                <?php
                                                                }
                                                                ?>
                                            </td>

                                            <td class="cell" colspan="2"> <button name="<?php echo $buttonValue  ?>" class='btn login-btn' type='submit' id='login-btn'><?php echo $buttonText ?></button></td>

                                        </tr>
                                        <tr class="row table-foot">

                                            <td colspan="7" class="cell">
                                                <?php echo $db_error ?>
                                            </td>
                                        </tr>

                                        <tr class="row table-foot">
                                            <td class="cell" colspan="5">
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="<?php if ($current_page <= 1) {
                                                                                        echo "?pageno=" . ($current_page);
                                                                                    } else {
                                                                                        echo "?pageno=" . ($current_page - 1);
                                                                                    } ?>"><?php if ($current_page > 1) {
                                                                                                                echo "Prev";
                                                                                                            } ?></a>
                                                    </li>
                                                    <?php
                                                                    if ($pages > 5) {
                                                                        if ($current_page + 5 > $pages) {
                                                                            $j = $pages;
                                                                        } else {
                                                                            $j = $current_page + 4;
                                                                        }

                                                                        for ($i = $current_page; $i <= $j; $i++) {
                                                                            echo "<li><a href='?pageno=$i'>$i</a></li>";
                                                                        }
                                                                    } else {
                                                                        for ($i = 1; $i <= $pages; $i++) {
                                                                            echo "<li><a href='?pageno=$i'>$i</a></li>";
                                                                        }
                                                                    }

                                                                    ?>
                                                    <li>
                                                        <a href="<?php if ($current_page >= $pages) {
                                                                                        echo '?pageno=1';
                                                                                    } else {
                                                                                        echo "?pageno=" . ($current_page + 1);
                                                                                    } ?>"><?php if ($current_page != $pages) {
                                                                                                                echo "Next";
                                                                                                            } ?></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </form>

            <?php
                        }
                    }
                }
            }
            ?>

                        </div>



                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>

                        <script src="../scripts/admin.js"></script>

                        <script type="text/javascript">
                            var msg = "<?php echo isset($_SESSION['show_hello_message']) ? $_SESSION['show_hello_message'] : "null" ?>";
                            // console.log(msg);
                            if (msg != "null") {
                                $.growl.notice({
                                    title: "Success",
                                    message: "Hello " + msg
                                });
                                msg = "<?php echo $_SESSION['show_hello_message'] = 'null'  ?>";
                            }
                        </script>


                </body>

                </html>