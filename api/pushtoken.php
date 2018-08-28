<?
require_once('api.php');
require_once('../core/applepush.php');
/*
API meaning
- POST : create / update the push token for a user
- GET : retrieve the token for given user.

*/

if (is_post()) {
  $json = array();
  //api_headers();
  try {
    $json = get_input_json();
    //var_dump($json);
  }
  catch (Exception $e) {
    echo api_error($e, array('json'=>$json));
    exit;
  }

  $user = $json['username'];
  $token = $json['token'];
  //var_dump($user,$token);

  try {
    ap_regdevice($user,$token);
    echo api_ok();
  }
  catch (Exception $e) {
    echo api_error($e);
  }
}
elseif ( is_get() ) {
  echo 'GET';
}
?>
