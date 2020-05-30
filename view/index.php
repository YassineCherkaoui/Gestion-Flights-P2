<?php 
require_once("../controller/session_handler.php");
require_once("../model/functions.php");
open_connetion();
$objects     = [];
if(isset($_POST["from"]) && isset($_POST["to"])){
$issafe      = true;
$depart      = safe_data($_POST, "from", $issafe);
$distination = safe_data($_POST, "to", $issafe);
if($issafe){
    $objects = get_flights_objects(
        "WHERE depart = '{$depart}' AND distination = '{$distination}' AND total_places > 0 AND is_active = 1");

    }
}
include("../layout/header.php");


?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <form class="form" action="index.php" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <select name="from" class="form-control my-3 " required>
                            <option value="" disabled selected>Depart</option>
                            <?php $result = get_rows("SELECT DISTINCT depart FROM Flight");
                                while($row = mysqli_fetch_row($result)){ ?>
                            <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-4 ">
                        <select name="to" class="form-control my-3" required>
                            <option value="" disabled selected>Distination</option>
                            <?php $result = get_rows("SELECT DISTINCT distination FROM Flight");
                                while($row = mysqli_fetch_row($result)){ ?>
                            <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <button type="submit" class="btn btn-primary btn-block my-3">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<div class="container">
    <?php echo message();?>
    <div class="table-responsive">
        <table class="table flights">
           <?php
                    if(!empty($objects)){
            ?>
            <thead class="thead-dark">
                <tr>
                    <th>Plane Name</th>
                    <th>Depart</th>
                    <th>Distination</th>
                    <th>Date Flight</th>
                    <th>Price</th>
                    <th>Available Places</th>
                </tr>
            </thead>
            <?php
            }
                $page = isset($_SESSION['id']) ? "reserve.php" : "sing.php";
            ?>
            </tbody>
            <?php foreach($objects as $flight){ ?>
            <tr onclick="window.location='<?php echo $page ?>?id=<?php echo $flight->get_id(); ?>'">
                <th><?php echo $flight->get_data()["plane_name"];?></th>
                <th><?php echo $flight->get_data()["depart"];?></th>
                <th><?php echo $flight->get_data()["distination"];?></th>
                <th><?php echo $flight->get_data()["date_flight"];?></th>
                <th><?php echo $flight->get_data()["price"];?>DH</th>
                <th><?php echo $flight->get_data()["total_places"];?></th>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php close_connection(); ?>
</body>

</html>