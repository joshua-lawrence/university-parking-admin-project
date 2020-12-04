<?php 
    require_once("./components.php");
    require_once("./entities.php");
    
    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];

    if($user['type'] == 1) {
        $spots = Parking::getAllParkingSpots();
    }
    else {
        $spots = Parking::getUsersParkingSpots($user['driver_id']);
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
    <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
    <style>
        table {
            border: 0px !important;
        }
        tr td {
            height: 70px !important;
            width: 50% !important;
            border: 3px solid grey !important;
            border-left: 0px !important;
            background-color: #fdfdfd;
            padding: 5px !important;
        }
        tr td:nth-child(even) {
            border-right: 0px !important;
        }
        tr td:nth-child(odd) {
            text-align: right;
        }
        tr td:hover {
            background-color: #eee;
        }
        .parkingbtn {
            display: block;
            background: rgb(0,212,255);
            background: radial-gradient(circle, #c2ffc3 0%, rgba(255,255,255,1) 100%);
            text-decoration: none;
            color: black;
        }
        .parkingbtn:hover {
            color: black;
            text-decoration: none;
        }
    </style>
    </head>
    <body style="background-color: #f8f9fa;">
 
<div class="container-fluid">
    <?php Components::renderNav($user); ?>
    <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                    <h3>Parking Lot</h3>
                    <div class="row" style="margin-top: 30px;">
                    <?php
                    $parkingcount = 1;
                    for($i = 0; $i < 3; $i++) {
                        ob_start();
                        ?>
                        <div class="col-sm-4">
                            <table class="table table-bordered">
                                <?php
                                for($j = 0; $j < 10; $j++) {
                                    ?>
                                    <tr>
                                        <?php
                                        for($k = 0; $k < 2; $k++) {
                                            if($user['type'] == 1) {
                                                if($spots[$parkingcount]['vehicle_id'] != null) {
                                                    echo("<td><a class='parkingbtn' href='vehicles.php?editvehicle=" . $spots[$parkingcount]['vehicle_id'] . "'>");
                                                    ?>
                                                    <?php echo "<small>" . $parkingcount . "</small>" .
                                                    ($spots[$parkingcount]['license_plate'] != null ? "<br>Plate #" . $spots[$parkingcount]['license_plate'] : ""); ?>
                                                    <?php
                                                    echo("</a>");
                                                }
                                                else {
                                                    echo "<td><small>" . $parkingcount . "</small></td>";
                                                }
                                            }
                                            else {
                                                ?>
                                                <td><?php echo "<small>" . $parkingcount . "</small>" .
                                                (array_key_exists($parkingcount, $spots) ? "<br>Plate #" . $spots[$parkingcount] : ""); ?></td>
                                                <?php
                                            }
                                            $parkingcount++;
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>