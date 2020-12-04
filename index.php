<?php 
    require_once("components.php");
    require_once("./entities.php");

    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];


    if($user['type'] == 1) {
        $vehicles = Vehicle::getAllVehicles();
        $violations = Violation::getAllViolations();
    }
    else {
        $vehicles = Vehicle::getUsersVehicles($user_id);
        $violations = Violation::getUsersViolations($user_id);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <link rel="icon" href="favicon.ico" type="image/x-icon"/>
     <title>U of U Parking System - Home</title>
    </head>
<body style="background-color: #f8f9fa;">


<div class="container-fluid">
    <?php Components::renderNav($user); ?>
    <div class="container" style="margin-top: 30px;">
    <?php if (isset($_REQUEST["newaccount"])) echo('<div class="alert alert-success" role="alert">Account created successfully! Welcome to the U Parking System<button type="button" class="close" data-dismiss="alert">x</button></div>'); ?>
        <?php if (isset($_REQUEST["signedin"])) echo('<div class="alert alert-success" role="alert">Signed in successfully! Welcome to the U Parking System<button type="button" class="close" data-dismiss="alert">x</button></div>'); ?>      
        <div class="row">
            <div class="col-sm-6" style="background-color: white; padding: 20px; box-shadow: 1px 1px 20px #eee">
                <div>
                    <?php
                        if($user['type'] == 1) {
                            echo '<a href="vehicles.php"><h3>All Vehicles</h3></a>';
                        }
                        else {
                            echo '<a href="vehicles.php"><h3>My Vehicles</h3></a>';
                        }
                    ?>
                    <table class="table table-hover" style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <?php
                                if($user['type'] == 1) {
                                    echo '<th scope="col">User</th>';
                                }
                                ?>
                                <th scope="col">Year</th>
                                <th scope="col">Make</th>
                                <th scope="col">Model</th>
                                <th scope="col">License Plate</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($vehicles as $vehicle) {
                            ob_start();
                            ?>
                            <tr>
                            <?php
                            if($user['type'] == 1) {
                                echo("<td>" . $vehicle['first_name'] . " " . $vehicle['last_name'] ."</td>");
                            } 
                            ?>
                                <td><?php echo $vehicle['year']; ?></td>
                                <td><?php echo $vehicle['make']; ?></td>
                                <td><?php echo $vehicle['model']; ?></td>
                                <td><?php echo $vehicle['license_plate']; ?></td>
                            </tr>
                            <?php
                            
                        }
                        ?> 
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-1">
            </div>
            <div class="col-sm-5" style="background-color: white; padding: 20px; box-shadow: 1px 1px 20px #eee">
                <div>
                <?php
                        if($user['type'] == 1) {
                            echo '<a href="violations.php"><h3>All Violations</h3></a>';
                        }
                        else {
                            echo '<a href="violations.php"><h3>My Violations</h3></a>';
                        }
                    ?>
                    <table class="table table-hover" style="margin-top: 30px;">
                    <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Amount Due</th>
                                <th scope="col">License Plate</th>
                                <?php
                                    if($user['type'] == 1) {
                                        echo('<th scope="col">Driver</th>');
                                    }
                                ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($violations as $violation) {
                            ob_start();
                            ?>
                            <tr>
                                <td><?php echo $violation['date']; ?></td>
                                <td><?php echo $violation['amount']; ?></td>
                                <td><?php echo $violation['license_plate']; ?></td>
                                <?php
                                    if($user['type'] == 0) {
                                        if($violation['paid'] == 0) {
                                            echo('<td><a href="violations.php?payviolation=' . $violation['violation_id'] . '"><button class="btn btn-success" style="float: right;">Pay</button></a></td>');
                                        }
                                        else {
                                            echo('<td><span>Paid</span></td>');
                                        }
                                    }
                                    else {
                                        echo('<td>' . $violation['first_name'] . ' ' . $violation['last_name'] . '</td>');
                                        echo('<td><a href="violations.php?deleteviolation=' . $violation['violation_id'] . '"><button class="btn btn-danger" data-id="' . $violation['violation_id'] . '" style="float: right;">Delete</button></a></td>');

                                    }
                                ?>
                            </tr>
                            <?php
                            
                        }
                        ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php if($user['type'] == 1) { ?>
        <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee; margin-top: 40px;">
                <?php
                    ob_start();
                    $users = User::getAllUsers();
                    ?>
                    <h3>Users</h3>
                    <table class="table table-hover" style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th scope="col">UserID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($users as $user) {
                            ob_start();
                            ?>
                            <tr>
                                <td><?php echo $user['driver_id']; ?></td>
                                <td><?php echo $user['first_name']; ?></td>
                                <td><?php echo $user['last_name']; ?></td>
                                </tr>
                            <?php
                            
                        }
                        ?> 
                        </tbody>
                    </table>
                    <?php 
                    echo ob_get_clean();
                    ?>
                </div>
            </div>
        <?php } ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>