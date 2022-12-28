<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //



    public function generateToken(Request $request)
    {
        $user = User::where([
            ["user_id" => $request->user_id],
            ["user_secret" => $request->user_secret],
            ["id_mitra" => $request->id_mitra],

        ])->first();

        if (!$user) {
            return response()
                ->json([
                    "rCode" => "999",
                    "message" => "Mitra Not Registered"
                ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                "rCode" => "000",
                "message" => "Success",
                "data" => [
                    "token" => $token
                ]
            ], 200);
    }

    protected function compute_hash($secret, $payload)
    {
        $hexHash =  hash_hmac('sha256', json_encode($payload), $secret);
        return $hexHash;
    }


    protected function hash_is_valid($secret, $payload, $verify)
    {
        $computed_hash = $this->compute_hash($secret, $payload);
        error_log(hash_equals($verify, $computed_hash));
        return hash_equals($verify, $computed_hash);
    }

    public function generateVA(Request $request)
    {
        $user = Auth::user();

        $va = VA::where('va', $request->va)->first();

        //cek signature

        if ($va) {
            return response()
                ->json([
                    "rCode" => "004",
                    "message" => "Va number already exist"
                ], 404);
        }

        $signature = $request->header('signature');
		$body = $request->post();
		$secret = $user->secret;

        if (!$this->hash_is_valid($secret, $body, $signature)) {
            return response()->json(['rCode' => '006', 'message' => 'Invalid Signature']);
        }



        $va = new VA();
        $va->user_id = $user->id;
        $va->name = $request->name;
        $va->billing_type = $request->billing_type;
        $va->email = $request->email;
        $va->phone = $request->phone;
        $va->datetime_expired = $request->datetime_expired;
        $va->description = $request->description;
        $va->tagihan = $request->tagihan;
        $va->no_rrn = $request->no_rrn;
        $va->va = $request->va;
        $va->payment_amount = $request->va;
        $va->va_status = $request->va;
        $va->save();

        return response()->json([
            "rCode" => "000",
            "message" => "Success",
            "data" => [
                "id_mitra" => $user->id_mitra,
                "id_produk" => $user->id_product,
                "va" => $va->va
            ]
        ], 200);
    }
}
