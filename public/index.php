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
        $wizard = new Wizard();
        $wizard->addIconDir(array(
            '/delapouite',
        ));

        $iconsList = $wizard->play();
        foreach ($iconsList as $lineKey => $line) {
            foreach ($line as $iconKey => $icon) {
                $iconsList[$lineKey][$iconKey] = str_replace(SYS_WEB, '', $icon);
            }
        }

        return $this['view']->render($response, 'index.twig', array(
            'iconsList' => $iconsList,
        ));
    }
)->setName('home');
// ============ END ROUTING ===================


// Run app
$app->run();
