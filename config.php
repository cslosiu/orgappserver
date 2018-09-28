<?
// config different value for each environment.
$config = array(
    'dsn'=>'mysql:host=localhost;charset=utf8;dbname=ezsch01',
    'db_username'=>'ezsch01',
    'db_password'=>'P@ss123w0rd',
    'env'=>'DEV'
);

// DEBUG PHASE SETTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$errorlevel = error_reporting();
error_reporting($errorlevel & ~E_NOTICE);

date_default_timezone_set('Asia/Hong_Kong');

function exception_handler($exception) {
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
}
  
set_exception_handler('exception_handler');

$_pdo_ = null;

// db
function get_pdo()
{
    global $config;
    global $_pdo_;
    if (!$_pdo_) {
        $db = null;
        try {
            $db = new PDO($config['dsn'], $config['db_username'],$config['db_password']);
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } 
        catch(PDOException $e) {
            echo '<p class="bg-danger">'.$e->getMessage().'</p>';
            return null;
        } 
        $_pdo_ = $db;
    }
    return $_pdo_;
}

function dbquery($sql, $params = array()) 
{
    // dbquery("insert into..(?,?)", array($p1, $p2) )
    // return the STATEMENT object.
    $d = get_pdo();
    $s = $d->prepare($sql);
    for($i=0;$i < count($params); $i++) {
        $s->bindValue($i+1, $params[$i]);
    }
    $s->execute();
    return $s;
}

session_start();

?>
