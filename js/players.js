var players = null;

function player_names(data) { 
    if (data[1]) {
        if (players.playerId == data[0].playerId) {
            document.getElementById('playerOneName').innerHTML = data[0].username;
            document.getElementById('playerTwoName').innerHTML = data[1].username;
        } else {
            document.getElementById('playerOneName').innerHTML = data[1].username;
            document.getElementById('playerTwoName').innerHTML = data[0].username;
        }
    } else {
        document.getElementById('playerOneName').innerHTML = data[0].username;
        document.getElementById('playerTwoName').innerHTML = "Waiting for others to join...";
    }
}


function updateInfo() {  
    $.ajax({
        url: "index.php/players" + players.playerId,
        method: 'GET',
        success: updatePlayer
    });
}


function updatePlayer(data) { //kanei update ton paikth kathe sec
    players = data[0];
    //fill_game();
    setTimeout(function () {
        updateInfo();
    }, 1000);
}



function addPlayer() { //prosthiki tou player sto database
    var username = document.getElementById('usrnm');
    if (username.value != '') {
        $.ajax({
            url: "index.php/players",
            method: 'POST',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify({
                x: username.value
            }),
            success: givePlayerValue
        });
    }
}

function givePlayerValue(data) {
    players = data[0]; //dinei to data se mia metavliti player
    generateGame(); 
}



