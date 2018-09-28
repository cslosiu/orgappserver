<?
// suppose being called automatically by system CRON

//require_once('../config.php');
require_once('pushinc.php');

function push($payloadObject, $deviceToken)
{
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
    $payload = json_encode($payloadObject);
    //$deviceToken = 'c468adeb78433507769f7a823c9fa3f0bd4673862d87414106ef60d98546501c';
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
}

function sendpost($postid)
{
    $q = "select q.post_id, d.aps_token, p.post_title, p.post_content, p.post_status, p.post_type 
        from `push_devices` d, push_queue q, push_to_user u, cms_posts p
        where d.user_id = u.user_id and p.id = q.post_id 
        and q.post_id = u.post_id and q.post_id = ?";
    $st = dbquery($q,array($postid));
    while($r = $st->fetch(PDO::FETCH_ASSOC)) {
        //TODO: handle BADGE# better
        $payloadObject = array(
            'aps' => array(
                'alert' => $r['post_title'],
                'sound' => 'default',
                'badge' => 1
            ),
            'orgapp_postcontent' => $r['post_content'],
            'orgapp_posttype' => $r['post_type'],
            'orgapp_poststatus' => $r['post_status']
        );
        push($payloadObject, $r['aps_token']);
    }
}

function mark_sent($post_id)
{
    $sql = "update push_queue set out_date = current_timestamp where post_id = ?";
    $st = dbquery($sql, array($post_id));
    $st->execute();
}

// process the push queue every this script runs
function process_queue()
{
    // performance: tune this limit #
    $sql = "SELECT post_id FROM `push_queue`
        where out_date is null
        order by in_date
        limit 10";
    $st = dbquery($sql);
    while($r = $st->fetch(PDO::FETCH_ASSOC)) {
        $pid = $r['post_id'];
        sendpost($pid);
        mark_sent($pid);
    }
}

process_queue();


?>