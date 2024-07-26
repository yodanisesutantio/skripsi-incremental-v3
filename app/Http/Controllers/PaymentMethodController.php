<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    public function editPaymentMethod(Request $request) {
        $this->validate($request, [
            'payment_methods.*.is_payment_active' => 'required|boolean',
            'payment_methods.*.payment_vendor' => 'required|string',
            'payment_methods.*.payment_receiver_name' => 'required|max:255',
            'payment_methods.*.payment_address' => 'required|max:255',
        ],[
            'payment_methods.*.payment_vendor.required' => 'Pilih salah satu nama Bank',
            'payment_methods.*.payment_receiver_name.required' => 'Kolom ini harus diisi',
            'payment_methods.*.payment_receiver_name.max' => 'Nama Terlalu Panjang',
            'payment_methods.*.payment_address.required' => 'Kolom ini harus diisi',
            'payment_methods.*.payment_address.max' => 'Nomor Rekening Terlalu Panjang',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->payment_methods as $paymentMethodData) {
                $paymentMethod = PaymentMethod::findOrFail($paymentMethodData['id']);
                $paymentMethod->update([
                    'admin_id' => Auth::id(),
                    'is_payment_active' => $paymentMethodData['is_payment_active'],
                    'payment_vendor' => $paymentMethodData['payment_vendor'],
                    'payment_receiver_name' => $paymentMethodData['payment_receiver_name'],
                    'payment_address' => $paymentMethodData['payment_address'],
                ]);
            }
        });

        return redirect()->intended('/admin-profile');
    }
}
