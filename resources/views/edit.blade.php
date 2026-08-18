<x-layout>
    <div class="max-w-2xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Edit Subscription: {{ $subscription->name }}</h1>

        <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label>Name</label>
                <!-- Notice how value="{{ $subscription->name }}" pre-fills the box -->
                <input type="text" name="name" value="{{ old('name', $subscription->name) }}" class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label>Cost</label>
                <input type="text" name="cost" value="{{ old('cost', $subscription->cost) }}" class="border p-2 w-full">
            </div>

            <!-- Add your other inputs (billing_cycle, dates, etc) here -->

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
        </form>
    </div>
</x-layout>