<div class="panel panel-primary">

    <div class="panel-heading">
        Resultados para <mark>consulta</mark> 
    </div>

    <table class="table table-hover">
        <?php
            $results = ['00', '01', '02', '03', '04'];
        ?>

        @foreach ($results as $id)
            <tr>
                <td>
                    <a href="" data-title="Documento {{ $id }}" data-route="{{ URL::to('colecao'.$id) }}" 
                    class="openModal" data-toggle="modal" data-target="#modalDocument">
                        Documento {{ $id }}
                    </a>    <br/>
                    <p>{{ substr( file_get_contents(app_path().'/data/colecoes/santa/'.$id.'.txt'), 0, 100 ) }}</p>
                </td>
            </tr>
        @endforeach
        
    </table>

    <div class="panel-footer text-center">
        <ul class="pagination" style="background-color: #003366;">
            <li><a href="#">&laquo;</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li style="font-color: black;"><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&raquo;</a></li>
        </ul>
    </div>
</div>

@include('site.resultados.documento-modal')