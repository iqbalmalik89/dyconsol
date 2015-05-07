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

    $globalWebUrl = UtilityRepo::getRootPath(false);
    $viewParameters = ['web_url' => $globalWebUrl];

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

	$app->get('/demo' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Demo';
        $app->render('demo.html.twig', $viewParameters);
    });

    $app->get('/', function () use ($app, $viewParameters) {
        $viewParameters['title'] = 'Home';        
        $app->render('index.html.twig', $viewParameters);
    })->name('index');

    $app->get('/index', function () use ($app, $viewParameters) {
        $viewParameters['title'] = 'Home';
        $app->render('index.html.twig', $viewParameters);
    })->name('index');

    $app->get('/contact' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Contact Us';        
        $app->render('contact.html.twig', $viewParameters);
    });

    $app->get('/about' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'About Us';        
        $app->render('about.html.twig', $viewParameters);
    });


    $app->get('/services/consulting-services' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Consulting Services';
        $app->render('consulting_services.html.twig', $viewParameters);
    });

    $app->get('/services' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Services';
        $app->render('services.html.twig', $viewParameters);
    });


    $app->get('/services/project-managed-services' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Project Managed Services';
        $app->render('project_managed_services.html.twig', $viewParameters);
    });

    $app->get('/services/business-application-services' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Business Application Services';
        $app->render('business_application_services.html.twig', $viewParameters);
    });

    $app->get('/services/infrastructure-management-services' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Infrastructure Management Services';
        $app->render('infrastructure_management_services.html.twig', $viewParameters);
    });

    $app->get('/utilities' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Utilities';
        $app->render('utilities.html.twig', $viewParameters);
    });

    $app->get('/retail' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Retail';
        $app->render('retail.html.twig', $viewParameters);
    });

    $app->get('/technology' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Technology';
        $app->render('technology.html.twig', $viewParameters);
    });

    $app->get('/banking' , function () use ($app, $viewParameters){
        $viewParameters['title'] = 'Banking';
        $app->render('banking.html.twig', $viewParameters);
    });

    $app->get('/admin/' , function () use ($app, $viewParameters){
        echo "<script>window.location='login.php'</script>";
    });

    $app->get('/careers' , function () use ($app, $viewParameters){
        $jobRepo = new JobRepo();
        $jobs = $jobRepo->getJobs(array('status' => 1));
        $viewParameters['title'] = 'Careers';
        $viewParameters['jobs'] = $jobs['data'];        
        $app->render('careers.html.twig', $viewParameters);
    });

    $app->get('/clients' , function () use ($app, $viewParameters){
        $testimonialRepo = new TestimonialRepo();
        $testimonials = $testimonialRepo->getTestimonials(array('status' => 'Show'));
<<<<<<< HEAD
        $viewParameters['title'] = 'Clients';
        $viewParameters['testimonials'] = $testimonials['data'];        
        $app->render('clients.html.twig', $viewParameters);
=======
        $clientRepo = new ClientsRepo();
        $clients = $clientRepo->getClients(array('status' => 'Show'));
        //   print_r($testimonials);
        //$app->render('clients.html.twig', array('title' => 'Careers', 'jobs' => $jobs['data']));
        $app->render('clients.html.twig', array('title' => 'Clients', 'testimonials' => $testimonials['data'], 'clients' => $clients['data']));
>>>>>>> b6d62f57cd4c2f7d8bc2c92d1d696fadb5ffaef5

    });


    $app->notFound(function () use ($app, $viewParameters) {
        $viewParameters['title'] = 'Not Found';        
        $app->render('404.html.twig', $viewParameters);
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

    // Login
    $app->post('/login' , function () use ($app){

        $new = new LoginRepo();
        $code = $new->login($app->requestdata);
        response($code, $code['data']);
    }); 
    
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


// Get Contact Query/Queries    
     $app->get('/contactquery', function() use ($app){

        $new = new ContactQueryRepo();
        $code = $new->getContactQueries($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });    

// Add Contact Query
     $app->post('/contactquery', function() use ($app){

        $new = new ContactQueryRepo();
        $code = $new->addContactQuery($app->requestdata);
        response($code, array());
    }); 

// Delete Contact Query
     $app->post('/deletecontactquery', function() use ($app){

        $new = new ContactQueryRepo();
        $code = $new->deleteContactQuery($app->requestdata);
        response($code, array());
    }); 

// Add Subscriber
      $app->post('/subscriber', function() use ($app){

        $new = new SubscriberRepo();
        $code = $new->addSubscriber($app->requestdata);
        response($code, array());
    }); 

// Get Subscriber(s)
     $app->get('/subscriber', function() use ($app){

        $new = new SubscriberRepo();
        $code = $new->getSubscriber($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });  

// Delete Subscriber
     $app->post('/deletesubscriber', function() use ($app){

        $new = new SubscriberRepo();
        $code = $new->deleteSubscriber($app->requestdata);
        response($code, array());
    });

    // Add Job
      $app->post('/job', function() use ($app){

        $new = new JobRepo();
        $code = $new->addJob($app->requestdata);
        response($code, array());
    }); 

      // Edit Job
      $app->post('/editjob', function() use ($app){

        $new = new JobRepo();
        $code = $new->editJob($app->requestdata);
        response($code, array());
    }); 

// Get Job(s)
     $app->get('/job', function() use ($app){

        $new = new JobRepo();
        $code = $new->getJobs($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });  

// Delete Job
     $app->post('/deletejob', function() use ($app){

        $new = new JobRepo();
        $code = $new->deleteJob($app->requestdata);
        response($code, array());
    });

    $app->get('/admindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->getAdminData();
        response(200, array('data' => $code));
    });

    $app->post('/editadmindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editAdminData($app->requestdata);
        response($code, array());
        
    });

    $app->post('/editadminpassword', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editadminpassword($app->requestdata);
        response($code, array());
        
    });     

    $app->get('/logout' , function () use ($app){
        session_destroy();
        response(200, array());
    }); 

    // Add Client
      $app->post('/client', function() use ($app){

        $new = new ClientsRepo();
        $code = $new->addClient($app->requestdata);
        response($code, array());
    }); 

      // Edit Client
      $app->post('/editclient', function() use ($app){

        $new = new ClientsRepo();
        $code = $new->editClient($app->requestdata);
        response($code, array());
    }); 

// Get Client(s)
     $app->get('/client', function() use ($app){

        $new = new ClientsRepo();
        $code = $new->getClients($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });  

// Delete Client
     $app->post('/deleteclient', function() use ($app){

        $new = new ClientsRepo();
        $code = $new->deleteClient($app->requestdata);
        response($code, array());
    });

    // Add Testimonial
      $app->post('/testimonial', function() use ($app){

        $new = new TestimonialRepo();
        $code = $new->addTestimonial($app->requestdata);
        response($code, array());
    }); 

      // Edit Testimonial
      $app->post('/edittestimonial', function() use ($app){

        $new = new TestimonialRepo();
        $code = $new->editTestimonial($app->requestdata);
        response($code, array());
    }); 

// Get Testimonial(s)
     $app->get('/testimonial', function() use ($app){

        $new = new TestimonialRepo();
        $code = $new->getTestimonials($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });  

// Delete Testimonial
     $app->post('/deletetestimonial', function() use ($app){

        $new = new TestimonialRepo();
        $code = $new->deleteTestimonial($app->requestdata);
        response($code, array());
    }); 

     $app->post('/client_upload', function() use ($app){
        $image = new Image();
        $resp = $image->uploadTmp($_FILES['logo'], 'client_logos');
        response($resp['code'], $resp);
    }); 


});






$app->run();