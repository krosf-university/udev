<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH.'Config/Routes.php')) {
  require SYSTEMPATH.'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('api', function (RouteCollection $routes) {
  $routes->get('tags/(:alpha)/posts', 'TagController::posts/$1');

  $routes->get('users/(:any)/posts', 'UserController::posts/$1');

  $routes->get('search', 'PostController::index');

  $routes->post('posts/(:num)/like', 'PostController::like/$1', ['filter' => 'auth']);

  $routes->post('posts/(:num)/discussions', 'DiscussionController::add/$1');
  $routes->get('posts/(:num)/discussions', 'DiscussionController::view/$1', ['filter' => 'auth:get']);

  $routes->resource('users',[
    'only' => ['index', 'show','create', 'update', 'delete'],
    'controller' => 'UserController',
    'filter' => 'auth:get',
  ]);

  $routes->resource('posts',[
    'only' => ['index', 'show','create', 'update', 'delete'],
    'controller' => 'PostController',
    'filter' => 'auth:get',
  ]);

  $routes->resource('roles',[
    'only' => ['index', 'show','create', 'update', 'delete'],
    'controller' => 'RoleController',
    'filter' => 'auth:get',
  ]);

  $routes->resource('tags',[
    'only' => ['index', 'show','create', 'update', 'delete'],
    'controller' => 'TagController',
    'filter' => 'auth:get',
  ]);

  $routes->post('images', 'ImageController::upload', [ 'filter' => 'auth' ]);

  $routes->group('auth', function (RouteCollection $routes) {
    $routes->get('revoke-token', 'AuthController::revokeToken', ['filter' => 'auth']);
    $routes->get('active/(:hash)', 'AuthController::activateAccount/$1');
    $routes->post('login', 'AuthController::login');
    $routes->post('register', 'UserController::create');
    $routes->post('refresh-token','AuthController::refreshToken');
    $routes->post('forgot-password', 'AuthController::forgotPassword');
    $routes->put('reset-password/(:hash)', 'AuthController::resetPassword/$1');
    $routes->put('resend-active-account', 'AuthController::resendActivateAccount');
  });
});

          /**
           * --------------------------------------------------------------------
           * Additional Routing
           * --------------------------------------------------------------------
           *
           * There will often be times that you need additional routing and you
           * need to it be able to override any defaults in this file. Environment
           * based routes is one such time. require() additional route files here
           * to make that happen.
           *
           * You will have access to the $routes object within that file without
           * needing to reload it.
           */
if (file_exists(APPPATH.'Config/'.ENVIRONMENT.'/Routes.php')) {
  require APPPATH.'Config/'.ENVIRONMENT.'/Routes.php';
}
