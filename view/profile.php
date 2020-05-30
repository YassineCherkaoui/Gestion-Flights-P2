<?php 
require_once("../controller/session_handler.php");
require_once("../model/functions.php");

if(!isset($_SESSION['id'])){
    header("Location: ../view/index.php");
    exit;
}
include("../layout/header.php");
open_connetion();
$user = new User($connection);
$reservations = null;
$user->create_from_id($_SESSION['id']);
if(isset($_SESSION['id'])){
  $reservations = get_travlers_objects("WHERE id_user = {$_SESSION['id']} ORDER BY id_travler DESC");
}

?>
<div class="jumbotron jumbotron-fluid mb-0">
  <div class="container">
    <?php echo message();?>
    <h1>Your Profile Information</h1>
    <div class="row mt-4" style="background-color: rgba(255,255,255,0.9);">
      <div class="col-xs-12 col-sm-6">
        <div class="row my-2">
          <div class="col-4 text-primary">First Name: </div>
          <div class="col-8"><?php echo $user->get_data()['first_name']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Last Name: </div>
          <div class="col-8"><?php echo $user->get_data()['last_name']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Passport N°: </div>
          <div class="col-8"><?php echo $user->get_data()['passport']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Card ID N°: </div>
          <div class="col-8"><?php echo $user->get_data()['id_card']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">State: </div>
          <div class="col-8"><?php echo ucfirst($user->get_data()['role']); ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="row my-2">
          <div class="col-4 text-primary">Birthday: </div>
          <div class="col-8"><?php echo $user->get_data()['birthday']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Email: </div>
          <div class="col-8"><?php echo $user->get_data()['email']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Country: </div>
          <div class="col-8"><?php echo $user->get_data()['nationality']; ?></div>
        </div>
        <div class="row my-2">
          <div class="col-4 text-primary">Phone N°: </div>
          <div class="col-8"><?php echo $user->get_data()['phone']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <?php 
  if(!empty($reservations)){
?>
  <table class="table table-striped mt-4 reserve" style="background-color: rgba(255, 255, 255, 0.9);">
    <thead>
      <tr>
        <th>Date Reservation</th>
        <th>Reserved For</th>
        <th>Depart / Destination</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($reservations as $reservation){
      $flight = new Flight($connection);
      $resere = new Reservation($connection);

      $flight->create_from_id($reservation->get_data()["id_flight"]);
      $resere->create_from_id($reservation->get_data()["id_resevation"]);

      $date = $resere->get_data()["date_resevation"];
      $for = ($reservation->get_data()["passport"] == $_SESSION['passport']) ?
       "You" : "". $reservation->get_data()["first_name"] . 
       " " . $reservation->get_data()["last_name"];
      $from = "From <b>". $flight->get_data()["depart"] . 
      "</b> To <b>" . $flight->get_data()["distination"] . "</b>";

    ?>

      <tr onclick="loadInfo(<?php echo $reservation->get_id(); ?>);" 
      data-toggle="modal" data-target="#showInfo">
        <td><?php echo $date ?></td>
        <td><?php echo $for ?></td>
        <td><?php echo $from ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php }else { ?>
  <h3 class="text-white text-center mt-4">There is no reservation yet</h3>
  <?php } ?>
</div>


<!-- info modal -->
<div class="modal fade" id="showInfo">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Extra Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
      <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="row my-2">
          <div class="col-6 text-primary">For: </div>
          <div class="col-6"><span id="fullName"></span></div>
        </div>
        <div class="row my-2">
          <div class="col-6 text-primary">Date Reservation: </div>
          <div class="col-6"><span id="dateR"></span></div>
        </div>
        <div class="row my-2">
          <div class="col-6 text-primary">Depart / Destination: </div>
          <div class="col-6"><span id="line"></span></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
      <div class="row my-2">
          <div class="col-6 text-primary">Depart On: </div>
          <div class="col-6"><span id="dateD"></span></div>
        </div>
        <div class="row my-2">
          <div class="col-6 text-primary">Flights Company: </div>
          <div class="col-6"><span id="planName"></span></div>
        </div>
        <div class="row my-2">
          <div class="col-6 text-primary">Price: </div>
          <div class="col-6"><span id="price"></span></div>
        </div>
      </div>
    </div>
      </div> <!--close modal-body -->
    </div>
  </div>
</div>

<script src="js/script.js"></script>
<?php close_connection(); ?>
</body>

</html>