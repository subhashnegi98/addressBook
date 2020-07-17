<?php require_once 'secure.php'; ?>
<?php
$user_id = $_SESSION['user_id'];
$db = mysqli_connect('localhost', 'root', '', 'adressbook');
$query = "select id,name,email,mobile_number from contacts where user_id='$user_id'";
$result = mysqli_query($db, $query);
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
            <h2>Address Book</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                ?>
                <hr>
                <table>
                    <thead>
                        <tr class="dark">
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Mobile Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                            while ($row = mysqli_fetch_array($result)) { 
                                
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row[1]; ?></td>
                                <td><?php echo $row[2]; ?></td>
                                <td><?php echo $row[3]; ?></td>
                                <td>
                                    <a href="view_contact.php?id=<?php echo $row[0]; ?>"><img src="../images/view.png" title="View Record" alt=""/></a>
                                    &nbsp;&nbsp; / &nbsp;&nbsp;
                                    <a href="edit_contact.php?id=<?php echo $row[0]; ?>"><img src="../images/edit.png" title="Edit Record" alt=""/></a>
                                    &nbsp;&nbsp; / &nbsp;&nbsp;
                                    <a href="delete_contact.php?id=<?php echo $row[0]; ?>" onclick="return confirm('Delete this record!')"><img src="../images/delete.png" title="Delete Record" alt=""/></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h3 style="color: red">Sorry, There are no contacts in your Address Book.</h3>
            <?php } ?>            
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
