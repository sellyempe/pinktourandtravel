<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PinkTravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="flex h-screen">
        <!-- Left Section - Background & Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-pink-600 to-pink-900 flex-col justify-center items-center text-white p-12">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Join Us Today</h1>
                <p class="text-xl text-pink-100 mb-8">Start your adventure with millions of travelers around the world</p>
                
                <div class="space-y-6 mt-12">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Create your profile</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Discover amazing places</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 12.172V16h3.828l9.586-9.586a2 2 0 000-2.828z"></path>
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Share your stories</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 overflow-y-auto">
            <div class="w-full max-w-md py-8">
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Join our travel community</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <p class="font-bold mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" 
                            placeholder="John Doe" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" 
                            placeholder="you@example.com" required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 mb-2">Password</label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" 
                            placeholder="••••••••" required>
                        <p class="text-xs text-gray-500 mt-1">At least 6 characters</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" 
                            placeholder="••••••••" required>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500 mt-1" required>
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-pink-600 hover:text-pink-700 font-medium">Terms of Service</a> and <a href="#" class="text-pink-600 hover:text-pink-700 font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105 mt-2">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Already registered?</span>
                    </div>
                </div>

                <p class="text-center mt-6 text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-semibold">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
