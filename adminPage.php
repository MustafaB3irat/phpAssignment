<?php
include 'layout.php';
include 'model.php';
session_name("session_name");
session_start();

?>

    <div class="container" style="margin-top: 100px;width: 600px">

        <form method="post" action="adminPage.php">

            <div class="form-group">


                <label for="multiselect"><strong>Select Elements to Show</strong></label>

                <select id="multiselect" multiple="multiple" style="width: 100%;height: 150px" class="form-control"
                        name="elements[]">
                    <option value="" disabled>
                        <small>Choose Elements to show</small>
                    </option>
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="gpa">GPA</option>
                    <option value="year">Year</option>
                    <option value="gender">Gender</option>
                </select>

                <label for="order" style="margin-top: 15px"><strong>Order By: </strong></label>
                <select class="form-control" name="order" id="order" class="form-control"
                        style="width: 100%;margin-left: 5px;margin-bottom: 90px">
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="gpa">GPA</option>
                    <option value="year">Year</option>
                    <option value="gender">Gender</option>
                </select>

                <label for="filter" style="margin-top: 20px"><strong>Filter: </strong></label>
                <input type="text" id="filter" name="filter" class="form-control"
                       style="margin-left: 5px;width: 100%"
                       placeholder="If you want, fill in a filter text e.g gpa > 3.0 ">


                <button class="btn btn-primary" style="margin-top: 20px;width: 150px" name="submit">Filter</button>


            </div>

        </form>
    </div>

    <script type="text/javascript">


    </script>


    </body>
    </html>

<?php

if (isset($_POST['submit'])) {

    $array = array();

    if (isset($_POST['elements'])) {
        foreach ($_POST['elements'] as $i) {
            $array[] = $i;
        }
    }

    if (!isset($_POST['elements'])) {
        ?>
        <div class="alert alert-danger container alert-dismissible" style="width: 600px; position: relative;top: 100px">
            <strong>Failed!</strong> Please Choose At least one element to show
        </div><?php
    }

    if (isset($_POST['order'])) {
        $order = $_POST['order'];
    } else if (!isset($_POST['order'])) {
        ?>
        <div class="alert alert-danger container alert-dismissible" style="width: 600px; position: relative;top: 100px">
            <strong>Failed!</strong> Please Choose Order By value...
        </div><?php
    }


    $conn = getConnection();

    $res = adminStuff($array, $order, $conn, $_POST['filter']);


    $keys = array();
    ?>
    <div class="container" style="width: 600px">
    <table class="table table-striped">
    <thead>
    <tr>
        <?php if ($row = $res->fetch()) {

            foreach ($row as $key => $value) {
                if (!is_numeric($key)) {
                    $keys[] = $key;

                    ?>

                    <th scope="col" style="font-size: 1.3pc"><?= strtoupper($key) ?></th>
                    <?php
                }
            }


        }


        $res = adminStuff($array, $order, $conn, $_POST['filter']);

        ?>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $res->fetch()) {
        ?>
        <tr style="font-size: 1.3pc">
        <?php foreach ($keys as $a) {
            ?>
            <td style="font-size: 1.2pc"><?= $row[$a] ?></td>
            <?php
        }

        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";


}