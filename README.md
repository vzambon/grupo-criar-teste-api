# Grupo Criar - Desafio Web Back-End
##### Vaga: Desenvolvedor Backend
#####  Área: Desenvolvimento de Software (Web)

## Descrição
Este projeto é uma API RESTful desenvolvida em Laravel como parte do desafio proposto pelo Grupo CRIAR para a vaga de Desenvolvedor Backend. A aplicação permite o gerenciamento de estados, cidades, grupos de cidades (clusters), campanhas e produtos, com funcionalidades de criação, edição, exclusão e listagem.

O projeto foi construído utilizando Docker Compose para facilitar a configuração e execução do ambiente de desenvolvimento. Em conjunto com uma serie de Shell scripts para automação do processo de instalação e deploy local do projeto.


## Tecnologias Utilizadas

-   **Docker** e **Docker Compose** (Ambiente de desenvolvimento)
-   **PHP** (Laravel Framework)
-   **Swoole** (Laravel Octane)
-   **MySQL**  (Banco de dados relacional)
-   **Redis** (Caching, Session e Queues)
-   **Meilisearch** (Indexação para Full Text Search)

## Instalação

Para executar o projeto há scripts convenientes para instação e execução.

Instalando o projeto:

    cd docker/local && ./install.sh --app-name=grupo-criar-api

Após a instalação inicial, as execuções posteriores serão feitas usando:

    cd docker/local && ./start.sh

Para fins de simuação mais próxima possível de um ambiente de produção, o servidor nginx está configurado para uso de subdomínios localhost:

- http://web.localhost.com
- http://api.localhost.com

Então é necessário adicionar esses domínios ao `/etc/hosts` da maquina host:

    echo -e "127.0.0.1 api.localhost.com\n127.0.0.1 web.localhost.com" | sudo tee -a /etc/hosts


## Endpoints

A REST Api possui os seguintes endpoints:

| Método | Url | Name | 
|--|--|--|
| `GET`    | api/campaigns           			| campaigns.index 		  |
| `POST`   | api/campaigns            			| campaigns.store 		  |
| `GET`    | api/campaigns/{campaign} 			| campaigns.show  		  |
| `PATCH`  | api/campaigns/{campaign} 			| campaigns.toggle-status |
| `DELETE` | api/campaigns/{id} 	 			| campaigns.destroy       |
| `GET`    | api/cities 			 			| cities.index 			  |
| `GET`    | api/cities/{city} 		 			| cities.show			  |
| `PATCH`  | api/cities/{city} 		 			| cities.toggle-status    |
| `GET`    | api/clusters 						| clusters.index		  |
| `POST`   | api/clusters 			 			| clusters.store		  |
| `GET`    | api/clusters/{cluster}  			| clusters.show			  |
| `POST`   | api/clusters 			  			| clusters.store		  |
| `PATCH`  | api/clusters/{cluster}   			| clusters.toggle-status  |
| `GET`    | api/clusters/{cluster}/campaings   | clusters.campains		  |
| `DELETE` | api/clusters/{id}  				| clusters.destroy		  |
| `GET`    | api/products   					| products.index		  |
| `POST`   | api/products   					| products.store		  |
| `DELETE` | api/products/{id}  				| products.destroy		  |
| `GET`    | api/products/{product}   			| products.show	     	  |
| `PUT`    | api/products/{product}   			| products.update	      |
| `PATCH`  | api/products/{product}   			| products.toggle-status  |
| `GET`    | api/products/{product}   			| products.show	     	  |
| `GET`    | api/products/{product}   			| products.show	     	  |
| `GET`    | api/states 			 			| states.index 			  |
| `GET`    | api/states/{state} 		 		| states.show			  |
| `PATCH`  | api/states/{state} 		 		| states.toggle-status    |

Rotas Web auxiliares do sistema:

| Método | Url | Name | 
|--|--|--|
| `GET`    | private-storage/{disk}/{filePath} | private-storage     |
| `GET`    | sanctum/csrf-cookie 			   | sanctum.csrf-cookie |
| `GET`    | up 							   |  					 |

## Documentação - Scrumble (Laravel OpenAPI)

A documentação desse projeto está disponível através do [Scramble](https://scramble.dedoc.co/), um pacote de geração automática de documentação OpenAPI (Swagger).

Acessível em:

    http://web.localhost.com/docs/api

## Estrutura do projeto

Apesar do projeto ter uma natureza simples, foi desenvolvido pensando em conceitos DDD para fins de demonstração.

![enter image description here](https://raw.githubusercontent.com/vzambon/grupo-criar-teste-api/assets/grupo-criar-tree.png?token=GHSAT0AAAAAACWBBXKKJJL4I23UO3SV5CLUZW7VUIQ)


## Tests

O projeto foi desenvolvido em TDD, então possui um conjunto de testes garantindo a integridade das regras de negócio. Para executá-los, basta rodar o comando artisan:

    php artisan test

