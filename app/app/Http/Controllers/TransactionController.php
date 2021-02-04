<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class TransactionController extends Controller
{
    public function create(Request $request) {
        $transactionId = $request->header("Transaction-Id");
        if (!$transactionId) {
            return response()->json(null, 400);
        }
        $payload = $request->json()->all();
        
        $rules = [
            'account_id' => 'required|string',
            'amount' => 'required|integer',
        ];
        
        $validator = Validator::make($payload, $rules);
        if ($validator->passes()) {
            $account = Account::where('id', $payload["account_id"])->first();
            if (!$account) {
                $account = Account::create(["id" => $payload["account_id"], "balance" => 0]);
            }
            if ($account) {
                DB::transaction(function () use($transactionId, $payload, $account) {
                    $transaction = Transaction::where('id', $transactionId)->first();
                    if (!$transaction) {
                        $transaction = Transaction::create(["id" => $transactionId, "account_id" => $account->id, "amount" => $payload["amount"]]);
                        $difference = $payload["amount"];
                    }
                    else {
                        $difference = $payload["amount"] - $transaction->amount;
                        $transaction->fill(["account_id" => $account->id, "amount" => $payload["amount"]]);
                        $transaction->save();
                    }
                    $account->balance += $difference;
                    $account->save();
                });
                return response()->json(null, 200);
            }
            return response()->json(null, 400);
        } else {
            $errors = $validator->errors()->all();
            return response()->json($errors, 400);
        }
    }
    
    public function view($id) {
        $t = Transaction::select("account_id", "amount")->where('id', $id)->first();
        if ($t) {
            return response()->json($t, 200);
        }
        return response()->json(null, 404);
    }
}
