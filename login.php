<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="container">
        <div class="container__form">
            <form action="" method="post" name="login">

                <div class="text-box">
                    <div class="icons-container"> <i class="fas fa-user"></i></div>
                    <div><input type="text" name="username" class="fields" placeholder=" Username"></div>
                </div>

                <div class="text-box">
                    <div class="icons-container"> <i class="fas fa-lock"></i></div>
                    <div><input type="password" name="password" class="fields" placeholder=" Password"></div>
                </div>

                <div>
                    <button class="btn login-btn" type="submit">Login</button>
                </div>

            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a6575f5b2f.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="scripts/login.js"></script>
</body>

</html>