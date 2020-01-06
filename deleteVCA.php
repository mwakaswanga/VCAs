<?php
	$vca = $_REQUEST['vca_id'];
	include('includes/dbConfig.php');
	$sql_del = "DELETE FROM registered_vcas WHERE vca_id = '$vca'";
	$result_del = mysqli_query($conn, $sql_del);
	if ($result_del) {
		header('Location:vcaAnalysisMore.php');
	}
?>