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
    
        $query = mysqli_query($mysql, "SELECT * FROM users WHERE email = '$email'");
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $response = [
                'status' => 401,
                'message' => 'email '.$email.' is exist ! Please Sign In !'
            ];
            echo json_encode($response);
        } else {
            $token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6/strlen($x)) )),1,6);
            $created_at = date('Y-m-d H:i:s');
            $insert = mysqli_query($mysql, "INSERT INTO users(email, password, token, created_at) VALUES('$email', '$password', '$token', '$created_at')");
            if ($insert) {
                $response = [
                    'status' => 200,
                    'message' => 'Sign up successfully, Please Sign In to get code to buy presale!'
                ];
                echo json_encode($response);
            } else {
                echo mysqli_error($mysql);
                $response = [
                    'status' => 401,
                    'message' => 'Server error, please try again later!'
                ];
                echo json_encode($response);
            }
        }
    } else {
        $response = [
			'status' => 401,
			'message' => 'Email or password can\'t empty!'
		];
		echo json_encode($response);
    }
	
?>