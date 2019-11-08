<?php
session_start();
require __DIR__ . '/config/db_connection.php';
$db = DB();
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);
$login_error_message = '';
// check Login request
if (!empty($_POST['btnLogin'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    }
    else if ($password == "") {
        $login_error_message = 'Password field is required!';
    }
    else if ($username == "" && $password == "") {
        $login_error_message = 'Username and Password fields are required!';
    }
    else {
        $user_id = $app->Login($username, $password);
        if($user_id > 0)
        {
            $_SESSION['user_id'] = $user_id;
            header("Location: validate_login.php"); //redirected here
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Login</h4>
            <?php
            if ($login_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
            }
            ?>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label >Username/Email</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label >Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                </div>
            </form>
            <div class="form-group">
                Not Registered Yet? <a href="registration.php">Register Here</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
