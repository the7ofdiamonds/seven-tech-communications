<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Email\Gateway\EmailGateway;
use SEVEN_TECH\Communications\Email\Gateway\EmailGatewayLink;

use PHPMailer\PHPMailer\PHPMailer;

class Gateway
{
    private $mailer;
    private $emailGateway;
    private $emailGatewayLink;
    private $websiteName;
    private $deletionTime;
    private $confirmationCodeExpiration;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->emailGateway = new EmailGateway($this->mailer);
        $this->emailGatewayLink = new EmailGatewayLink($this->mailer);
        $this->websiteName = 'THE7OFDIAMONDS.TECH';
        $this->deletionTime = '90 Days';
        $this->confirmationCodeExpiration = '15 minutes';
    }

    public function signup(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send signup email.', $statusCode);
            }

            $subject = 'Signup Email';

            $message = "Thanks for joining {$this->websiteName}  {$user->name}";

            $signupEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($signupEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function verifyAccount(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send verify account email.', $statusCode);
            }

            $link = $request['link'];

            if (empty($link)) {
                $statusCode = 400;
                throw new Exception('Link is required to send verify account email.', $statusCode);
            }

            $buttonName = 'VERIFY';

            $subject = 'Account Verification';

            $message = "Click the link below to verify your account at {$this->websiteName}.";

            $verifyAccountEmailResponse = $this->emailGatewayLink->sendGatewayEmail($user, $subject, $message, $link, $buttonName);

            return rest_ensure_response($verifyAccountEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function verifiedAccount(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send verified account email.', $statusCode);
            }

            $subject = 'Account Verfified';

            $message = "Thank you {$user->name}, your account has been verified at {$this->websiteName}.";

            $verifiedAccountEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($verifiedAccountEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function lockedAccount(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send account locked email.', $statusCode);
            }

            $link = $request['link'];

            if (empty($link)) {
                $statusCode = 400;
                throw new Exception('Link is required to send account locked email.', $statusCode);
            }

            $buttonName = 'UNLOCK';

            $subject = "Your account is locked at {$this->websiteName}";

            $message = "At this time your account is locked at {$this->websiteName}. Click the link below to restore your access and permissions";

            $lockedAccountEmailResponse = $this->emailGatewayLink->sendGatewayEmail($user, $subject, $message, $link, $buttonName);

            return rest_ensure_response($lockedAccountEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function removedAccount(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send account removed email.', $statusCode);
            }

            $link = $request['link'];

            if (empty($link)) {
                $statusCode = 400;
                throw new Exception('Link is required to send account removed email.', $statusCode);
            }

            $buttonName = 'RESTORE';

            $subject = "Your account has been removed at {$this->websiteName}";

            $message = "At this time your account has been removed at {$this->websiteName}. You have {$this->deletionTime} to restore this account before it is deleted.";

            $removedAccountEmailResponse = $this->emailGatewayLink->sendGatewayEmail($user, $subject, $message, $link, $buttonName);

            return rest_ensure_response($removedAccountEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function deletedAccount(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send account deleted email.', $statusCode);
            }

            $subject = "Your account has been deleted at {$this->websiteName}";

            $message = "At this time your account has been deleted at {$this->websiteName}.";

            $deletedAccountEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($deletedAccountEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function forgotPassword(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send forgot password email.', $statusCode);
            }

            $link = $request['link'];

            if (empty($link)) {
                $statusCode = 400;
                throw new Exception('Link is required to send forgot password email.', $statusCode);
            }

            $buttonName = 'CHANGE';

            $subject = "Change Password at {$this->websiteName}";

            $message = "Below is a link to change your password. You have {$this->confirmationCodeExpiration} to use this email to change your password.";

            $forgotPasswordEmailResponse = $this->emailGatewayLink->sendGatewayEmail($user, $subject, $message, $link, $buttonName);

            return rest_ensure_response($forgotPasswordEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function updatePassword(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send update password email.', $statusCode);
            }

            $link = $request['link'];

            if (empty($link)) {
                $statusCode = 400;
                throw new Exception('Link is required to send update password email.', $statusCode);
            }

            $buttonName = 'UPDATE';

            $subject = "Update Password at {$this->websiteName}";

            $message = "Below is a link to update your password. You have {$this->confirmationCodeExpiration} to use this email to update your password.";

            $updatePasswordEmailResponse = $this->emailGatewayLink->sendGatewayEmail($user, $subject, $message, $link, $buttonName);

            return rest_ensure_response($updatePasswordEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedPassword(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send changed password email.', $statusCode);
            }

            $subject = "Password Changed at {$this->websiteName}";

            $message = "At this time your password has been changed at {$this->websiteName}.";

            $changedPasswordEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($changedPasswordEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedName(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send changed name email.', $statusCode);
            }

            $subject = "Your name has been changed at {$this->websiteName}";

            $message = "At this time your name was changed at {$this->websiteName}.";

            $changedNameEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($changedNameEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedPhone(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send changed phone email.', $statusCode);
            }

            $subject = "Your phone number was changed at {$this->websiteName}";

            $message = "At this time your phone number was changed at {$this->websiteName}.";

            $changedPhoneEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($changedPhoneEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }

    public function changedUsername(WP_REST_Request $request)
    {
        try {
            $user = $request['user'];

            if (empty($user)) {
                $statusCode = 400;
                throw new Exception('User is required to send changed username email.', $statusCode);
            }

            $subject = "Your username was changed at {$this->websiteName}";

            $message = "At this time your username was changed at {$this->websiteName}.";

            $changedUsernameEmailResponse = $this->emailGateway->sendGatewayEmail($user, $subject, $message);

            return rest_ensure_response($changedUsernameEmailResponse);
        } catch (Exception $e) {
            $message = array(
                'errorMessage' => $e->getMessage(),
                'statusCode' => $e->getCode()
            );
            $response = rest_ensure_response($message);
            $response->set_status($e->getCode());

            return $response;
        }
    }
}
