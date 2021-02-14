<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->getConnection();

$userlog = new User($db);

require_once '../../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'));

$id_token = $data->id_token;
$email = $data->email;
$name = $data->name;

$CLIENT_ID = "735570779221-va8gafv9ivcajojh9bage1edgbl45opa.apps.googleusercontent.com";
$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend


$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
    $theEmail = $payload['email'];

    if ($theEmail == $email && $CLIENT_ID == $payload['aud']) {
        $userlog->email = $email;
        $userlog->name = $name;
        $token = $userlog->cek_email($id_token, $email, $name);
        $success = array (
            'status' => true,
            'token' => $token
        );
        echo json_encode($success);
        return;
        if($token = $userlog->cek_email($id_token, $email, $name)) {
            $success = array (
                'status' => true,
                'token' => $token
            );
            echo json_encode($success);
        } else {
            $error = array (
                'status' => false,
                'msg' => "Ops, something wrong"
            );
            echo json_encode($error);
        }
    } else { //email not same
        echo "error";
    }
} else {
    echo "Nope";
}

?>