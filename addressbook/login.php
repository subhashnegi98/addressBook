<?php
    $status = 0;
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $user_id = trim($_POST['user_id']);
        $password = sha1($_POST['password']);
        $db = mysqli_connect('localhost', 'root', '', 'adressbook');
        $query = "select * from users where user_id='$user_id' and password='$password'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            if($row['active']==1){
                session_start();
                $role_name = $row['role_name'];
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role_name'] = $role_name;
                $_SESSION['name'] = $row['name'];
                
                if($role_name=='admin'){
                    header('Location: admin/home.php');
                }else{
                    header('Location: member/home.php');
                }
            }else{
                $status = 2;
            }
        }else{
            $status = 1;
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
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <table>
                    <tbody>
                        <tr>
                            <td>User ID : </td>
                            <td><input type="text" name="user_id" value="nagendra" required /></td>
                        </tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" name="password" value="abc#123" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Login" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php if($status==1) { ?>
            <h2 class="error">User ID / Password is Incorrect</h2>
            <?php } ?>
            <?php if($status==2) { ?>
            <h2 class="error">Your Id is Inactive! Please verify your Email ID</h2>
            <?php } ?>
            <a href="forgot_password.php">Forgot Password</a>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
