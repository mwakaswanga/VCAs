<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>JhpCRS | Login</title>
	<link rel="stylesheet" href="includes/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="includes/bootstrap/js/bootstrap.js">
	<link rel="stylesheet" href="includes/design.css">
</head>
<body>
	<div class="container">
		<div class="row" id="header">
			<h2>VCAs Database</h2>
		</div>

		<div class="row" id="new_account">
			<h2><a href="#">Request New Account</a></h2>
		</div>
		
			<form action="includes/authentication.php" method="POST">
				
				<div class="row" id="data_fields">
					<div class="form-group">
						<label class="control-label">Username</label>
						<input type="text" name="username" class="form-control">			
					</div>

					<div class="form-group">
						<label class="control-label">Password</label>
						<input type="password" name="pass" class="form-control">			
					</div>

					 <!-- Hidden input to be used to capture an error-->
            		 <input type="hidden" id="custId" name="error_value" value="error">

					<div class="form-group"> 
		                <div class="col-md-offset-3 col-md-10">
		                 <?php  
		                      if(isset($_SESSION['$error_value']))
		                      {
		                        echo "<span id='error' style = 'color:red'>Wrong user name and password combination!</span>";
		                        unset($_SESSION['$error_value']);
		                      }
		                  ?>
		                </div>
		            </div>

					<button class="btn btn-primary btn-lg" type="submit">Login</button>

				</div>

				<div class="row" id="footer">
					<div form-group>
						<label class="control-label"><a href="">Update password</a></label>
					</div>
					<div class="form-group">
						<label class="control-label"><a href="">Forgot Username or Password</a></label>	
					</div>
				</div>

			</form>
	</div>
</body>
</html>
