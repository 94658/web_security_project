<?php
session_start();
require __DIR__ . '/config/db_connection.php';
$db = DB();
// Application library  with DemoLib class  that does registration and login logic
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);

require_once __DIR__ . '/GoogleAuthenticator/GoogleAuthenticator.php';
$pga = new PHPGangsta_GoogleAuthenticator();
try {
    $secret = $pga->createSecret();
} catch (Exception $e) {
}

$register_error_message = '';

// check Register request
if (!empty($_POST['btnRegister'])) {
    if ($_POST['name'] == "") {
        $register_error_message = 'Name field is required!';
    } else if ($_POST['email'] == "") {
        $register_error_message = 'Email field is required!';
    } else if ($_POST['username'] == "") {
        $register_error_message = 'Username field is required!';
    } else if ($_POST['password'] == "") {
        $register_error_message = 'Password field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $register_error_message = 'Invalid email address!';
    } else if ($app->isEmail($_POST['email'])) {
        $register_error_message = 'Email is already in use!';
    } else if ($app->isUsername($_POST['username'])) {
        $register_error_message = 'Username is already in use!';
    } else {
        $user_id = $app->Register($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $secret);
        $_SESSION['user_id'] = $user_id;
        header("Location: confirm_google_auth.php");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row jumbotron">
        <div class="col-md-12">
            <h2>
                 Two factor authentication Registration
            </h2>

        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Register</h4>
            <?php
            if ($register_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '</div>';
            }
            ?>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label >Email</label>
                    <input type="email" name="email" class="form-control"/>
                </div>
                <div class="form-group">
                    <label >Username</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label >Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                </div>
            </form>
            <div class="form-group">
                Click here to <a href="index.php">Login</a> if you have already registered your account.
            </div>
        </div>
    </div>
</div>

</body>
</html>
