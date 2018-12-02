<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 02/12/2018
 * Time: 02:36
 */



namespace App\Mailer;
use Twig\Environment;

class SendMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * SendMailer constructor.
     * @param \Swift_Mailer $swiftMailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $swiftMailer, Environment $twig)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }


    /**
     * @param $subject
     * @param $fromEmail
     * @param $toEmail
     * @param $template
     * @return int
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function send($subject, $fromEmail, $toEmail, $template)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody(
                $this->twig->render($template),
                'text/html'
            )

        ;

        return $this->swiftMailer->send($message);
    }

}
