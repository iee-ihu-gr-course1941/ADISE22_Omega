<?php

function show_status(){
    global $mysqli;

    check_abort();

    $sql = 'SELECT * FROM game_status';
    $st = $mysqli -> prepare($sql);
    $st = execute();
    $res = $st -> get_result();

    header('Content-type : application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC),JSON_PRETTY_PRINT);
}

function check_abort() {
	global $mysqli;
	
    //result is 2 with game_status = aborded if playerId = 1(player with id 2 was inactive and aborted the game)
    //result is 1 with game_status = aborded if playerId = 2(player with id 1 was inactive and aborted the game)
	$sql = "UPDATE game_status SET g_status='aborted', result=IF(playerId=1,2,1),playerId=NULL WHERE playerId IS NOT NULL AND last_change<(NOW()-INTERVAL 5 MINUTE) AND g_status='started'";
	$st = $mysqli->prepare($sql);
	$r = $st->execute();
}

function update_game_status() {
	global $mysqli;
	
	$status = read_status();
	
	$new_status=null;
	$new_playerId=null;
	
	$st3=$mysqli->prepare('select count(*) as aborted from players WHERE last_action< (NOW() - INTERVAL 5 MINUTE)');
	$st3->execute();
	$res3 = $st3->get_result();
	$aborted = $res3->fetch_assoc()['aborted'];
	if($aborted>0) {
		$sql = "UPDATE players SET username=NULL, token=NULL WHERE last_action< (NOW() - INTERVAL 5 MINUTE)";
		$st2 = $mysqli->prepare($sql);
		$st2->execute();
		if($status['g_status']=='started') {
			$new_status='aborted';
		}
	}

	$sql = 'select count(*) as c from players where username is not null';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	$active_players = $res->fetch_assoc()['c'];
	
	switch($active_players) {
		case 0: $new_status='not active'; break;
		case 1: $new_status='initialized'; break;
		case 2: $new_status='started'; 
				if($status['playerId']==null) {
					$new_playerId = 1; // It was not started before...
				}
				break;
	}

	$sql = 'update game_status set status=?, playerId=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('ss',$new_status,$new_playerId);
	$st->execute();
	
	
	
}

function read_status() {
	global $mysqli;
	
	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);

	$st->execute();
	$res = $st->get_result();
	$status = $res->fetch_assoc();
	return($status);
}





?>