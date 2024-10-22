<?php

namespace SEVEN_TECH\Communications\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Exception;
use WP_User;

class Email
{
    private $web_address;
    private $logo_link;
    private $site_name;
    private $facebook;
    private $twitter;
    private $contact_email;
    private $linkedin;
    private $instagram;
    private $year;
    private $company_name;
    private $emailTemplateHeader;
    private $emailTemplateFooter;

    public function __construct()
    {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        $this->web_address = esc_url(home_url());
        $this->logo_link = '';

        if (!empty($logo[0])) {
            $this->logo_link = esc_url($logo[0]);
        }

        $this->site_name = get_bloginfo('name');

        $this->facebook = esc_attr(get_option('facebook_link'));
        $this->twitter = esc_attr(get_option('twitter_link'));
        $this->contact_email = esc_attr(get_option('contact_email'));
        $this->linkedin = esc_attr(get_option('linkedin_link'));
        $this->instagram = esc_attr(get_option('instagram_link'));
        $this->year = date("Y");
        $this->company_name = get_theme_mod('footer_company');

        $this->emailTemplateHeader = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailHeader.php';
        $this->emailTemplateFooter = SEVEN_TECH_COMMUNICATIONS . 'Templates/TemplatesEmailFooter.php';
    }

    public function emailHeader()
    {
        try {
            $swap_var = array(
                "{WEB_ADDRESS}" => $this->web_address,
                "{LOGO_LINK}" => $this->logo_link,
                "{SITE_NAME}" => $this->site_name,
            );

            if (!file_exists($this->emailTemplateHeader)) {
                throw new Exception('Unable to locate contact email template.');
            }

            $header = file_get_contents($this->emailTemplateHeader);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    $header = str_replace($key, $swap_var[$key], $header);
                }
            }

            return $header;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function emailBody(string $template, array $content)
    {
        try {
            $header = $this->emailHeader();

            $fileExists = file_exists($template);

            if (!$fileExists) {
                throw new Exception("Could not find body template at {$template}.", 404);
            }

            $body = file_get_contents($template);

            foreach (array_keys($content) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    if ($content[$key] != '') {
                        $body = str_replace($key, $content[$key], $body);
                    } else {
                        $body = str_replace($key, '', $body);
                    }
                }
            }

            $footer = $this->emailFooter();

            $fullEmailBody = $header . $body . $footer;

            return $fullEmailBody;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function emailFooter()
    {
        try {
            $swap_var = array(
                "{FACEBOOK}" => $this->facebook,
                "{TWITTER}" => $this->twitter,
                "{CONTACT_EMAIL}" => $this->contact_email,
                "{LINKEDIN}" => $this->linkedin,
                "{INSTAGRAM}" => $this->instagram,
                "{YEAR}" => $this->year,
                "{COMPANY_NAME}" => $this->company_name
            );

            if (file_exists($this->emailTemplateFooter)) {
                throw new Exception('Unable to locate contact email template.');
            }

            $footer = file_get_contents($this->emailTemplateFooter);

            foreach (array_keys($swap_var) as $key) {
                if (strlen($key) > 2 && trim($key) != '') {
                    $footer = str_replace($key, $swap_var[$key], $footer);
                }
            }

            return $footer;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function sendEmail(WP_User $user, string $smtp_auth, string $smtp_host, string $smtp_secure, string $smtp_port, string $smtp_username, string $smtp_password, string $from_email, string $from_name, string $subject, $body, $altBody) : bool
    {
        try {
            $to_email = $user->user_email;
            $name =  $user->first_name . ' ' .$user->last_name;
            $to_name = $name;

            $mailer = new PHPMailer();

            $mailer->isSMTP();
            $mailer->SMTPAuth = $smtp_auth;
            $mailer->Host = $smtp_host;
            $mailer->SMTPSecure = $smtp_secure;
            $mailer->Port = $smtp_port;

            $mailer->Username = $smtp_username;
            $mailer->Password = $smtp_password;

            $mailer->setFrom($from_email, $from_name);
            $mailer->addAddress($to_email, $to_name);

            $mailer->isHTML(true);
            $mailer->Subject = $subject;

            $mailer->Body = $body;
            $mailer->AltBody = $altBody;

            $mailer->send();

            if ($mailer->ErrorInfo) {
                throw new PHPMailerException("Message could not be sent. Mailer Error: {$mailer->ErrorInfo}");
            }

            return true;
        } catch (PHPMailerException $e) {
            throw new PHPMailerException($e);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
