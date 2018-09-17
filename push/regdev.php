<?
require_once('pushinc.php');
require_once('../api.php');

/*
 regdev. API style.
 POST: to create/update a user-token pair
 GET: to retrieve the token for given user.
*/

if (is_post()) {
    $json = array();
    try {
      $json = get_input_json();
    }
    catch (Exception $e) {
      echo api_error($e, array('json'=>$json));
      exit;
    }
    $user = $json['username'];
    $token = $json['token'];

    // output . 
    try {
      push_regdevice($user,$token);
      api_headers();
      echo api_ok();
    }
    catch (Exception $e) {
        api_headers();
        echo api_error($e);
    }    
}
?>