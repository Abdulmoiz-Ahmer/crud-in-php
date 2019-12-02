$(
    function () {
        $("form[name='admin']").validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                }, categories: {
                    required: true
                }, statuses: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: "Required!"
                },
                password: {
                    required: "Required!",
                    minlength: "Minimum 6 characters required!"
                }, categories: {
                    required: "Required!"
                }, statuses: {
                    required: "Required!"
                }
            }, errorPlacement: function (error, element) {
                console.log(element);
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
    }
);
