<?php

class Excecao extends Eloquent{

	public static function parametros($nomeMetodo)
	{
		switch($nomeMetodo){
			case 'bancoPronto':
				return self::parametrosBancoPronto();
				break;
		}
	}
	
	private static function parametrosBancoPronto()
	{
		$data['mensagem'] = 'O banco não está pronto para a criação de um novo índice!';
		$data['scriptName'] = 'block.script';

        return $data;
	}
}