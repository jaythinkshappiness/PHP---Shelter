<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Type.php";
    require_once __DIR__."/../src/Animal.php";



    $app = new Silex\Application();
    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=shelter';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server,$username,$password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render("index.html.twig",array('types'=>Type::getAll(),'animals'=>Animal::getAll()));
    });

    $app->post("/", function() use ($app) {
        $new_type = new Type($_POST['type']);
        $new_type->save();
        return $app['twig']->render("index.html.twig",array('types'=>Type::getAll(),'animals'=>Animal::getAll()));
    });



    return $app;
?>
