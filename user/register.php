<?php

class register
{
    public static function call($con)
    {
        //Avoiding creating unnecessary notices
        $username = (isset($_GET['username']) ? $_GET['username'] : null);
        $email = (isset($_GET['email']) ? $_GET['email'] : null);
        $password = (isset($_GET['password']) ? $_GET['password'] : null);
        $confPassword = (isset($_GET['confPassword']) ? $_GET['confPassword'] : null);

        //Username MUST be at least 4 characters long
        if (strlen($username) < 4) {
            echo json_encode(array(
                'status' => 'ERROR',
                'message' => 'Sorry, your username must be at least 4 characters long'
            ));
            exit;
        }

        //Check to make sure that both passwords match
        if($password != $confPassword) {
            echo json_encode(array(
                'status' => 'ERROR',
                'message' => 'Please make sure that your password and confirmation passwords match'
            ));
            exit;
        }

        //Check to make sure that the username is not already in use
        $usernameCheck = mysqli_query($con, 'SELECT id FROM users WHERE username="'.$username.'"');
        while($row = mysqli_fetch_assoc($usernameCheck)) {
            echo json_encode(array(
                'status' => 'ERROR',
                'message' => 'Sorry, that username has already been taken'
            ));
            exit;
        }

        //Check to make sure that the email address isn't already in use
        $emailCheck = mysqli_query($con, 'SELECT id FROM users WHERE email="'.$email.'"');
        while($row = mysqli_fetch_assoc($emailCheck)) {
            echo json_encode(array(
                'status' => 'ERROR',
                'message' => 'Sorry, that email is already in use'
            ));
            exit;
        }
    }
}