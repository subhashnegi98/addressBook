<?php require_once 'secure.php'; ?>
<?php
    $status = 0;
    $user_id = $_SESSION['user_id'];
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $cpassword = sha1($_POST['cpassword']);
        $npassword = $_POST['npassword'];
        $copassword = $_POST['copassword'];
        $db = mysqli_connect('localhost', 'root', '', 'adressbook');
        $query = "select password from users where user_id='$user_id'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        $password = sha1($npassword);
        if($cpassword==$row[0]){
            $query = "update users set password='$password' where user_id='$user_id'";
            mysqli_query($db, $query);
            $status = 2;
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
        <link href="../css/default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <h2>Change Password</h2>
            <hr>
            <form action="change_password.php" method="POST">
                <table>
                    <tbody>
                        <tr>
                            <td>Current Password : </td>
                            <td><input type="password" name="cpassword"  required /></td>
                        </tr>
                        <tr>
                            <td>New Password : </td>
                            <td><input type="password" name="npassword"  required /></td>
                        </tr>
                        <tr>
                            <td>Confirm Password : </td>
                            <td><input type="password" name="copassword"  required /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Update Password" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php if($status==1) { ?>
            <h2 class="error">Current Password is Incorrect</h2>
            <?php } ?>
            <?php if($status==2) { ?>
            <h2 class="success">Password has been updated successfully</h2>
            <?php } ?> 
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
