# Bispix
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## FAQ - uso da ferramenta

1. Como utilizar o banco de dados no Laravel?
  - Configure o arquivo `app/config/database.php` na parte de `connections` com os dados do seu servidor MySQL (local ou remoto);
  - Crie um banco de dados no seu servidor (com o nome que você informou no arquivo acima);
  - Execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate` para criar as tabelas a partir dos códigos já existentes (ver pasta `app/database/migrations`);
  - Para resetar o banco, execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate:rollback`.

2. Estou tendo erros com a mensagem `Maximum execution time` no meu browser! 
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

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
