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

    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);

    if (!isset($_POST['terms']))
    {
        $validation=false;
        $_SESSION['eTerms']="You must agree terms and rules!";
    }

    $secretKey="6Lfj1qEUAAAAACBSRYXCSi2TaVppGk-YTzjPZ81U";

    $captcha = file_get_contents(
    'https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);

    $response=json_decode($captcha);

    if ($response->success==false)
    {
        $validation=false;
        $_SESSION['eBot']="Click reCaptcha checkbox!";
    }

    $_SESSION['rNick']=$nick;
    $_SESSION['rMail']=$email;
    $_SESSION['rPwd']=$pwd;
    $_SESSION['rPwd2']=$pwd2;
    if (isset($_POST['terms']))
        $_SESSION['rTerms']=true;


    require_once "dbConnect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $conn = new mysqli($host, $dbUser, $dbPwd, $dbName);
        if ($conn->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $result = $conn->query('SELECT id FROM users WHERE email="$email"');

            if (!$result) throw new Exception($conn->error);

            $emails=$result->num_rows;
            if ($emails>0)
            {
                $validation=false;
                $_SESSION['eEmail']="There is an account on this e-mail address!";
            }

            $result = $conn->query("SELECT id FROM users WHERE user='$nick'");

            if (!$result) throw new Exception($conn->error);

            $nicks=$result->num_rows;
            if ($nicks>0)
            {
                $validation=false;
                $_SESSION['eNick']="Nick is taken!";
            }

            if ($validation==true) {
                if ($conn->query("INSERT INTO users VALUES (NULL, '$nick', '$pwdHash', '$email')"))
                {
                    $_SESSION['successful']=true;
                    header("Location: hello.php");
                }
                else
                {
                    throw new Exception($conn->error);
                }
            }

            $conn->close();

        }
    }
    catch (Exception $e)
    {
        echo '<span style="color:red">Server error! Please try later</span>';
        //echo "<br>".$e;
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
    Nickname: <input type="text" value="<?php
    if (isset($_SESSION['rNick']))
    {
        echo $_SESSION['rNick'];
        unset($_SESSION['rNick']);
    }
?>" name="nick"><br>
    <?php
    if (isset($_SESSION['eNick']))
        echo '<div class="error">'.$_SESSION['eNick']."</div>";
        unset($_SESSION['eNick']);
    ?><br>
    Email: <input type="text" value="<?php
    if (isset($_SESSION['rMail']))
    {
        echo $_SESSION['rMail'];
        unset($_SESSION['rMail']);
    }
    ?>" name="email"><br>
    <?php
    if (isset($_SESSION['eEmail']))
        echo '<div class="error">'.$_SESSION['eEmail']."</div>";
    unset($_SESSION['eEmail']);
    ?>
    <br>
    Password: <input type="password" value="<?php
    if (isset($_SESSION['rPwd']))
    {
        echo $_SESSION['rPwd'];
        unset($_SESSION['rPwd']);
    }
    ?>" name="pwd"><br>    <?php
    if (isset($_SESSION['ePwd']))
        echo '<div class="error">'.$_SESSION['ePwd']."</div>";
    unset($_SESSION['ePwd']);
    ?>
    <br>
    Password2: <input type="password" value="<?php
    if (isset($_SESSION['rPwd2']))
    {
        echo $_SESSION['rPwd2'];
        unset($_SESSION['rPwd2']);
    }
    ?>" name="pwd2"><br><br>

    <label>
        <input type="checkbox" name="terms" <?php
        if (isset($_SESSION['rTerms']))
        {
            echo "checked";
            unset($_SESSION['rTerms']);
        }
        ?>>I agree to the terms and rules!
    </label>

    <?php
    if (isset($_SESSION['eTerms']))
        echo '<div class="error">'.$_SESSION['eTerms']."</div>";
    unset($_SESSION['eTerms']);
    ?>


    <br><br>

    <div class="g-recaptcha" data-sitekey="6Lfj1qEUAAAAAHpmW2m8lI84rpX8rksrTZX36Cxt"></div>
    <br/>
    <?php
    if (isset($_SESSION['eBot']))
        echo '<div class="error">'.$_SESSION['eBot']."</div>";
    unset($_SESSION['eBot']);
    ?>

    <input type="submit" value="signup">

</form>

</body>

</html>