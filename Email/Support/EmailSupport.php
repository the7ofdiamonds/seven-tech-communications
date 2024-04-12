<?php
namespace SEVEN_TECH\Communications\Email\Support;

class EmailSupport{
    public function sendSupportEmail($firstName, $lastName, $fromEmail, $subject, $message){
        $supportEmailResponse = [
            'successMessage' => "Thank You, {$firstName}. Your message has been sent, and a reply
            will be sent to {$fromEmail}"
        ];
        return $supportEmailResponse;
    }
}