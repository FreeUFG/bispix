<?php

class IndiceInvertidoController extends BaseController {

	public function passo1()
	{
		$data = IndiceInvertido::parametros('passo-1');
		return View::make('template.empty', $data);
	}
	public function passo2()
	{
		$data = IndiceInvertido::parametros('passo-2');
		return View::make('template.empty', $data);
	}
	public function passo3()
	{
		$nomeColecao = Session::get('nome-colecao');
        IndiceInvertido::tokenizer($nomeColecao);

		$data = IndiceInvertido::parametros('passo-3');
		return View::make('template.empty', $data);
	}
	public function passo4()
	{
		IndiceInvertido::normalizacao();

		$data = IndiceInvertido::parametros('passo-4');
		return View::make('template.empty', $data);
	}
	public function fim()
	{
		$nomeColecao = Session::get('nome-colecao');
		Colecao::setNomeColecaoAtual($nomeColecao);
		
		$data = IndiceInvertido::parametros('fim');
		return View::make('template.empty', $data);
	}	
	public function colecao($id)
	{
		if(is_numeric($id)){
			if(0 <= $id && $id <= 99){
				echo file_get_contents(app_path().'/data/colecoes/harrypotter/'.$id.'.txt');
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
