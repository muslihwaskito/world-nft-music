<?php
	require_once 'config.php';
	// Create connection
	$mysql = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($mysql->connect_error) {
		$die("Connection failed: " . $mysql->connect_error);
	}

    if (!empty($_POST)) {
        
		$email = $_POST['email'];
		$password = md5($_POST['password']);
	
		$query = mysqli_query($mysql, "SELECT token FROM users WHERE email = '$email' and password = '$password'");
		$result = mysqli_fetch_assoc($query);
		if ($result) {
			$response = [
				'status' => 200,
				'data' => [
					'token' => $result['token']
				]
			];
			echo json_encode($response);
		} else {
			$response = [
				'status' => 401,
				'message' => 'Email or password is wrong!'
			];
			echo json_encode($response);
		}
    } else {
        $response = [
			'status' => 401,
			'message' => 'Email or password can\'t empty!'
		];
		echo json_encode($response);
    }
	
?>