<?php

namespace App\Service;
use Exception;
use App\Entities\User;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;


class LoanService {


    public function createLoan(LoanRequest $request) {
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'dateOfLoan' => $request->dateOfLoan,
            'returnDate' => $request->returnDate,
            'title' => $request->title,
            'notes' => $request->notes
        ]);

        try {
            $user->save();
        } catch(QueryException $exception) {
            throw new Exception('Neki od podataka nisu validni');
        }
    }
}





?>