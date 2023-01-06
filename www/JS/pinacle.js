


$(function(){
draw_empty_board();
    $("#btn2").click(function(){
        fill_board();
    });
});

function draw_empty_board() {
    var t='<table id="card_deck">';
    for(var i=0;i<1;i++) {
        t += '<tr>';
        for(var j=1;j<53;j++) {
            t += '<td class="cardDeck" id="cardCode">' + j +'</td>';
        }
        t+='</tr>';
    }
    t+='</table>';
    $('#div1').html(t);
    }
  

function fill_board() {
	$.ajax(
        {url: "pinacle.php/cards/", 
		success: $("#div1").text("hello") 
        }
    );
}

function fill_board_by_data(data){
    for(var i=0;i<data.length;i++) {
        var o = data[i];
    }    
}

