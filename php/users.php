<?php
require_once "php/dbconnect.php";
require_once "php/game.php";

function show_users() {
	global $mysqli;
	$sql = 'select username,playerId from players';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function show_user($playerid) {
	global $mysqli;
	$sql = 'select username,playerId from players where   = ?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i',$playerid);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}



//mhn vazw prepare ekei poy den xreiazetai  kai exw null sto telos
 function set_user($input) {
	if(!isset($input['username']) || $input['username']=='') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"No username given."]);
		exit;
	}
	$username = $input['username'];
    global $mysqli;
	$sql_query = "SELECT COUNT(*) AS num FROM players WHERE username IS NOT NULL";
	$result = mysqli_query($mysqli, $sql_query);
	$row=$result->fetch_assoc(); //epistrefh apotelesma diavazei grammes
	if($row['num']== 2) {
				$sql = "DELETE FROM players";
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				print "TABLE IS FULL";
					/*if ($mysqli->query($sql) === TRUE) {
					 // echo "Record deleted successfully";
					}else {
						  echo "Error deleting record: " . $conn->error;
						}*/
				}else if ($row['num']==0){
				$sql = "INSERT INTO players(username,p_turn,token) VALUES (?,0,MD5(CONCAT(?,NOW())))";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ss",$username,$username);
				
				if($stmt->execute()) 
				{
					$stmt->close();
					header('HTTP/1.1 201 Created');
				} 
				else 
				{
					print $stmt->error;
					header('HTTP/1.1 500 Internal Server Error');
				}
				
				
				}else if ($row['num']==1) {
				$sql = "INSERT INTO players(username,p_turn,token) VALUES (?,1,MD5(CONCAT(?,NOW())))";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ss",$username,$username);
				
				if($stmt->execute()) 
				{
					$stmt->close();
					header('HTTP/1.1 201 Created');
				} 
				else 
				{
					print $stmt->error;
					header('HTTP/1.1 500 Internal Server Error');
				}	
					
					
					
				}
				
				
		update_game_status();
		$sql = 'select * from players where username = ?';
		$st = $mysqli->prepare($sql);
		$st->bind_param('s',$username);
		$st->execute();
		$res = $st->get_result();
		header('Content-type: application/json');
		print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}
 

function handle_user($method, $playerid, $input) {
	if($method=='GET') {
		show_user($playerid);
	} else if($method=='POST') {
        set_user($input);
    }
	global $mysqli;
	$sql='select count(*) as num from players';
	$sw=$mysqli->prepare($sql);
	$sw->execute();
	$req=$sw->get_result();
	$res=$req->fetch_assoc();
	print "result:".$res;
	
}

?>