

jQuery.validator.addMethod("CheckPassword", function (value, element) {
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    if (value.match(passw)) {
        return true;
    }
    else {
        return false;
    }
}, "One uppercase, One lowercase and a no is required!");

jQuery.validator.addMethod("CheckName", function (value, element) {
    var regex = /[^a-zA-Z]/;
    if (value.match(regex)) {
        return false;
    }
    else {
        return true;
    }
}, 'Please enter a valid name.');


$(

    function () {

        $("#login-btn").click(function () {

            $("form[name='admin']").validate({
                rules: {
                    username: {
                        required: true,
                        CheckName:true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        CheckPassword: true
                    }, categories: {
                        required: true
                    }, statuses: {
                        required: true
                    }
                },
                // messages: {
                //     //     username: {
                //     //         required: "Required!"
                //     //     },
                //     password: {

                //         CheckPassword: "One uppercase, One lowercase and a no is required!"
                //     }
                //     // , categories: {
                //     //         required: "Required!"
                //     //     }, statuses: {
                //     //         required: "Required!"
                //     //     }
                // },
                errorPlacement: function (error, element) {
                    // console.log(element);
                    // console.log(error);

                    if (element[0].name === "username") {
                        $(".error-username").append(error);
                    } else if (element[0].name === "statuses") {
                        $(".error-status").append(error);
                    } else if (element[0].name === "categories") {
                        $(".error-category").append(error);
                    }
                    else {
                        $(".error-password").append(error);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            })
        });


    }
);


