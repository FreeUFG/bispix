# Bispix
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## Ferramentas importantes
  - [Git](http://git-scm.com/downloads): Sistema para controle de versão de código;
  - [XAMPP](https://www.apachefriends.org/pt_br/download.html): Distribuição Apache fácil de instalar contendo PHP, MySQL e Perl;
  - [Composer](https://getcomposer.org/download/): Gerenciador de dependências para PHP;
  - [Sublime](http://www.sublimetext.com/3): Editor de texto, muito utilizado por desenvolvedores web;
  - [MySQL Workbench](https://dev.mysql.com/downloads/workbench/): Ferramenta gratuita para gerenciamento de banco de dados (é necessário o registro gratuito na Oracle).

## FAQ - uso da ferramenta

1. Como utilizar o banco de dados no Laravel?
  - Configure o arquivo `app/config/database.php` na parte de `connections` com os dados do seu servidor MySQL (local ou remoto);
  - Crie um banco de dados no seu servidor (com o nome que você informou no arquivo acima);
  - Execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate` para criar as tabelas a partir dos códigos já existentes (ver pasta `app/database/migrations`);
  - Para resetar o banco, execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate:rollback`.

2. Estou tendo mensagens de erros que exibem `Maximum execution time` no meu navegador! 
  - Aumente o tempo máximo de execução no arquivo PHP.ini. 
  - Procure no seu servidor onde você pode editar este arquivo
  - Alguma parte do arquivo deve conter as seguintes linhas:
  ```
; Maximum execution time of each script, in seconds
; http://php.net/max-execution-time
; Note: This directive is hardcoded to 0 for the CLI SAPI
max_execution_time=30
```
  - Mude a linha ``max_execution_time=30`` para ``max_execution_time=600``, por exemplo (de 30s para 10min).

3. Estou tendo mensagens de erros no navegador associadas a algum arquivo ``autoload``!
  - Possivelmente existe alguma dependência desatualizada no seu projeto;
  - Execute, na linha de comando, dentro do diretório do projeto, o comando ``composer update`` (necessária conexão com Internet).
  
### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
