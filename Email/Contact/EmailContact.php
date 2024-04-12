<?php
namespace SEVEN_TECH\Communications\Email\Contact;

class EmailContact{

    public function sendContactEmail($firstName, $lastName, $fromEmail, $subject, $message){
        $contactEmailResponse = [
            'successMessage' => "Thank You, {$firstName}. Your message has been sent, and a reply
            will be sent to {$fromEmail}"
        ];
        return $contactEmailResponse;
    }
}