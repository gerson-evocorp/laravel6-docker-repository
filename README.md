versoes:
    Laravel ^6.2
    PHP ^7.2
    Postgres 11.7

ja inclui:
    Carbon
    Passport

permissoes:
    chown -Rf 1000:1000 .
    chown -Rf www-data:www-data storage/

install packege im module:
    Acesse o Modulo:
        cd Modules/<modulo_name>
    baixe o pacote:
        composer require <package>
    Na raiz do projeto execute:
        php artisan module:update <modulo_name>

create repository:
    create repository with genreic methods:
        php artisan module:make-repository <repository_name> <model_name> <module_name>
    create plain repository:
        php artisan module:make-repository <repository_name> -p <model_name> <module_name>
    create repository with service:
        php artisan module:make-repository <repository_name> -s <model_name> <module_name>
    create service with genreic methods:
        php artisan module:make-service <service_name> <repository_name> <module_name>
    create plain service:
        php artisan module:make-service <service_name> -p <repository_name> <module_name>
    
links base:
    laravel-modules
        https://medium.com/@destinyajax/how-to-build-modular-applications-in-laravel-the-plug-n-play-approach-part-1-13a87f7de06
    repository-patern
        https://blog.schoolofnet.com/trabalhando-com-repository-no-laravel/
    guards:
        https://pusher.com/tutorials/multiple-authentication-guards-laravel
