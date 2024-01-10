# Gestor Tarefas

## por Fabio carneiro

---

`README ainda em desenvolvimento e partes do sistema estão por serem feitas.`

o projeto ainda não possuí algumas coisas básicas como gestão de usuários, casdastro e etc.

para poder usar o sistema é necessário instalar as dependências com o composer, executar as migrations e gerar os seeds.

---

instalar as dependências:

```bash
composer install
```

aplicando as migrations:

```bash
php artisan migrate
```

aplicando os seeds para alimentar o banco de dados

```bash
php artisan db:seed --class=UserSeeders
```

rodando o projeto com artisan serve:

```bash
php artisan sarve
```
