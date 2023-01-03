<?php
require_once "php/dbconnect.php";

#require_once "php/board.php";
$method = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'), true);

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = $request[0];

print_r($requestBody);
//$subresource = $request[1];

#print "\n METHOD " . $method .  "\n";

#print "\n REQUEST_BODY \n";
#print_r($requestBody);
#print "\n REQUEST RESOURCE\n";
#print_r($resource);



if ($resource == "newgame") {
	if ($method == "POST") {
		print "starting new game";
		print "cards assignments";
		header('HTTP/1.1 201 Created');
	}
}

if ($method == "POST") {
	print "starting new game";
	print "cards assignments";
}

//Resource for players
if ($resource == "players") {
	if ($method == "POST") {
		require_once "php/users.php";
		add_user($requestBody);
	}
	if ($method == "DELETE") {
		require_once "php/users.php";
		deleteAllUsers();
	}
	if ($method == "GET") {
		require_once "php/users.php";
		if (isset($_GET['playerId'])) {
			$id = $_GET['playerId'];
			show_user($id);
		} else {
			show_users();
		}	
	}
}

//Resource for game
if ($resource == "gamestatus") {

	if ($method=="GET"){
		require_once "php/board.php";
		show_status();
	}if ($method=="DELETE") {
		require_once "php/board.php";
		reset_game();
	}
	
		
}

if ($resource=="playtest"){
	if ($method=="POST"){
		require_once "php/board.php";
		playtest($requestBody);
	}
}


if ($resource=="play3cards"){
	if ($method=="POST"){
		require_once "php/board.php";
		//$post_data = array();
		//$posted_data = json_decode($_POST['cardCode'], true);
		//$requestBody = $post_data;
		//play3cards($requestBody);
		$card1 = "";
		$card2 = "";
		$card3 = "";
		$post_data=array();
		$post_data = json_decode($_POST['json'], true);
		$requestBody[] = $post_data;
		///print_r($requestBody);
		$card1 = implode($requestBody[0]);
		$card2 = implode($requestBody[1]);
		$card3 = implode ($requestBody[2]);
		//echo implode("card1 \n",$requestBody[0]); 
		//echo implode("card2 \n",$requestBody[1]);
		//echo  implode("card3 \n",$requestBody[2]);


		echo "card 1: \n " .$card1."\n";
		echo "card 2: \n " . $card2."\n";
		echo "card 3: \n " . $card3."\n";

		play3cards($card1,$card2,$card3);

	}


}








/*if ($resource=="play3cards"){
	if ($method=="POST"){
		require_once "php/board.php";
		$posted_data = array();
    if (!empty($_POST['json'])) {
        $posted_data = json_decode($_POST['json'], true);
			play3cards($posted_data);
    }
	}

}*/


//Resource for cards
if ($resource == "cards") {
	if ($method == "GET") {
		require_once "php/board.php";
		getallcards();

	}
	if (isset($_GET['playerId'])) {
		$id = $_GET['playerId'];
		showcardbyplayer($id);

	}
}

if ($resource == "showcards") {
	if ($method == "GET") {
		require_once "php/board.php";
		show_cardgame($requestBody);
		echo nl2br("Players with theese cards");
	}
}


if ($resource == "drawcard") {
	if ($method == "POST") {
		require_once "php/board.php";
		draw_card($requestBody);
	}
}


if ($resource == "showgame") {
	if ($method == "POST") {
		require_once "php/board.php";
		show_game($requestBody);
	}
}






//τελος γυρου και αλλγη σειρας
if ($resource == "endturn") {
	if ($method == "POST") {
		require_once "php/game.php";
	}
}

if ($resource == "pass") {
	if ($method == "POST") {
		pass();
	}
}

?>