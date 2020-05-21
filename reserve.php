<?php 

//create a database connection
$connection = mysqli_connect("localhost", "root", "", "flightManagment", "3306");
if(mysqli_connect_errno()){
    die("Database coonection error: ".mysqli_connect_error() ." (".mysqli_connect_errno().")");
}

if(isset($_POST['idUser']) && isset($_POST['idFlight'])){
    $user_id = mysqli_real_escape_string($connection, $_POST['idUser']);
    $flight_id = mysqli_real_escape_string($connection, $_POST['idFlight']);
    $query = "INSERT INTO Reservation (";
    $query .= "id_flight, id_client) ";
    $query .= "VALUES (";
    $query .= "{$flight_id}, {$user_id})";
    $result = mysqli_query($connection, $query);

    if($result){
        header("Location: bill.php");
        exit;
    }else{
        die("there was an error in your query");
    }
}
session_start();
if(!(isset($_SESSION['log']) && isset($_GET['id']))) {
  header("Location: index.php");
  exit;
}

include("header.php");
$user_id = $_SESSION['id'];
$flight_id = mysqli_real_escape_string($connection, $_GET['id']);
$query = "SELECT f.depart, f.distination, c.first_name, c.last_name, f.plane_name, f.date_flight, f.total_places, f.price ";
$query .= "FROM Client c, Flight f ";
$query .= "WHERE  c.id_client = {$user_id} AND f.id_flight = {$flight_id}";
$result = mysqli_query($connection, $query);
  if($result && mysqli_num_rows($result) == 1){
    $result = mysqli_fetch_assoc($result);
  }else{
    die("there is an error in your query");
  }
?>
 
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <p>
                From <b><?php echo $result['depart']?></b> to <b><?php echo $result['distination']?></b> 
            </p>
        </div>
        <div class="card-body">

            <h4 class="card-title">Reservation for <span class="text-primary">
                <?php echo $result['first_name']. ' '.$result['last_name']?></span></h4>

            <h6 class="card-text">
                Flight on <span class="text-primary"><?php echo $result['plane_name']?>
            </span> start from <span class="text-primary"><?php echo $result['date_flight']?></span><br>
            </h6>
        </div>
        <div class="card-footer" style="display: flex; justify-content: space-between;">
            <div>
                <p class="card-text">Total Price: <span class="text-primary"><?php echo $result['price']?></span></p>
            </div>
            <form action="reserve.php" method="POST">
            <input type="hidden" name="idUser" value="<?php echo $user_id;?>">
            <input type="hidden" name="idFlight" value="<?php echo $flight_id;?>">
            <button type="submit" class="btn btn-primary">Confirm this reservation</button>
            </form>
        </div>
    </div>
</div>

<?php 
    // mysqli_free_result($result);
    mysqli_close($connection);
?>
</body>
</html>