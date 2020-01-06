<?php
  session_start();

  if (!isset($_SESSION['username'])) {
      header("Location:index.php");
  }elseif ($_SESSION['privilege'] != 3) {
      $_SESSION['no_access'] = "You don't have enough privilege to perform this operation! Contact the admin";
      header('Location:main.php');
  }

  if (isset($_POST['fname'])) {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];
    $email = $_POST['email'];
    $priv = $_POST['privilege'];

    $hash = sha1($pass);

    if($pass === $repass) {
      
      include('includes/dbConfig.php');

      $sql_chck_usr = "SELECT * FROM users WHERE username = '$uname' AND email = '$email'";
      $result_chck_usr = mysqli_query($conn, $sql_chck_usr);
      if ($result_chck_usr) {
          $rows_chck_usr = mysqli_num_rows($result_chck_usr);
           //check if similar username already exists in the system
          if ($rows_chck_usr > 0) {
              unset($uname);
              $_SESSION['usr_chck_error'] = "This username already exists! Either reset password or use different username if it's first new registration!";
              unset($_SESSION['usr_add']);
          }else{
              //add new user to the system, after confirming that there is no dupicate
              $sql_usr_add = "INSERT INTO users(firstname, surname, username, password, privilege, email) VALUES('$fname','$sname','$uname','$hash','$priv','$email')";
              $result_usr_add = mysqli_query($conn, $sql_usr_add);
              if ($result_usr_add) {
                  $_SESSION['usr_add'] = $fname." ".$sname." has been successfully added!";
                  unset($_SESSION['usr_chck_error']);
                  unset($fname);
                  unset($sname);
                  unset($uname);
              }
          }
      }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
  <title>JhpCRS | Home</title>
  <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="includes/bootstrap/js/bootstrap.js">
  <link rel="stylesheet" href="includes/design.css">
</head>

  <body>
  <div id="header_strip">
    <h1>Jhpiego VCAs Database <span id="jhpcrs">JhpVCAs</span></h1>
  </div>

  <div class="cont">
    <div class="row">



      <form class="form-horizontal" action="addUser.php" method="POST">
      <div id="nav_main" class="col-md-2">
        <?php include("includes/nav_main.php");?>
      </div>
      
      <div class="col-md-10">

            <div class="form-group">
              <div class="col-md-5">
               <?php
                  if (isset($_SESSION['usr_add'])) {
                      echo "<span class='success'>".$_SESSION['usr_add']."</span>";
                      unset($_SESSION['usr_add']);
                  }elseif (isset($_SESSION['usr_chck_error'])) {
                      echo "<span class='error'>".$_SESSION['usr_chck_error']."</span>";
                      unset($_SESSION['usr_chck_error']);
                  }
               ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">First name:</label>
              <div class="col-md-3">
                <input type="text" name="fname" class="form-control" id="fname" placeholder="first name">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Surname:</label>
              <div class="col-md-3">
                <input type="text" name="sname" class="form-control" id="sname" placeholder="surname">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Username:</label>
              <div class="col-md-3">
                <input type="text" name="uname" class="form-control" id="uname" placeholder="username">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Paswword:</label>
              <div class="col-md-3">
                <input type="password" name="pass" class="form-control" id="pass" placeholder="password">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Re - Paswword:</label>
              <div class="col-md-3">
                <input type="password" name="repass" class="form-control" id="pass" placeholder="enter password again">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Email:</label>
              <div class="col-md-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="email address">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-1" for="fname">Privilege:</label>
              <div class="col-md-3">
                <input type="number" name="privilege" class="form-control" id="privilege" placeholder="enter 1 or 2 for privilege">
              </div>
            </div>
      </div>

       <div class="form-group"> 
                <div class="col-md-offset-2 col-md-3">
                  <button type="submit" class="btn btn-primary">Add user</button>
                </div>
            </div>
    </form>
      </div>
    </div>    
  </div>
</body>
</html>