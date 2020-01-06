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
		<div id="display" class="col-md-10" style="margin-top: 10px;">
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<div class="col-md-3">
					<label><span style="color: green; background-color: black; padding: 10px;">10 Highest Performing VCAs</span></label>
				</div>
			</div>
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<div class="col-md-8">
					<table class="table table-striped table-condensed">
						<thead>
							<tr class="success">
								<th>Name</th>
								<th>Gender</th>
								<th>Age</th>
								<th>Total Referrals</th>
								<th>% Referrals</th>
							</tr>
						</thead>
						<tbody>
							<?php
								include('includes/dbConfig.php');

								$sql_hpv = "SELECT r.firstname AS 'fname', r.surname AS 'sname', r.age AS 'age', r.gender AS 'gender', SUM(s.r1)+SUM(s.r1r9)+SUM(s.r10r14)+SUM(s.r15r19)+SUM(s.r20r24)+SUM(s.r25r29)+SUM(s.r30r34)+SUM(s.r35r49)+SUM(s.r50plus) AS 'totalRef', vca FROM registered_vcas r INNER JOIN services s WHERE r.vca_id = s.vca GROUP BY vca ORDER BY totalRef DESC LIMIT 10";
								$result_hpv = mysqli_query($conn, $sql_hpv);

								if ($result_hpv) {
									$rows_hpv = mysqli_num_rows($result_hpv);
									for ($i=0; $i < $rows_hpv ; $i++) { 
										$data_hpv = mysqli_fetch_assoc($result_hpv);
										?>
										<tr>
											<td><?php echo $data_hpv['fname']." ".$data_hpv['sname'];?></td>
											<td><?php echo $data_hpv['gender'];?></td>
											<td><?php echo $data_hpv['age'];?></td>
											<td><?php echo $data_hpv['totalRef'];?></td>
											<td><?php echo '45%';?></td>
										</tr>
										<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>	
			</div>
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<?php
					if (isset($_SESSION['incomplete'])) {
						echo "<span style='color:red'>".$_SESSION['incomplete']."</span>";
						unset($_SESSION['incomplete']);
					}
				?>
			</div>
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<div class="col-md-3">
					<label><span style="color: red; background-color: black; padding: 10px;">10 Lowest Performing VCAs</span></label>
				</div>
			</div>
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<div class="col-md-8">
					<table class="table table-striped table-condensed">
						<thead>
							<tr class="danger">
								<th>Name</th>
								<th>Gender</th>
								<th>Age</th>
								<th>Total Referrals</th>
								<th>% Referrals</th>
							</tr>
						</thead>
						<tbody>
							<?php
								include('includes/dbConfig.php');

								$sql_hpv = "SELECT r.firstname AS 'fname', r.surname AS 'sname', r.age AS 'age', r.gender AS 'gender', SUM(s.r1)+SUM(s.r1r9)+SUM(s.r10r14)+SUM(s.r15r19)+SUM(s.r20r24)+SUM(s.r25r29)+SUM(s.r30r34)+SUM(s.r35r49)+SUM(s.r50plus) AS 'totalRef', vca FROM registered_vcas r INNER JOIN services s WHERE r.vca_id = s.vca GROUP BY vca ORDER BY totalRef ASC LIMIT 10";
								$result_hpv = mysqli_query($conn, $sql_hpv);

								if ($result_hpv) {
									$rows_hpv = mysqli_num_rows($result_hpv);
									for ($i=0; $i < $rows_hpv ; $i++) { 
										$data_hpv = mysqli_fetch_assoc($result_hpv);
										?>
										<tr>
											<td><?php echo $data_hpv['fname']." ".$data_hpv['sname'];?></td>
											<td><?php echo $data_hpv['gender'];?></td>
											<td><?php echo $data_hpv['age'];?></td>
											<td><?php echo $data_hpv['totalRef'];?></td>
											<td><?php echo '45%';?></td>
										</tr>
										<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>	
			</div>
			<div id="display" class="col-md-10" style="margin-top: 30px;">
				<form action="vcaAnalysisMore.php" method="POST" class="form-inline">
					<div class="form-group">
						<label for="vca_search">Search VCA By: </label>
						<select name="search_cat" id="search_cat">
							<?php
								include('includes/dbConfig.php');

								$sql_desc = "describe registered_vcas";
								$result_desc = mysqli_query($conn, $sql_desc);
								if ($result_desc) {
									$rows_desc = mysqli_num_rows($result_desc);
									for ($i=0; $i < $rows_desc; $i++) { 

										$data_desc = mysqli_fetch_assoc($result_desc);
										?>
										<option value="<?php $data_desc['Field'];?>"><?php echo $data_desc['Field'];?></option>
										<?php
									}

									$_SESSION['search_cat'] = $data_desc['Field'];
								}
							?>
						</select>
						<input type="text" name="search_value">
						<button class="btn btn-primary btn-sm" type="submit">Search</button>
					</div>					
				</form>
			</div>
		</div>	
		</div>		
	</div>
</body>
</html>
<?php		
	}
?>
