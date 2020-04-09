
function pollComplete(votesData) {
	$("#votes").html(votesData.content);
	if(votesData.refresh == 1){
		setTimeout("startPolling()", 3000);	
	}
};

function startPolling(votesData){
	$.post('votes.php', {}, pollComplete, 'json');
};

function callComplete(votesData) {
	$("#votes").html(votesData.content);
};

function connect(votesData) {
	$.post('votes.php', {}, callComplete, 'json');
};


$(document).ready( function() {
  $("#voteButton").live('click', function() {	
		$(".main").load("vote.php");
	});
	
	$(".setVote").live('click', function() {	
		startPolling();
		$(".main").load("main.php?a=vote&v=" + $(this).attr('id'));
	});

  $("[name=newSession]").live('click', function() {    
  	$("#sessionIdField").toggle();
  });

  if($("#sessionId").val()) {
    $("#sessionIdField").show();
    $("#existingSession").attr('checked', true);
  }

});