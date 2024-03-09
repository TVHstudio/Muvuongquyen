<?php
include_once("../../cfg.php");
$mysqli = new mysqli($config['host'], $config['root'], $config['pass'], $config['dbname'], $config['port']);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$openId = isset($_GET['openId']) ? trim($_GET['openId']) : '';
$appid = isset($_GET['appid']) ? trim($_GET['appid']) : '';
$pfParam = isset($_GET['pfParam']) ? trim($_GET['pfParam']) : '';
$serverId = isset($_GET['serverId']) ? trim($_GET['serverId']) : '';

$sql = "SELECT * FROM `h5`.`account` WHERE `id`=" . $appid . " LIMIT 1";
$result = $mysqli->query($sql);
if (!$result) {
    die('Query Error: ' . $mysqli->error);
}

$flash = array(
	"srvid"=>$serverId,
	"user"=>"",
	"spverify"=>"",
	"newbie"=>0,
	"serverid"=>$serverId,
	"login_ip"=>'127.0.0.1',
	"srvtime"=>time(),
	"pfid"=>3,
	"pf"=>"mkhf",
	"loadurl"=>"https://muvuongquyen.com",
	"isBan"=>0,
	"roleCount"=>1,
	"nickname"=>"",
	"isnew"=>0,
	"srvaddr"=>"",
	"srvport"=>0,
	"appid"=>$appid,
	"v"=>209,
	"crtr"=>0,
	"welc"=>0,
	"via"=>$appid,
	"hosts"=>"https://muvuongquyen.com/zycs_zs/ver/",
	"pfhost"=>"https://muvuongquyen.com/zycs_zs/ver/",
);

$data = array(
	"v"=> 209,
	"appId"=>$appid,
	"openKey"=>"",
	"serverId"=> "2",
	"serverName"=> "",
	"loginFlag"=> 1,
	"gameNotice"=> "",
	"isnew"=> 0,
	"isback"=> false,
	"bg_ver"=> "",
	"logo"=> $appid,
	"payItems"=> [],
	"pName"=> "mkhf",
	"code"=> 1,
);

if ($result && $result->num_rows > 0) {

    $ret = $result->fetch_array(MYSQLI_ASSOC);
    if ($ret['openId'] != $openId) {
        exit('{}');
    }

    $flash['user'] = $ret['account'];
    $flash['spverify'] = $ret['pass'];
    
    $sql = "SELECT * FROM `h5`.`h5_server` WHERE `sid` = {$serverId} LIMIT 1";
    $serverResult = $mysqli->query($sql);
    if ($serverResult && $serverResult->num_rows > 0) {
        $svr = $serverResult->fetch_array(MYSQLI_ASSOC);
        $flash['srvaddr'] = $svr['host'];
        $flash['srvport'] = intval($svr['port']);
    } else {
        die('Server info not found.');
    }

    $data['flashUrl'] = "?" . http_build_query($flash);
    
    $sql = "UPDATE `h5`.`account` SET `last_server`={$serverId} WHERE `id`={$appid}";
    $mysqli->query($sql);

    // Annahme: $server_list ist irgendwo definiert
    $cf = $server_list[$serverId];
    
    $game = new mysqli($cf['host'], $cf['root'], $cf['pass'], $cf['dbname'], $cf['port']);
    if ($game->connect_error) {
        die('Game DB Connect Error (' . $game->connect_errno . ') ' . $game->connect_error);
    }

    $sql = "SELECT * FROM globaluser WHERE account='{$ret['account']}' LIMIT 1";
    $s = $game->query($sql);

    if ($s && $s->num_rows < 1) {
        $sql = "INSERT INTO globaluser 
                (account, passwd, identity, createtime, updatetime, updateip, ipstr, gmlevel, pwtime, closed, openkey, pfkey, manyouid, pf) VALUES 
                ('{$ret['account']}', '{$ret['pass']}', '440783198809098888', NOW(), NOW(), '0', '', '10', '0', '0', '', '', '', '')";
        $game->query($sql);
    } else {
        $sql = "SELECT TIMESTAMPDIFF(HOUR, updatetime, NOW()) AS hours FROM globaluser WHERE account='{$ret['account']}'";
        $result = $game->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['hours'] >= 24) {
                $sql = "UPDATE globaluser SET updatetime = NOW(), rmb = rmb + 100 WHERE account='{$ret['account']}'";
                $game->query($sql);
            }
        }
    }
}
exit(json_encode($data));
?>
