<?php
require_once "php/dbconnect.php";

#require_once "php/board.php";
$method = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'), true);

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = $request[0];

print_r($requestBody);

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

	if ($method == "GET") {
		require_once "php/board.php";
		show_status();
	}
	if ($method == "DELETE") {
		require_once "php/board.php";
		reset_game();
	}
}


if ($resource == "playcard") {
	if ($method == "POST") {
		require_once "php/board.php";
		playcard($requestBody);
	}
}



if ($resource == "play3cards") {
	if ($method == "POST") {
		require_once "php/board.php";

		$card1 = "";
		$card2 = "";
		$card3 = "";
		//$post_data=array();
		//$post_data = json_decode($_POST['json'], true);
		$post_data = json_decode(json_encode($requestBody), true);
		$requestBody[] = $post_data;
		///print_r($requestBody);
		$card1 = implode($requestBody[0]);
		$card2 = implode($requestBody[1]);
		$card3 = implode($requestBody[2]);



		echo "card 1: \n " . $card1 . "\n";
		echo "card 2: \n " . $card2 . "\n";
		echo "card 3: \n " . $card3 . "\n";

		play3cards($card1, $card2, $card3);

	}
}


if ($resource == "play4cards") {
	if ($method == "POST") {
		require_once "php/board.php";

		$card1 = "";
		$card2 = "";
		$card3 = "";
		$card4 = "";
		//$post_data=array();
		//$post_data = json_decode($_POST['json'], true);
		$post_data = json_decode(json_encode($requestBody), true);
		$requestBody[] = $post_data;
		///print_r($requestBody);
		$card1 = implode($requestBody[0]);
		$card2 = implode($requestBody[1]);
		$card3 = implode($requestBody[2]);
		$card4 = implode($requestBody[3]);


		echo "card 1: \n " . $card1 . "\n";
		echo "card 2: \n " . $card2 . "\n";
		echo "card 3: \n " . $card3 . "\n";
		echo "card 3: \n " . $card3 . "\n";

		play4cards($card1, $card2, $card3, $card4);

	}
}


if ($resource == "playsequence") {
	if ($method == "POST") {
		require_once "php/board.php";

		$card1 = "";
		$card2 = "";
		$card3 = "";
		$card4 = "";
		$card5 = "";

		//$post_data=array();
		//$post_data = json_decode($_POST['json'], true);
		$post_data = json_decode(json_encode($requestBody), true);
		$requestBody[] = $post_data;
		///print_r($requestBody);
		$card1 = implode($requestBody[0]);
		$card2 = implode($requestBody[1]);
		$card3 = implode($requestBody[2]);
		$card4 = implode($requestBody[3]);
		$card4 = implode($requestBody[4]);


		echo "card 1: \n " . $card1 . "\n";
		echo "card 2: \n " . $card2 . "\n";
		echo "card 3: \n " . $card3 . "\n";
		echo "card 3: \n " . $card3 . "\n";
		echo "card 3: \n " . $card4 . "\n";

		playsequence($card1, $card2, $card3, $card4, $card5);

	}
}





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

 

if ($resource == "drawcard") {
	if ($method == "POST") {
		require_once "php/board.php";
		draw_card($requestBody);
	}
}


if ($resource == "pass") {
	if ($method == "PUT") {
		require_once "php/board.php";
		pass();

	}
}

if ($resource == "endturn") {
	if ($method == "PUT") {
		require_once "index.php/board.php";
		pass();
	}

}

?>