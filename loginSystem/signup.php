<?php
session_start();
if (isset($_POST['email']))
{
    $validation=true;
    $nick=$_POST['nick'];
    if ((strlen($nick)<3)||(strlen($nick)>20)) {
        $validation = false;
        $_SESSION['eNick']="Nick must be from 3 to 20 characters!";
    }
    if (ctype_alnum($nick)==false)
    {
        $validation=false;
        $_SESSION['eNick']="Nick must contain only numbers and characters!";
    }
    $email=$_POST['email'];
    $email2=filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email2, FILTER_VALIDATE_EMAIL)==false || $email2!=$email)
    {
        $validation=false;
        $_SESSION['eEmail']="Wrong email adress!";
    }
    $pwd=$_POST['pwd'];
    $pwd2=$_POST['pwd2'];
    if (strlen($pwd)<8)
    {
        $validation=false;
        $_SESSION['ePwd']="Password must contains at least 8 characters!";
    }
    if ($pwd!=$pwd2)
    {
        $validation=false;
        $_SESSION['ePwd']="Passwords do not match!";
    }
    if ($validation==true)
    {
        echo "Validation complete!";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Sign up</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<form method="post">
    Nickname: <input type="text" name="nick"><br>
    <?php
    if (isset($_SESSION['eNick']))
        echo '<div class="error">'.$_SESSION['eNick']."</div>";
        unset($_SESSION['eNick']);
    ?><br>
    Email: <input type="text" name="email"><br>
    <?php
    if (isset($_SESSION['eEmail']))
        echo '<div class="error">'.$_SESSION['eEmail']."</div>";
    unset($_SESSION['eEmail']);
    ?>
    <br>
    Password: <input type="password" name="pwd"><br>    <?php
    if (isset($_SESSION['ePwd']))
        echo '<div class="error">'.$_SESSION['ePwd']."</div>";
    unset($_SESSION['ePwd']);
    ?>
    <br>
    Password2: <input type="password" name="pwd2"><br><br>
    <label><input type="checkbox" name="terms">I agree to the terms and rules!</label><br><br>
    <form action="?" method="POST">
        <div class="g-recaptcha" data-sitekey="6LcNx6EUAAAAAMcC5bF_PlCIMSowkhWqrBZebJbO"></div>
        <br/>
        <input type="submit" value="signup">
    </form>
</form>

</body>

</html>