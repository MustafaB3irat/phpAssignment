<?php

include "layout.php";
include "model.php";
session_name("session_name");
session_start();
?>

    <div class="container" style="margin-top: 100px;width: 600px;height: 600px">
        <form action="admin.php" method="post" enctype="application/x-www-form-urlencoded">
            <div class="form-group">
                <label for="name">Admin Name:</label>
                <input type="text" class="form-control" id="name" aria-describedby="Admin Name"
                       placeholder="Enter Admin Name" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                       name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login as Admin</button>
        </form>
    </div>

<?php


if (isset($_POST['login']) && (!isset($_SESSION['admin']))) {

    if ($_POST['name'] = "alaa" && md5($_POST['password']) == md5("comp334")) {


        $_SESSION['admin'] = "set";
        $_SESSION['name'] = "Alaa Hashesh";
        $_SESSION['gender'] = 'M';


    } else { ?>
        <div class="alert alert-danger container" style="width: 600px;position: relative;top: -280px">
            <strong>Error!</strong> You Are not Authorized!
        </div> <?php
    }
}

if (isset($_SESSION['admin'])) {

    header("Location:adminPage.php");
}
