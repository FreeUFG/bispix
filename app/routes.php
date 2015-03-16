<?php

Route::get('/', 'PrincipalController@index');
Route::get('/results', 'PrincipalController@results');
Route::post('/results', 'PrincipalController@results');

Route::get('/gerar-indice', 'IndiceInvertidoController@index');
Route::put('/gerar-indice/tokenizer', 'IndiceInvertidoController@tokenizer');
Route::put('/gerar-indice/pre-processamento', 'IndiceInvertidoController@preprocessamento');
Route::put('/gerar-indice/indice-invertido', 'IndiceInvertidoController@indice');

Route::get('/teste', function(){
	IndiceInvertido::quebraPalavras('santa');
});

Route::get('colecao{id}', 'IndiceInvertidoController@colecao');
Route::get('toklog', 'IndiceInvertidoController@toklog');
