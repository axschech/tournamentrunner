$(document).ready(function(){

	$('#register_form').submit(function(e){
		e.preventDefault();
		var form = $(this).serializeArray();
		var post = {};
		for(var i in form)
		{
			if(form[i].value=="")
			{
				var name = form[i].name;
				var str = name+" is blank";
				$('#register_alert').html(str);
				return false;
			}
			else
			{
				post[form[i].name] = form[i].value;
			}
		}

		$.post('register',post,function(d){
			var data = JSON.parse(d);
			if(data.error.length>0)
			{
				if(data.error[0]=="exists")
				{
					$('#register_alert').html('You already exist!');
				}
				else
				{
					$('#register_alert').html("Please fill all the fields");
				}
			}
			else
			{
				location.reload();
			}
		});
	});


	$('#login_form').submit(function(e)
	{
		e.preventDefault();
		var form = $(this).serializeArray();
		var post = {};
		for(var i in form)
		{
			if(form[i].value=="")
			{
				var name = form[i].name;
				var str = name+" is blank";
				$('#login_alert').html(str);
				return false;
			}
			else
			{
				post[form[i].name] = form[i].value;
			}
		}
		
		$.post('login',post,function(d)
		{
			var data = JSON.parse(d)
			if(data.error.length>0)
			{
				if(data.error.length==1)
				{
					$('#login_alert').html(data[0]);
				}
				else if(data.error.length>1)
				{
					$('#login_alert').html("All fields are required");
				}
			}
			else
			{
				location.reload();
			}
		});
	});

});
