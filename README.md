versoes:
    Laravel ^6.2
    PHP ^7.2
    Postgres 11.7

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

links base:
    laravel-modules
        https://medium.com/@destinyajax/how-to-build-modular-applications-in-laravel-the-plug-n-play-approach-part-1-13a87f7de06
    repository-patern
        https://medium.com/laraveltips/voc%C3%AA-entende-repository-pattern-voc%C3%AA-est%C3%A1-certo-disso-d739ecaf544e
    guards:
        https://pusher.com/tutorials/multiple-authentication-guards-laravel
