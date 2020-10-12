<?php 
    require_once("components.php");
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
    <div class="row">
        <div class="col-sm-3" style="margin: auto; background-color: white; margin-top: 100px; padding: 50px;">
            <h1 style="text-align: center; margin-top: 20px;"><span style="color:red; font-weight: 800">U</span> Parking System</h1>
            <h3 style="text-align: center; margin-top: 60px;">Sign In</h3>
            <form class="form-signin" style="padding: 10px;">
                <label>Email address</label>
                <input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>
                <label style="padding-top: 30px;">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 30px;">Sign in</button>
                <a href="index.php" style="position: relative; top: 30px;">Return Home</a>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
