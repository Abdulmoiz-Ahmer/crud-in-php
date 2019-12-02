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
                        ?>
                        <form action="" method="post">
                            <td class='cell'></td>
                            <td class='cell'>

                                <div class='text-box'>
                                    <div class='field-container'>
                                        <input type='text' name='username' class='fields' placeholder=' Username'>
                                    </div>
                                </div>
                                <span class='error-username errors'>
                                    <?php echo $user_error; ?>
                                </span>
                            </td>

                            <td class='cell'>
                                <div class='text-box'>
                                    <div class='field-container'>
                                        <input type='password' name='password' class='fields' placeholder=' Password'>
                                    </div>
                                </div>

                                <span class='error-password errors'>
                                    <?php echo $password_error; ?>
                                </span>
                            </td>


                            <td class='cell'>
                                <div class='text-box'>
                                    <select class='decorated' name='categories'>
                                        <?php
                                                    $categories = $crud->fetchCategories();

                                                    if (is_array($categories) && count($categories) > 0) {
                                                        foreach ($categories as $category) {
                                                            echo "<option value='" . $category['categoryId'] . "'>" . $category['categoryName'] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value='no-value'>" . "loading!" . "</option>";
                                                    }
                                                    ?>
                                    </select>
                                </div>


                            </td>

                            <td class="cell">
                                <div class='text-box'>
                                    <select class='decorated' name='categories'>
                                        <?php
                                                    $statuses = $crud->fetchStatuses();

                                                    if (is_array($statuses) && count($statuses) > 0) {
                                                        foreach ($statuses as $stat) {
                                                            echo "<option value='" . $stat[' statusId'] . "'>" . $stat['statusValue'] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value='no-value'>" . "loading!" . "</option>";
                                                    }
                                                    ?>
                                    </select></div>
                            </td>
                            
                            <td class='cell' colspan='2'>
                               <button class='btn login-btn' type='submit'>Insert</button>
                            </td>

                        </form>
            <?php
                        echo "</tr>";

                        echo "</tfoot>";
                        echo "</table>";
                    }
                } else {
                    echo $res;
                }
            } else {
                echo "Something Went Wrong!";
            }
            ?>




///////////////changed





