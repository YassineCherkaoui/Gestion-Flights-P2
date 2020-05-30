<?php
require_once("../controller/session_handler.php");
require_once("../model/functions.php");

if (isset($_POST["reserve"])){
    open_connetion();
    $reservation = new Reservation($connection);
    $travler = new Travler($connection);

    $reservation->create_new($_POST, ['idFlight', 'idUser']);
    $_POST['idReservation'] = $reservation->get_id();

    $travler->create_new($_POST, ['idUser', 'idFlight', 'idReservation', 'firstname', 'lastname', 'passport']);
    close_connection();
    if($reservation->is_has_row() && $travler->is_has_row()){
        $_SESSION['state'] = "success";
        $_SESSION['message'] = "Your reservation is done successfully";
        header("Location: ../view/index.php");
        exit;
    }else{
        $_SESSION['state'] = "danger";
        $_SESSION['message'] = "Oh no, something went wrong!";
        header("Location: ../view/reserve.php?id={$_POST['idFlight']}");
    }
   

}else{
    header("Location: ../view/index.php");
}
?>


