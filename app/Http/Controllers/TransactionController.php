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

        return redirect()->route('transactions')->with(['success' => 'You have deposited successfully!']);;
    }

    public function withdrawIndex()
    {
        return view('withdraw');
    }
    public function withdraw(Request $request)
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
        $transaction->transaction_type = 'WITHDRAW';
        $transaction->date = date('Y-m-d H:i:s');

        $user = User::find($transaction->user_id);

        // dd($user->transactions);

        if ($user->account_type == 'INDIVIDUAL') {
            $fee = (($request->amount * 0.015) / 100);
            $reaining_amount = $request->amount - 1000;

            if (date('D', strtotime($transaction->date)) == 'Fri') {
                $fee = 0;
            } else if ($this->totalTransactionLastMonth($user->transactions)) {
                $fee = 0;
            } else if ($reaining_amount > 0) {
                $fee = (($reaining_amount * 0.015) / 100);
            }
        } else if ($user->account_type == 'BUSINESS') {
            $fee = (($request->amount * 0.025) / 100);
            if ($this->totalWithdrawalAmount($user->transactions) >= 50000) {
                $fee = (($reaining_amount * 0.015) / 100);
            }
        }


        $transaction->fee = $fee;
        $user->balance -= ($transaction->amount + $fee);
        // return $fee;

        if ($user->balance > $transaction->amount) {
            $user->save();
            $transaction->save();

            return redirect()->route('transactions')->with(['success' => 'You have withdrawn successfully!']);
        }

        return redirect()->route('transactions')->with(['error' => 'This user has no sufficient balance!']);
    }

    public function totalWithdrawalAmount($transactions)
    {
        // $transactions = $this->transactions();
        $totalWithdrawalAmount = 0;
        foreach ($transactions as $key => $value) {
            if ($value->transaction_type == "WITHDRAW") {
                $totalWithdrawalAmount += $value->amount;
            }
        }
        return $totalWithdrawalAmount;
    }
    public function totalTransactionLastMonth($transactions)
    {
        // $transactions = $this->transactions();

        foreach ($transactions as $key => $value) {
            $prevMonth = strtotime("-1 month");
            $prevMonth = date("Y-m-d", $prevMonth);
            if ($this->totalWithdrawalAmount($transactions) > 5000 && $value->date <= $prevMonth) {
                return true;
            }
        }
    }
}
