@include('block.header')
@include('block.topmenu')

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
                                      'url' => '/resultados',
                                      'class' => 'form-inline',
                                      'id' => 'search',
                                      'name' => 'search'
                                      ))
                    }}
                        <div class="form-group">
                            <input style="width: 25em;" type="text" class="form-control"
                                placeholder="Busque aqui..." name="query">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" href="{{ URL::to('/resultados') }}">
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
