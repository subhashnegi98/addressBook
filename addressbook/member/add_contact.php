<?php require_once 'secure.php'; ?>
<?php require_once 'file_name.php'; ?>
<?php
$status = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_SESSION['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile_number = trim($_POST['mobile_number']);
    $dob = strtotime($_REQUEST['date_of_birth']);
    $date_of_birth = date('Y-m-d', $dob);
    $city = trim($_POST['city']);
    $file_name = $_FILES['photo']['name'];
    if (!empty($file_name)) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $photo = get_name($file_name);
        move_uploaded_file($tmp_name, 'photos/' . $photo);
    } else {
        $photo = 'no_photo.jpg';
    }

    $conn = mysqli_connect('localhost', 'root', '', 'adressbook');
    $sql = "insert into contacts(user_id,name,email,mobile_number,date_of_birth,photo) values('$user_id','$name','$email','$mobile_number','$date_of_birth','$photo')";

    if (mysqli_query($conn, $sql)) {
        $status = 1;
    } else {
        $status = 2;
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
        <link href="../css/base/jquery-ui-1.9.2.custom.css" rel="stylesheet">
        <script src="../js/jquery-1.8.3.js"></script>
        <script src="../js/jquery-ui-1.9.2.custom.js"></script>
        <script>
            $(function () {
                $("#datepicker").datepicker({
                    inline: true, changeYear: true, changeMonth: true, yearRange: '1990:2019', dateFormat: 'd-M-yy'
                });
            });
        </script>
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <h2>Add New Contact</h2>
            <hr> 
            <form action="add_contact.php" method="POST" enctype="multipart/form-data">
                <table>
                    <tbody>
                        <tr>
                            <td>Name : </td>
                            <td><input type="text" name="name" required /></td>
                        </tr>
                        <tr>
                            <td>Email ID : </td>
                            <td><input type="text" name="email" required /></td>
                        </tr>
                        <tr>
                            <td>Mobile Number : </td>
                            <td><input type="text" name="mobile_number" required /></td>
                        </tr>
                        <tr>
                            <td>Date Of Birth : </td>
                            <td><input id="datepicker" type="text" name="date_of_birth" readonly required /></td>
                        </tr>
                        <tr>
                            <td>City : </td>
                            <td><input type="text" name="city" required /></td>
                        </tr>
                        <tr>
                            <td>Photo : </td>
                            <td><input type="file" name="photo"  /></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <input type="submit" value="Add Contact" />
                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>  
            <?php if ($status == 2) { ?>
                <h2 class="error">Error! We can not process your request. Please try Later</h2>
            <?php } ?>
            <?php if ($status == 1) { ?>
                <h2 class="success">The contact is added to your Address Book</h2>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
