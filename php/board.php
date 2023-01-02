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


/*function playcard($id)
{
if (!isset($id['playerId'])) {
header("HTTP/1.1 400 Bad Request");
print json_encode(['errormesg' => "NO PLAYER ID GIVEN"]);
exit;
}else{
header("HTTP/1.1 400 Bad Request");
print json_encode(['errormesg' => "Player id was given"]);
header("HTTP/1.1 201 created");
}
/*if (!isset($selectedcardtoplay['cardId'])) {
header("HTTP/1.1 400 Bad Request");
print json_encode(['errormesg' => "NO PLAYER ID GIVEN"]);
exit;
}*/

//global $mysqli;
//$pId = $id;
//$cardtoplay = $selectedcardtoplay;
//$sql = 'SELECT cardId from hand WHERE playerId=?';
//$stmt = $mysqli->prepare($sql);
//$stmt->bind_param('i', $pId);
//$stmt->execute();
//$result = $stmt->get_result();


/*while ($row = mysqli_fetch_array($result)) {
$selectedcard = $row;
echo "\n Selected card: " . $selectedcard['cardId'];
$card = intval($selectedcard[$cardtoplay]);
echo gettype($card) . "\n";
echo "The card that you want to play is: \n" . $card;
/*$sql = 'INSERT INTO discarded_cards (cardId) VALUES (?,?)';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $pId, $card);
$stmt->execute();
$sql = 'DELETE FROM clonedeck where cardId = ? ';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $card);
$stmt->execute();*/


//header('Content-type: application/json');
//	print json_encode(array($result->fetch_all(MYSQLI_ASSOC)), JSON_PRETTY_PRINT);

//}




function playtest($input)
{

	global $mysqli;
	$sql = 'call playerTurn()';
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();


	echo "Method started";

	global $mysqli;
	if (!isset($input['cardCode']) || $input['cardCode'] == '') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "NO CARD WAS GIVEN"]);
		exit;
	}
	$cardplay = $input['cardCode'];
	$sql = 'DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = ? AND p_turn = 0) LIMIT 1';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $cardplay);
	$stmt->execute();

	$sql = 'INSERT INTO discarded_cards(cardCode) VALUES(?)';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $cardplay);
	$stmt->execute();

	/*
	$sql = 'SELECT cardCode FROM discarded_cards WHERE number = (SELECT MAX(number) FROM discarded_cards)';
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	$ren = $result->fetch_assoc();
*/
	//header('Content-type: application/json');
	//print json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}




function handle_game($method)
{
	global $mysqli;
	if ($method == 'GET') {
		$sql = 'SELECT cardCode FROM cardtable WHERE number = (SELECT MAX(number) FROM cardtable)';
		$sm = $mysqli->prepare($sql);
		$sm->execute();
		$rem = $sm->get_result();
		$ren = $rem->fetch_assoc();
		show_game($ren['cardCode']);
	} else if ($method == 'POST') {
		reset_game();
	}
}

function pass()
{
	global $mysqli;
	$sql = 'call playerTurn()';
	$st = $mysqli->prepare($sql);
	$st->execute();

	$sql = 'SELECT cardCode FROM discarded_cards WHERE number = (SELECT MAX(number) FROM discarded_cards)';
	$sm = $mysqli->prepare($sql);
	$sm->execute();
	$rem = $sm->get_result();
	$ren = $rem->fetch_assoc();

	show_game($ren['cardCode']);
}






?>