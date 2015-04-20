<?php

include('../utils.php');

// ============ BOOTSTRAP =======================
// Session
session_name (SESSION_NAME) ;
session_start();

// Create Slim app
$app = new \Slim\App();

// Register Twig View helper
$app->register(new \Slim\Views\Twig(SYS_APP . '/tpl'));
// ============ END BOOTSTRAP ===================

// ============ ROUTING ===================
$app->get(
    '/',
    function ($request, $response, $args) {
        return $this['view']->render($response, 'index.twig');
    }
)->setName('home');
// ============ END ROUTING ===================


// Run app
$app->run();