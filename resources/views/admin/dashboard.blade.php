<x-admin-layout>
    <x-slot:navActions>
        <span class="text-sm text-gray-600">Admin Panel</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg font-semibold transition">
                Log Out
            </button>
        </form>
    </x-slot:navActions>

    <div class="max-w-4xl mx-auto w-full">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>

        @if (session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Total Users</p>
                <p class="text-4xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Quick Links</p>
                <div class="flex flex-col gap-2 mt-1">
                    <a href="{{ route('admin.users') }}"
                       class="text-sm text-orange-500 hover:text-orange-600 font-semibold">→ User Management</a>
                    <a href="{{ route('admin.queue') }}"
                       class="text-sm text-orange-500 hover:text-orange-600 font-semibold">→ Queue Monitor</a>
                </div>
            </div>
        </div>

        {{-- Log viewer --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Laravel Log</h2>
            <pre class="text-xs text-gray-600 bg-gray-50 rounded-lg p-4 overflow-auto max-h-96 whitespace-pre-wrap break-words">{{ $logs }}</pre>
        </div>
    </div>
</x-admin-layout>