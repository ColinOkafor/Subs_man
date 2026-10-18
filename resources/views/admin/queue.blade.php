<x-admin-layout>
    <x-slot:navActions>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-600 hover:text-orange-500 transition">← Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg font-semibold transition">
                Log Out
            </button>
        </form>
    </x-slot:navActions>

    <div class="max-w-4xl mx-auto w-full">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Queue Monitor</h1>
        <p class="text-sm text-gray-500 mb-6">Live status of the Laravel job queue (Redis driver).</p>

        {{-- Status cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Pending</p>
                <p class="text-3xl font-bold text-gray-900">—</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Failed</p>
                <p class="text-3xl font-bold text-red-500">—</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Processed</p>
                <p class="text-3xl font-bold text-green-500">—</p>
            </div>
        </div>

        {{-- Info box --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">How to monitor</h2>
            <p class="text-sm text-gray-600 mb-3">
                Run the queue worker on your server (or Render) to process jobs:
            </p>
            <pre class="text-xs bg-gray-50 rounded-lg p-4 text-gray-700 overflow-auto">php artisan queue:work redis --tries=3</pre>
            <p class="text-sm text-gray-600 mt-4 mb-3">
                To see failed jobs:
            </p>
            <pre class="text-xs bg-gray-50 rounded-lg p-4 text-gray-700 overflow-auto">php artisan queue:failed</pre>
            <p class="text-sm text-gray-500 mt-4">
                For a live dashboard, consider installing
                <a href="https://laravel.com/docs/horizon" target="_blank"
                   class="text-orange-500 hover:underline font-semibold">Laravel Horizon</a>
                — it gives you a full Redis queue UI at <code class="bg-gray-100 px-1 rounded">/horizon</code>.
            </p>
        </div>
    </div>
</x-admin-layout>