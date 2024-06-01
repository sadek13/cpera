<?php

session_start();



require('../../class/user.class.php');
require('../../class/division.class.php');





$user = new User();

$division = new Division();

if (isset($_POST)) {


    $username = $_POST['username'];
    $password = $_POST['password'];



    if (!empty($user->checkUsername($username, $password))) {


        $user_id = $user->checkUsername($username, $password)[0]['user_id'];
        $user_type = $user->checkUsername($username, $password)[0]['user_type'];
        $response = array(
            'status' => 'ok'
            // 'user_id'=>$user_id
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid Credentials'
        );
        header('Content-Type: application/json');

        echo json_encode($response);
        exit;
    }



    // Set the Content-Type header







    $_SESSION['user_type'] = $user_type;

    $_SESSION['user_name'] = $username;

    $_SESSION['login'] = true;

    $_SESSION['user_id'] = $user_id;


    if ($division->isPM($user_id)[0]['COUNT(*)'] > 0)
        $_SESSION['isPM'] = true;
    else
    $_SESSION['isPM'] = false;
    


    header('Content-Type: application/json');

    echo json_encode($response);
    exit;
}
