<?php

namespace App\Service;
use Exception;
use App\Mail\RegistrationMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class EmailService {

    public function sendRegistrationEmail($email, $firstname, $lastName, $token) {
        
        $link = "http://localhost:8080/auth/verification?token=$token";
        $this->send($email, new RegistrationMail($firstname, $lastName, $link));
    }

    public function sendResetPasswordEmail($email,$resetPasswordToken) {
        $link = "http://localhost:8080/auth/new-password?token=$resetPasswordToken";
        $this->send($email, new ResetPasswordMail($link));
    }

    private function send($email, $content) {
        try {
            Mail::to($email)->send($content);
        } catch (Exception $exception) {
            throw new Exception('Email servis trenutno nije dostupan');
        }
    }
}