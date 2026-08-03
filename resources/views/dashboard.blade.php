<x-layout>
    <x-slot:navItems>
        <span class="text-sm text-gray-600 hidden sm:inline-block">
            Logged in as <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>
        </span>
        <form method="POST" action="/logout" class="m-0">
            @csrf
            <button type="submit" class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg font-semibold transition duration-200">
                Log Out
            </button>
        </form>
    </x-slot:navItems>

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
</x-layout>