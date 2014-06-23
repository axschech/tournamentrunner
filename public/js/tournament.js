$(document).ready(function(){
	"user strict";
	var url = location.href;
	var splits = url.split('/');
	var id = splits[splits.length-1];
	$('#jumble').click(function(){
		
		$.get(id+'/players?check=true',function(d)
		{
			var data = JSON.parse(d);
			if(data.error.length>0)
			{
				return data.error[0];
			}
			else
			{
				refreshPlayers(data);
			}
		});
	});

	$('#start').click(function(e){

		e.preventDefault();
		
		
		var html="";
		$.post(id+'/game',function(d){
			var data = JSON.parse(d);

			if(data.error.length>0)
			{
				return data.error[0];
			}
			else
			{
				var game = data.game[0];
				html = '<div id="buttons"><span style="font-size:50px"> Game '+game+' </span><br /><br /><button type="button" id="new" class="btn btn-default btn-lg btn-warning disabled ">Next Game</button><br /><br /><button type="button" id="end" class="btn btn-default btn-lg btn-danger">End Tournament</button><br /><br /><br /><br /><br /></div>';
				$('#buttons').html(html);
				buildChart();
			}
		});
	});

	$('#new').click(function(e){
		$.ajax({
			url:id+'/',
			method:'PUT',
			dataType:'JSON',
			success: function(data)
			{
				console.log(data);
				var input = {"players":[]};
				input.players[0] = data.players;

				buildChart(input);
				refreshPlayers(input);
			}
		});
	});

	function buildChart(data)
	{
		if(data!=undefined)
		{
			build(data);
		}
		else
		{
			$.get(id+'/players',function(d){

				var data = JSON.parse(d);
				if(data.error.length>0)
				{
					return data.error[0];
				}
				else
				{
					build(data);
				}
			});
		}
		

		function build(data)
		{
			var html = "";

				i = 1;
				html+= "<table class='table'>";
				html+= "<thead><tr><th>Name</th><th>Score</th><th>Place</th><th>Game</th></tr></thead>";
				for(var z in data.players[0])
				{
				  var item = data.players[0][z];

				  html+= "<tr>";
				  // echo "<td>".$i."</td>";
				  html+= "<td>"+item.name+"</td>";
				  html+= "<td>"+item.score+"</td>";
				  html+= "<td>"+item.place+"</td>";
				  html+= "<td>"+item.game+"</td>";
				  html+= "</tr>";
				  // $i++;
				}
				html+= "</table>";
				$('#playerChart').html(html);
		}
	}

	$('.playersForm').on('submit',function(e){
		console.log('submitted');
		e.preventDefault();
		console.log('got here');
		var form = $(this).serializeArray();
		var put = {};
		for(var i in form)
		{
			put[form[i].name] = form[i].value;
		}

		var daURL = id+'/game';
		$.ajax({
			url: daURL,
			method: 'PUT',
			data: {"data":put},
			dataType: 'JSON',
			success: function(data)
			{
				console.log(data);
				console.log(data.error.active);
				if(data.error.active!=undefined && data.error.active==false)
				{
					$('.top-right').notify({
						message: { text: 'Please start the tournament first' },
						type: 'danger'
					}).show();
					return false;
				}
				if(data.done)
				{
					$('#new').removeClass('disabled')
				}
				var input = {"players":[]};
				input.players[0] = data.players;
				buildChart(input);
				refreshPlayers(input);
			}
		});
	});

	function refreshPlayers(data)
	{
		console.log(data);
		var i = 0;
		var j = 1;
		var n = 0;
		var html = "<div class='col-md-2'><form class='playersForm'>";
		// var html="";
		for(var z in data.players[0])
	    {   
	        if(i==4)
	        {
	          html+= "<button type='submit' class='btn'>Submit</button></form></div><div class='col-md-2'><form class='playersForm'>";
	          i=0;
	        }
	          html+= "<div class='col-md-12'>";
	          if(i==0)
	          {
	            html+= "<h4>Round "+j.toString()+"</h4>";
	            j++;
	          }
	          html+= data.players[0][z].name;

	          if(data.players[0][z].scored==0)
	          {
	          	html+= "<div class='pull-right'><input type='text' name='"+data.players[0][z].id+"' style='width:50px' /></div>";
	          }
	          else
	          {
	          	html+= "<div class='pull-right'><input type='text' name='"+data.players[0][z].id+"' value='"+data.players[0][z].curScore+"' disabled style='width:50px' /></div>";
	          }
	          html+= "</div>";
	          html+= "<br />";
	       
	        if(n==data.players[0].length-1)
	        {
	           html+= "<button type='submit' class='btn'>Submit</button></form>";
	        }
	         i++;
	        n++;
	    }

	    $('#players').html(html);
	    
	    $('.playersForm').on('submit',function(e){
		console.log('submitted');
		e.preventDefault();
		console.log('got here');
		var form = $(this).serializeArray();
		var put = {};
		for(var i in form)
		{
			put[form[i].name] = form[i].value;
		}

		var daURL = id+'/game';
		$.ajax({
			url: daURL,
			method: 'PUT',
			data: {"data":put},
			dataType: 'JSON',
			success: function(data)
			{
				console.log(data);
				console.log(data.error.active);
				if(data.error.active!=undefined && data.error.active==false)
				{
					$('.top-right').notify({
						message: { text: 'Please start the tournament first' },
						type: 'danger'
					}).show();
					return false;
				}
				if(data.done)
				{
					$('#new').removeClass('disabled')
				}
				var input = {"players":[]};
				input.players[0] = data.players;
				buildChart(input);
				refreshPlayers(input);
			}
		});
	});
	}



});