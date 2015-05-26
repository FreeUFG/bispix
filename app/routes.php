<?php

Route::get('/', 'PrincipalController@index');
Route::put('/', 'PrincipalController@index');
Route::get('/resultados', 'PrincipalController@resultados');
Route::post('/resultados', 'PrincipalController@resultados');

Route::get('/gerar-indice/passo-1', 'IndiceInvertidoController@passo1');
Route::put('/gerar-indice/passo-2', 'IndiceInvertidoController@passo2');
Route::put('/gerar-indice/passo-3', 'IndiceInvertidoController@passo3');
Route::put('/gerar-indice/passo-4', 'IndiceInvertidoController@passo4');
Route::put('/gerar-indice/fim', 'IndiceInvertidoController@fim');

Route::get('/excecao/banco-pronto', 'ExcecaoController@bancoPronto');

Route::get('colecao{id}', 'IndiceInvertidoController@colecao');		//Importante para a exibição de documentos
Route::get('toklog', 'IndiceInvertidoController@toklog');			//Importante para a exibição da barra de progresso
