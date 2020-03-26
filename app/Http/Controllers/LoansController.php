<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\LoanService;
use App\Http\Requests\LoanRequest;
use Exception;

class LoansController extends Controller
{

    protected $loanService;

    public function __construct(LoanService $loanService) {
        $this->loanService = $loanService;
    }

    public function createLoan(LoanRequest $request) {
        try {
            $this->loanService->createLoan($request);
            return response()->json([], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
