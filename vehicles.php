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
        <?php Components::renderNav(); ?>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                    <h3>My Vehicles</h3>
                    <table class="table table-hover" style="margin-top: 30px;">
                        <thead>
                            <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>2001</td>
                            <td>Toyota</td>
                            <td>Corolla</td>
                            </tr>
                            <tr>
                            <td>2009</td>
                            <td>Audi</td>
                            <td>A4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>