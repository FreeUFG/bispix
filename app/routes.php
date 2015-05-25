<?php

Route::get('/', 'PrincipalController@index');
Route::get('/resultados', 'PrincipalController@resultados');
Route::post('/resultados', 'PrincipalController@resultados');

Route::get('/gerar-indice', 'IndiceInvertidoController@index');
Route::put('/gerar-indice/tokenizer', 'IndiceInvertidoController@tokenizer');
Route::get('/gerar-indice/pre-processamento', 'IndiceInvertidoController@preprocessamento');
Route::put('/gerar-indice/indice-invertido', 'IndiceInvertidoController@indice');

Route::get('/excecao/banco-pronto', 'ExcecaoController@bancoPronto');

Route::get('colecao{id}', 'IndiceInvertidoController@colecao');		//Importante para a exibição de documentos
Route::get('toklog', 'IndiceInvertidoController@toklog');			//Importante para a exibição da barra de progresso
