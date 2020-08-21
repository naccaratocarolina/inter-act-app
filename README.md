## InterAct

Seja bem vinde! O InterAct é uma rede social voltada para a saúde mental, onde seus usuários são livres para compartilhar os seus hobbies e trocar experiências.
Além disso, é um aplicativo desenvolvido pensando nesse período de isolamento social, onde as pessoas são livres para compartilhar seus passatempos em comum e
estimular atividades e trocas saudáveis.

## Desenvolvedores
- Alexandra Gomes
- Carolina Naccarato
- Hussein Latif
- Matheus Isidoro

## Frameworks utilizadas
- Ionic
- Laravel

## Instruções
Após clonar esse repositório na sua máquina:
### 1. Front-end
```bash
npm install
ionic serve
```

## 2. Back-end
- Crie um banco de dados local
- Salve as credenciais do BD no arquivo ```.env``` e rode os comandos
```bash
php artisan key:generate
php artisan migrate --seed
php artisan passport:install
php artisan serve
```
