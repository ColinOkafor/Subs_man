<x-layout>
    <!-- Narrow container for the login form -->
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white shadow-lg rounded-xl px-8 pt-6 pb-8 mb-4 border border-gray-100">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Welcome to Subs Man</h2>
                <p class="text-gray-500 text-sm mt-1">Keeping track of your schedules</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                
               <!-- from the form error components to enable the page to display form errors -->
                <x-form-errors/>
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="name">
                        User Name
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                           id="name" type="name" name="name" placeholder="John Doe" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                        Password
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                           id="password" type="password" name="password" placeholder="••••••••" required>
                </div>
                
                 <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                        Email
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                           id="Email" type="email" name="email" placeholder="test@emaiil.com" required>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition duration-200" type="submit">
                    Sign Up
                </button>
            </form>
        </div>
        
        <p class="text-center text-gray-600 text-sm mt-4">
            Already have an account? <a href="/login" class="text-blue-600 font-semibold hover:underline">Log in</a>
        </p>
    </div>
</x-layout>