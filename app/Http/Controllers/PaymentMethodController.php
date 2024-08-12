<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use App\Models\PaymentMethod; // Access Payment Method Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class PaymentMethodController extends Controller
{
    // Edit Payment Method or Create a new one, depends on the user actions in the forms
    public function editPaymentMethod(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'payment_methods.*.is_payment_active' => 'required|boolean',
            'payment_methods.*.payment_vendor' => 'required|string',
            'payment_methods.*.payment_receiver_name' => 'required|max:255',
            'payment_methods.*.payment_address' => 'required|max:255',
        ],
        
        // Validation Error messages
        [
            'payment_methods.*.payment_vendor.required' => 'Pilih salah satu nama Bank',
            'payment_methods.*.payment_receiver_name.required' => 'Kolom ini harus diisi',
            'payment_methods.*.payment_receiver_name.max' => 'Nama Terlalu Panjang',
            'payment_methods.*.payment_address.required' => 'Kolom ini harus diisi',
            'payment_methods.*.payment_address.max' => 'Nomor Rekening Terlalu Panjang',
        ]);

        // Data Transactions to Edit and Delete the Payment Method
        DB::transaction(function () use ($request) {
            // Handle Payment Method Deletes Logic
            if ($request->has('payment_methods_to_delete')) {
                foreach ($request->payment_methods_to_delete as $paymentMethodId) {
                    PaymentMethod::findOrFail($paymentMethodId)->delete();
                }
            }

            foreach ($request->payment_methods as $paymentMethodData) {
                // If user only update the payment method data find the ID
                if (isset($paymentMethodData['id'])) {
                    $paymentMethod = PaymentMethod::findOrFail($paymentMethodData['id']);
                } 
                
                // If user added a new payment method, make a new data
                else {
                    $paymentMethod = new PaymentMethod();
                    $paymentMethod->admin_id = Auth::id(); // Get the admin_id from the currently logged in user
                }

                // Get the value for is_payment_active attribute from the request
                $paymentMethod->is_payment_active = $paymentMethodData['is_payment_active']; 
                // Get the value for payment_vendor attribute from the request
                $paymentMethod->payment_vendor = $paymentMethodData['payment_vendor']; 
                // Get the value for payment_receiver_name attribute from the request
                $paymentMethod->payment_receiver_name = $paymentMethodData['payment_receiver_name']; 
                // Get the value for payment_address attribute from the request then encrypt the data before saving it to database
                $paymentMethod->payment_address = Crypt::encryptString($paymentMethodData['payment_address']); 

                // Update or Create new data
                $paymentMethod->save();
            }
        });

        // Generate a flash message via Toastr after data transaction successful
        $request->session()->flash('success', 'Anda berhasil mengubah Metode Pembayaran!');

        // Redirect users back to profile page
        return redirect()->intended('/admin-profile');
    }
}
