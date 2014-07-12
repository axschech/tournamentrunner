$(document).ready(function(){

	if(localStorage['tournament'])
	{
		showNew();
	}

	$('#new').click(function(){
		showNew();
	});
	function showNew()
	{
		$(this).hide();
		$('#newTournament').show();
		loadPlayers();
		$('#playerList').show();
		if(localStorage['tournament'])
		{
			$('#goTournament').show();
		}
	}
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
		if(player=="")
		{
			$('#add_alert').html("You must enter a name");
			return false;
		}

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
			loadPlayers();
			$('#playerName').val("");
			$('#add_alert').html("");

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
			$('#goTournament').show();
			
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

	window.henh = function deleteTournament(id)
	{
		$.ajax({
			url: 'tournament/'+id,
			method: 'DELETE',
			dataType: 'JSON',
			success: function(data)
			{
				if(data.error.length==0 && data.tournaments)
				{
					var html = "";
					for(var i=0; i<data.tournaments.length; i++)
					{
						var plus = i+1;
						var item = data.tournaments[i];
						html+="<div class='col-md-10'><h4>"+plus+". <a href='tournament/"+item['id']+"'>"+item['name']+"</a><button type='button' onClick='henh("+item['id']+")' class='btn btn-xs pull-right'><span class='glyphicon glyphicon-remove'></span></button></h4></div>";
					}
					$('#currentTournaments').html(html);
				}

			}
		});
		return false;
	}
});