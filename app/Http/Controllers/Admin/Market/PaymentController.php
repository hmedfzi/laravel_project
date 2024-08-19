<?php

namespace App\Http\Controllers\Admin\Market;

use Illuminate\Http\Request;
use App\Models\Market\Payment;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function offline()
    {
        $payments = Payment::wehere('paymentable_type', 'App\Models\Market\OfflinePyament')->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function online()
    {
        $payments = Payment::wehere('paymentable_type', 'App\Models\Market\OnlinePyament')->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function cash()
    {
        $payments = Payment::wehere('paymentable_type', 'App\Models\Market\CashPyament')->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function confirm()
    {
        return view('admin.market.payment.index');
    }

    public function canceled(Payment $payment)
    {
        $payment->status = 2;
        $payment->save();
        return redirect()->route('admin.market.payment.index')->with('swal-success', 'تغییرات شما با موفقیت انجام شد.');
    }

    
    public function returned(Payment $payment)
    {
        $payment->status = 3;
        $payment->save();
        return redirect()->route('admin.market.payment.index')->with('swal-success', 'تغییرات شما با موفقیت انجام شد.');
    }

    public function show(Payment $payment)
    {
        return view('admin.market.payment.show', compact('payment'));
        }
}
