# Restaurant menu
Based on Symfony 5.2.1

## Installation

**Install Symfony CLI:**\
`wget https://get.symfony.com/cli/installer -O - | bash`

**Check your computer meets all requirements:**\
`symfony check:requirements`

**Run composer:**\
`composer install`

**Create Database:**\
`php bin/console doctrine:database:create`

**Run migrations:**\
`php bin/console doctrine:migrations:migrate`

**Run fixtures:**\
`php bin/console doctrine:fixtures:load`

**Run the server:**\
`symfony server:start`

**Admin user credentials:**\
`Login: admin@example.com`\
`Password: admin`

**Available routes:**\
`/login`\
`/register`\
`/admin - Admin panel for managing entities`\
`/api - CRUD for entities`