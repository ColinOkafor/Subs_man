<x-layout>
    <x-slot:navActions>
        <span class="text-sm text-gray-600 hidden sm:inline-block">
            Logged in as <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>
        </span>
        <form method="POST" action="{{route('logout')}}" class="m-0">
            @csrf
            <button type="submit" class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg font-semibold transition duration-200">
                Log Out
            </button>
        </form>
    </x-slot:navActions>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="p-8 text-center sm:text-left">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Welcome to your Dashboard
                </h1>
                <p class="text-lg text-gray-600">
                    Hello, <strong>{{ Auth::user()->name }}</strong>. You are currently viewing the private, authenticated area of the application.
                </p>
            </div>
           
        </div>
    </div>
    <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Your inputs go here. Use $subscription->name to populate existing data -->
</form>
<form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit">Delete Subscription</button>
</form>
</x-layout>