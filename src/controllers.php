<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mailgun\Mailgun;
use Netzhuffle\Entities\Mail;
use Netzhuffle\Entities\Attachment;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
});

$app->get('/in/list', function () use ($app) {
    $mails = $app['orm.em']->createQuery('SELECT m FROM Netzhuffle\Entities\Mail m')->getResult();

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

    $mail = new Mail();
    $mail->setRecipient($request->request->get('recipient'));
    $mail->setSender($request->request->get('sender'));
    $mail->setOriginalFrom($request->request->get('from'));
    $mail->setSubject($request->request->get('subject'));
    $mail->setBodyPlain($request->request->get('body-plain'));
    $mail->setStrippedText($request->request->get('stripped-text'));
    $mail->setStrippedSignature($request->request->get('stripped-signature'));
    $mail->setBodyHtml($request->request->get('body-html'));
    $mail->setStrippedHtml($request->request->get('stripped-html'));
    $mail->setMessageHeaders($request->request->get('message-headers'));
    $mail->setSpam($request->request->get('X-Mailgun-Sflag'));
    $mail->setSpamScore($request->request->get('X-Mailgun-Sscore'));
    $mail->setDkimResult($request->request->get('X-Mailgun-Dkim-Check-Result'));
    $mail->setSpf($request->request->get('X-Mailgun-Spf'));
    $mail->setDatetime($request->request->get('timestamp'));
    $mail->setOriginalDatetime($request->request->get('Date'));
    $app['orm.em']->persist($mail);

    $attachmentCount = $request->request->get('attachment-count');
    for ($i = 1; $i <= $attachmentCount; $i++) {
        $attachment = new Attachment();
        $file = $request->files->get('attachment-' . $i);
        $extension = $file->guessExtension();
        $attachment->setMail($mail);
        $attachment->setMimetype($file->getMimeType());
        $attachment->setOriginalName($file->getClientOriginalName());
        $attachment->setNewName(sha1(uniqid(mt_rand(), true)) . ($extension ? '.' . $extension : ''));
        $attachment->setSize($file->getClientSize());
        $file->move(__DIR__.'/../attachments', $attachment->getNewName());
        $app['orm.em']->persist($attachment);
    }
    
    $app['orm.em']->flush();

    return '';
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $page = 404 == $code ? '404.html' : '500.html';

    return new Response($app['twig']->render($page, array('code' => $code)), $code);
});
