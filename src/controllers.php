<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mailgun\Mailgun;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
});

$app->get('/in/list', function () use ($app) {
    $mails = $app['db']->query('SELECT * FROM mails')->fetchAll();

    return $app['twig']->render('list.html', array(
        'mails' => $mails,
    ));
});

$app->post('/mailgun', function (Request $request) use ($app) {
    $timestamp = $request->get('timestamp');
    $token = $request->get('token');
    $hash = hash_hmac('sha256', $timestamp . $token, $app['mailgun.key']);
    if (!$hash == $request->get('signature')) {
        $app->abort(403, 'signature is wrong');
    }

    $app['db']->insert('mails', array(
        'recipient' => $request->request->get('recipient'),
        'sender' => $request->request->get('sender'),
        'frommail' => $request->request->get('from'),
        'subject' => $request->request->get('subject'),
        'bodyplain' => $request->request->get('body-plain'),
        'strippedtext' => $request->request->get('stripped-text'),
        'strippedsignature' => $request->request->get('stripped-signature'),
        'bodyhtml' => $request->request->get('body-html'),
        'strippedhtml' => $request->request->get('stripped-html'),
        'messageheaders' => $request->request->get('message-headers'),
        'spam' => $request->request->get('X-Mailgun-Sflag'),
        'spamscore' => $request->request->get('X-Mailgun-Sscore'),
        'dkimresult' => $request->request->get('X-Mailgun-Dkim-Check-Result'),
        'spf' => $request->request->get('X-Mailgun-Spf'),
        'timestamp' => $request->request->get('timestamp'),
        'datetime' => $request->request->get('Date'),
    ));
    $mailId = $app['db']->lastInsertId();

    $attachmentCount = $request->request->get('attachment-count');
    for ($i = 1; $i <= $attachmentCount; $i++) {
        $file = $request->files->get('attachment-' . $i);
        $extension = $file->guessExtension();
        $newName = 'att' . $mailId . '-' . $i . ($extension ? '.' . $extension : '');
        $app['db']->insert('attachments', array(
            'mail' => $mailId,
            'mimetype' => $file->getMimeType(),
            'originalname' => $file->getClientOriginalName(),
            'newname' => $newName,
            'size' => $file->getClientSize(),
        ));
        $file->move(__DIR__.'/../attachments', $newName);
    }

    return '';
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $page = 404 == $code ? '404.html' : '500.html';

    return new Response($app['twig']->render($page, array('code' => $code)), $code);
});
