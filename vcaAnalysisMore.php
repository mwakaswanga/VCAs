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
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>VCA ID</th>
							<th>First name</th>
							<th>Surname</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php

							include('includes/dbConfig.php');

							if (isset($_POST['search_value'])) {
								$search_value = $_POST['search_value'];
								$sql = "SELECT * FROM registered_vcas WHERE (vca_id='$search_value' OR firstname='$search_value' OR surname='$search_value' OR age='$search_value' OR gender='$search_value' OR region='$search_value' OR district='$search_value' OR ward='$search_value' OR ccl='$search_value' OR user='$search_value')";
								$result = mysqli_query($conn, $sql);
								if ($result) {
									$rows = mysqli_num_rows($result);
									for ($i=0; $i < $rows; $i++) { 
										$data = mysqli_fetch_assoc($result);
										?>
											<tr>
												<td><?php echo $data['vca_id'];?></td>
												<td><?php echo $data['firstname'];?></td>
												<td><?php echo $data['surname'];?></td>
												<td>
													<a href="deleteVCA.php?vca_id=<?=$data['vca_id']?>"><button class="btn btn-danger">Delete</button></a>
													<a href="updateVCA.php"><button class="btn btn-warning">Update</button></a>
													<a href="moreDetails.php"><button class="btn btn-success">More details</button></a>
												</td>
											</tr>
										<?php
									}
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</body>
</html>
<?php		
	}
?>