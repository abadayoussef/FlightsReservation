<?php 
session_start();
if (isset($_SESSION['log'])){ header("Location: index.php"); exit; }
//create a database connection
$connection = mysqli_connect("localhost", "root", "", "flightManagment", "3306");
if(mysqli_connect_errno()){
      die("Database coonection error: ".mysqli_connect_error() ." (".mysqli_connect_errno().")");
}
$message = "";
if (isset($_POST["singin"])){
    $first_name = (isset($_POST["fname"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["fname"])) : NULL;
    $last_name = (isset($_POST["lname"]) && trim($_POST["fname"]) !== "" )?  mysqli_real_escape_string($connection,trim($_POST["lname"])) : NULL;
    $birthday = (isset($_POST["bday"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["bday"])) : NULL;
    $nationality = (isset($_POST["nation"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["nation"])) : NULL;
    $passport = (isset($_POST["passport"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["passport"])) : NULL;
    $id_card = (isset($_POST["idcard"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["idcard"])) : NULL;
    $email = (isset($_POST["email"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["email"])) : NULL;
    $phone = (isset($_POST["phone"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["phone"])) : NULL;
    $password_user = (isset($_POST["pswd"]) && trim($_POST["fname"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["pswd"])) : NULL;

    if($first_name && $last_name && $birthday &&
     $nationality && $passport && $id_card && 
     $email && $phone && $password_user){
        $query = "INSERT INTO Client (";
        $query .= "first_name, last_name, id_card, passport, nationality, birthday, email, password_user, phone) ";
        $query .= "VALUES (";
        $query .= "'{$first_name}', '{$last_name}', '{$id_card}', ";
        $query .= "'{$passport}', '{$nationality}', '{$birthday}', '{$email}', '{$password_user}', '{$phone}') ";

        $result = mysqli_query($connection, $query);
        if($result && mysqli_affected_rows($connection) == 1){
          if(isset($_GET['id'])){
            $_SESSION['id'] = mysqli_insert_id($connection);
            $_SESSION['firstname'] = $first_name;
            $_SESSION['log'] = "in";
            header("Location: reserve.php?id={$_GET['id']}");
            exit;
          }
          $message = "<p class=\"text-success mt-4\">the account is created succefully</p>";
        }else{
          die("the insertion is failed");
        }

     }
}

if(isset($_POST["loggin"])){
  $email = (isset($_POST["lgemail"]) && trim($_POST["lgemail"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["lgemail"])) : NULL;
  $password_user = (isset($_POST["lgpswd"]) && trim($_POST["lgpswd"]) !== "" ) ? mysqli_real_escape_string($connection,trim($_POST["lgpswd"])) : NULL;
  $query = "SELECT id_client, first_name FROM Client ";
  $query .= "WHERE email = '{$email}' AND password_user = '{$password_user}' LIMIT 1";
  $result = mysqli_query($connection, $query);
  if($result && mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_row($result);
    $_SESSION['id'] = $row[0];
    $_SESSION['firstname'] = $row[1];
    $_SESSION['log'] = "in";
    if(isset($_GET['id'])){
      header("Location: reserve.php?id={$_GET['id']}");
      exit;
    }else{
      header("Location: index.php");
      exit;
    }
  }else{
    die("the email or password is not correct back and try again!");
  }
}
    include("header.php");
?>
<div class="container">
  <?php echo $message; ?>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#singin">Create New Account</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#login">Login</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane container active" id="singin">
      <h1 class="mt-4">Create New Account:</h1>
      <form action="regester.php<?php echo isset($_GET['id']) ? '?id='.$_GET['id'] : '' ?>" method="POST"
        class="needs-validation mt-4" novalidate>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-6 my-2">
              <label for="fname">First Name:</label>
              <input type="text" class="form-control" id="fname" placeholder="Your first name" name="fname" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 my-2">
              <label for="lname">Last Name:</label>
              <input type="text" class="form-control" id="lname" placeholder="Your last name" name="lname" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>

          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-6 my-2">
              <label for="bday">Bithday:</label>
              <input type="date" class="form-control" id="bday" placeholder="Enter your birthday" name="bday" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 my-2">
              <label for="nation">Nationality:</label>
              <input type="text" class="form-control" id="nation" placeholder="Enter your country" name="nation"
                required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>

          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
              <label for="passport">Passport N°:</label>
              <input type="text" class="form-control" id="passport" placeholder="Enter your passport N°" name="passport"
                required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
              <label for="idcard">ID Card:</label>
              <input type="text" class="form-control" id="idcard" placeholder="Enter card ID" name="idcard" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
              <label for="phone">Phone N°:</label>
              <input type="phone" class="form-control" id="phone" placeholder="Ex: +0123-456-789" name="phone" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-6 my-2">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-xs-12 col-sm-6 my-2"></div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" name="singin">Submit</button>
      </form>
    </div>
    <div class="tab-pane container fade" id="login">
      <h1 class="mt-4">Login:</h1>
      <form action="regester.php<?php echo isset($_GET['id']) ? '?id='.$_GET['id'] : ''; ?>" method="POST"
        class="needs-validation mt-4" novalidate>
        <div class="row">
          <div class="col-xs-12 col-sm-6 my-2">
            <div class="form-group">
              <label for="lgemail">Your Email:</label>
              <input type="email" class="form-control" id="lgemail" placeholder="Enter Your Email" name="lgemail"
                required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 my-2">
            <div class="form-group">
              <label for="lgpwd">Password:</label>
              <input type="password" class="form-control" id="lgpwd" placeholder="Enter password" name="lgpswd"
                required>
              <div class="valid-feedback">Valid.</div>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" name="loggin">Submit</button>
      </form>
    </div>
  </div>

  <script>
    // Disable form submissions if there are invalid fields
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</div>
<?php mysqli_close($connection); ?>
</body>

</html>