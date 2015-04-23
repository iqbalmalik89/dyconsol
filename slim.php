<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    "debug" => true,
    'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => false //dirname(__FILE__) . '/cache'
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

session_cache_limiter(false);
session_start();

/*
* HTTP STATUS CODES
* 200 ok
* 400 Bad Request
* 401 Unauthorized
* 409 Conflict
*/

function response($code, $dataAry)
{
    if($code != 200)
    {
        $dataAry['status'] = 'error';        
    }
    else
    {
        $dataAry['status'] = 'success'; 
    }
    $response = $GLOBALS['app']->response();
    $response['Content-Type'] = 'application/json';
    $response->status($code);
    $response->body(json_encode($dataAry));
}




	$jsonParams = array();
	$formParams = $app->request->params();
    $data = $app->request->getBody();

	if(!empty($data))
	{
	    $decodeJsonParams = json_decode($data, TRUE);
        if(is_array($decodeJsonParams))
            $jsonParams = $decodeJsonParams;
	}

	$app->requestdata = array_merge($jsonParams, $formParams);

	$app->get('/demo' , function () use ($app){
        $app->render('demo.html.twig', array('title' => 'Demo'));
    });

    $app->get('/', function () use ($app) {
        $app->render('index.html.twig', array('title' => 'Home'));
    })->name('index');


    $app->get('/contact' , function () use ($app){
        $app->render('contact.html.twig', array('title' => 'Contact Us'));
    });

    $app->get('/about' , function () use ($app){
        $app->render('about.html.twig', array('title' => 'About Us'));
    });

    $app->get('/services' , function () use ($app){
        $app->render('services.html.twig', array('title' => 'Services'));
    });

    $app->get('/services/consulting-services' , function () use ($app){
        $app->render('consulting_services.html.twig', array('title' => 'Consulting Services'));
    });

    $app->get('/services/project-managed-services' , function () use ($app){
        $app->render('project_managed_services.html.twig', array('title' => 'Project Managed Services'));
    });

    $app->get('/services/business-application-services' , function () use ($app){
        $app->render('business_application_services.html.twig', array('title' => 'Business Application Services'));
    });

    $app->get('/services/infrastructure-management-services' , function () use ($app){
        $app->render('infrastructure_management_services.html.twig', array('title' => 'Infrastructure Management Services'));
    });

    $app->get('/utilities' , function () use ($app){
        $app->render('utilities.html.twig', array('title' => 'Utilities'));
    });

    $app->get('/retail' , function () use ($app){
        $app->render('retail.html.twig', array('title' => 'Retail'));
    });

    $app->get('/banking' , function () use ($app){
        $app->render('banking.html.twig', array('title' => 'Banking'));
    });

    $app->get('/careers' , function () use ($app){
        $app->render('careers.html.twig', array('title' => 'Careers'));
    });


    $app->notFound(function () use ($app) {
        $app->render('404.html.twig', array('title' => 'Not Found'));
    });














/*
* JSON middleware
* It Always make sure, response is in the form of JSON
* We also initiate database connection here
*/

$app->add(new JsonMiddleware('/api'));


/*
* Grouped routes
*/

$app->group('/api', function () use ($app) {

    // Add Category
    $app->post('/addcategory' , function () use ($app){
        $new = new CategoryRepo();
        $code = $new->addCategory($app->requestdata);
        response($code, array());
    });


    $app->get('/states', function() use ($app){

        $new = new LocationRepo();
        $code = $new->getStates($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    }); 

     $app->get('/contactquery', function() use ($app){

        $new = new ContactQueryRepo();
        $code = $new->getContactQueries($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });    

     $app->post('/contactquery', function() use ($app){

        $new = new ContactQueryRepo();
        $code = $new->addContactQuery($app->requestdata);
        response($code, array());
    }); 

});






$app->run();