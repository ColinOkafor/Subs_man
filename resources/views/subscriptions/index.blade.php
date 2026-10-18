<x-layout>
    <x-slot:navActions>
        <span class="text-sm text-gray-600 hidden sm:inline">{{ Auth::user()->name }}</span>
        <a href="{{ route('profile.show') }}"
           class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm hover:bg-orange-600 transition">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg font-semibold transition">
                Log Out
            </button>
        </form>
    </x-slot:navActions>

    <div class="max-w-2xl mx-auto w-full">

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Subscriptions</h1>
            <a href="{{ route('subscriptions.create') }}"
               class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                <span>+</span>
                <span class="hidden sm:inline">Add Subscription</span>
                <span class="sm:hidden">Add</span>
            </a>
        </div>

        {{-- Tabs --}}
        @php $tab = request('tab', 'saved'); @endphp
        <div class="flex border-b border-gray-200 mb-5">
            <a href="{{ route('subscriptions.index', array_merge(request()->query(), ['tab' => 'saved'])) }}"
               class="px-5 py-2.5 text-sm font-semibold border-b-2 transition
                      {{ $tab === 'saved' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Subs Saved
            </a>
            <a href="{{ route('subscriptions.index', array_merge(request()->query(), ['tab' => 'due'])) }}"
               class="px-5 py-2.5 text-sm font-semibold border-b-2 transition
                      {{ $tab === 'due' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Subs Due
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('subscriptions.index') }}" class="mb-5">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Search subscriptions…"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
        </form>

        {{-- List --}}
        @if ($subscriptions->isEmpty())
            <div class="text-center py-16 text-gray-400">
                @if ($tab === 'due')
                    <p class="text-base font-medium">No subscriptions due within 7 days.</p>
                    <p class="text-sm mt-1">You're all caught up!</p>
                @else
                    <p class="text-base font-medium">No subscriptions yet.</p>
                    <p class="text-sm mt-1">Tap <strong>Add Subscription</strong> to get started.</p>
                @endif
            </div>
        @else
            <ul class="space-y-2">
                @foreach ($subscriptions as $sub)
                    <li class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-200 shadow-sm hover:border-orange-300 transition">
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-900 text-sm truncate">{{ $sub->name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ ucfirst($sub->billing_cycle) }}
                                @if ($sub->category) · {{ $sub->category }} @endif
                                @if ($tab === 'due' && $sub->next_billing_date)
                                    · Due {{ $sub->next_billing_date->diffForHumans() }}
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="font-bold text-gray-900 text-sm">${{ number_format($sub->cost, 2) }}</span>
                            <a href="{{ route('subscriptions.edit', $sub) }}"
                               class="text-sm text-orange-500 hover:text-orange-600 font-semibold">Edit</a>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Pagination --}}
            @if ($subscriptions->hasPages())
                <div class="mt-6">{{ $subscriptions->appends(request()->query())->links() }}</div>
            @endif

            {{-- Total --}}
            <div class="mt-5 flex items-center justify-between bg-white rounded-xl border border-gray-200 px-5 py-4 shadow-sm">
                <span class="font-bold text-gray-900">Monthly Total</span>
                <span class="text-lg font-bold text-orange-500">${{ number_format($totalPerMonth, 2) }}</span>
            </div>
        @endif
    </div>
</x-layout>