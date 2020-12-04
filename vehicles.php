<?php 
    require_once("./components.php");
    require_once("./entities.php");

    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];


    if (isset($_REQUEST["deletevehicle"])) {
        Vehicle::deleteVehicle($_REQUEST["deletevehicle"]);
    }

    if (isset($_REQUEST["savevehicle"])) {
        if(isset($_REQUEST["id"])) {
            Vehicle::saveVehicle($user["driver_id"], $_REQUEST["year"], $_REQUEST["make"], $_REQUEST["model"], $_REQUEST["license_plate"], $_REQUEST["id"]);
            Parking::unOccupySpace($_REQUEST["id"]);
            Parking::occupySpace($_REQUEST["id"], $_REQUEST["parkingspace"]);
            
        }
        else {
            $tempid = Vehicle::saveVehicle($user["driver_id"], $_REQUEST["year"], $_REQUEST["make"], $_REQUEST["model"], $_REQUEST["license_plate"]);
            Parking::occupySpace($tempid, $_REQUEST["parkingspace"]);
        }
    }

    if (isset($_REQUEST["editvehicle"])) {
        $vehicle = Vehicle::getVehicle($_REQUEST["editvehicle"]);
    }


    if($user['type'] == 1) {
        $vehicles = Vehicle::getAllVehicles();
    }
    else {
        $vehicles = Vehicle::getUsersVehicles($user_id);
    }
    
 
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, user-scalable=yes">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        </head>
    <body style="background-color: #f8f9fa;">
    
    <div class="container-fluid">
        <?php Components::renderNav($user); ?>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                <?php if (isset($_REQUEST["savevehicle"])) echo('<div class="alert alert-success" role="alert">Vehicle saved successfully!<button type="button" class="close" data-dismiss="alert">x</button></div>'); ?>

                <?php if(isset($_REQUEST["editvehicle"]) || isset($_REQUEST["addvehicle"])) {
                    $spots = Parking::getAllEmptyParkingSpots();
                    $yourspots = Parking::getUsersParkingSpots($user['driver_id']);
                    ob_start();
                    ?>
                        <form action="vehicles.php">
                            <?php if($user['type'] == 1 && isset($_REQUEST["editvehicle"])) { echo "Driver: " . $vehicle['first_name'] . " " . $vehicle['last_name'] . "<br>"; } ?>
                            <div class="form-group">
                                <label for="formGroupExampleInput">Year</label>
                                <input type="text" class="form-control" id="year" name="year" value="<?php if (isset($_REQUEST["editvehicle"])) echo $vehicle['year'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">Make</label>
                                <input type="text" class="form-control" id="make" name="make" value="<?php if (isset($_REQUEST["editvehicle"])) echo $vehicle['make'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">Model</label>
                                <input type="text" class="form-control" id="model" name="model" value="<?php if (isset($_REQUEST["editvehicle"])) echo $vehicle['model'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">License Plate</label>
                                <input type="text" class="form-control" id="license_plate" name="license_plate" value="<?php if (isset($_REQUEST["editvehicle"])) echo $vehicle['license_plate'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">Parking Space</label>
                                <select name="parkingspace" class="form-control">
                                <?php
                                if(in_array($vehicle['license_plate'], $yourspots)) {
                                    echo("<option value='" . array_search($vehicle['license_plate'], $yourspots) . "'>" . array_search($vehicle['license_plate'], $yourspots) . "</option>");
                                }
                                    foreach($spots as $spot) {
                                        echo("<option value='" . $spot['space_id'] . "'>" . $spot['space_id'] . "</option>");
                                    }
                                ?>
                                </select>
                            </div>
                            <input type="hidden" name="savevehicle" value="1">
                            <?php if (isset($_REQUEST["editvehicle"])) echo("<input type='hidden' name='id' value='" .  $_REQUEST["editvehicle"] . "'/>"); ?>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="vehicles.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
                        </form>
                    <?php
                    echo ob_get_clean();
                }
                else {
                    ob_start();

                    if($user['type'] == 1) {
                        echo '<h3>All Vehicles</h3>';
                    }
                    else {
                        echo '<h3>My Vehicles</h3>';
                    }
                ?>
                    <a href="vehicles.php?addvehicle"><button class="btn btn-primary" style="float: right; margin-bottom: 10px;">Add a Vehicle</button></a>
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
                            <th></th>
                            <th></th>
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
                                <td><a href="vehicles.php?editvehicle=<?php echo $vehicle['vehicle_id'] ?>"><button class="btn btn-success" style="float: right;">Edit</button></a></td>
                                <td><a href="vehicles.php?deletevehicle=<?php echo $vehicle['vehicle_id'] ?>"><button class="btn btn-danger" data-id="<? echo $vehicle['vehicle_id']; ?>" style="float: right;">Delete</button></a></td>
                            </tr>
                            <?php
                            
                        }
                        ?> 
                        </tbody>
                    </table>
                    <?php 
                    echo ob_get_clean();
                }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
    </script>
    </body>
</html>