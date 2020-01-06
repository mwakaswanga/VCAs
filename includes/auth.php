<?php
	session_start();

	include("dbConfig.php");

	if (!$conn) {
		die("Connection failed: ".mysqli_connect_error());
	}
	else{

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = $_POST['username'];
			$password = $_POST['pass'];
			$hash = sha1($password);
			//SQL Query
			$sql = "SELECT * FROM users WHERE (username = '$username' AND password = '$hash')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				
				$rows = mysqli_num_rows($result);
				if ($rows == 1) {
					
					$data = mysqli_fetch_array($result, MYSQLI_ASSOC);

					$_SESSION['user_id'] = $data['user_id'];
					$_SESSION['username'] = $data['username'];
					$_SESSION['privilege'] = $data['privilege'];

					header("Location:../main.php");

				}

				else{

					$_SESSION['login_error'] = 'Wrong username and password combination!';
					header("Location:../index.php");
				}
			}
		}
	}
?>