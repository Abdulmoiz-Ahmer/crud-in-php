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
                    // if (isset($_GET['pageno'])) {
                    //     $pageno = $_GET['pageno'];
                    // } else {
                    //     $pageno = 1;
                    // }
                    $limit = 10;

                    $result = $crud->countRecords($user->getCategory(), $user->getId());
                    if (is_array($result) && count($result) > 0) {
                        $rows = $result[0]["rows"];
                        $total_pages = ceil($rows / $limit);
                        if (isset($_GET['pageno'])) {
                            if ($_GET['pageno'] < 1)
                                $pageno = 1;
                            else if ($_GET['pageno'] > $total_pages)
                                $pageno = $total_pages;
                            else
                                $pageno = $_GET['pageno'];
                        } else {
                            $pageno = 1;
                        }

                        $offset = ($pageno - 1) * $limit;

                        $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $user->getId(), $limit, $offset);
                        if (is_array($res) && count($res) > 0) {
                            echo "<table class='table'>";
                            echo "<thead class='table-head'>";
                            echo "<tr><th colspan='4' class='row-head'>Colleagues</th></tr>";
                            echo "<tr>";
                            echo "<th class='row-head'>Name</th>";
                            echo "<th class='row-head'>Occupation</th>";
                            echo "<th class='row-head'>Account Status</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($res as $row) {
                                echo "<tr class='row'>";
                                echo "<td class='cell'>" . $row["userName"] . "</td>";
                                echo "<td class='cell'>" . $row["categoryName"] . "</td>";
                                echo "<td class='cell'>" . $row["statusValue"] . "</td>";
                                echo "</tr>";
                            }
                            echo "</body>";
                            echo "<tfoot>";

                            ?>
                            <td class="cell" colspan="3">
                                <ul class="pagination">
                                    <li class="<?php if ($pageno <= 1) {
                                                                echo 'disabled';
                                                            } ?>">
                                        <a href="<?php if ($pageno <= 1) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?pageno=" . ($pageno - 1);
                                                                } ?>">Prev</a>
                                    </li>
                                    <?php
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    echo "<li><a href='?pageno=$i'>$i</a></li>";
                                                }
                                                ?>
                                    <li class="<?php if ($pageno >= $total_pages) {
                                                                echo 'disabled';
                                                            } ?>">
                                        <a href="<?php if ($pageno >= $total_pages) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?pageno=" . ($pageno + 1);
                                                                } ?>">Next</a>
                                    </li>
                                </ul>
                            </td>

                <?php

                            echo "</tfoot>";
                            echo " </table>";
                        }
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