<?php
session_name("session_name");
session_start();
?>

<html>

<head>

    <title>Applicant</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>


</head>
<body>

<nav class="navbar navbar-light bg-light fixed-top">
    <?php


    if (isset($_SESSION['admin'])) {
        ?>
        <a href="#" class="navbar-brand fas fa-user-shield"> Mr.Alaa Hashesh</a>
        <a href="#" class="navbar-brand fas fa-sign-out-alt" data-toggle="modal"
           data-target="#logoutModal">Logout
        </a>
        <?php
    } else {
        if (!isset($_SESSION['user'])) {
            ?>
            <a href="main.php" class="navbar-brand fas fa-plus"> Submit Application </a>
            <a href="admin.php" class="navbar-brand fas fa-user-shield"> Go Admin</a>
            <a href="login.php" class="navbar-brand fas fa-sign-in-alt">Login</a>
            <?php
        }
        if (isset($_SESSION['user'])) {
            ?>
            <a href="review.php" class="navbar-brand fas fa-eye"> Review</a>
            <a href="update.php" class="navbar-brand fas fa-edit"> Update</a>

            <?php

            if (isset($_SESSION['name']) && isset($_SESSION['gender'])) {
                if ($_SESSION['gender'] == 'M') {
                    ?>
                    <a href="#" class="navbar-brand  fas fa-male"> Mr.<?= $_SESSION['name'] ?></a>
                    <?php
                }

                if ($_SESSION['gender'] == 'F') {
                    ?>
                    <a href="#" class="navbar-brand  fas fa-female"> Ms.<?= $_SESSION['name'] ?></a>
                    <?php
                }
            } ?>
            <a href="#" class="navbar-brand fas fa-sign-out-alt" data-toggle="modal"
               data-target="#logoutModal">Logout
            </a>


            <?php

        }
    }

    ?>


</nav>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="temp.php">Logout</a>
            </div>
        </div>
    </div>
</div>