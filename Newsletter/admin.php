<?php
session_start();

if (isset($_SESSION['loggedID']))
{
    header("Location: list.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Admin Panel - login system</title>
</head>
<body>
<h1>Admin - login system</h1>

<form method="post" action="list.php">
    <label>
    <input type="text" name="login" placeholder="Login..."><br><br>
    <input type="password" name="pwd" placeholder="Password..."><br><br>
    <input type="submit" name="submit-login"><br><br>

        <?php
        if (isset($_SESSION['badAttempt']))
        {
            echo "<p>Wrong login or password!</p>";
            unset($_SESSION['badAttempt']);

        }
        ?>
    </label>


</form>

</body>

</html>