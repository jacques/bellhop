<?php
/**
 * BellHop
 *
 * @author    Jacques Marneweck <jacques@siberia.co.za>
 * @copyright 2018 Jacques Marneweck.  All rights strictly reserved.
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    // Pre-launch file of peters
    $html = file_get_contents(__DIR__.'/../html/xindex.html');

    $response->getBody()->write($html);

    return $response;
});

/**
 * Registration
 */
$app->map(['GET', 'POST'], '/register/', function (Request $request, Response $response, array $args) use ($app) {
    if ($request->isPost()) {
        $post = $request->getParsedBody();
        $ok = true;

        $v = new Valitron\Validator($post);
        $v->rule('required', [
            'first_name',
            'last_name',
            'email_address',
        ]);
        $v->rule('email', 'email_address');
        #$v->rule('emailDNS', 'email_address');
        if($v->validate()) {
// Create the Transport
$transport = (new Swift_SmtpTransport('smtp-relay.gmail.com', 465, 'ssl'))
        ;

        error_log("[NEW REGISTRATION ON WAITING LIST] " . json_Encode($post));

        $mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Welcome to the easy way to pay HMRC'))
  ->setFrom(['hello@wayvglobal.com' => 'HMRC Pay'])
  ->setTo([$post['email_address']])
  ->setBcc(['jmarneweck@gmail.com'])
  ->setBody('Hi ' . $post['first_name'] . ',

Thank you for registering your interest in our service.  We will let you know once we are ready to go live.

Regards
The HMRC Pay Team')
  ;

    // Send the message
    $result = $mailer->send($message);
    error_log('[EMAIL STATUS] ' . $result);

    $html = $app->template->display('registered.tpl');

    $response->getBody()->write($html);

    return $response;
        } else {

        $app->template->bulkAssign($post);
        $app->template->assign('errors', $v->errors());
        $html = $app->template->display('register.tpl');
        $response->getBody()->write($html);
                return $response;
        }
    }

    $html = $app->template->display('register.tpl');

    $response->getBody()->write($html);

    return $response;
});
