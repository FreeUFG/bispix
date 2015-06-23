<?php

class ColecaoTableSeeder extends Seeder {

    public function run()
    {
        $colecao = new Colecao;
        
        $colecao->nome = 'Santa Cruz';
        $colecao->nome_seletor = 'santa';
        $colecao->endereco = 'santa';
        $colecao->em_uso = false;

        $colecao->save();

        $colecao = new Colecao;
        
        $colecao->nome = 'Teste';
        $colecao->nome_seletor = 'teste';
        $colecao->endereco = 'teste';
        $colecao->em_uso = false;

        $colecao->save();

        $colecao = new Colecao;

        $colecao->nome = 'Harry Potter';
        $colecao->nome_seletor = 'harrypotter';
        $colecao->endereco = 'harrypotter';
        $colecao->em_uso = false;

        $colecao->save();
    }

}