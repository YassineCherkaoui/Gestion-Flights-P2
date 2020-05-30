<?php 
require_once("../controller/session_handler.php");
require_once("../model/functions.php");

if (isset($_REQUEST["id"]) && isset($_SESSION["id"])){
    open_connetion();
    $travler = new Travler($connection);
    $flight = new Flight($connection);
    $reserve = new Reservation($connection);

    $travler->create_from_id($_REQUEST["id"]);
    $flight->create_from_id($travler->get_data()["id_flight"]);
    $reserve->create_from_id($travler->get_data()["id_resevation"]);

    $returned_data = [
        "travler" => $travler->get_data(),
        "flight" => $flight->get_data(),
        "reserve" => $reserve->get_data()
    ];
    echo json_encode($returned_data);
    close_connection();
}
?>