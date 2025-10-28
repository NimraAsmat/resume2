<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Verify Your Email Address</h1>
                    <p class="text-gray-600">Please check your email for verification link</p>
                </div>

                
                @if (session('resent'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

            
                <div class="text-center mb-8">
                    <p class="text-gray-700 mb-6 text-lg">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>
                    
                    <p class="text-gray-600 mb-6">
                        {{ __('If you did not receive the email') }},
                    </p>

                    
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" 
                                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl px-6 py-3 font-semibold shadow-md transition-transform duration-200 hover:-translate-y-1">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('Click here to request another') }}
                        </button>
                    </form>
                </div>

               
                <div class="text-center mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Didn't receive the email?</h3>
                    <p class="text-blue-700 text-sm">
                        Check your spam folder or make sure you entered the correct email address.
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
