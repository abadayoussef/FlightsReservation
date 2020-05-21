<?php 
session_start();
    //create a database connection
    $connection = mysqli_connect("localhost", "root", "", "flightManagment", "3306");
    if(mysqli_connect_errno()){
        die("Database coonection error: ".mysqli_connect_error() ." (".mysqli_connect_errno().")");
    }
    include("header.php");
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <form class="form" action="index.php" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <select name="from" class="form-control my-3 " required>
                            <option value="" disabled selected>Depart</option>
                            <?php 
                    $query = "SELECT DISTINCT depart FROM Flight";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        die("Query is not valid");
                    }
                    while($row = mysqli_fetch_row($result)){
                    ?>
                            <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                            <?php
                    }
                    ?>
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4 ">
                        <select name="to" class="form-control my-3" required>
                            <option value="" disabled selected>Distination</option>
                            <?php 
                    $query = "SELECT DISTINCT distination FROM Flight";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        die("Query is not valid");
                    }
                    while($row = mysqli_fetch_row($result)){
                    ?>
                            <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                            <?php
                    }
                    ?>
                            ?>
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
    <div class="table-responsive">
        <table class="table">
            <?php
                if(isset($_POST["from"]) && isset($_POST["to"])){
                    $depart = mysqli_real_escape_string($connection,$_POST["from"]);
                    $distination = mysqli_real_escape_string($connection, $_POST["to"]);
                    $query = "SELECT * FROM Flight ";
                    $query .= "WHERE depart = '{$depart}' AND distination = '{$distination}' AND total_places > 0";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        die("Query is not valid");
                    }
                    if(mysqli_num_rows($result) > 0){
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
                    $page = isset($_SESSION['log']) ? "reserve.php" : "regester.php";

                    ?>
            </tbody>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr onclick="window.location='<?php echo $page ?>?id=<?php echo $row['id_flight']; ?>'">
                <th><?php echo $row["plane_name"];?></th>
                <th><?php echo $row["depart"];?></th>
                <th><?php echo $row["distination"];?></th>
                <th><?php echo $row["date_flight"];?></th>
                <th><?php echo $row["price"];?></th>
                <th><?php echo $row["total_places"];?></th>
            </tr>
            <?php
                    }
                    ?>
            </tbody>
            <?php
                }
                    ?>
        </table>
    </div>
</div>
</div>
<?php 
    mysqli_free_result($result);
    mysqli_close($connection);
     ?>
</body>

</html>