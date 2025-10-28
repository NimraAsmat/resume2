<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password | ResumeBuilder Pro</title>
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
           
            <div class="mb-6">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 border-2 border-blue-600 rounded-xl font-semibold hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Go Back
                </a>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Confirm Password</h1>
                    <p class="text-gray-600">Please confirm your password before continuing</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                   
                    <div class="mb-6 text-center">
                        <p class="text-gray-700 text-lg">
                            {{ __('Please confirm your password before continuing.') }}
                        </p>
                    </div>

                   
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password" type="password" 
                                   class="w-full bg-blue-50 border border-blue-200 rounded-xl pl-10 pr-4 py-3 text-gray-900
                                   placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   transition-all duration-200 @error('password') border-red-300 @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm mt-2 block" role="alert">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                       
                        <button type="submit"
                                class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl
                                px-6 py-3 font-semibold shadow-md transition-transform duration-200 hover:-translate-y-1
                                flex items-center justify-center">
                            <i class="fas fa-shield-check mr-2"></i>
                            Confirm Password
                        </button>

                      
                        @if (Route::has('password.request'))
                            <a class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-200 text-center sm:text-right" 
                               href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        @endif
                    </div>
                </form>

               
                <div class="text-center mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Security Check</h3>
                    <p class="text-blue-700 text-sm">
                        This extra step ensures your account remains secure.
                    </p>
                </div>
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
