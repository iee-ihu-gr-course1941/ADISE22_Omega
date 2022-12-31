<?php
require_once "php/dbconnect.php";
require_once "php/game.php";

function show_users()
{
	global $mysqli;
	$sql = 'select username,playerId from players';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function show_user($id)
{
	global $mysqli;
	$pId = $id;
	$sql = 'SELECT username,playerId FROM players WHERE playerId = ?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i', $pId);
	$st->execute();
	$res = $st->get_result();
	if (isset($_GET['playerId'])) {
		echo $_GET['playerId'];
	} else {

	}
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function add_user_to_db($username)
{
	global $mysqli;
	$sql = "INSERT INTO players(username,p_turn,token) VALUES (?,0,MD5(CONCAT(?,NOW())))";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $username, $username);

	if ($stmt->execute()) {
		$idOfInsertedPlayer = $mysqli->insert_id;
		$stmt->close();
		header('HTTP/1.1 201 Created');
		return $idOfInsertedPlayer;
	} else {
		print $stmt->error;
		header('HTTP/1.1 500 Internal Server Error');
		return -1;
	}
}

function deleteAllUsers()
{
	global $mysqli;
	$sql = "DELETE FROM players";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();

	$sql = "ALTER TABLE players AUTO_INCREMENT=1";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();

}


function add_user($input)
{
	if (!isset($input['username']) || $input['username'] == '') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "No username given."]);
		exit;
	}
	$username = $input['username'];
	global $mysqli;
	$sql_query = "SELECT COUNT(*) AS num FROM players WHERE username IS NOT NULL";
	$result = mysqli_query($mysqli, $sql_query);
	$row = $result->fetch_assoc(); //epistrefh apotelesma diavazei grammes

	$id = 0;
	if ($row['num'] < 2) {
		$id = add_user_to_db($username);
	}
	if ($row['num'] == 2) {
		deleteAllUsers();

		$sql = "ALTER TABLE players AUTO_INCREMENT=1";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();

		$id = add_user_to_db($username);
	}


	update_game_status();
	$sql = 'select * from players where playerId = ?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i', $id);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	header('HTTP/1.1 201 Created');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

?>