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
        <h1 class="text-2xl font-bold text-gray-900 mb-6">User Management</h1>

        @if (session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            {{-- Table: desktop --}}
            <table class="w-full text-sm hidden sm:table">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-widest text-gray-400">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-widest text-gray-400">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-widest text-gray-400">Joined</th>
                        <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $user->name }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-right">
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Cards: mobile --}}
            <ul class="divide-y divide-gray-100 sm:hidden">
                @foreach ($users as $user)
                    <li class="p-4">
                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Joined {{ $user->created_at->format('M d, Y') }}</div>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="mt-3"
                              onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-red-500 hover:text-red-700 font-semibold">
                                Delete
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="mt-5">{{ $users->links() }}</div>
        @endif
    </div>
</x-admin-layout>