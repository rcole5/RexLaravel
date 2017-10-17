# Rex Backend Laravel Test

Documentation at http://docs.rexback.apiary.io/

Deploying
---------

### Configure .env

Fill out the database info in the /.env file.

### Creating a User

    $ php artisan tinker
    >>> App\User::create(["name" => "Ryan Cole", "email" => "test@test.com", "password" => password_hash(md5("yourpassword"), PASSWORD_BCRYPT)]);
    
### Seeding the databaes

Make sure 

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
and

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
are UNCOMMENTED in \database\seeds\DatabaseSeeder.php.

Run
    
    $ php artisan migrate:refresh --seed
    
If running cross domain uncomment the headers in the api.php file.
    
### Running the devlopment server

    $ php artisan serve --port {port number}
    
Testing
---------

Make sure 

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
and

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
are COMMENTED in \database\seeds\DatabaseSeeder.php.
Also make sure headers are commented out in your api.php file.

Run

    $ composer test
    
