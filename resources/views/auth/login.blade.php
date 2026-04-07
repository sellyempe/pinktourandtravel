<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PinkTravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="flex h-screen">
        <!-- Left Section - Background & Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-pink-600 to-pink-900 flex-col justify-center items-center text-white p-12">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Welcome Back</h1>
                <p class="text-xl text-pink-100 mb-8">Your journey to amazing travel experiences starts here</p>
                
                <div class="space-y-6 mt-12">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Explore the world with us</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 7H7v6h6V7z"></path>
                                <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2V2a1 1 0 112 0v1a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2v1a1 1 0 11-2 0v-1h-2v1a1 1 0 11-2 0v-1H9a2 2 0 01-2-2v-2H6a1 1 0 110-2h1V9H6a1 1 0 010-2h1V5a2 2 0 012-2V2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Plan your perfect trip</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Share your adventures</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-2">Login</h2>
                    <p class="text-gray-600">Sign in to your account</p>
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

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

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
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-pink-600 hover:text-pink-700 font-medium">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or</span>
                    </div>
                </div>

                <p class="text-center mt-6 text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-700 font-semibold">Create one</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
