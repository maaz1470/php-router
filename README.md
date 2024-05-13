# PHP Router

Basic usase in php router


1. Install php router using `composer require rahat1470/php-router` this command
2. Create `.htaccess` file in your root project directory and write bellow this code.

    ```
    RewriteEngine On
    RewriteCond %{REQUEST_URI}  !(\.png|\.jpg|\.webp|\.gif|\.jpeg|\.zip|\.css|\.svg|\.js|\.pdf)$
    RewriteRule (.*) index.php [QSA,L]

    ```
3. Create your first route on your application.

    ```
    use Rahat1470\PhpRouter\Route;

    Route::get('/',function(){
        return 'Hello World';
    });

    // or

    Route::get('/',[App::class, 'method']);

    ```

4. You can pass some parameter like:

    ```
    use Rahat1470\PhpRouter\Route;

    Route::get('/posts/$post_name',function($post_name){
        return $post_name;
    });

    ```
5. You can access passing dynamic parameter your class like:

    ```
    use Rahat1470\PhpRouter\Route;

    Route::get('/posts/$post_url',[Post::class, 'findPost']);

    // Post Class
    class Post{
        public static function findPost($url){
            return $url;
        }
    }

    ```
