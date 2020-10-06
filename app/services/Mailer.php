<?php


class Mailer
{
    protected $sender_email;
    protected $recipient_email;
    protected $subject;
    protected $message_path;


    public function __construct(string $recipient_email, string $subject, string $message_path, string $sender_email = "lndt.librarire@gmail.com")
    {
        $this->sender_email = $sender_email;
        $this->recipient_email = $recipient_email;
        $this->subject = $subject;
        $this->message_path = $message_path;
    }


    public function send(array $vars = array())
    {
        extract($vars);
        ob_start();
        require_once $this->message_path;
        $html = ob_get_clean();
        $sendgrid_apikey = "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";

        $url = 'https://api.sendgrid.com/';

        $params = array(
            'to'        => "test@yopmail.com",
            'toname'    => "Example User",
            'from'      =>  $this->sender_email,
            'fromname'  => "lndt",
            'subject'   => $this->subject,
            'text'      => "I'm text!",
            'html'      => $html,
        );

        $request =  $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);

        $options = array(
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $sendgrid_apikey),
            CURLOPT_POSTFIELDS => $params
        );
        curl_setopt_array($session, $options);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    }
}


// $mailer = new Mailer("osiris@yopmail.com", "Bienvenue parmis nous", "../layouts/mailer/welcome_send.php");

// $mailer->send(array("user" => "antoine"));
