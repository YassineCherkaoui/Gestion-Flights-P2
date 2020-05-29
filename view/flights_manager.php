<?php 
require_once("../controller/session_handler.php");
require_once("../model/functions.php");

if(!(isset($_SESSION['id']) && $_SESSION['role'] == "admin")){
    header("Location: ../view/index.php");
    exit;
}
include("../layout/header.php");
open_connetion();
$objects = get_flights_objects("ORDER BY id_flight DESC");
close_connection();
?>
<div class="container">
    <?php echo message();?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#addFlight">Add New Flight</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#toggleFlight">Toggle Flights</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane container active" id="addFlight">
            <h1>Add New Flight:</h1>
            <!-- plane_name, depart, destination, date_flight, price, total_places,is_active -->
            <form action="../controller/flight_process.php" method="POST" class="needs-validation mt-4" novalidate>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="plane">Plane Name:</label>
                            <input type="text" class="form-control" id="plane" placeholder="Plane Name" name="plane"
                                required>
                        </div>
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="dateFlight">Date Flight:</label>
                            <input type="date" class="form-control" id="dateFlight" name="dateFlight" required>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="Dplocation">Depart:</label>
                            <input type="text" class="form-control" id="Dplocation" placeholder="Depart location"
                                name="Dplocation" required>
                        </div>
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="Dslocation">Destination</label>
                            <input type="text" class="form-control" id="Dslocation" placeholder="Destination"
                                name="Dslocation" required>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label for="places">Total Places:</label>
                            <input type="text" class="form-control" id="places" placeholder="Plane Capacity"
                                name="places" required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label for="idcard">Ticket Price:</label>
                            <input type="text" class="form-control" id="price" placeholder="Price in DH" name="price"
                                required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label class="mr-3">Is Active:</label>
                            <label>Yes<input type="radio" class="form-control" name="isActive" value="1"
                                    checked></label>
                            <label>No<input type="radio" class="form-control" name="isActive" value="0"></label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3" name="addPlane">Submit</button>
            </form>

        </div>
        <div class="tab-pane container fade" id="toggleFlight">
            <h1>Toggle Flights:</h1>
            <div class="table-responsive">
        <table class="table table-striped mt-4 reserve">
            <thead class="thead-dark">
                <tr>
                    <th>Plane Name</th>
                    <th>Depart</th>
                    <th>Destination</th>
                    <th>Date Flight</th>
                    <th>Price</th>
                    <th>Available Places</th>
                    <th>Activation</th>
                </tr>
            </thead>
            </tbody>
            <form action="../controller/flight_process.php" method="POST">
            <?php foreach($objects as $flight){ ?>
            <tr>
                <th><?php echo $flight->get_data()["plane_name"];?></th>
                <th><?php echo $flight->get_data()["depart"];?></th>
                <th><?php echo $flight->get_data()["distination"];?></th>
                <th><?php echo $flight->get_data()["date_flight"];?></th>
                <th><?php echo $flight->get_data()["price"];?>DH</th>
                <th><?php echo $flight->get_data()["total_places"];?></th>
                
                <?php 
                if($flight->get_data()["is_active"] == 1){
                ?>
                <th><button type="submit" value="<?php echo $flight->get_id();?>" name="switch" class="btn btn-danger btn-sm">Cancel</th>
                <?php
                }else {
                ?>
                <th><button type="submit" value="<?php echo $flight->get_id();?>" name="switch" class="btn btn-success btn-sm">Enable</button></th>
                
            </tr>
            <?php }} ?>
            </form>
            </tbody>
        </table>
    </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>
</body>

</html>