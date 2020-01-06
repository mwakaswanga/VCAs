<?php
	
	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	if (isset($_POST['vca_id']) && isset($_POST['r1']) && isset($_POST['c1'])) {
		
		$month = $_POST['month'];
		$year = $_POST['year'];
		$exec = $_SESSION['user_id'];
		$vca = $_POST['vca_id'];
		//referred
		$r1 = $_POST['r1'];
		$r1r9 = $_POST['r1r9'];
		$r10r14 = $_POST['r10r14'];
		$r15r19 = $_POST['r15r19'];
		$r20r24 = $_POST['r20r24'];
		$r25r29 = $_POST['r25r29'];
		$r30r34 = $_POST['r30r34'];
		$r35r49 = $_POST['r35r49'];
		$r50plus = $_POST['r50plus']; 
		//circumcised
		$c1 = $_POST['c1'];
		$c1c9 = $_POST['c1c9'];
		$c10c14 = $_POST['c10c14'];
		$c15c19 = $_POST['c15c19'];
		$c20c24 = $_POST['c20c24'];
		$c25c29 = $_POST['c25c29'];
		$c30c34 = $_POST['c30c34'];
		$c35c49 = $_POST['c35c49'];
		$c50plus = $_POST['c50plus'];

		include('includes/dbConfig.php');

		$sql_chck_dup = "SELECT * FROM services WHERE (month = '$month' AND year = '$year' AND vca = '$vca')";
		$result_chck_dup = mysqli_query($conn, $sql_chck_dup);
		if ($result_chck_dup) {
			$rows_chck_dup = mysqli_num_rows($result_chck_dup);
			if ($rows_chck_dup == 0) {
				
				$sql = "INSERT INTO services(month, year, user, vca, r1, r1r9, r10r14, r15r19, r20r24, r25r29, r30r34, r35r49, r50plus, c1, c1c9, c10c14, c15c19, c20c24, c25c29, c30c34, c35c49, c50plus) VALUES('$month','$year','$exec','$vca','$r1','$r1r9','$r10r14','$r15r19','$r20r24','$r25r29','$r30r34','$r35r49','$r50plus','$c1','$c1c9','$c10c14','$c15c19','$c20c24','$c25c29','$c30c34','$c35c49','$c50plus')"; 
				$result = mysqli_query($conn, $sql);
				if ($result) {
					$_SESSION['add_success'] = 'Record successfully added!';
					
				}
			}
			else{
				$_SESSION['dup'] = 'This record already exists in the database!';
			}
		}

	}
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>JhpVCAs | VCA Referrals</title>
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

		          <form class="form-horizontal" action="addService.php" method="POST">

		          	<div class="form-group"> 
			                <div class="col-md-10">
			                 	<?php
			                 		if (isset($_SESSION['add_success'])) {
			                 			echo '<span class = "success">'.$_SESSION['add_success'].'</span>';
			                 		}elseif (isset($_SESSION['dup'])) {
			                 			echo '<span class = "error">'.$_SESSION['add_success'].'</span>';
			                 		}

			                 		unset($_SESSION['dup']);
			                 		unset($_SESSION['add_success']);
			                 	?>
			                </div>
			            </div>

		          	<div id="background" style="background-color: #99c2ff; margin-right: 400px; padding: 20px; margin-bottom: 20px; color: black; opacity: 0.8;">
			            <div class="form-group">
			              <label class="control-label col-md-2" for="project">VCA Name:</label>
			              <div class="col-md-4">
			                	<select name="vca_id">
			                		<?php
			                			include('includes/dbConfig.php');
			                			$sql = "SELECT * FROM registered_vcas";
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
			              <label class="control-label col-md-2" for="project">Month:</label>
			              <div class="col-md-4">
			                	<select name="month">
			                		<option value="January">January</option>
			                		<option value="February">February</option>
			                		<option value="March">March</option>
			                		<option value="April">April</option>
			                		<option value="May">May</option>
			                		<option value="June">June</option>
			                		<option value="July">July</option>
			                		<option value="August">August</option>
			                		<option value="September">September</option>
			                		<option value="October">October</option>
			                		<option value="November">November</option>
			                		<option value="December">December</option>
			                	</select>
			              </div>
			            </div>  

			            <div class="form-group">
			            	<label class="control-label col-md-2" for="project">Year:</label>
			            	<div class="col-md-4">
			            		<select name="year">
			            			<option value="2010">2010</option>
			            			<option value="2011">2011</option>
			            			<option value="2012">2012</option>
			            			<option value="2013">2013</option>
			            			<option value="2014">2014</option>
			            			<option value="2015">2015</option>
			            			<option value="2016">2016</option>
			            			<option value="2017">2017</option>
			            			<option value="2018">2018</option>
			            			<option value="2019">2019</option>
			            			<option value="2020">2020</option>
			            			<option value="2021">2021</option>
			            		</select>
			            	</div>
			            </div>
			           </div>

			            <div id="referral" style="background-color: #E9F385; margin-right: 400px; padding: 20px; margin-bottom: 20px;">

			            	<div class="form-group">
								<label class="control-label col-md-2">Referred < 1 :</label>
								<div class="col-md-4">
									<input type="number" name="r1" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 1 - 9 :</label>
								<div class="col-md-4">
									<input type="number" name="r1r9" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 10 - 14 :</label>
								<div class="col-md-4">
									<input type="number" name="r10r14" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 15 - 19 :</label>
								<div class="col-md-4">
									<input type="number" name="r15r19" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 20 - 24 :</label>
								<div class="col-md-4">
									<input type="number" name="r20r24" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 25 - 29 :</label>
								<div class="col-md-4">
									<input type="number" name="r25r29" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 30 - 34 :</label>
								<div class="col-md-4">
									<input type="number" name="r30r34" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 35 - 49 :</label>
								<div class="col-md-4">
									<input type="number" name="r35r49" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Referred 50+ :</label>
								<div class="col-md-4">
									<input type="number" name="r50plus" class="form-control">
								</div>
							</div>

			            </div>

			      		<div id="circumcised" style="background-color: #E2EEF0; margin-right: 400px; padding: 20px; margin-bottom: 20px;">

			            	<div class="form-group">
								<label class="control-label col-md-2">Circumcised < 1 :</label>
								<div class="col-md-4">
									<input type="number" name="c1" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 1 - 9 :</label>
								<div class="col-md-4">
									<input type="number" name="c1c9" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 10 - 14 :</label>
								<div class="col-md-4">
									<input type="number" name="c10c14" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 15 - 19 :</label>
								<div class="col-md-4">
									<input type="number" name="c15c19" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 20 - 24 :</label>
								<div class="col-md-4">
									<input type="number" name="c20c24" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 25 - 29 :</label>
								<div class="col-md-4">
									<input type="number" name="c25c29" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 30 - 34 :</label>
								<div class="col-md-4">
									<input type="number" name="c30c34" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 35 - 49 :</label>
								<div class="col-md-4">
									<input type="number" name="c35c49" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Circumcised 50+ :</label>
								<div class="col-md-4">
									<input type="number" name="c50plus" class="form-control">
								</div>
							</div>

			            </div>

			            <div class="form-group"> 
			                <div class="col-md-10">
			                  <button type="submit" class="btn btn-primary">Submit</button>
			                </div>
			            </div>

		          </form>

			</div>
		</div>		
	</div>
</body>
</html>