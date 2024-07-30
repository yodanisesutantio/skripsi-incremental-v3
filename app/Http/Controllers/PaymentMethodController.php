<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

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
            // Handle deletions
            if ($request->has('payment_methods_to_delete')) {
                foreach ($request->payment_methods_to_delete as $paymentMethodId) {
                    PaymentMethod::findOrFail($paymentMethodId)->delete();
                }
            }

            foreach ($request->payment_methods as $paymentMethodData) {
                if (isset($paymentMethodData['id'])) {
                    $paymentMethod = PaymentMethod::findOrFail($paymentMethodData['id']);
                } else {
                    $paymentMethod = new PaymentMethod();
                    $paymentMethod->admin_id = Auth::id();
                }

                $paymentMethod->is_payment_active = $paymentMethodData['is_payment_active'];
                $paymentMethod->payment_vendor = $paymentMethodData['payment_vendor'];
                $paymentMethod->payment_receiver_name = $paymentMethodData['payment_receiver_name'];
                $paymentMethod->payment_address = Crypt::encryptString($paymentMethodData['payment_address']);
                $paymentMethod->save();
            }
        });

        $request->session()->flash('success', 'Anda berhasil mengubah Metode Pembayaran!');

        return redirect()->intended('/admin-profile');
    }
}
