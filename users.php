<?php 
    require_once("./components.php");
    require_once("./entities.php");
    
    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];

    $drivers = User::getAllUsers();

    if($user['type'] != 1) {
        header('Location: index.php');
    }

    if(isset($_REQUEST['giveadmin'])) {
        User::toggleAdmin($_REQUEST['driver_id']);
    }

    $users = User::getAllUsers();

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
    </head>
    <body style="background-color: #f8f9fa;">
 
<div class="container-fluid">
    <?php Components::renderNav($user); ?>
    <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                <?php
                    ob_start();
                    ?>
                    <h3>Users</h3>
                    <table class="table table-hover" style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th scope="col">UserID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Admin?</th>
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
                                <?php
                                if($user['driver_id'] != 6) {
                                    ?>
                                    <td><input type="checkbox" onchange="giveAdmin(<?php echo $user['driver_id']; ?>)" <?php if($user['type'] == 1) { echo 'checked'; }; ?>></input>
                                    <?php
                                }
                                else {
                                    ?>
                                    <td></td>
                                    <?php
                                }
                                ?>
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
        </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>

function giveAdmin(driver_id) {
    $.ajax({
        url : 'users.php?giveadmin',
        type : 'POST',
        data : {
            'driver_id': driver_id
        },
    });
}



</script>
</body>
</html>