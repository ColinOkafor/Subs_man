<x-layout>
    <x-slot:navActions>
        <a href="{{ route('subscriptions.index') }}"
           class="text-sm text-gray-600 hover:text-orange-500 transition">← Back</a>
    </x-slot:navActions>

    <div class="max-w-2xl mx-auto w-full">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">New Subscription</h1>

        <form method="POST" action="{{ route('subscriptions.store') }}">
            @csrf

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Basic Info</h2>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Netflix" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="cost">Amount *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                            <input id="cost" type="number" name="cost" value="{{ old('cost') }}"
                                   placeholder="0.00" step="0.01" min="0" required
                                   class="w-full pl-7 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        </div>
                        @error('cost') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="billing_cycle">Billing Cycle *</label>
                        <select id="billing_cycle" name="billing_cycle" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                            <option value="">Select…</option>
                            @foreach (['weekly', 'monthly', 'quarterly', 'yearly'] as $cycle)
                                <option value="{{ $cycle }}" {{ old('billing_cycle') === $cycle ? 'selected' : '' }}>
                                    {{ ucfirst($cycle) }}
                                </option>
                            @endforeach
                        </select>
                        @error('billing_cycle') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="status">Status *</label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        <option value="">Select…</option>
                        @foreach (['active', 'paused', 'cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Dates &amp; Category</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="start_date">Start Date</label>
                        <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="next_billing_date">Next Billing Date</label>
                        <input id="next_billing_date" type="date" name="next_billing_date" value="{{ old('next_billing_date') }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        @error('next_billing_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="category">Category</label>
                    <select id="category" name="category"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        <option value="">Select…</option>
                        @foreach (['Entertainment','Music','Software','News & Media','Fitness','Food & Drink','Gaming','Education','Other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Notes</h2>
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="short_note">
                    Short Note <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea id="short_note" name="short_note" maxlength="300" rows="3"
                          placeholder="e.g. Family plan, shared with 4 people"
                          class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm resize-y focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                >{{ old('short_note') }}</textarea>
                @error('short_note') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-8 rounded-lg text-sm transition">
                Save Subscription
            </button>
        </form>
    </div>
</x-layout>