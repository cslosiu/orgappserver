<?php
/*
// Production mode
$certificateFile = 'apns-dis.pem';
$pushServer = 'ssl://gateway.push.apple.com:2195';
$feedbackServer = 'ssl://feedback.push.apple.com:2196';
 */
// Sandbox mode
$certificateFile = 'orgapp-push-dev.pem';
$pushServer = 'ssl://gateway.sandbox.push.apple.com:2195';
$feedbackServer = 'ssl://feedback.sandbox.push.apple.com:2196';

// push notification
$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $certificateFile);
$fp = stream_socket_client(
    $pushServer,
    $error,
    $errorStr,
    100,
    STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,
    $streamContext
);

// make payload
$payloadObject = array(
    'aps' => array(
        'alert' => '時間 Server Time:'.date('Y-m-d H:i:s'),
        'sound' => 'default',
        'badge' => 3
    ),
    'custom_key' => 'custom_value'
);
$payload = json_encode($payloadObject);

$deviceToken = 'c468adeb78433507769f7a823c9fa3f0bd4673862d87414106ef60d98546501c';
              //c468adeb78433507769f7a823c9fa3f0bd4673862d87414106ef60d98546501c
$expire = time() + 3600;
$id = time();

if ($expire) {
    // Enhanced mode
    $binary  = pack('CNNnH*n', 1, $id, $expire, 32, $deviceToken, strlen($payload)).$payload;
} else {
    // Simple mode
    $binary  = pack('CnH*n', 0, 32, $deviceToken, strlen($payload)).$payload;
}
$result = fwrite($fp, $binary);
fclose($fp);

?>
