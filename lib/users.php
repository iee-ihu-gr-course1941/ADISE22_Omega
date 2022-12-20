<?php

function show_users() {
	global $mysqli;
	$sql = 'select username,playerId from players';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function set_user($input) {
	if(!isset($input['username']) || $input['username']=='') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"No username given."]);
		exit;
	}
	$username = $input['username'];
	global $mysqli;
	$sql = 'SELECT COUNT(*) AS num FROM players';
	$st = $mysqli -> prepare($sql);
	$st -> execute();
	$res = $st -> get_result();
	$r = $res -> fetch_assoc(); 
	if ($r['num'] == 0) {
			$sql = 'INSERT INTO players(username,playerId,token,last_action,p_turn) VALUES (?,1,MD5(concat(?,NOW())),NULL,0)';
	} elseif ($r['num'] == 1) {
			$sql = 'INSERT INTO players(username,playerId,token,last_action,p_turn) VALUES (?,2,MD5(concat(?,NOW())),NULL,1);';
	} else {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Player number is full"]);
		exit;
	}
	$st2 = $mysqli -> prepare($sql);
	$st2 -> bind_param('ss', $username,$username);
	$st2 -> execute();
}
?>