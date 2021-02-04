<?php

namespace App\Http\Controllers;

use App\Models\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function view($id) {
        $a = Account::select("balance")->where('id', $id)->first();
        if ($a) {
            return response()->json($a, 200);
        }
        return response()->json(null, 404);
    }
    
    public function getMaxTransactions() {
        $query = DB::table('transactions')->selectRaw('count(id) as count, account_id')
                        ->groupBy('account_id')
                        ->havingRaw('count(id) = (select max(x) from (SELECT count(id) as x, account_id FROM transactions group by account_id))')
                        ->get();
        $accounts = [];
        for ($i=0; $i < count($query); $i++) {
            if ($i==0) {
                $maxTransctions = $query[$i]->count;
            }
            $accounts[] = $query[$i]->account_id;
        }
        $response = ["maxVolume" => intval($maxTransctions), "accounts" => $accounts];
        return response()->json($response, 200);
    }
}
