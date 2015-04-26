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

function askWizard($iconNb, $lineNb) {
    $iconsList = array();

    $wizard = new Wizard();
    $wizard->addIconDir(array(
        '/carl-olsen',
        '/delapouite',
        '/felbrigg',
        '/john-colburn',
        '/john-redman',
        '/lorc',
        '/priorblue',
        '/sbed',
        '/viscious-speed',
        '/willdabeast',
    ));

    $iconsList = $wizard->play($iconNb, $lineNb);
    foreach ($iconsList as $lineKey => $line) {
        foreach ($line as $iconKey => $icon) {
            $iconsList[$lineKey][$iconKey] = str_replace(SYS_WEB, '', $icon);
        }
    }

    return $iconsList;
}

// ============ ROUTING ===================
$app->get(
    '/',
    function ($request, $response, $args) {
        $iconsList = askWizard(3, 3);

        return $this['view']->render($response, 'index.twig', array(
            'iconsList' => $iconsList,
        ));
    }
)->setName('home');
$app->get(
    '/{iconNb}',
    function ($request, $response, $args) {
        $iconsList = askWizard($args['iconNb'], 3);

        return $this['view']->render($response, 'index.twig', array(
            'iconsList' => $iconsList,
        ));
    }
);
$app->get(
    '/{iconNb}/{lineNb}',
    function ($request, $response, $args) {
        $iconsList = askWizard($args['iconNb'], $args['lineNb']);

        return $this['view']->render($response, 'index.twig', array(
            'iconsList' => $iconsList,
        ));
    }
);
// ============ END ROUTING ===================

// Run app
$app->run();
