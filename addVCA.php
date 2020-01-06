<?php
	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	if (isset($_POST['fname']) && isset($_POST['sname']) && isset($_POST['age']) && isset($_POST['gender'])) {

		$fname = $_POST['fname'];
		$sname = $_POST['sname'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$exec = $_SESSION['user_id'];
		
		include('includes/dbConfig.php');

		$sql_chck_dup = "SELECT * FROM registered_vcas WHERE (firstname = '$fname' AND surname = '$sname' AND age = '$age' AND gender = '$gender')";
		$result_chck_dup = mysqli_query($conn, $sql_chck_dup);
		if ($result_chck_dup) {
			$rows_chck_dup = mysqli_num_rows($result_chck_dup);
			if ($rows_chck_dup == 0) {
				
				$sql = "INSERT INTO registered_vcas(firstname, surname, age, gender, user) VALUES('$fname', '$sname', '$age', '$gender', '$exec')";
				$result = mysqli_query($conn, $sql);
				if ($result) {

					//SQL to get VCA id
					$sql_gt_id = "SELECT * FROM registered_vcas ORDER BY vca_id DESC LIMIT 1";
					$eresult_gt_id = mysqli_query($conn, $sql_gt_id);
					if ($eresult_gt_id) {
						$data = mysqli_fetch_array($eresult_gt_id, MYSQLI_ASSOC);
					}

					$_SESSION['usr_chck'] = $fname." ".$sname." has been successfully added to the database! with VCA ID: ".$data['vca_id'];
				}
			}
			else{
				$_SESSION['usr_chck_err'] = 'This VCA already exists in the database!';
			}
		}
	}
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>JhpVCAs | Register VCA</title>
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
			<div id="nav_main" class="col-md-2">
				<?php include("includes/nav_main.php");?>
			</div>

			<div id="display" class="col-md-10">

		          <form class="form-horizontal" action="addVCA.php" method="POST">

			            <div class="form-group">
			              <label class="control-label col-md-1" for="project">First name:</label>
			              <div class="col-md-4">
			                <input type="text" name="fname" class="form-control" id="fname" placeholder="VCAs first name">
			              </div>
			            </div>

			            <div class="form-group">
			              <label class="control-label col-md-1" for="project">Surname:</label>
			              <div class="col-md-4">
			                <input type="text" name="sname" class="form-control" id="sname" placeholder="VCAs last name">
			              </div>
			            </div>

			             <div class="form-group">
			              <label class="control-label col-md-1" for="project">Age:</label>
			              <div class="col-md-4">
			                <input type="number" name="age" class="form-control" id="age" placeholder="age">
			              </div>
			            </div>

			             <div class="form-group">
			              <label class="control-label col-md-1" for="project">Gender:</label>
			              <div class="col-md-4">
			                  <select class="form-control" name="gender" id="gender">
			                     <option value="Male">Male</option>
			                     <option value="Female">Female</option>
			                     <option value="Other">Other</option>
			                  </select>
			              </div>
			            </div>

						<div class="form-group">
							<label class="control-label col-md-1" for="fname">Region:</label>
							<div class="col-md-3">
								<select name="region">
									<option value="Iringa">Iringa</option>
									<option value="Morogoro">Morogoro</option>
									<option value="Njombe">Njombe</option>
									<option value="Singida">Singida</option>
									<option value="Tabora">Tabora</option>
								</select>
							</div>	
						</div>

						<div class="form-group">
							<label class="control-label col-md-1" for="fname">District:</label>
							<div class="col-md-3">
								 <input type="text" name="district" class="form-control" id="district" placeholder="district">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-1" for="fname">Ward:</label>
							<div class="col-md-3">
								 <input type="text" name="ward" class="form-control" id="ward" placeholder="ward">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-1" for="fname">CCL:</label>
							<div class="col-md-3">
								 <select name="vca_id">
			                		<?php
			                			include('includes/dbConfig.php');
			                			$sql = "SELECT * FROM users WHERE designation = 'CCL'";
			                			$result = mysqli_query($conn, $sql);
			                			if ($result) {
			                				$rows = mysqli_num_rows($result);
			                				while ($data = mysqli_fetch_row($result)) {
			                                  echo '<option value="'.$data['0'].'">'.$data['0']." -- ".$data["1"]." ".$data['2'].'</option>';
			                                }
						                }
			                		?>
			                	</select>
							</div>
						</div>

			            <div class="form-group"> 
			                <div class="col-md-offset-1 col-md-10">
			                 		<?php
			                 			if (isset($_SESSION['usr_chck'])) {
			                 				echo '<span class = "success">'.$_SESSION['usr_chck'].'</span>';
			                 			}elseif (isset($_SESSION['usr_chck_err'])) {
			                 				echo '<span class = "error">'.$_SESSION['usr_chck_err'].'</span>';
			                 			}

			                 			unset($_SESSION['usr_chck']);
                      					unset($_SESSION['usr_chck_err']);
			                 		?>
			                </div>
			            </div>

			            <div class="form-group"> 
			                <div class="col-md-offset-1 col-md-10">
			                  <button type="submit" class="btn btn-primary">Submit</button>
			                </div>
			            </div>

		          </form>

			</div>
		</div>		
	</div>
</body>
</html>