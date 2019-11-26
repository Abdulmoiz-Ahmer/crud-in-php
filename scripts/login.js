$(
    function () {
        $("form[name='login']").validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: "This field is required!"
                },
                password: {
                    required: "This field is required!",
                    minlength: "Minimum 6 characters in this field!"
                }
            }, errorPlacement: function (error, element) {
                if (element[0].name === "username") {
                    $(".error-username").append(error);
                } else {
                    $(".error-password").append(error);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        })
    }
);
