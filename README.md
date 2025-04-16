💼 Legal.AI – Match Inteligente para Áreas Jurídicas Legal.AI é uma aplicação web construída com Laravel que simula um sistema inteligente de recomendação de especialistas jurídicos com base na área de atuação e localização. Ideal para fins educacionais, projetos acadêmicos ou como protótipo para plataformas voltadas ao setor jurídico.

🚀 Funcionalidades Interface intuitiva para busca de especialistas jurídicos.

Sistema de "match" baseado em afinidade por área, localização e um fator de diversificação aleatória.

Listagem dos 3 perfis mais compatíveis com o usuário.

Apresentação clara dos fatores que contribuíram para a pontuação de afinidade.

🛠️ Tecnologias Utilizadas

PHP 8+

Laravel 10

Bootstrap 5.3

Blade Templates

Font Awesome

Animate.css

📂 Estrutura do Projeto

├── routes/ │ └── web.php # Define as rotas principais ├── app/ │ ├── Http/ │ │ └── Controllers/ │ │ └── MatchController.php # Lógica principal de match e controle │ └── helpers.php # Função utilitária para extrair iniciais dos nomes ├── resources/ │ └── views/ │ └── welcome.blade.php # Interface principal ├── composer.json # Autoload de helpers

⚙️ Instalação e Execução

Clone o repositório git clone https://github.com/Pedromonteiro740/legal-ai.git cd legal-ai

Instale as dependências composer install

Configure o ambiente Crie um arquivo .env e configure: cp .env.example .env php artisan key:generate Não é necessário banco de dados para esse projeto.

Habilite o helper no composer.json Certifique-se de que app/helpers.php está incluso no autoload: "autoload": { "files": [ "app/helpers.php" ] } Depois, execute: composer dump-autoload

Rode o servidor php artisan serve Acesse: http://localhost:8000

💡 Como funciona o Match? A lógica de correspondência está no MatchController. Ela considera três fatores principais:

Área de atuação (peso: 45%)

Localização (peso: 35%)

Fator de diversificação aleatório (peso: até 20%)

A pontuação final de afinidade é calculada, normalizada para um máximo de 99, e os 3 perfis mais compatíveis são exibidos ao usuário.

📑 Explicação dos Arquivos

🔁 routes/web.php Define duas rotas principais:

GET /: Exibe o formulário de busca.

POST /buscar: Processa o formulário e retorna os matches.

🎯 MatchController.php showForm(): Carrega a página inicial com as áreas únicas dos perfis.

findMatches(): Processa os dados do formulário, calcula os matches e retorna os 3 melhores.

calculateMatchScore(): Lógica de cálculo com pesos para área, localização e aleatoriedade.

🧠 helpers.php Função initials($name) que retorna as iniciais de um nome, usada para exibir avatares ou identificadores estilizados.

🌐 welcome.blade.php Interface visual do projeto:

Formulário com campos de nome, área e localização.

Listagem dos melhores especialistas recomendados.

Uso de estilos modernos e responsivos.

Principais decisões tomadas durante o desenvolvimento

Rotas As rotas são configuradas no arquivo routes/web.php. As duas principais rotas são:
GET '/': Exibe o formulário de entrada, permitindo que o usuário selecione sua área de atuação, localização e forneça seu nome.

POST '/buscar': Recebe os dados do formulário e encontra os 3 melhores matches (profissionais) com base nas semelhanças de área de atuação, localização e outros fatores. Essa rota utiliza o método findMatches no MatchController.

Controlador (MatchController) O controlador MatchController contém a lógica de cálculo dos "matches" entre o usuário e os perfis cadastrados. Ele contém duas funções principais:
showForm: Exibe o formulário para o usuário preencher.

findMatches: Valida e processa os dados do formulário, calcula a afinidade entre o usuário e os perfis, e retorna os 3 melhores matches com base na afinidade calculada.

Decisões de Implementação: Validação de entrada: O método findMatches realiza a validação dos dados do formulário usando o Request do Laravel para garantir que as entradas sejam corretas.

Cálculo de afinidade: A afinidade é calculada com base em três fatores principais: área de atuação, localização e um fator de diversificação aleatório. O cálculo de afinidade também leva em consideração os pesos atribuídos a cada um desses fatores.

Perfil Falso (Fake Profiles) A aplicação usa perfis fictícios pré-definidos no código para simular o comportamento da funcionalidade de matchmaking. Cada perfil possui informações como:
Nome

Cargo

Área de atuação

Localização

Descrição

Tags (como LGPD, Compliance, etc.)

Pesos para área, localização e outros fatores.

Calculando a Afinidade O método calculateMatchScore é responsável por calcular a afinidade entre o usuário e os perfis. Ele leva em consideração os seguintes fatores:
Área de atuação: Um perfil com uma área de atuação mais próxima à do usuário recebe uma pontuação maior.

Localização: A localização do perfil é comparada com a localização fornecida pelo usuário.

Diversificação: A afinidade também é ajustada por um fator de diversificação aleatório para evitar que o sistema sempre retorne os mesmos resultados.

Visualização no Front-End (welcome.blade.php) A interface de usuário foi construída com o uso de Bootstrap para garantir uma experiência responsiva e fluída. Além disso, as cores e o layout foram escolhidos para criar uma aparência profissional e atraente.
Estilos personalizados: O estilo da página foi ajustado com o uso de variáveis CSS (--primary, --secondary, etc.) para garantir um design moderno e harmônico.

Cartões de perfil: Os resultados de "match" são apresentados em cartões (.match-card), que mostram as informações do perfil e uma "badge" de afinidade, destacando o nível de afinidade entre o usuário e o perfil.

Helpers e Funções de Utilidade No arquivo helpers.php, a função initials é definida para extrair as iniciais do nome de um perfil. Isso é útil para exibir um avatar visual simples (com as iniciais) caso o perfil não tenha uma foto.

Performance e Carregamento Para melhorar a experiência do usuário, foi implementada uma sobreposição de carregamento (loading-overlay) que aparece enquanto os dados estão sendo processados. Isso ajuda a garantir que o usuário saiba que a aplicação está processando os dados e evita a sensação de que a interface está congelada.

Estrutura do Composer A aplicação inclui o arquivo helpers.php no autoload do Composer para garantir que as funções auxiliares estejam disponíveis em todo o código sem a necessidade de importação explícita.

"autoload": { "files": [ "app/helpers.php" ] }

Este projeto exemplifica o uso de Laravel para implementar uma funcionalidade de matchmaking inteligente, utilizando parâmetros de afinidade e lógica personalizada para criar uma experiência de usuário intuitiva. A arquitetura modular e o uso de recursos como validação de formulários e helpers garantem que o código seja bem estruturado e de fácil manutenção.

✨ O que eu faria diferente se tivesse mais tempo

Integração com banco de dados real.

Cadastro e login de usuários.

Sistema de avaliação e feedback dos especialistas.

Filtros mais avançados (anos de experiência, tags, etc).

🧑‍💻 Autor Pedro Henrique Monteiro Souza 📧 Contato: pedrohenriquemonteiro@usp.br