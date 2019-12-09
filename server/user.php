<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
require("my_sql.php");
require("session.php");

if (isset($_POST["logout-btn"])) {
    unset($_SESSION["userObj"]);

    // // session_destroy();
    $_SESSION['show_hello_message'] = 'logout';
    header("Location: login.php");
}

$crud = new MySql();
if ($crud->create_instance() == "ok") {
    $limit = 10;

    $result = $crud->countRecords($user->getCategory(), $user->getId());
    if (is_array($result) && count($result) > 0) {
        $rows = $result[0]["rows"];
        $total_pages = ceil($rows / $limit);
        if (isset($_GET['pageno'])) {
            if ($_GET['pageno'] < 1 || $_GET['pageno'] > $total_pages)
                $pageno = 1;
            else
                $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        $offset = ($pageno - 1) * $limit;

        $res = $crud->retreiveDataFromSimilarCategory($user->getCategory(), $user->getId(), $limit, $offset);

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
                <div>
                    <div>
                        <form action="" method="post">
                            <?php require("../html/logoutbtn.html") ?>
                        </form>
                    </div>
                    <div class="table-container">
                        <?php
                                if (is_array($res) && count($res) > 0) {
                                    ?>
                            <table class='table'>
                                <thead class='table-head'>
                                    <tr>
                                        <th colspan='4' class='row-head'>Colleagues</th>
                                    </tr>
                                    <tr>
                                        <th class='row-head'>Name</th>
                                        <th class='row-head'>Occupation</th>
                                        <th class='row-head'>Account Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                                foreach ($res as $row) { ?>
                                        <tr class='row'>
                                            <td class='cell'><?php echo $row["userName"] ?></td>
                                            <td class='cell'><?php echo $row["categoryName"] ?></td>
                                            <td class='cell'><?php echo $row["statusValue"] ?></td>
                                        </tr>
                                    <?php
                                                } ?>

                                <tfoot>

                                    <td class="cell" colspan="3">
                                        <ul class="pagination">
                                            <li>
                                                <a href="<?php if ($pageno <= 1) {
                                                                            echo "?pageno=" . ($pageno);
                                                                        } else {
                                                                            echo "?pageno=" . ($pageno - 1);
                                                                        } ?>"><?php if ($pageno > 1) {
                                                                                                echo "Prev";
                                                                                            } ?></a>
                                            </li>
                                            <?php
                                                        if ($total_pages > 5) {
                                                            for ($i = $pageno; $i <= $total_pages; $i++) {
                                                                echo "<li><a href='?pageno=$i'>$i</a></li>";
                                                            }
                                                        } else {
                                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                                echo "<li><a href='?pageno=$i'>$i</a></li>";
                                                            }
                                                        }

                                                        ?>
                                            <li>
                                                <a href="<?php if ($pageno >= $total_pages) {
                                                                            echo '?pageno=1';
                                                                        } else {
                                                                            echo "?pageno=" . ($pageno + 1);
                                                                        } ?>"><?php if ($pageno != $total_pages) {
                                                                                                echo "Next";
                                                                                            } ?></a>
                                            </li>
                                        </ul>
                                    </td>



                                </tfoot>
                            </table>
                <?php
                        }
                    }
                } else {
                    echo "Something Went Wrong!";
                }
                ?>

                    </div>

                </div>
            </div>

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
        </body>

        </html>