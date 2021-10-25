## Regulação médica
A aplicação foi feita com Laravel 7 e Mysql.

### Pré-requisito
- PHP >= 7.2
- Composer
- MYSQL

### Instalação
```bash
$ git clone https://github.com/felipenaf/regulacao-medica
$ cd regulacao-medica
$ composer install
```
- Popular a base com o arquivo __script.sql__ que se encontra na raiz do projeto
- Criar uma cópia do arquivo __.env.example__ para __.env__
- Alterar as informações do banco de dados

```ini
DB_DATABASE=regulacao_medica
DB_USERNAME=
DB_PASSWORD=
```

```bash
$ php artisan key:generate
$ php artisan serve
```
- Acessar o servidor que geralmente fica em http://127.0.0.1:8000

### Informações
O script do banco está trazendo alguns dados de entidades que não possuem tela de cadastro. Um deles é a entidade Usuário.

Criei os usuários com senhas simples e sem criptografia para facilitar o teste.

|email|senha|tipo|
|-----|-----|----|
|amadeus@hsl.com|123|Médico de Família|
|sebastian@hsl.com|123|Médico de Família|
|ludwig@hsl.com|123|Médico Regulador|
|frederic@hsl.com|123|Médico Regulador|
