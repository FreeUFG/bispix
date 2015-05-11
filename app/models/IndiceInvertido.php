<?php

class IndiceInvertido extends Eloquent{

	protected $table = 'indice';
	
	private static function listaDiretorio($nomeDiretorio)
	{
		
		$lista = scandir($nomeDiretorio);
		$chave = array_search(".", $lista);
		unset($lista[$chave]);
		$chave = array_search("..", $lista);
		unset($lista[$chave]);

		return $lista;
	}	
	public static function quebraPalavras($nomeDiretorio)
	{
		$endAbsoluto = app_path().'/data/colecoes/'.$nomeDiretorio;
		$lista = self::listaDiretorio($endAbsoluto);

		$log = app_path().'/data/colecoes/log.txt';

		foreach($lista as $arq){
			
			$logFile = fopen($log,'w');
			$data = "Indexando o arquivo ".$arq." ...";
			fwrite($logFile, $data);
			fclose($logFile);

			$pont = fopen($endAbsoluto.'/'.$arq,'r');
			if($pont){
				$posicao = 0;
				while(true) {
					$linha = fgets($pont);
					if ($linha==null) break;
					
					$termos = explode(' ', $linha);
					
					foreach($termos as $t){
						$posicao++;
						$registro = array(
							'termo' => $t,
							'documento' => $arq,
							'posicao' => $posicao
						);
						DB::table('indice')->insert( $registro );
					}
				}
			}
		}
		echo 'Lido com sucesso! </br>';
		fclose($pont);
	}
}