<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <!--IE Compatibility modes-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--Mobile first-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Login Page</title>
        <script src="core/lib/jquery/jquery.js"></script>
    </head>

    <body class="">
        <div class="">
            <div class="">
                <div id="login" class="">
                    <form action="<?= $helper->url("Session", "verify") ?>" method="post">
                        <p class="">
                            Login
                        </p><br />
                        <input type="text" name="name" placeholder="Username" class=""><br />
                        <input type="password" name="password" placeholder="Password" class=""><br />
                        <button class="" type="submit">Login</button>
                    </form>
                </div>
                <br />
                <div id="signup" class="">
                    <form action="<?= $helper->url("User", "register") ?>" method="post"><br />
                        <p class="">
                            Registro
                        </p><br />
                        <input type="text" placeholder="username" name="name" class=""><br />
                        <input type="text" placeholder="surname" name="surname" class=""><br />
                        <input type="email" placeholder="mail@domain.com" name="mail" class=""><br />
                        <input type="password" placeholder="password" name="password" class=""><br />
                        <input type="password" placeholder="re-password" class=""><br />
                        <button class="" type="submit">Register</button>
                    </form>
                </div>
            </div>
            <?php
            if (isset($errors['login'])) {
                ?>
                <br />
                <div class="">
                    <strong>Error!</strong> <?= $errors['login'] ?>
                </div>
            <?php }
            ?>
            <hr>
            <div class="">
                <ul class="">
                    <li><a class="" href="#login" data-toggle="tab">Login</a></li>
                    <li><a class="" href="#signup" data-toggle="tab">Signup</a></li>
                </ul>
            </div>
        </div>
    </body>

</html>
