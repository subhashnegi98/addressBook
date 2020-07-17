<?php
    $db = mysqli_connect('localhost', 'root', '', 'adressbook');
    //$password = sha1('abc#123');
    //$query = "insert into users values('nagendra','$password','admin','Nagendra Dhagarra','ndhagarra@gmail.com','2019-07-27','Favourite Movie','Matrix',1);";
    $password = sha1('xyz#123');
    $query = "insert into users values('amit','$password','member','Amit Sharma','amit@yahoo.com','2019-07-27','Favourite Food','Rajma Chaval',1);";
    mysqli_query($db, $query);
    mysqli_close($db);
?>