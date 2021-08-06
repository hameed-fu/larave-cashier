<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPlans()
    {
        $key = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($key);
        $plansraw = $stripe->plans->all();
        $plans = $plansraw->data;
        foreach($plans as $plan) {
            $prod = $stripe->products->retrieve(
                $plan->product,[]
            );
            $plan->product = $prod;
        }
        return $plans;
    }

    public function index() {
        $plans = $this->getPlans();
        $user = \Auth::user();
        // dd($user->createSetupIntent());
        return view('home', [
            'user'     => $user,
            'intent'   => $user->createSetupIntent(),
            'plans'    => $plans
        ]);
    }
}
