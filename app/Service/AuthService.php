<?php

namespace App\Service;
use Exception;
use App\Entities\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use App\Mail\SendMailable;
use App\Service\EmailService;
use Illuminate\Database\QueryException;

class AuthService {

    protected $emailService;

    public function __construct(EmailService $emailService) {
        $this->emailService = $emailService;
    }

    public function login($email, $password) {
        $login = array('email' => $email, 'password' => $password);
        $token = auth()->attempt($login);

        if(!$token) {
            throw new Exception("Podaci nisu validni");
        }
        $user = auth()->user();

        if(!$user->is_active) {
            throw new Exception("User $user->email nije aktivirao svoj nalog");
        }

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function createUser(RegisterRequest $request) {

        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => Str::random(20)
        ]);
        
        try {
            $user->save();
        } catch (QueryException $exception) {
            
            throw new Exception("Neki od podataka nisu validni, probajte ponovo sa novim email");
        }

        $this->emailService->sendRegistrationEmail($request->email,$request->firstName,$request->lastName,$user->token);
    }

    public function activateUser($token, $password) {
        $user = User::where('token', $token)->firstOrFail();

        // TODO
        // if chcek password

        $user->token = '';
        $user->is_active = true;
        try {
            $user->save();
        } catch(QueryException $exception) {
            throw new Exception('Nalog je vec aktiviran');
        }
    }
}

?>