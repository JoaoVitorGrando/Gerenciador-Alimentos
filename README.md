# 🍎 Sistema de Gerenciamento de Alimentos

Um sistema web desenvolvido em Laravel para gerenciamento de alimentos, permitindo controle de estoque, validade e categorização de produtos.

## ✨ Funcionalidades

- 📝 Cadastro de alimentos com nome, quantidade e validade
- 📊 Categorização de alimentos (frutas, legumes, carnes, etc.)
- ⚠️ Alertas de estoque baixo
- 🕒 Monitoramento de validade próxima
- 🔍 Filtros por categoria e status
- 📱 Interface responsiva e intuitiva

## 🛠️ Tecnologias Utilizadas

- PHP 8.4
- Laravel 12.14.1
- MySQL
- Bootstrap 5
- Font Awesome
- HTML5/CSS3

## 🚀 Como Executar o Projeto

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/gerenciador-alimentos.git
cd gerenciador-alimentos
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o arquivo .env:
```bash
cp .env.example .env
```

4. Configure as variáveis de ambiente no arquivo .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Execute as migrations:
```bash
php artisan migrate
```

6. Inicie o servidor:
```bash
php artisan serve
```

7. Acesse o sistema em `http://localhost:8000`

## 📋 Estrutura do Projeto

- `app/Models/Alimento.php` - Modelo com regras de negócio
- `app/Http/Controllers/AlimentoController.php` - Controlador com lógica de aplicação
- `resources/views/alimentos/` - Views do sistema
- `database/migrations/` - Estrutura do banco de dados

## 🎯 Funcionalidades Principais

### Gerenciamento de Alimentos
- Adição de novos alimentos
- Edição de informações
- Exclusão de registros
- Visualização em tabela organizada

### Controle de Estoque
- Monitoramento de quantidade
- Alertas de estoque baixo
- Definição de estoque mínimo

### Gestão de Validade
- Registro de data de validade
- Alertas de produtos próximos do vencimento
- Status visual de validade

### Categorização
- Organização por categorias
- Filtros por tipo de alimento
- Visualização agrupada

## 👨‍💻 Autor

João - Desenvolvedor Web

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 🤝 Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou enviar pull requests.

---

Desenvolvido por João Grando para a disciplina de Desenvolvimento Web 3
