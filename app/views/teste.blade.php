<!DOCTYPE html>
<html>
<head>
	<title>Teste</title>
</head>
<body>
	<a class="clickable">Vamos lah!</a>
	<div id="teste"></div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    	$(document).on("click", ".clickable", function () {
    		//var endereco = '{{ app_path().'/data/colecao/00.txt' }}';
    		var endereco = '{{ file_get_contents(app_path().'/data/colecao/00.txt') }}';
    		//var loc = window.location.pathname;
    		//$('#teste').html(loc);
    		//var endereco = '{{ URL::to('colecao01') }}';
    		/*$('#teste').load(endereco, function(response,status,xhr){
				if (status=="success")
				{
					$("div").html("<ol></ol>");
					$(response).find("artist").each(function(){
						var item_text = $(this).text();
						$('<li></li>').html(item_text).appendTo('ol');
					});
				}
				else
				{
					$("div").html("An error occured: <br/>" + xhr.status + " " + xhr.statusText);
				}
			 });*/
    		$('#teste').html(endereco);	
		});
    </script>
</html>
