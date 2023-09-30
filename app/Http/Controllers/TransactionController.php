<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTransaction()
    {
        return view('transactions');
    }

    public function getTransactionList()
    {
        $data = Transaction::all();

        return $data;
    }

    public function depositIndex()
    {
        return view('deposit');
    }
    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [ // <---
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
            // response()->json(['errors' => $validator->messages()]);
        }

        $transaction = new Transaction();
        $transaction->user_id = $request->user_id;
        $transaction->amount = $request->amount;
        $transaction->transaction_type = 'DEPOSIT';
        $transaction->date = date('Y-m-d H:i:s');
        $transaction->save();

        $user = User::find($transaction->user_id);
        $user->balance += $transaction->amount;
        $user->save();

        return redirect()->route('transactions');
    }

    public function withdraw()
    {
    }
}
