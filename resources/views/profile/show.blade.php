<x-layout>
    <x-slot:navActions>
        <a href="{{ route('subscriptions.index') }}"
           class="text-sm text-gray-600 hover:text-orange-500 transition">← Dashboard</a>
    </x-slot:navActions>

    <div class="max-w-2xl mx-auto w-full">

        @if (session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xl flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- Profile Info --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Profile Information</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-8 rounded-lg text-sm transition">
                    Save Profile
                </button>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Change Password</h2>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="current_password">Current Password</label>
                    <input id="current_password" type="password" name="current_password" placeholder="••••••••"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">New Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-gray-400">Min 8 chars · uppercase · lowercase · number · symbol</p>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="password_confirmation">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                </div>
                <button type="submit"
                        class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-8 rounded-lg text-sm transition">
                    Update Password
                </button>
            </form>
        </div>

        {{-- Sign Out --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Sign Out</h2>
            <p class="text-sm text-gray-500 mb-5">Sign out of SubsMan on this device.</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-lg transition">
                    Sign Out
                </button>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="bg-white rounded-xl border border-red-200 shadow-sm p-6">
            <h2 class="text-xs font-bold uppercase tracking-widest text-red-400 mb-1">Delete Account</h2>
            <p class="text-sm text-gray-500 mb-5">Permanently removes your account and all subscriptions.</p>
            <form method="POST" action="{{ route('profile.destroy') }}"
                  onsubmit="return confirm('Delete your account? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="delete_password">
                        Confirm with your password
                    </label>
                    <input id="delete_password" type="password" name="password" required placeholder="••••••••"
                           class="w-full sm:w-64 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
                </div>
                <button type="submit"
                        class="text-sm bg-red-50 text-red-600 hover:bg-red-100 font-semibold px-5 py-2.5 rounded-lg border border-red-200 transition">
                    Delete My Account
                </button>
            </form>
        </div>
    </div>
</x-layout>