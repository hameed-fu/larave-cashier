<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function submitOrder(Request $request){
        // dd($request->all());
       $user = \Auth::user();
       $payment = $request->payment;
    //    $user->createOrGetStripeCustomer();
    //    $user->addPaymentMethod($paymentMethod);
            $user->createAsStripeCustomer([
                'name' => $user['name'],
                'email'  => $user['email'],
                // 'payment_method' => $request->payment
            ]);
        try {
            $user->newSubscription($request->plan,$user['email'])->create($payment);
            
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
       return redirect('/home');
   }

   function test(){
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 5 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);
   }    
   
}
