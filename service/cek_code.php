<?php
	require_once 'config.php';
	// Create connection
	$mysql = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($mysql->connect_error) {
		$die("Connection failed: " . $mysql->connect_error);
	}

    if (!empty($_POST)) {
        $token = $_POST['token'];
    
        $query = mysqli_query($mysql, "SELECT * FROM users WHERE token = '$token'");
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
                'message' => 'Code is Wrong!! Please Sign In or Sign up to get Code!'
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
			'status' => 401,
			'message' => 'Code can\'t empty!'
		];
		echo json_encode($response);
    }
	
?>