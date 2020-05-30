<?php 
require_once("../model/class_user.php");
require_once("../model/class_flight.php");
require_once("../model/class_reservation.php");
require_once("../model/class_travler.php");

$connection = null;
function open_connetion(){
    global $connection;
    $connection = mysqli_connect("localhost", "root", "", "flightManagmentP2", "3306");
    if(mysqli_connect_errno()){
        die("Database connection error: ".mysqli_connect_error() ." (".mysqli_connect_errno().")");
    }
}

function close_connection(){
    global $connection;
     mysqli_close($connection);
}

function get_travlers_objects($where=null){
    global $connection;
    $objects = [];
    $query = "SELECT id_travler FROM Travler" . (!empty($where) ? " ".$where : "");
    $result = get_rows($query);
    while($row = mysqli_fetch_row($result)){
        $travler = new Travler($connection);
        $travler->create_from_id($row[0]);
        $objects[] = $travler;
    }
    return $objects;
}

function get_flights_objects($where=null){
    global $connection;
    $objects = [];
    $query = "SELECT id_flight FROM Flight" . (!empty($where) ? " ".$where : "");
    $result = get_rows($query);
    while($row = mysqli_fetch_row($result)){
        $flight = new Flight($connection);
        $flight->create_from_id($row[0]);
        $objects[] = $flight;
    }
    return $objects;
}

function get_rows($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    if($result){
        return $result;
    }else{
        die("Error in : " . $query . "<br>" . mysqli_error($connection));
    }
}

function safe_data($value,$name,&$issafe){
    global $connection;
    if(isset($value[$name]) && trim($value[$name]) !== ""){
        return mysqli_real_escape_string($connection,trim($value[$name]));
    }else{
        $issafe = false;
        return null;
    }
}
?>