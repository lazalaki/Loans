<?php

namespace App\Service;
use Exception;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;

class EmailService {

    public function sendRegistrationEmail($email, $firstname, $lastName, $token) {
        
        $link = "http://localhost:8080/auth/verification?token=$token";
        $this->send($email, new RegistrationMail($firstname, $lastName, $link));
    }

    private function send($email, $content) {
        try {
            Mail::to($email)->send($content);
        } catch (Exception $exception) {
            
            throw new Exception('Email servis trenutno nije dostupan');
        }
    }
}