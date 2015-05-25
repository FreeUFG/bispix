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
		$data['viewName'] = 'site.resultados.index';
		$data['scriptName'] = 'site.resultados.script';

        return $data;
	}
}