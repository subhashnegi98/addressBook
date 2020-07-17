<?php require_once 'secure.php'; ?>
<?php
    $user_id = $_SESSION['user_id'];
    $db = mysqli_connect('localhost', 'root', '', 'adressbook');
    $query = "select * from users";
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
            <h2>Registered Users</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                ?>
                <hr>
                <table>
                    <thead>
                        <tr class="dark">
                            <th>S.No.</th>
                            <th>User ID</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Join Date</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Active</th>
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
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[2]; ?></td>
                                <td><?php echo $row[3]; ?></td>
                                <td><?php echo $row[4]; ?></td>
                                <td><?php echo $row[5]; ?></td>
                                <td><?php echo $row[6]; ?></td>
                                <td><?php echo $row[7]; ?></td>
                                <td><?php echo ($row[8]==0?'In-Active':'Active'); ?></td>
                                <td>
                                    <a href="delete_user.php?user_id=<?php echo $row[0]; ?>" onclick="return confirm('Delete this record!')"><img src="../images/delete.png" title="Delete Record" alt=""/></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h3 style="color: red">Sorry, There are no users.</h3>
            <?php } ?>            
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
