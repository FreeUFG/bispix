    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    {{ HTML::script('assets/bs/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/offcanvas.js') }}
    <script>
    	$(document).ready(function () {
			setInterval(function(){   
                $('.colecao-loader').load( '{{ URL::to('/toklog') }}' );
                var x = $('.colecao-loader').text();
                x = x.substr(x.length - 10);
                x = x.substr(0,2);
                var y = '\
                <div class="progress"> \
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' + 
                    x + '" aria-valuemin="0" aria-valuemax="14" style="width: ' + (x/14)*100 + '%"> \
                    <span class="sr-only">40% Complete (success)</span> \
                  </div> \
                </div>';
                if(x != "")
                    $('.colecao-loader-2').html(y);
    		},1000);
		});
    </script>  