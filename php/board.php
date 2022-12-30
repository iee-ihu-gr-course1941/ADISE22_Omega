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

//τραβαει καρτα και μπαινει στο χερι του αντιστοιχου παικτη
function draw_card(){
global $mysqli;

	$sql='SELECT cardid from clonedeck ORDER BY RAND() LIMIT 1 ';
    $sq=$mysqli->prepare($sql);
    $sq->execute();
    $req=$sq ->get_result();
    $row=$req -> fetch_assoc();
	$result = mysqli_query($mysqli,$sql);
	while($row = mysqli_fetch_array($result)) { // it works
    echo "Card random id :\n".$row['cardid']; 
	} 

	$sql = 'SELECT playerId FROM players WHERE p_turn = 1';
	$sw = $mysqli -> prepare($sql);
	$sw -> execute();
	$rew = $sw -> get_result();
	$res = $rew -> fetch_assoc();
	$result = mysqli_query($mysqli,$sql);
	while($players = mysqli_fetch_array($result)) { // it works
    echo "Player turn :\n".$players['playerId']; 
	}

	isset($players['playerId']);
	
	 //μεχρι εδω δουλευει

if ($players['playerId'==1]){
$sql = 'INSERT INTO hand (playerId,cardid) VALUES (1,?)';
}else{
    $sql = 'INSERT INTO hand (playerid,cardid) VALUES (0,?)';   
    }

    $sp=$mysqli->prepare($sql);
    $sp ->bind_param('i', $row['cardid']);
    $sp ->execute();

    
}



//θελει την συνεχεια
function show_game($ttable){
global $mysqli;
$sql='SELECT cardcode,playerid from hand INNER JOIN carddeck WHERE hand.cardid=carddeck.cardid';
$st=$mysqli->prepare($sql);
$st -> execute();
$res=$st-> get_result();




}













?>