<?php

namespace Galerie\Mail; 

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Message;

use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime as Mime;
use Zend\Mime\Message as MimeMessage;




class MailSender
{

    protected static $transport = null;

    public static function initialize($params)
    {
        static::$transport = new SmtpTransport();
        static::$transport->setOptions(new SmtpOptions(array(
            'name' => $params['name'],
            'host' => $params['host'],
            'port' => $params['port'],
        )));
    }


    public function send(
        $sender, $sender_name, $to, $to_name, $subject, $text_body, $html_body, $logo
    ) {
        // Création de la partie texte
        $text = new MimePart($text_body);
        $text->type = Mime::TYPE_TEXT;

        // Création de la partie HTML
        $html = new MimePart($html_body);
        $html->type = Mime::TYPE_HTML;

        // Création du message
        $body = new MimeMessage();
        $body->setParts(array($text, $html));
        
        $mail = new Message();        
        $mail->setBody($body);
        $mail->setFrom($sender, $sender_name);
        $mail->addTo($to, $to_name);
        $mail->setSubject($subject);

        static::$transport->send($mail);
    }

}

