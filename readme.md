# Bispix
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## Perguntas comuns no uso da ferramenta

1. Como utilizar o banco de dados no Laravel?
  - Configure o arquivo `app/config/database.php` na parte de `connections` com os dados do seu servidor MySQL (local ou remoto);
  - Crie um banco de dados no seu servidor (com o nome que você informou no arquivo acima);
  - Execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate` para criar as tabelas a partir dos códigos já existentes (ver pasta `app/database/migrations`);
  - Para resetar o banco, execute, na linha de comando, dentro do diretório do projeto, o comando `php artisan migrate:rollback`

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
