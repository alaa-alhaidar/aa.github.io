<?php
  session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
        if(!empty($email) && !empty($password) && !is_numeric($email))
		{
			//read from database
			$query = "select * from login where email = '$email' limit 1";
			$result = mysqli_query($conn, $query);
            
            if(mysqli_num_rows($result) === 0)
            {
                header("Location: login.html");
            }
			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					$versicherungsnummer=$user_data['versicherungsnummer'];
					$username=$user_data['username'];
					
					if($user_data['psw'] === $password && $user_data['email'] === $email)
					{
						if($user_data['profile'] === "admin"){
							$_SESSION['message'] = "Login ist erfolgreich";
							$_SESSION["username"] = $user_data['username'];
							header("Location: admin-sicht/patient-info.php?versicherungsnummer=$versicherungsnummer &username=$username");
							die;
						}
						else if($user_data['profile'] === "patient"){
							$_SESSION['message'] = "Login ist erfolgreich";
							$_SESSION["username"] = $user_data['username'];
							header("Location: patient-sicht/patient-info.php?versicherungsnummer=$versicherungsnummer &username=$username");
							die;
						}
						else if($user_data['profile'] === "arzt"){
							$_SESSION['message'] = "Login ist erfolgreich";
							$_SESSION["username"] = $user_data['username'];
							header("Location: arzt-sicht/patient-info.php?versicherungsnummer=$versicherungsnummer &username=$username");
							die;
						}

					} else {
						$_SESSION['message'] = "Email oder Passwort ist falsch..";
                        header("Location: login.html");
                        die;
                    }
				}
			}
			
			
		}else
		{
			$_SESSION['message'] = "Email oder Passwort ist falsch..";
            header("Location: login.html");
			
		}

		$stmt->close();
		$conn->close();
	}


?>