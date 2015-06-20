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
        
        $colecao->nome = 'Jogos Eletronicos';
        $colecao->nome_seletor = 'jogos';
        $colecao->endereco = 'jogos';
        $colecao->em_uso = false;

        $colecao->save();
    }

}