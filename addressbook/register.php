<?php
$status = 0;
$template = 1;
$errors = array();
$user_id = '';
$password = '';
$cpassword = '';
$name = '';
$email = '';
$question = '';
$answer = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_POST['user_id']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    //Validation Part 1 : All required fields are filled
    if ($user_id == '') {
        $errors['user_id'] = 'User ID is required';
    }
    if ($password == '') {
        $errors['password'] = 'Password is required';
    }
    if ($name == '') {
        $errors['name'] = 'Name is required';
    }
    if ($email == '') {
        $errors['email'] = 'Email is required';
    }
    if ($question == '') {
        $errors['question'] = 'Quation is required';
    }
    if ($answer == '') {
        $errors['answer'] = 'Answer is required';
    }

    //Validation Part 2 : Data is Valid

    if (count($errors) == 0) {
        if (!preg_match('/^[A-Za-z]\w+$/', $user_id)) {
            $errors['user_id'] = 'User ID is not Valid';
        }
        if (strlen($password) < 6) {
            $errors['password'] = 'Password too short';
        }
        if ($password != $cpassword) {
            $errors['cpassword'] = 'Password does not match';
        }
        if (!preg_match('/^[A-Za-z]+(\s[A-Za-z]+)*$/', $name)) {
            $errors['name'] = 'Name has some inalid characters';
        }
        if (!preg_match('/^\w+@\w+[.]com$/', $email)) {
            $errors['email'] = 'Enter a valid email ID';
        }
    }

    //Validation Part 3 : Check for primary key violation

    if (count($errors) == 0) {
        $db = mysqli_connect('localhost', 'root', '', 'adressbook');
        $query = "select * from users where user_id='$user_id'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $errors['user_id'] = 'The User ID is NOT available';
        }
    }

    if (count($errors) == 0) {
        $password = sha1($password);
        $date = date('Y-m-d');
        $db = mysqli_connect('localhost', 'root', '', 'adressbook');
        $query = "insert into users values('$user_id','$password','member','$name','$email','$date','$question','$answer',0)";
        mysqli_query($db, $query);
        require_once('class.phpmailer.php');

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'php.batch.2015@gmail.com';
        $mail->Password = 'abc#1234';
        $mail->SMTPAuth = true;

        $mail->From = 'php.batch.2015@gmail.com';
        $mail->FromName = 'Unisoft Dehradun';
        $mail->AddAddress($email);

        $mail->IsHTML(true);
        $mail->Subject = "Registration Successful";
        $mail->Body = 'Your registration is complete. Please click  <a href="http://unisoftdehradun.com/verify.php?email=' . $email . '">here</a> to verify your email.';

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        $template = 2;
    }
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Simplypink by TEMPLATED</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="css/default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <?php if ($template == 1) { ?>
                <h2>Registeration Page</h2>
                <form action="register.php" method="POST">
                    <table>
                        <tbody>
                            <tr>
                                <td>User ID : </td>
                                <td>
                                    <input type="text" name="user_id" value="<?php echo $user_id; ?>"   />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['user_id'])) {
                                        echo '<span class="error">';
                                        echo $errors['user_id'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Password : </td>
                                <td>
                                    <input type="password" name="password" value="<?php echo $password; ?>"  />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['password'])) {
                                        echo '<span class="error">';
                                        echo $errors['password'];
                                        echo '</span>';
                                    }
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Confirm Password : </td>
                                <td>
                                    <input type="password" name="cpassword"  value="<?php echo $cpassword; ?>"  />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['cpassword'])) {
                                        echo '<span class="error">';
                                        echo $errors['cpassword'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Name: </td>
                                <td>
                                    <input type="text" name="name" value="<?php echo $name; ?>"  />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['name'])) {
                                        echo '<span class="error">';
                                        echo $errors['name'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email ID : </td>
                                <td>
                                    <input type="text" name="email" value="<?php echo $email; ?>" />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['email'])) {
                                        echo '<span class="error">';
                                        echo $errors['email'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Question : </td>
                                <td>
                                    <input type="text" name="question" value="<?php echo $question; ?>" />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['question'])) {
                                        echo '<span class="error">';
                                        echo $errors['question'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Answer : </td>
                                <td>
                                    <input type="text" name="answer" value="<?php echo $answer; ?>"  />
                                    <span class="error">*</span>
                                    <?php
                                    if (isset($errors['answer'])) {
                                        echo '<span class="error">';
                                        echo $errors['answer'];
                                        echo '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="submit" value="Register" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php if ($status == 1) { ?>
                    <h2 class="error">User ID / Password is Incorrect</h2>
                <?php } ?>
                <?php if ($status == 2) { ?>
                    <h2 class="error">Your Id is Inactive! Please verify your Email ID</h2>
                <?php } ?>
            <?php } ?>
            <?php if ($template == 2) { ?>
                <h2>Your registration is Complete</h2>
                <p>An email has been sent to your id <?php echo $email; ?> with a verification Link</p>
                <p>In order to use our services you must activate your login ID</p>
                <p>Click <a href="login.php">here</a> to Login</p>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
