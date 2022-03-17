<?php

require __DIR__.'/../core/Application.php';

$app = new Application();

// ====================[configurations]====================
$app->response->set_template_base_dir(__DIR__.'/../views/');

// ====================[middlewares]====================
// session middleware
$app->use(function(& $req) {
  session_start();
  $req->session = $_SESSION;
});

// auth middleware
$app->use(function(& $req) {
  // $req->user = ['email' => 'aissa@django.com'];
  $req->user = null;
});

$login_required = function($req, $res, $next) {
  if(is_null($req->user)) {
    return $res->redirect('/login');
  }
  return $next();
};

// ====================[routes]====================
$app->route('/', function($req, $res, $next) use($app) {
  return $res->render_template($req, 'index.php');
});

$app->route('/about', function($req, $res, $next) {
  return $res->render_template($req, 'about.php', ['name' => 'about']);
});

$app->route('/home', function($req, $res, $next) {
  return $res->redirect('/');
});

$app->run();
