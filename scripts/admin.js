// jQuery.validator.addMethod("CheckPassword", function (value, element) {
//     var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
//     if (value.match(passw)) {
//         return true;
//     }
//     else {
//         return false;
//     }
// }, "One uppercase, One lowercase and a no is required!");

// jQuery.validator.addMethod("CheckName", function (value, element) {
//     var regex = /[^a-zA-Z]/;
//     if (value.match(regex)) {
//         return false;
//     }
//     else {
//         return true;
//     }
// }, 'Please enter a valid name.');


$(

    function () {

        $("#pass_field").keyup(function (e) {
            if (!checkPasswordValidity(e.target.value))
                $(".error-password").text("Please insert a valid password!");
            else
                $(".error-password").text("");

        });

        $("#username").keyup(function (e) {
            if (e.target.value == "" || (!checkNameValidity(e.target.value)))
                $(".error-username").text("Please insert a valid name!");
            else
                $(".error-username").text("");
        });

        $("#category-select").change(function (e) {
            if ($(this).children("option:selected").val() != '') {

                if ($(this).children("option:selected").val() >= 3 && $(this).children("option:selected").val() <= 14) {
                    $(".error-category ").text("");
                } else {
                    $(".error-category").text("Please select a valid option");
                }

            } else {
                $(".error-category").text("Please select a valid option");
            }
        });

        $("#status-select").change(function (e) {
            if ($(this).children("option:selected").val() != '') {
                if ($("#login-btn").text() == "Insert") {
                    if ($(this).children("option:selected").val() != 0 && $(this).children("option:selected").val() != 2) {
                        $(".error-status").text("Please select a valid option");
                    } else {
                        $(".error-status").text("");
                    }
                } else if ($("#login-btn").text() == "Update") {
                    if ($(this).children("option:selected").val() >= 0 && $(this).children("option:selected").val() <= 2) {
                        $(".error-status").text("");
                    } else {
                        $(".error-status").text("Please select a valid option");
                    }
                }
            } else {
                $(".error-status").text("Please select a valid option");
            }
        });

        $("#login-btn").click(function (e) {
            e.preventDefault();
            console.log($("#status-select").find(":selected").val());

            if ($("#username").val() == "" || (!checkNameValidity($("#username").val())))
                $(".error-username").text("Please insert a valid name!");
            else {
                if ($("#category-select").val() == '') {
                    $(".error-category").text("Please select a valid option");
                } else {
                    if ($("#category-select").val() >= 3 && $("#category-select").val() <= 14) {
                        $(".error-category ").text("");

                        if ($("#status-select").val() != '') {
                            if ($("#login-btn").text() == "Insert") {
                                if ($("#status-select").val() != 0 && $("#status-select").val() != 2) {
                                    $(".error-status").text("Please select a valid option");
                                } else {
                                    $(".error-status").text("");
                                    password_checking();
                                }
                            } else if ($("#login-btn").text() == "Update") {
                                if ($("#status-select").val() >= 0 && $("#status-select").val() <= 2) {
                                    $(".error-status").text("");
                                    $("form[name='admin']").submit();

                                    // password_checking();
                                } else {
                                    $(".error-status").text("Please select a valid option");
                                }
                            }
                        } else {
                            $(".error-status").text("Please select a valid option");
                        }
                    } else {
                        $(".error-category").text("Please select a valid option");
                    }
                }
            }
        });

        function password_checking() {
            if (!checkPasswordValidity($("#pass_field").val()))
                $(".error-password").text("Please insert a valid password!");
            else {
                $("form[name='admin']").submit();
            }
        }

        function checkNameValidity(value) {
            var regex = /[^a-zA-Z]/;
            if (value.match(regex))
                return false;
            else
                return true;
        }

        function checkPasswordValidity(value) {
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            if (value.match(passw))
                return true;
            else
                return false;
        }


    }
);


