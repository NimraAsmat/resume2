<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .input-field {
            background: #dbeafe; 
            border: 1px solid #93c5fd; 
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        
        .input-field:focus {
            background: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="max-w-2xl w-full mx-auto">
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Reset Password</h1>
                    <p class="text-gray-600">Enter your email to receive reset instructions</p>
                </div>

              
                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

            
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                  
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full bg-blue-50 border border-blue-200 rounded-xl pl-10 pr-4 py-3 text-gray-900
                                placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                transition-all duration-200 @error('email') border-red-300 @enderror"
                                placeholder="Enter your email address">
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm mt-2 block" role="alert">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                  
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl
                            px-4 py-3 font-semibold shadow-md transition-transform duration-200 hover:-translate-y-1 mb-6">
                        Send Password Reset Link
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>

               
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        We'll send you a link to reset your password
                    </p>
                </div>
            </div>

           
            <div class="mt-6">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 border-2 border-blue-600 rounded-xl font-semibold hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>

 
<footer class="py-4 mt-auto">
    <p class="text-center text-gray-500 text-sm">
        © 2024 ResumeBuilder Pro. All rights reserved.
    </p>
</footer>
</body>
</html>
