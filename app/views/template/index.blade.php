@include('block.header')

    <body OnLoad="document.search.input.focus();">
        <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="{{ URL::to('/') }}">Bispix</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('/gerar-indice') }}">Gerar índice</a></li>
                        <li class="disabled"><a href="#">Usar outra coleção</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
          </div><!-- /.container -->
        </div><!-- /.navbar -->
        <div class="container-fluid text-center">
            <h1 style="font-size: 6em; margin-top: 1em;">
                Bispix
            </h1>
            <p style="margin-top: 1.5em; margin-bottom: 1.5em;">
                O seu buscador da UFG Regional Jataí!
            </p>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    {{ Form::open(array(
                                      'url' => '/results',
                                      'class' => 'form-inline',
                                      'id' => 'search',
                                      'name' => 'search'
                                      )) 
                    }}
                        <div class="form-group">
                            <input style="width: 25em;" type="text" class="form-control" 
                                placeholder="Busque aqui..." name="input">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" href="{{ URL::to('/results') }}">
                                Ir
                            </button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        {{ HTML::script('assets/bs/js/bootstrap.min.js') }}
        {{ HTML::script('assets/js/offcanvas.js') }}

    </body>
</html>
