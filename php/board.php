<?php

//works
function show_status()
{
	global $mysqli;
	$sql = 'SELECT * FROM game_status';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();

	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}

//works
function reset_game()
{

	global $mysqli;

	$sql = 'call clean_game()';
	$st = $mysqli->prepare($sql);
	$st->execute();

	//clean_game,cardshuffle,carddeal

	$sql = 'call card_shuffle()';
	$st = $mysqli->prepare($sql);
	$st->execute();

	$sql = 'call card_deal()';
	$st = $mysqli->prepare($sql);
	$st->execute();
	header('HTTP/1.1 204 No Content');

}

//works
function getallcards()
{
	global $mysqli;
	$sql = 'select * from clonedeck';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}


function showcardbyplayer($id)
{

	global $mysqli;
	$pId = $id;
	$sql = 'SELECT cardcode,playerid from hand inner JOIN deck where hand.cardid = deck.cardid AND hand.playerid = ?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i', $pId);
	$st->execute();
	$res = $st->get_result();

	header('Content-type: application/json');
	print json_encode(array($res->fetch_all(MYSQLI_ASSOC)), JSON_PRETTY_PRINT);

}

//works
function draw_card($id)
{
	global $mysqli;
	//$pId = $id;
	if (!isset($id['playerId'])) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "NO PLAYER ID GIVEN"]);
		exit;
	}
	$pId = $id;

	$sql = 'SELECT cardId from clonedeck ORDER BY RAND() LIMIT 1 ';
	$sq = $mysqli->prepare($sql);
	$sq->execute();
	$result = $sq->get_result();

	while ($row = mysqli_fetch_array($result)) {

		$drawcard = $row;
		echo "\n Card drew: " . $drawcard['cardId'];
		$card = intval($drawcard[0]);
		echo gettype($card) . "\n";
		
		$sql = 'INSERT INTO hand (playerId,cardId) VALUES (?,?)';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $pId, $card);
		$stmt->execute();

		$sql = 'DELETE FROM clonedeck where cardId = ? ';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $card);
		$stmt->execute();

	}



	header('Content-type: application/json');
	print json_encode(array($result->fetch_all(MYSQLI_ASSOC)), JSON_PRETTY_PRINT);

}


function playcard($id){
	if (!isset($id['playerId'])) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "NO PLAYER ID GIVEN"]);
		exit;
	}
	global $mysqli;
	$pId = $id;
	$sql = 'SELECT cardId from hand WHERE playerId=?';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i',$pId);
	$stmt->execute();
	$result = $stmt->get_result();

	
	while ($row = mysqli_fetch_array($result)) {

		$drawcard = $row;
		echo "\n Card drew: " . $drawcard['cardId'];
		$card = intval($drawcard[0]);
		echo gettype($card) . "\n";
		
		$sql = 'INSERT INTO hand (playerId,cardId) VALUES (?,?)';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $pId, $card);
		$stmt->execute();

		$sql = 'DELETE FROM clonedeck where cardId = ? ';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $card);
		$stmt->execute();

	}

}












?>