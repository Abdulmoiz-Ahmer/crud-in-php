$(
    function () {

        $("input[name='password']").keyup(function (e) {
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

        $("#login-btn").click(function (e) {
            e.preventDefault();
            console.log($("#username").val() == "" ? "yes" : "nos");

            if ($("#username").val() == "" || (!checkNameValidity($("#username").val())))
                $(".error-username").text("Please insert a valid name!");
            else {
                if (!checkPasswordValidity($("#password").val()))
                    $(".error-password").text("Please insert a valid password!");
                else {
                    $("form[name='login']").submit();
                }
            }


        });

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
        // $("form[name='login']").validate({
        //     rules: {
        //         username: {
        //             required: true
        //         },
        //         password: {
        //             required: true,
        //             minlength: 6
        //         }
        //     },
        //     messages: {
        //         username: {
        //             required: "This field is required!"
        //         },
        //         password: {
        //             required: "This field is required!",
        //             minlength:"Minimum 6 characters required!"
        //         }
        //     }, errorPlacement: function (error, element) {
        //         if (element[0].name === "username") {
        //             $(".error-username").append(error);
        //         } else {
        //             $(".error-password").append(error);
        //         }
        //     },
        //     submitHandler: function (form) {
        //         form.submit();
        //     }
        // })
    }


);
