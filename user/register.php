<?php

class register
{
    public static function call($con)
    {
        //Avoiding creating unnecessary notices
        $username = (isset($_POST['username']) ? $_POST['username'] : null);
        $email = (isset($_POST['email']) ? $_POST['email'] : null);
        $password = (isset($_POST['password']) ? $_POST['password'] : null);
        $confPassword = (isset($_POST['confPassword']) ? $_POST['confPassword'] : null);

        //Username MUST be at least 4 characters long
        if (strlen($username) < 4) {
			throw new Exception('Sorry, your username must be at least 4 characters long', 400);
        }

        //Check to make sure that both passwords match
        if($password != $confPassword) {
			throw new Exception('Please make sure that your password and confirmation passwords match', 400);
        }

        //Check to make sure that the username is not already in use
        $usernameCheck = mysqli_query($con, 'SELECT id FROM users WHERE username="'.$username.'"');
        while($row = mysqli_fetch_assoc($usernameCheck)) {
			throw new Exception('Sorry, that username has already been taken', 400);
        }

        //Check to make sure that the email address isn't already in use
        $emailCheck = mysqli_query($con, 'SELECT id FROM users WHERE email="'.$email.'"');
        while($row = mysqli_fetch_assoc($emailCheck)) {
			throw new Exception('Sorry, that email is already in use', 400);
        }
		
		//Register user in backend API
		$salt = self::generateSalt();
		$pepper = functions::getPepper();
		$hash = functions::generateHash([
			'password' => $password,
			'salt' => $salt,
			'pepper' => $pepper
		]);
		
		return ['Salt = ' . $salt . ' Pepper = ' . $pepper . ' Hash = ' .$hash];
    }
	
	public static function generateSalt() {
		return md5(microtime());
	}
}