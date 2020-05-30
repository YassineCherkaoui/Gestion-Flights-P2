<?php 
require_once("../controller/session_handler.php");
require_once("../model/functions.php");


if(!(isset($_SESSION['id']) && isset($_GET['id']))){
    header("Location: ../view/index.php");
    exit;
}
open_connetion();
$flight = new Flight($connection);
$flight->create_from_id((int) $_GET['id']);
include("../layout/header.php");

?>
<div class="container">
<?php echo message();?>

    <ul class="nav nav-tabs mx-auto" style="max-width:450px;">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#user">For You</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#guest">For Someone Else</a>
        </li>
    </ul>

    <div class="tab-content mx-auto" style="max-width:450px;">
        <div class="tab-pane container m-0 p-0 active" id="user">
            <div class="card" style="background-color: rgba(255, 255, 255, 0);">
                <div class="card-header">
                    <h4 class="card-title">Confirm Your Recervation</h4>
                </div>
                <div class="card-body p-4">
                    <p>From <span class="text-primary"><?php echo $flight->get_data()['depart']?></span> to
                        <span class="text-primary"><?php echo $flight->get_data()['distination']?></span></p>
                    <p>Reservation for <span
                            class="text-primary"><?php echo $_SESSION['firstname']. ' '.$_SESSION['lastname']?></span></p>
                    <p>Flight on <span class="text-primary"><?php echo $flight->get_data()['plane_name']?></span></p>
                    <p>Start from <span class="text-primary"><?php echo $flight->get_data()['date_flight']?></span></p>
                </div>
                <div class="card-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <p class="card-text">Total Price: <span
                                class="text-primary"><?php echo $flight->get_data()['price']?></span></p>
                    </div>
                    <form action="../controller/reserve_process.php" method="POST">
                        <input type="hidden" name="idUser" value="<?php echo $_SESSION['id'];?>">
                        <input type="hidden" name="idFlight" value="<?php echo (int) $_GET['id'];?>">
                        <input type="hidden" name="firstname" value="<?php echo $_SESSION['firstname'];?>">
                        <input type="hidden" name="lastname" value="<?php echo $_SESSION['lastname'];?>">
                        <input type="hidden" name="passport" value="<?php echo $_SESSION['passport'];?>">
                        <button type="submit" class="btn btn-primary" name="reserve">Confirm this reservation</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="tab-pane container m-0 p-0 fade" id="guest">

            <form action="../controller/reserve_process.php" method="POST" class="needs-validation" novalidate>

                <div class="card" style="background-color: rgba(255, 255, 255, 0);">
                    <div class="card-header">
                        <h4 class="card-title">Fill The Information</h4>
                    </div>
                    <div class="card-body p-4">

                        <p>From <span class="text-primary"><?php echo $flight->get_data()['depart']?></span> to
                            <span class="text-primary"><?php echo $flight->get_data()['distination']?></span></p>
                        <p>Flight on <span class="text-primary"><?php echo $flight->get_data()['plane_name']?></span></p>
                        <p>Start from <span class="text-primary"><?php echo $flight->get_data()['date_flight']?></span></p>
                        Reservation for:

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter First Name" name="firstname"
                                required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Last Name" name="lastname"
                                required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Passport N°" name="passport"
                                required>
                        </div>

                    </div>
                    <div class="card-footer" style="display: flex; justify-content: space-between;">
                        <div>
                            <p class="card-text">Total Price: <span
                                    class="text-primary"><?php echo $flight->get_data()['price']?></span></p>
                        </div>

                        <input type="hidden" name="idUser" value="<?php echo $_SESSION['id'];?>">
                        <input type="hidden" name="idFlight" value="<?php echo (int) $_GET['id'];?>">
                        <button type="submit" class="btn btn-primary" name="reserve">Confirm this reservation</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script src="js/script.js"></script>
<?php close_connection(); ?>
</body>
</html>