<?php

class Principal extends Eloquent{

	public static function parametros($nomeMetodo)
	{
		switch($nomeMetodo){
			case 'resultados':
				return self::parametrosResultados();
				break;
		}
	}
	private static function parametrosResultados()
	{
		$query = Input::get('query');
		$data['query'] = $query;
		$data['enderecoColecao'] = Colecao::getEnderecoColecaoAtual();
		$data['viewName'] = 'site.resultados.index';
		$data['scriptName'] = 'site.resultados.script';
		$data['postings'] = Consulta::executar($query);

        return $data;
	}

private static function parametrosResultadosAND()
	{
		$query = Input::get('query');
		
		$data['query'] = $query;
		$data['enderecoColecao'] = Colecao::getEnderecoColecaoAtual();
		$data['viewName'] = 'site.resultados.index';
		$data['scriptName'] = 'site.resultados.script';
		$data['postings'] = Consulta::executar($query);

        return $data;
	}
	

}
