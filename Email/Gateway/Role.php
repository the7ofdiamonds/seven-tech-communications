<?php

// namespace SEVEN_TECH\Communications\Email\Gateway;

// use SEVEN_TECH\Gateway\Account\Account;
// use SEVEN_TECH\Gateway\Database\DatabaseExists;
// use SEVEN_TECH\Gateway\Exception\DestructuredException;

// class Role
// {
//     private $exists;
//     private $email;

//     public function __construct()
//     {
//         $this->exists = new DatabaseExists;
//         $this->email = new Email;
//     }

//     function roleAdded($email, $roleAdded){
//         try {
//             $this->exists->existsByEmail($email);

//             $account = new Account($email);

//             $subject = "Your role at {$this->email->site_name} has been changed";

//             $template = SEVEN_TECH_GATEWAY . 'Templates/TemplatesEmailBody.php';

//             $message = "A role of {$roleAdded} has been added to your account.";
//             $url = home_url() . "/login";
//             $button_name = 'LOGIN';

//             $content = array(
//                 "{MESSAGE}" => $message,
//                 "{URL}" => $url,
//                 "{BUTTON_NAME}" => $button_name
//             );

//             $this->email->sendEmail($account, $subject, $template, $content, $message);

//             return $message;
//         } catch (DestructuredException $e) {
//             throw new DestructuredException($e);
//         }
//     }

//     function roleRemoved($email, $roleRemoved){
//         try {
//             $this->exists->existsByEmail($email);

//             $account = new Account($email);

//             $subject = "Your role at {$this->email->site_name} has been changed";

//             $template = SEVEN_TECH_GATEWAY . 'Templates/TemplatesEmailBody.php';

//             $message = "The {$roleRemoved} role has been removed from your account.";
//             $url = home_url() . "/login";
//             $button_name = 'LOGIN';

//             $content = array(
//                 "{MESSAGE}" => $message,
//                 "{URL}" => $url,
//                 "{BUTTON_NAME}" => $button_name
//             );

//             $this->email->sendEmail($account, $subject, $template, $content, $message);

//             return $message;
//         } catch (DestructuredException $e) {
//             throw new DestructuredException($e);
//         }
//     }
// }
