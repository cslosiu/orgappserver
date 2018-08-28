<?
// generic api helper functions

function get_input_json()
{
  $data = json_decode(file_get_contents('php://input'), true);
  return $data;
}

function api_error($exception, $data = array())
{
  $data['result'] = 'error';
  $data['error'] = $exception->getMessage();
  return json_encode($data);
}

function api_ok($data = array())
{
  $data['result'] = 'ok';
  return json_encode($data);
}

function api_headers()
{
    header("Content-Type: application/json");
}

function is_post()
{
  $api_method = $_SERVER['REQUEST_METHOD'];
  return $api_method == 'POST';
}

function is_get()
{
  $api_method = $_SERVER['REQUEST_METHOD'];
  return $api_method == 'GET';
}

?>
