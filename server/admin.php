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
$updateName = "";
$updateCategory = "";
$updateStatus = "";
// $updateId = "";
$buttonText = "Insert";
$buttonValue = "insert-btn";
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
        require("my_sql.php");
        require("logging.php");
        require("session.php");
        // $totalpages = $_SESSION["pages"];
        // if (isset($_SESSION["pages"])) {

        //     for ($i = 1; $i <= $_SESSION["pages"]; $i++) {
        //         echo "<button name='page_button' type='submit' value='$i'></button>";
        //     }
        // }
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
                // echo "insert bottom";
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
            } else if (isset($_POST["update-btn-bottom"])) {
                // echo "update bottom";
                $validator = new Validate2();
                $resultName = $validator->proceed($_POST["username"]);
                $resultName == "ok" ? $username_value = $validator->crossScriptingRemoval($_POST["username"]) : $name_error = $resultName;

                $resultPass = $validator->proceed($_POST["password"]);
                $validator->crossScriptingRemoval($_POST["password"]);
                $password_value = $validator->crossScriptingRemoval($_POST["password"]);
                if ($resultPass != "ok") {
                    $password_error = $resultPass;
                }

                $resultStatuses = $validator->dropdown_validity_status($validator->crossScriptingRemoval($_POST["statuses"]));
                if ($resultStatuses != "ok") {
                    $stat_error = $resultStatuses;
                } else {
                    $status_value = $validator->crossScriptingRemoval($_POST["statuses"]);
                }

                $resultCategory = $validator->dropdown_validity_category($validator->crossScriptingRemoval($_POST["categories"]));
                if ($resultCategory != "ok") {
                    $category_error = $resultCategory;
                } else {
                    $category_value = $validator->crossScriptingRemoval($_POST["categories"]);
                    echo $_POST["categories"];
                }

                if ($resultName == ($resultCategory == ($resultStatuses == ($resultPass == "ok")))) {
                    if ($crud->create_instance() == "ok") {
                        $result = $crud->updateRecord($_SESSION["updateId"], $username_value, $password_value, $category_value, $status_value);
                        $db_error = $result;
                    }
                }
                $updateName = "";
                $updateCategory = "";
                $updateStatus = "";
                $buttonText = "Insert";
                $buttonValue = "insert-btn";
            } else if (isset($_POST["logout-btn"])) {
                unset($_SESSION["userObj"]);
                $_SESSION['show_hello_message'] = 'logout';
                header("Location: login.php");
            } else if (isset($_POST["page_button"])) {
                if($_POST["page_button"]<1){
                    $_POST["page_button"]=1;
                }else if($_POST["page_button"] >$_SESSION["pages"]){
                    $_POST["page_button"]=$_SESSION["pages"];
                }
                $_SESSION["currentPage"] = $_POST["page_button"];
                
             }
        }


        ?>

        <div class="table-container">
            <?php
            if ($crud->create_instance() == "ok") {
                $total = $crud->totalRecords(0);
                if ($total != 0) {
                    $limit = 10;
                    $pages = ceil($total / $limit);
                    $_SESSION["pages"] = $pages;
                    if (isset($_SESSION["currentPage"])) {
                        $current_page = $_SESSION["currentPage"];
                    } else {
                        $current_page = 1;
                    }
                    $offset = ($current_page - 1)  * $limit;
                    // $start = $offset + 1;
                    // $end = min(($offset + $limit), $total);
                    $res = $crud->fetchAllRecordsOfUsers($limit, $offset, 0);

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

                                            <th class="row-head">Name</th>

                                            <th class="row-head">Occupation</th>
                                            <th class="row-head">Account Status</th>
                                            <th class="row-head" colspan="2">Operations</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                                        foreach ($res as $row) {
                                                            echo "<tr class='row'>";
                                                            echo "<td class='cell'>" . $row["userName"] . "</td>";

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
                                            <td class="cell">
                                                <div class="text-box">

                                                    <div class="field-container"><input type="text" name="username" class="fields" placeholder=" Username" value="<?php echo $updateName ?>"></div>
                                                </div>
                                                <span class="error-username errors"><?php echo $name_error ?></span>

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
                                                        <select class='decorated' name='statuses'>
                                                            <?php
                                                                            $statuses = $crud->fetchStatuses();

                                                                            if (is_array($statuses) && count($statuses) > 0) {
                                                                                echo "<option value=''>Select</option>";
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
                                                <div class="text-box">

                                                    <div class="field-container"><input id="pass_field" type="password" name="password" class="fields" placeholder=" Password"></div>
                                                </div>
                                                <span class="error-password errors"><?php echo $password_error  ?></span>

                                            </td>

                                            <td class="cell" colspan="2"> <button name="<?php echo $buttonValue  ?>" class='btn login-btn' type='submit' id='login-btn'><?php echo $buttonText ?></button></td>

                                        </tr>
                                        <tr class="row table-foot">

                                            <td colspan="7" class="cell">
                                                <?php echo $db_error ?>
                                            </td>
                                        </tr>
                                        <tr class='row table-foot'>
                                            <td colspan='7' class="cell pagination-container">
                                                <?php

                                                                $totalpages = $_SESSION["pages"];
                                                                if (isset($_SESSION["pages"])) {

                                                                    for ($i = 1; $i <= $_SESSION["pages"]; $i++) {
                                                                        echo "<button name='page_button' type='submit' value='$i' class='page-btn'>$i</button>";
                                                                    }
                                                                }
                                                                ?>
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



</body>

</html>