# Carrinho de Compras Usando POO

### O que é

O projeto de e-commerce permite o cadastro de produtos, a adição de itens ao carrinho, a finalização de compras e a atualização do valor total. Além disso, inclui um sistema de autenticação de usuários, que utiliza geração e verificação de tokens para garantir a segurança.

### Banco de dados

O banco de dados ***cart*** contém 6 tabelas:

#### cart:
<ul>
<li>id (int, primary-key),</li>
<li>status (boolean)</li>
</ul>

#### products:
<ul>
<li>id (int, primary-key),</li>
<li>name (varchar, 255)</li>
<li>description (varchar, 500)</li>
<li>price (float)</li>
</ul>

#### cart_products:
<ul>
<li>id (int, primary-key),</li>
<li>cart_id (foreign-key)</li>
<li>product_id (foreign-key)</li>
</ul>

#### user:
<ul>
<li>id (int, primary-key),</li>
<li>name (varchar, 255)</li>
<li>birth_date (date)</li>
<li>address (varchar, 255)</li>
<li>cpf (varchar, 255)</li>
<li>email (varchar, 255)</li>
<li>password (varchar, 255)</li>
</ul>

#### personal_access_tokenser:

<ul>
<li>id (int, primary-key),</li>
<li>token (varchar, 255)</li>
<li>user_id (foreign-key)</li>
<li>expired_at (datetime)</li>
<li>created_at (datetime)</li>
</ul>

#### sales_order:
<ul>
<li>id (int, primary-key),</li>
<li>cart_id (foreign-key)</li>
<li>total (float)</li>
<li>address (varchar, 255)</li>
<li>user_id (foreign-key)</li>
</ul>

### O que foi praticado:

* [x] Criação de classes
* [x] Criação de atributos e métodos
* [X] Criação de getters e setters
* [X] Manipulação de arrays básico
* [X] Conexão com banco de dados
* [X] Tratamento de exceções
* [X] Herança
* [X] Encapsulamento
* [X] Polimorfismo
* [ ] Interfaces
* [X] Traits
* [X] Consumo de bibliotecas externas
* [X] Desenvolvimento de API Rest com autenticação

### Próximos passos
* [ ] Proteção contra SQL Injection
* [ ] Proteção contra script