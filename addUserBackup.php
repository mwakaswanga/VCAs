<?php
  session_start();

  if (!isset($_SESSION['username'])) {
      header("Location:index.php");
  }/**elseif ($_SESSION['privilege'] !== '3') {
      $_SESSION['no_access'] = "You don't have privilege to manage users, contact the admin!";
      header("Location:landingPage.php");
  }**/

  if (isset($_POST['fname'])) {
    
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $priv = $_POST['priv'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];

    $hash = sha1($pass); //password hashing

    if ($pass !== $repass) {
        $_SESSION['error_password'] = "Your passwords don't match";
    }else{

        include('includes/dbConfig.php');
        $sql = "SELECT username FROM users WHERE username = '$email'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $rows = mysqli_num_rows($result);
            if ($rows >= 1) {
                $_SESSION['user_exist'] = "This user already exists!";
            }else{
                $sql = "INSERT INTO users(firstname, surname, username, password, designation, privilege) VALUES('$fname', '$sname', '$email', '$hash', '$designation', '$priv')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION['user_added'] = "User successfully added!";
                }

            }
        }

    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>J-OKRs | Add User</title>
    <!-- Importing CSS style from a bootstrap file -->
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style/custom_css.css">
  </head>

  <body>

    <div class="container">

      <div class="row">

          <form class="form-horizontal" action="addUser.php" method="POST">

             <div class="form-group">
              <div class="col-md-offset-3 col-md-6">
                <?php
                    if (isset($_SESSION['error_password'])) {
                        echo "<span class='error_message'>".$_SESSION['error_password']."</span>";
                    }elseif (isset($_SESSION['user_exist'])) {
                        echo "<span class='error_message'>".$_SESSION['user_exist']."</span>";
                    }elseif (isset($_SESSION['user_added'])) {
                        echo "<span class='success_message'>".$_SESSION['user_added']." You can <a href='addUser.php'>add more users</a> or go back to <a href='landingPage.php'>main panel</a></span>";
                    }

                    //unsetting all sessions
                    unset($_SESSION['error_password']);
                    unset($_SESSION['user_exist']);
                    unset($_SESSION['user_added']);
                ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="fname">First name(s):</label>
              <div class="col-md-6">
                <input type="text" name="fname" class="form-control" id="fname" placeholder="first name">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="surname">Surname:</label>
              <div class="col-md-6">
                <input type="text" name="sname" class="form-control" id="sname" placeholder="family name">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="designation">Designation:</label>
              <div class="col-md-6">
                <input type="text" name="designation" class="form-control" id="designation" placeholder="designation">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="email">Email address:</label>
              <div class="col-md-6">
                <input type="email" name="email" class="form-control" id="email" placeholder="jhpiego email address">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="priv">Privilege:</label>
              <div class="col-md-6">
                   <select class="form-control" id="priv" name="priv">
                      <option value="admin">Admin</option>
                      <option value="header">Head of Project (Department)</option>
                      <option value="end_user">End User</option>
                    </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="password">Password (J-OKRs):</label>
              <div class="col-md-6">
                <input type="password" name="pass" class="form-control" id="pass" placeholder="password">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3" for="email">Confirm password (J-OKRs):</label>
              <div class="col-md-6">
                <input type="password" name="repass" class="form-control" id="repass" placeholder="re-enter your above password">
              </div>
            </div>

            <div class="form-group"> 
                <div class="col-md-offset-3 col-md-10">
                  <button type="submit" class="btn btn-primary">Create account</button>
                </div>
            </div>

          </form>

      </div>
    </div>
  
  <!-- Importing JS from a boostrap file -->
  <script type="text/javascript"></script>
  </body>
</html>