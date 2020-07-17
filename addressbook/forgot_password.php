<?php
    $status = 0;
    $question = '';
    $answer = '';
    $user_id = '';
    $template = 1;
    $password = '';
    if($_SERVER['REQUEST_METHOD']==='POST'){
        if($_POST['form']==1){
            $user_id = trim($_POST['user_id']);
            $db = mysqli_connect('localhost', 'root', '', 'adressbook');
            $query = "select Question from users where user_id='$user_id'";
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result)==1){
                $row = mysqli_fetch_array($result);
                $question = $row[0];
                $template = 2;
            }else{
                $status = 1;
            }
        }else{
            $user_id = trim($_POST['user_id']);
            $question = trim($_POST['question']);
            $answer = trim($_POST['answer']);
            $db = mysqli_connect('localhost', 'root', '', 'adressbook');
            $query = "select Answer,Email from users where user_id='$user_id'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);
            if($answer==$row[0]){
                $str = str_shuffle('khfjglaiHLDJKFDGH6549435$#@!*&');
                $str = substr($str, 0,8);
                $password = sha1($str);
                $query = "update users set password='$password' where user_id='$user_id'";
                mysqli_query($db, $query);
                $template = 3;
                require_once('class.phpmailer.php');
                $email = $row[1];
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
                $mail->Subject = "Password Update";
                $mail->Body = 'Your new password is : '.$str;

                if (!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
                
            }else{
                $status = 2;
                $template = 2;
            }
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
            <?php if($template==1) { ?>
            <h2>Forgot Password</h2>
            <form action="forgot_password.php" method="POST">
                <table>
                    <tbody>
                        <tr>
                            <td>User ID : </td>
                            <td><input type="text" name="user_id" required value="<?php echo $user_id;?>" /></td>
                        </tr>                        
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Submit" />
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="form" value="1" />
            </form>
            <?php if($status==1) { ?>
                <h2 class="error">User ID is Incorrect</h2>
            <?php } ?>
            <?php } ?>
            <?php if($template==2) { ?>
            <h2>Forgot Password</h2>
            <form action="forgot_password.php" method="POST">
                <table>
                    <tbody>
                        <tr>
                            <td>User ID : </td>
                            <td><input type="text" name="user_id" readonly value="<?php echo $user_id;?>" /></td>
                        </tr>
                        <tr>
                            <td>Question : </td>
                            <td><input type="text" name="question" readonly value="<?php echo $question;?>" /></td>
                        </tr>
                        <tr>
                            <td>Answer : </td>
                            <td><input type="text" name="answer" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Submit" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="form" value="2" />
            </form>
            <?php if($status==2) { ?>
                <h2 class="error">The given answer is Incorrect</h2>
            <?php } ?>
            <?php } ?>  
            <?php if($template==3) { ?>
                <h2>Your password has been reset</h2>
                <p>An email has been sent to your registered email ID <?php echo $str;?></p>
                <p>Click <a href="login.php">here</a> to Login</p>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
