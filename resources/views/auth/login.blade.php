<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Particle background styles */
    .particle-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      pointer-events: none;
    }
    #particleCanvas {
      width: 100%;
      height: 100%;
      display: block;
    }
  </style>
</head>
<body class="bg-gray-100">
<div class="particle-background">
  <canvas id="particleCanvas"></canvas>
</div>

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow-2xl sm:rounded-lg sm:px-10 border border-gray-200">

      <div class="space-y-6">

        <!-- Header -->
        <div class="text-center">
          <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
          <p class="mt-2 text-sm text-gray-600">Sign in to your account</p>
        </div>

        <!-- Global Error Message -->
        @if (session('error'))
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
          @csrf

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
              <input id="email" name="email" type="email" autocomplete="email" required
                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-sm bg-gray-50"
                placeholder="Enter your email"
                value="{{ old('email') }}">
            </div>
            @error('email')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input id="password" name="password" type="password" autocomplete="current-password" required
                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-sm bg-gray-50"
                placeholder="Enter your password">
            </div>
            @error('password')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Remember me & Forgot password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember_me" name="remember" type="checkbox"
                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
              <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>

            <div class="text-sm">
              <a href="{{ route('password.request') }}" class="font-medium text-orange-600 hover:text-orange-500 transition-colors duration-200">
                Forgot your password?
              </a>
            </div>
          </div>

          <!-- Login Button -->
          <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
              LOGIN
            </button>
          </div>
        </form>

        <!-- Divider -->
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or continue with</span>
          </div>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-2 gap-3">
          <a href="{{ route('auth.google') }}" class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
            <i class="fab fa-google text-red-500 mr-2"></i>
            Google
          </a>
          <a href="{{ route('auth.github') }}" class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
            <i class="fab fa-github mr-2"></i>
            GitHub
          </a>
        </div>

        <!-- Register -->
        <div class="text-center text-sm">
          <span class="text-gray-600">Don't have an account?</span>
          <a href="{{ route('register') }}" class="font-medium text-orange-600 hover:text-orange-500 transition-colors duration-200 ml-1">
            Register now
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="/js/particles.js"></script>

</body>
</html>
