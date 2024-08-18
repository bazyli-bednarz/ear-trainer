# ear-trainer

Ear training app built with Symfony for my master's degree project developed to facilitate and support learning process for music school and academies students. 

## Installation
* enter project directory
* `docker-compose up -d` - start containers
* `docker-compose exec php bash` - enter PHP container
* `composer install` - install required dependencies
* `cd app` - enter app directory
* `bin/console doctrine:migrations:migrate` - make migrations
* `bin/console doctrine:fixtures:load` - populate database with dummy data
* `localhost:8000` - launch app in browser


## Database structure
![Database structure](./database-diagram.png)