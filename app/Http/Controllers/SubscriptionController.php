<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class SubscriptionController extends Controller
{
    public function create(){
        //return the view containing the HTML form
        return view('create_sub');
    }
    public function store(Request $request){
        // 1. STRICT VALIDATION
        // - name: required, string, max 255
        // - cost: required, numeric, min 0
        // - billing_cycle: required, string (use an 'in' rule for monthly/yearly)
        // - next_billing_date: required, date, after_or_equal:today
        $userData = $request->validate([
            'name' => ['required','string'],
            'cost' => ['required', 'decimal:2'],
            'status' => ['required', 'string'],
            'billing_cycle' => ['required', 
                                Rule::in(['weekly', 'monthly', 'annually'])],
            'start_date' =>['required', 'date', 'date_format:Y-m-d'],
            'next_billing_date' => ['required', 'date', 'after_or_equal:today'],
            'category' => ['required', 'string'],
            'short_note' =>['required', 'string']
        ]);

        // 2. CREATE THE RECORD
        // MUST associate this subscription with the logged-in user.
        // Do not pass a user_id from the form (that is a massive security flaw).
        // Grab it from the server side: $request->user()->subscriptions()->create(...)
       $request->user()->subscriptions()->create($userData);

        // 3. REDIRECT
        // Redirect back to the 'subscriptions.index' route with a success message.
        return redirect('subscriptions.index')->with('status', 'Subscription created successfully.');
    
    }
    public function index( Request $request){
        // 1. Fetch ONLY the subscriptions belonging to the currently authenticated user.
        $subscriptions = $request->user()->subscriptions;
        // 2. Return the view, passing those subscriptions to it.
        return view('subscriptions.index', compact('subscriptions'));
    }
    public function show(Subscription $subscription){
        // 1. SECURITY CHECK: Ensure the logged-in user actually owns THIS subscription.
        abort_if($subscription->user_id !== $request->user()->id, 403);
        // (Laravel Route Model Binding doesn't check ownership by default unless scoped).
        // 2. Return the detailed view, passing the single subscription object.
        return view('subscriptions.show', [
            'subscription' => $subscription
        ]);
    }
        public function edit(Request $request, Subscription $subscription){
        // SECURITY: Reject if the logged-in user does not own this subscription
        abort_if($subscription->user_id !== $request->user()->id, 403, 'Unauthorized access.');

        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription){
        // SECURITY CHECK
        abort_if($subscription->user_id !== $request->user()->id, 403, 'Unauthorized access.');

        // 1. VALIDATE: Use the exact same validation rules in store() method
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'cost' => ['required', 'decimal:2'],
            // ... the rest of the rules ...
        ]);

        // 2. UPDATE THE RECORD
        $subscription->update($validatedData);

        // 3. REDIRECT
        return redirect()->route('subscriptions.index')->with('status', 'Subscription updated.');
    }

    public function destroy(Request $request, Subscription $subscription){
        // SECURITY CHECK
        abort_if($subscription->user_id !== $request->user()->id, 403, 'Unauthorized access.');

        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('status', 'Subscription deleted.');
    }
}
