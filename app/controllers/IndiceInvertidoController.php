<?php

class IndiceInvertidoController extends BaseController {

	public function index()
	{
		if( IndiceInvertido::bancoPronto() ){	
			$data = IndiceInvertido::parametros('index');
			return View::make('template.empty', $data);
		}

		return Redirect::to('/excecao/banco-pronto');
	}
	public function tokenizer()
	{
        $nomeColecao = Input::get('nome-colecao');
        IndiceInvertido::quebraPalavras($nomeColecao);

        return Redirect::to('/gerar-indice/pre-processamento');
	}
	public function preprocessamento()
	{
		$data['viewName'] = 'block.gerarIndice.index';
		$data['panelName'] = 'block.gerarIndice.preprocessamento';
		$data['scriptName'] = 'block.scriptGeraIndice';

		$data['navAtivo'] = 'preprocessamento';
		$data['panelUrl'] = URL::to('/gerar-indice/indice-invertido');
        $data['panelId'] = 'preprocessamentoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

		return View::make('template.empty', $data);
	}
	public function indice()
	{
		$data['viewName'] = 'block.gerarIndice.index';
		$data['panelName'] = 'block.gerarIndice.indice';
		$data['scriptName'] = 'block.scriptGeraIndice';

		$data['navAtivo'] = 'indice';
		$data['panelUrl'] = URL::to('/');
        $data['panelId'] = 'indiceForm';
        $data['panelNext'] = 'Concluído';
        $data['panelIcon'] = 'ok';

		return View::make('template.empty', $data);
	}	
	public function colecao($id)
	{
		if(is_numeric($id)){
			if(0 <= $id && $id <= 99){
				echo file_get_contents(app_path().'/data/colecoes/santa/'.$id.'.txt');
				return;
			}
		}
		return Redirect::to('/');

	}
	public function toklog()
	{
		echo file_get_contents(app_path().'/data/colecoes/log.txt');

	}

}
