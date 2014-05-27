$(document).ready(function(){
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
				var i = 0;
				var j = 1;
				var n = 0;
				var html = "<div class='col-md-2'>";
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
                      html+= "<div class='pull-right'><input type='text' style='width:50px' /></div>";
                      html+= "</div>";
                      html+= "<br />";
                    i++;
                    n++;
                    if(n==data.players[0].length)
	                {
	                   html+= "<button type='submit' class='btn'>Submit</button></form>";
	                }
                }

                $('#players').html(html);
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
				html = '<div id="buttons"><span style="font-size:50px"> Game '+game+' </span><br /><br /><button type="button" id="new" class="btn btn-default btn-lg btn-warning disabled ">New Game</button><br /><br /><button type="button" id="end" class="btn btn-default btn-lg btn-danger">End Tournament</button><br /><br /><br /><br /><br /></div>';
				$('#buttons').html(html);
				buildChart();
			}
		});
	});


	function buildChart()
	{
		$.get(id+'/players',function(d){

			var data = JSON.parse(d);
			if(data.error.length>0)
			{
				return data.error[0];
			}
			else
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
		});
	}

	$('.playersForm').submit(function(e){
		e.preventDefault();
		var form = $(this).serializeArray();
		console.log(form);
		return false;
	});

});