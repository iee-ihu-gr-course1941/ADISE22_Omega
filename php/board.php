<?php
//game status για να εμφανισει το ποιος παικτης παιζει το τοκεν και το state του παιχνιδιου

switch ($r=array_shift($request)){

case 'game':switch($b=array_shift($request)){

}





}


//works
function show_status(){
    global $mysqli;
	#$sql_query = "SELECT * from game_status";
	#$result=mysqli_query($mysqli,$sql_query);
	#$res=$result->fetch_assoc();
    $sql = 'SELECT * FROM game_status';
    $st= $mysqli->prepare($sql);
    $st->execute();
	$res=$st->get_result();

    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}

//works
function reset_game(){

    global $mysqli;
    
    $sql = 'call clean_game()';
    $st= $mysqli->prepare($sql);
    $st->execute();

    //clean_game,cardshuffle,carddeal

    $sql='call card_shuffle()';
    $st=$mysqli->prepare($sql);
    $st->execute();

    $sql='call card_deal()';
    $st=$mysqli->prepare($sql);
    $st->execute();


}







//εμφανιζει τα φυλλα που εχουν οι παικτες να δω λιγο την κληση σε αλλες μεθοδους
function show_cardgame($ttable){

    global $mysqli;
	#$cardid=$_GET['cardcode'];
	
    $sql = 'SELECT cardcode,playerid from hand inner JOIN deck where hand.cardid = deck.cardid';
    $st=$mysqli-> prepare($sql);
    $st->execute();
    $res=$st ->get_result();
	
	$sql = 'SELECT p_turn AS tr FROM players WHERE playerid = 1';
	$sw = $mysqli -> prepare($sql);
	$req = $sw -> execute();
	$req = $sw -> get_result();
	$rew = $req -> fetch_assoc();
	
	

    header ('Content-type: application/json');
    print json_encode(array($res->fetch_all(MYSQLI_ASSOC),/*$ttable,$res['tr']*/),JSON_PRETTY_PRINT);

}

//τραβαει καρτα και μπαινει στο χερι του αντιστοιχου παικτη θελει δουλεια
//μαλλον θελει με post μεθοδο

function draw_card(){
global $mysqli;

	$sql='SELECT cardId from clonedeck ORDER BY RAND() LIMIT 1 ';
    $sq=$mysqli->prepare($sql);
    $sq->execute();
    $req=$sq ->get_result();
    $row=$req -> fetch_assoc();
	$result = mysqli_query($mysqli,$sql);
	 
	$random=mysqli_fetch_array($result);
	$card=$random['cardId'];
	
	print "Random card \n".$card;

	$sql = 'SELECT playerId FROM players WHERE p_turn = 0';
	$sw = $mysqli -> prepare($sql);
	$sw -> execute();
	$rew = $sw -> get_result();
	$res = $rew -> fetch_assoc();
	$result = mysqli_query($mysqli,$sql);
	
	$players=mysqli_fetch_array($result);
	$pid=$players['playerId'];
	
	print "Player turn \n".$pid;

if ($pid==1){
$sql = 'INSERT INTO hand (playerId,cardId) VALUES (1,?)';
}else{
    $sql = 'INSERT INTO hand (playerid,cardId) VALUES (2,?)';   
    }

    $sp=$mysqli->prepare($sql);
    $sp ->bind_param('i',$card);
    $sp ->execute();
	
	
	
	$sql = 'call playerTurn()';
    $st = $mysqli->prepare($sql);
    $st -> execute();
	$ro=$st->get_result();
    
}



//θελει την συνεχεια
function show_game($ttable) { //SELECT tou hand, kai tou paixti me id 1 kai ta gurname sgia emfanisi
	global $mysqli;
	$sql = 'SELECT cardCode, playerId FROM hand INNER JOIN carddeck WHERE hand.cardid = carddeck.cardid';
	$st = $mysqli -> prepare($sql);
	$st -> execute();
	$res = $st -> get_result();

	$sql = 'SELECT turn AS tr FROM players WHERE playerid = 1';
	$sw = $mysqli -> prepare($sql);
	$req = $sw -> execute();
	$req = $sw -> get_result();
	$rew = $req -> fetch_assoc();

	header('Content-type: application/json');
	print json_encode(array($res->fetch_all(MYSQLI_ASSOC), $ttable, $rew['tr']), JSON_PRETTY_PRINT);
}













?>