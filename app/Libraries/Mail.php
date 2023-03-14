<?php

namespace App\Libraries;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public $protocol = 'smtp';
    public $host = '';
    public $port = '';
    public $username = '';
    public $password = '';
    public $mailType = 'html';
    public $SMTPAuth = FALSE;
    public $SMTPSecure = 'tls';
    public $isSMTP = TRUE;


    private $subject = '';
    private $message = '';

    private $to = '';
    private $from = '';
    private $from_name = '';

    private $smtp_debug = 0;
    private $mc;

    public function __construct($use_config = 'default', $smtp_debug = 0)
    {
        $this->mc = new PHPMailer;
        $this->smtp_debug = $smtp_debug;

        if (is_string($use_config)) {
            $MyConfig = config('MyApp');
            if (isset($MyConfig->email[$use_config])) {
                $config     = $MyConfig->email[$use_config];
                $this->protocol     = isset($config['protocol']) ? $config['protocol'] : '';
                $this->host         = isset($config['host']) ? $config['host'] : '';
                $this->port         = isset($config['port']) ? $config['port'] : '';
                $this->SMTPAuth     = isset($config['SMTPAuth']) ? $config['SMTPAuth'] : false;
                $this->username     = isset($config['username']) ? $config['username'] : '';
                $this->password     = isset($config['password']) ? $config['password'] : '';
                $this->SMTPSecure   = isset($config['SMTPSecure']) ? $config['SMTPSecure'] : 'tls';
                $this->from         = $this->username;
                $this->from_name    = isset($config['senderName']) ? $config['senderName'] : '';
            } else {
                die('Config ' . $use_config . ' Not Found');
            }
        }
    }

    public function setFrom($from, $from_name = '')
    {
        $this->from = $from;
        $this->from_name = $from_name == '' ? $from : $from_name;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function addAttachment($filename, $new_name = '')
    {
        if ($new_name != '') {
            $this->mc->addAttachment($filename, $new_name);
        } else {
            $this->mc->addAttachment($filename);
        }
    }

    public function AddEmbeddedImage($filename, $embed_name)
    {
        $this->mc->AddEmbeddedImage($filename, $embed_name);
    }

    public function send()
    {
        if ($this->protocol == 'smtp') {
            $this->mc->Host = $this->host;
            $this->mc->Port = $this->port;
            $this->mc->SMTPSecure = $this->SMTPSecure;
            $this->mc->SMTPAuth = $this->SMTPAuth;
            $this->mc->Username = $this->username;
            $this->mc->Password = $this->password;
            $this->mc->setFrom($this->from, $this->from_name);
            $this->mc->addAddress($this->to);
            $this->mc->msgHTML($this->message);
            $this->mc->Subject = $this->subject;
            if ($this->isSMTP) {
                $this->mc->isSMTP();
            }

            $this->mc->SMTPDebug = $this->smtp_debug;
            $this->mc->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            if ($this->mc->send()) {
                return 1;
            } else {
                return 0;
            }
        }
    }
}
