<?php


function getConnection()
{

    $host = "localhost";
    $username = "c28MustafaB3irat";
    $password = "mus%^&4545";
    $dbname = "c28MustafaB3irat";


    try {
        $conn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($conn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function insertApplicant($name, $email, $gpa, $password, $gender, $year, $connection)
{
    try {


        $query = "insert into applicants(name, email , password , gpa , year , gender) values (?,?,?,?,?,?);";

        $stmt = $connection->prepare($query);

        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $password);
        $stmt->bindValue(4, $gpa);
        $stmt->bindValue(5, $year);
        $stmt->bindValue(6, $gender);

        $stmt->execute();
        return;

    } catch (PDOException $x) {
        if ($x->getCode() == 1062) { ?>
            <div class="alert alert-danger container alert-dismissible"
                 style="width: 600px; position: relative;top: 100px">
            <strong> Failed!</strong> Email: <?= $email ?> is already used
            </div><?php
        } else if ($x->errorInfo[1] == 1062) {
            ?>
            <div class="alert alert-danger container alert-dismissible"
                 style="width: 600px; position: relative;top: 100px">
            <strong> Failed!</strong> Email: <?= $email ?> is already used
            </div><?php

        }

        die();

    }


}

function login($email, $password, $conn)
{
    try {

        return $conn->query("select * from applicants where email = '" . $email . "' and password ='" . $password . "';");
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function getByEmail($email, $conn)
{

    try {

        return $conn->query("select * from applicants where email ='" . $email . "';");

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function updateApplicant($email, $name, $gpa, $password, $year, $gender, $conn, $oldEmail)
{
    try {

        $query = "update applicants set email = ? , name = ? , password = ?  ,gpa =? , year = ?, gender = ? where email = '" . $oldEmail . "';";

        $stmt = $conn->prepare($query);

        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, $name);
        $stmt->bindValue(3, $password);
        $stmt->bindValue(4, $gpa);
        $stmt->bindValue(5, $year);
        $stmt->bindValue(6, $gender);

        $stmt->execute();

    } catch (PDOException $x) {
        if ($x->getCode() == 1062) { ?>
            <div class="alert alert-danger container alert-dismissible"
                 style="width: 600px; position: relative;top: 100px">
            <strong> Failed!</strong> Email: <?= $email ?> is already used
            </div><?php
        } else if ($x->errorInfo[1] == 1062) {
            ?>
            <div class="alert alert-danger container alert-dismissible"
                 style="width: 600px; position: relative;top: 100px">
            <strong> Failed!</strong> Email: <?= $email ?> is already used
            </div><?php

        }

        die();

    }
}

function adminStuff($array, $orderOption, $conn, $filter)
{
    try {

        $query = "select ";


        $num = count($array);
        foreach ($array as $i) {
            if ($num > 1)
                $query = $query . $i . ", ";
            else {
                $query = $query . $i;
            }
            $num--;
        }

        if (!empty($filter) && isset($filter)) {
            $query = $query . " from applicants where " . $filter . " order by " . $orderOption . ";";
        } else {
            $query = $query . " from applicants order by " . $orderOption . ";";
        }

        return $conn->query($query);

    } catch (Exception $e) { ?>
        <div class="alert alert-danger container alert-dismissible" style="width: 600px; position: relative;top: 100px">
            <strong>Failed!</strong> Please Check The Filter text
        </div><?php

    }
}
