<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("database.php");

class User {

    static function createUser($first_name, $last_name, $email, $password) {
        $data = [
            'type' => 0,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password
        ];
        $db = Database::getInstance();
        try {
            $statement = "INSERT INTO driver(`type`, first_name, last_name, email, `password`) VALUES (:type, :first_name, :last_name, :email, :password)";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function updateUser($driver_id, $first_name, $last_name, $card, $ccv, $exp) {
        $data = [
            'driver_id' => $driver_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'card' => (int)$card,
            'ccv' => (int)$ccv,
            'exp' => $exp
        ];
        $db = Database::getInstance();
        try {
            $statement = "UPDATE driver SET first_name=:first_name, last_name=:last_name, card=:card, ccv=:ccv, exp=:exp WHERE driver_id=:driver_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function getUser($driver_id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM driver WHERE driver_id = $driver_id";
        if($result = $db->query($statement)) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading user";
        }
    }

    static function getAllUsers() {
        $db = Database::getInstance();
        $statement = "SELECT * FROM driver";
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading users";
        }
    }

    static function getUserId($email) {
        $db = Database::getInstance();
        $statement = "SELECT `driver_id` FROM driver WHERE email = '$email'";
        if($result = $db->query($statement)) {
            return $result->fetch(\PDO::FETCH_ASSOC)['driver_id'];
        }
        else {
            echo "Error loading user id";
        }
    }

    static function getPassword($email) {
        $db = Database::getInstance();
        $statement = "SELECT `password` FROM driver WHERE email = '$email'";
        if($result = $db->query($statement)) {
            return $result->fetch(\PDO::FETCH_ASSOC)['password'];
        }
        else {
            return false;
        }
    }

    static function toggleAdmin($driver_id) {
        $db = Database::getInstance();

        $statement = "SELECT `type` FROM driver WHERE driver_id = '$driver_id'";
        if($result = $db->query($statement)) {
            $type = $result->fetch(\PDO::FETCH_ASSOC)['type'];
        }

        if($type == 0) {
            $type = 1;
        }
        else {
            $type = 0;
        }

        $data = [
            'driver_id' => $driver_id,
            'type' => $type
        ];
        
        try {
            $statement = "UPDATE driver SET type=:type WHERE driver_id=:driver_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }
    
}

class Violation {

    static function deleteViolation($id) {
        $data = [
            'violation_id' => $id
        ];
        $db = Database::getInstance();
        try {
            $statement = "DELETE FROM violation WHERE violation_id = :violation_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function saveViolation($driver_id, $license_plate, $amount) {
        $data = [
            'driver_id' => $driver_id,
            'date' => date("Y/m/d"),
            'license_plate' => $license_plate,
            'paid' => 0,
            'amount' => $amount
        ];
        $db = Database::getInstance();
        try {
            $statement = "INSERT INTO violation (driver_id, `date`, license_plate, amount, paid) VALUES (:driver_id, :date, :license_plate, :amount, :paid)";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function payViolation($violation_id) {
        $data = [
            'violation_id' => $violation_id,
            'paid' => 1
        ];
        $db = Database::getInstance();
        try {
            $statement = "UPDATE violation SET paid=:paid WHERE violation_id=:violation_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    } 

    static function getViolation($id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM violation 
        WHERE violation_id = $id";
        if($result = $db->query($statement)) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading violation";
        }
    }
    static function getUsersViolations($id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM violation WHERE driver_id = $id";
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading violations";
        }
    }

    static function getAllViolations() {
        $db = Database::getInstance();
        $statement = '
        SELECT * FROM violation
        LEFT JOIN driver
        ON violation.driver_id = driver.driver_id
        ';
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading violations";
        }
    }

}

class Image {

    static function getImage($driver_id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM images WHERE driver_id = $driver_id";
        if($result = $db->query($statement)) {
            if($return = $result->fetch(PDO::FETCH_ASSOC)) {
                return $return["path"];
            }
            else {
                return "https://nolashaolin.com/wp-content/uploads/2018/07/placeholder-face-big.png";
            }
        }
        else {
            echo "Error finding image";
        }
    }

    static function uploadImage($driver_id, $file) {

        $path = 'img/' . basename($file["name"]);
        move_uploaded_file($file["tmp_name"], $path);
        

        if(Image::getImage($driver_id) == "https://nolashaolin.com/wp-content/uploads/2018/07/placeholder-face-big.png") {
            $data = [
                'driver_id' => $driver_id,
                'path' => $path
            ];
            $db = Database::getInstance();
            try {
                $statement = "INSERT INTO images (driver_id, path) VALUES (:driver_id, :path)";
                $db->execute($statement, $data);
            }
            catch (exception $e) {
                echo $e;
            }
        } 
        else {
            $data = [
                'driver_id' => $driver_id,
            ];
            $db = Database::getInstance();
            try {
                $statement = "DELETE FROM images WHERE driver_id = :driver_id";
                $db->execute($statement, $data);
            }
            catch (exception $e) {
                echo $e;
            }
            $data = [
                'driver_id' => $driver_id,
                'path' => $path
            ];
            try {
                $statement = "INSERT INTO images (driver_id, path) VALUES (:driver_id, :path)";
                $db->execute($statement, $data);
            }
            catch (exception $e) {
                echo $e;
            }
        }
    }
}

class Parking {
    static function unOccupySpace($vehicle_id) {
        $data = [
            'vehicle_id' => $vehicle_id,
            'new_id' => null
        ];
        $db = Database::getInstance();
        try {
            $statement = "UPDATE parkingspace SET vehicle_id = :new_id WHERE vehicle_id=:vehicle_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function occupySpace($vehicle_id, $space_id) {
        $data = [
            'vehicle_id' => $vehicle_id,
            'space_id' => $space_id
        ];
        $db = Database::getInstance();
        try {
            $statement = "UPDATE parkingspace SET vehicle_id = :vehicle_id WHERE space_id=:space_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function getAllEmptyParkingSpots() {
        $db = Database::getInstance();
        $statement = '
        SELECT * FROM parkingspace
        WHERE vehicle_id IS NULL
        ';
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading parking spaces";
        }
    }

    static function getAllParkingSpots() {
        $db = Database::getInstance();
        $statement = '
        SELECT * FROM parkingspace
        LEFT JOIN vehicle
        ON parkingspace.vehicle_id = vehicle.vehicle_id
        ';
        if($result = $db->query($statement)) {
            $results = $result->fetchAll(\PDO::FETCH_ASSOC);
            $array = array();
            foreach($results as $result) {
                $key = array_shift($result);
                $array[$key] = $result;
            }
            return $array;
        }
        else {
            echo "Error loading parking spaces";
        }
    }

    static function getUsersParkingSpots($driver_id) {
        $db = Database::getInstance();
        $statement = "
        SELECT * FROM parkingspace
        LEFT JOIN vehicle
        ON parkingspace.vehicle_id = vehicle.vehicle_id
        WHERE vehicle.driver_id = $driver_id
        ";
        if($result = $db->query($statement)) {
            return array_column($result->fetchAll(\PDO::FETCH_ASSOC), 'license_plate', 'space_id');
        }
        else {
            echo "Error loading parking spaces";
        }
    }
}

class Vehicle {

    static function deleteVehicle($id) {
        $data = [
            'vehicle_id' => $id
        ];
        $db = Database::getInstance();
        try {
            $statement = "DELETE FROM vehicle WHERE vehicle_id = :vehicle_id";
            $db->execute($statement, $data);
        }
        catch (exception $e) {
            echo $e;
        }
    }

    static function saveVehicle($driver_id, $year, $make, $model, $license_plate, $id = null) {
        if($id == null) {
            $data = [
                'driver_id' => $driver_id,
                'year' => $year,
                'make' => $make,
                'model' => $model,
                'license_plate' => $license_plate
            ];
            $db = Database::getInstance();
            try {
                $statement = "INSERT INTO vehicle (driver_id, year, make, model, license_plate) VALUES (:driver_id, :year, :make, :model, :license_plate)";
                return $db->execute($statement, $data);
            }
            catch (exception $e) {
                echo $e;
            }
        }
        else {
            $data = [
                'driver_id' => $driver_id,
                'year' => $year,
                'make' => $make,
                'model' => $model,
                'license_plate' => $license_plate,
                'vehicle_id' => (int)$id
            ];
            $db = Database::getInstance();
            try {
                $statement = "UPDATE vehicle SET driver_id=:driver_id, year=:year, make=:make, model=:model, license_plate=:license_plate WHERE vehicle_id=:vehicle_id";
                $db->execute($statement, $data);
            }
            catch (exception $e) {
                echo $e;
            }
        }

    }

    static function getVehicle($id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM vehicle 
        LEFT JOIN driver
        ON vehicle.driver_id = driver.driver_id
        WHERE vehicle_id = $id
                ";
        if($result = $db->query($statement)) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading vehicles";
        }
    }

    static function getUsersVehicles($id) {
        $db = Database::getInstance();
        $statement = "SELECT * FROM vehicle WHERE driver_id = $id";
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading vehicles";
        }
    }

    static function getAllVehicles() {
        $db = Database::getInstance();
        $statement = '
        SELECT * FROM vehicle
        LEFT JOIN driver
        ON vehicle.driver_id = driver.driver_id
        ';
        if($result = $db->query($statement)) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            echo "Error loading vehicles";
        }
    }

}