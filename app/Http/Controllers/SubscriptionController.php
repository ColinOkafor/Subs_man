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
        return view('subscriptions.create');
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
                                Rule::in(['weekly', 'monthly', 'quarterly', 'yearly'])],
            'start_date' =>['required', 'date', 'date_format:Y-m-d'],
            'next_billing_date' => ['nullable', 'date', 'after_or_equal:today'],
            'category' => ['nullable', 'string'],
            'short_note' =>['nullable', 'string']
        ]);

        // 2. CREATE THE RECORD
        // MUST associate this subscription with the logged-in user.
        // Do not pass a user_id from the form (that is a massive security flaw).
        // Grab it from the server side: $request->user()->subscriptions()->create(...)
       $request->user()->subscriptions()->create($userData);

        // 3. REDIRECT
        // Redirect back to the 'subscriptions.index' route with a success message.
        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully.');
    
    }
    public function index(Request $request)
    {
        $query = $request->user()->subscriptions();

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('short_note', 'like', "%{$q}%");
            });
        }

        // Filter by billing cycle
        if ($request->filled('cycle_filter')) {
            $query->where('billing_cycle', $request->cycle_filter);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'next_billing_date');
        $direction = $request->get('direction', 'asc');
        $allowedSorts = ['next_billing_date', 'cost', 'name'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }

        // Tab filtering
        $tab = $request->get('tab', 'saved');
        if ($tab === 'due') {
            $query->whereNotNull('next_billing_date')
                ->whereBetween('next_billing_date', [now()->toDateString(), now()->addDays(7)->toDateString()]);
        } else {
            // 'saved' tab — due more than a week away or no date set
            $query->where(function ($q) {
                $q->whereNull('next_billing_date')
                ->orWhere('next_billing_date', '>', now()->addDays(7)->toDateString());
            });
        }

        $subscriptions = $query->paginate(10);
        // Monthly total across all user's active subscriptions (not just current page)
        $totalPerMonth = $request->user()->subscriptions()
            ->where('status', 'active')
            ->get()
            ->sum(function ($sub) {
                return match ($sub->billing_cycle) {
                    'weekly'    => $sub->cost * 52 / 12,
                    'monthly'   => $sub->cost,
                    'quarterly' => $sub->cost / 3,
                    'yearly'    => $sub->cost / 12,
                    default     => 0,
                };
            });

        return view('subscriptions.index', compact('subscriptions', 'totalPerMonth'));
    }
    public function show(Request $request, Subscription $subscription){
        // 1. SECURITY CHECK: Ensure the logged-in user actually owns THIS subscription.
        abort_if($subscription->user_id !== $request->user()->id, 403);
        // (Laravel Route Model Binding doesn't check ownership by default unless scoped).
        // 2. Return the detailed view, passing the single subscription object.
        return view('subscriptions.show', compact('subscription'));

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
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'cost'             => ['required', 'numeric', 'min:0'],
            'status'           => ['required', Rule::in(['active', 'paused', 'cancelled'])],
            'billing_cycle'    => ['required', Rule::in(['weekly', 'monthly', 'quarterly', 'yearly'])],
            'start_date'       => ['nullable', 'date', 'date_format:Y-m-d'],
            'next_billing_date'=> ['nullable', 'date', 'date_format:Y-m-d'],
            'category'         => ['nullable', 'string', 'max:255'],
            'short_note'       => ['nullable', 'string', 'max:300'],
        ]);

        // 2. UPDATE THE RECORD
        $subscription->update($validated);

        // 3. REDIRECT
        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated.');
    }

    public function destroy(Request $request, Subscription $subscription){
        // SECURITY CHECK
        abort_if($subscription->user_id !== $request->user()->id, 403, 'Unauthorized access.');

        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted.');
    }
}
