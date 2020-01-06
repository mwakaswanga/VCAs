<?php
	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}
	else{
		
?>
<!DOCTYPE html>
<html>
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
			<div id="nav_main" class="col-md-2">
				<?php include("includes/nav_main.php");?>
			</div>

			<div id='error_backward' class="col-md-10" style="margin-top: 30px;">
				<div class="col-md-5">
					<?php
						if (isset($_SESSION['no_access'])) {
							echo "<span class='error'>".$_SESSION['no_access']."</span>";
							unset($_SESSION['no_access']);
						}
					?>
				</div>
			</div>

			<div id="display" class="col-md-10" style="margin-top: 30px;">

				<div class="col-md-2" id="label_referrals" style="text-align: center; font-weight: bold; background-color: #ecf8ec; padding-top: 20px; padding-bottom: 20px;">
					<a href="#" style="text-decoration: none;">Registered<br/>VCAs</a>
				</div>
				
				<div class="col-md-3" id="no_vcas">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 60px; padding-left: 60px; color: white;">No. of VCAs</span><br/>
					<span style="font-size: 70px; color: green;">
						<?php
							include('includes/dbConfig.php');
							$sql_v = "SELECT * FROM registered_vcas ";
							$result_v = mysqli_query($conn, $sql_v);
							if ($result_v) {
								$rows = mysqli_num_rows($result_v);
								echo $rows;
							}
						?>
					</span>
				</div>

				<div class="col-md-3" id="gndr_vcas">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 60px; padding-left: 60px; color: white;">Male</span><br/>
					<span style="font-size: 70px; color: green;">
					<?php 
						include('includes/dbConfig.php');
						//Male percentage
						$sql_m = "SELECT * FROM registered_vcas WHERE gender = 'Male'";
						$result_m = mysqli_query($conn, $sql_m);
						if ($result_m) {
							$rows_m = mysqli_num_rows($result_m);
							$pc_m = ($rows_m/$rows) * 100;
							echo round($pc_m, 1)."%";
							//echo $rows_m;
						}
					?>
				</span>
				</div>

				<div class="col-md-3" id="gndr_vcas">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 60px; padding-left: 60px; color: white;">Female</span><br/>
					<span style="font-size: 70px; color: green;">
					<?php 
						include('includes/dbConfig.php');
						//Male percentage
						$sql_f = "SELECT * FROM registered_vcas WHERE gender = 'Female'";
						$result_f = mysqli_query($conn, $sql_f);
						if ($result_f) {
							$rows_f = mysqli_num_rows($result_f);
							$pc_f = ($rows_f/$rows) * 100;
							echo round($pc_f, 1)."%";
							//echo $rows_m;
						}
					?>
				</span>
				</div>
			</div>

			<div id="display_referrals" class="col-md-10" style="margin-top: 30px;">

				<div class="col-md-2" id="label_referrals" style="text-align: center; font-weight: bold; background-color: #e6f0ff; padding-top: 20px; padding-bottom: 20px;">
					<a href="#" style="text-decoration: none;">Referrals and<br/>Circumcisions</a>
				</div>
				
				<div class="col-md-3" id="no_referrals">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 58px; padding-left: 58px; color: white;">Cum. Referrals</span><br/>
					<span style="font-size: 70px; color: green">
						<?php
							include('includes/dbConfig.php');
							//Total referrals
							$sql_ref = "SELECT SUM(r1) + SUM(r1r9) + SUM(r10r14) + SUM(r15r19) + SUM(r20r24) + SUM(r25r29) + SUM(r30r34) + SUM(r35r49) + SUM(r50plus) AS 'Referrals' FROM services";
							$result_ref = mysqli_query($conn, $sql_ref);
							if ($result_ref) {
								$rows_ref = mysqli_num_rows($result_ref);
								$data_ref = mysqli_fetch_assoc($result_ref);
								echo $data_ref['Referrals'];
							}
						?>
					</span>
				</div>

				<div class="col-md-3" id="no_referrals">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 21px; padding-left: 21px; color: white;">Perc. Circumcised</span><br/>
					<span style="font-size: 70px; color: blue;">
						<?php
							include('includes/dbConfig.php');
							//Total circumcision
							$sql_circ = "SELECT SUM(c1) + SUM(c1c9) + SUM(c10c14) + SUM(c15c19) + SUM(c20c24) + SUM(c25c29) + SUM(c30c34) + SUM(c35c49) + SUM(c50plus) AS 'Circ' FROM services";
							$result_circ = mysqli_query($conn, $sql_circ);
							if ($result_circ) {
								$rows_circ = mysqli_num_rows($result_circ);
								$data_circ = mysqli_fetch_assoc($result_circ);
								$data_circ['Circ'];
								/**
								Calculate percentage of circumcised clients out of the referrals
								**/
								$perc_circ = ($data_circ['Circ']/$data_ref['Referrals'])*100;
								echo round($perc_circ, 1)."%";
							}
						?>
					</span>
				</div>

				<div class="col-md-3" id="no_referrals">
					<span style="background-color:  black; padding-top: 5px; padding-bottom: 5px; padding-right: 18px; padding-left: 18px; color: white;">Perc. Not Circumcised</span><br/>
					<span style="font-size: 70px; color: red;">
						<?php
							//Percentage of uncircumcised clients out of all referrals
							$perc_not_circ = 100 - $perc_circ;
							echo round($perc_not_circ, 1)."%";
						?>
					</span>
				</div>

			</div>

			<div id="display" class="col-md-offset-2 col-md-10" style="margin-top: 30px;">

				<table class="table">
					<thead>
						<tr>
							<th class="info">Year</th>
							<th class="success">Referrals</th>
							<th class="warning">Perc. Circ.</th>
							<th class="danger">Perc. Referred BUT NOT Circ.</th>
						</tr>
					</thead>
					<?php

						include('includes/dbConfig.php');
						// Referrals Vs Circumcision by year
						$sql_rvc = "SELECT year, SUM(r1)+SUM(r1r9)+SUM(r10r14)+SUM(r15r19)+SUM(r20r24)+SUM(r25r29)+SUM(r30r34)+SUM(r35r49)+SUM(r50plus) AS 'Ref',SUM(c1)+SUM(c1c9)+SUM(c10c14)+SUM(c15c19)+SUM(c20c24)+SUM(c25c29)+SUM(c30c34)+SUM(c35c49)+SUM(c50plus) AS 'Circ' FROM services GROUP BY year";
						$result_rvc = mysqli_query($conn, $sql_rvc);
						if ($result_rvc) {
						 	$rows_rvc = mysqli_num_rows($result_rvc);
						 	for ($i=0; $i < $rows_rvc; $i++) { 
						 		$data_rvc = mysqli_fetch_assoc($result_rvc);
						 		?>
						 		<tbody>
						 			<tr>
						 				<td class="info"><?php echo $data_rvc['year']; ?></td>
						 				<td class="success"><?php echo $data_rvc['Ref']; ?></td>
						 				<td class="warning">
						 					<?php 
						 						$perc_rvc = ($data_rvc['Circ']/$data_rvc['Ref']) * 100;
						 						echo round($perc_rvc, 1)."%";
						 				 	?>	
						 				 </td>
						 				<td class="danger">
						 				<?php
						 					$perc_nrvc = 100 - $perc_rvc;
						 					echo round($perc_nrvc, 1)."%";
 						 				?>	
						 				</td>
						 			</tr>
						 		</tbody>
						 		<?php
						 	}
						 } 

					?>
				</table>
			</div>

		</div>		
	</div>
</body>
</html>
<?php		
	}
?>