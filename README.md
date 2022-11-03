
## About API
- Clonar repositorio 
- git clone https://github.com/globalr7on/api_github.git

## How to work
- cd api_github
- Modificar o usuario em controlador GetRepositoryController -> $response = http::get('https://api.github.com/users/('colocar usuario')/repos');
- php artisan serve 