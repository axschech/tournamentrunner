$(document).ready(function(){

	$('#new').click(function(){
		$(this).hide();
		$('#newTournament').show();
		loadPlayers();
		$('#playerList').show();
		if(localStorage['tournament'])
		{
			$('#goTournament').show();
		}
	});

	$('#addPlayer').click(function(e){
		addPlayer(e);
	});

	$('#playerName').keypress(function(e)
	{
		if(e.which == 13)
		{
			addPlayer(e);
		}
	});


	$('#goTournament').click(function(e){
		e.preventDefault();
		var post = {};

		var title = $('#title').val();

		if(localStorage['tournament'])
		{
			var players = localStorage['tournament'];
		}
		else
		{
			return false;
		}
		
		post.title = title;

		post.players = players;

		$.post('tournament',post,function(d){
			var data = JSON.parse(d);
			if(data.error.length>0)
			{
				$('#add_alert').html(data.error[0])
				return false;
			}
			else
			{
				if(data.id)
				{
					localStorage.clear();
					window.location="tournament/"+data.id;
				}
			}
		});
	});

	function addPlayer(e)
	{
		e.preventDefault();
		var player = $('#playerName').val();
		var title = $('#title').val();
		if(!localStorage['title'])
		{
			localStorage['title'] = title;
		}
		else if(title=="")
		{
			$('#add_alert').html('Please chose a title');
			return false;
		}

		if(!localStorage['tournament'])
		{
			localStorage['tournament'] = JSON.stringify([player]);
		}
		else
		{
			var players = JSON.parse(localStorage['tournament']);

			if(players.indexOf(player) == -1)
			{
				players.push(player);
				localStorage['tournament'] = JSON.stringify(players);
				loadPlayers();
				$('#playerName').val("");
				$('#add_alert').html("");
			}
			else
			{
				$('#add_alert').html("You've already added that player!");
			}
		}
	}

	function loadPlayers()
	{	
		if(localStorage['title'])
		{
			$('#title').val(localStorage['title']);
		}
		if(localStorage['tournament'])
		{
			var playersHTML = "";
			var players = JSON.parse(localStorage['tournament']);
			var x = 1;
			for(var i in players)
			{
				playersHTML+= "<span class='players'><h4>"+x+". "+players[i]+"<button type='button' class='btn btn-xs pull-right _"+players[i]+" playerButton'><span class='glyphicon glyphicon-remove _"+players[i]+" playerButton'></span></button></h4></span><br />";
				x++;
			}
			$('#listOfPlayers').html(playersHTML);
			
			$('.playerButton').click(function(e){
				
				var classes = e.target.classList;
				var id;
				for(var z in classes)
				{
					if(classes[z].indexOf("_") != -1)
					{
						id = classes[z].substr(1);
						break;
					}

				}

				var players = JSON.parse(localStorage['tournament']);
				var newPlayers = [];
				for(var i=0; i<players.length; i++)
				{
					if(players[i]!=id)
					{
						newPlayers.push(players[i]);
					}
				}
				localStorage['tournament'] = JSON.stringify(newPlayers);
				loadPlayers();
			});
		}
		else
		{
			return false;
		}
	}
});