<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
  
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="max-w-2xl w-full mx-auto">
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Welcome Back</h1>
                    <p class="text-gray-600">Sign in to ResumeBuilder Pro</p>
                </div>

                
                <a href="{{ route('google.login') }}" 
                   class="w-full bg-white border border-gray-300 rounded-xl flex items-center justify-center gap-3 px-4 py-4 font-semibold transition-all duration-200 hover:border-blue-500 hover:-translate-y-0.5 hover:shadow-md mb-6">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-gray-700">Continue with Google</span>
                </a>

                
                <div class="flex items-center mb-6">
                    <span class="flex-1 border-t border-gray-200"></span>
                    <span class="mx-3 text-gray-500 text-sm">or</span>
                    <span class="flex-1 border-t border-gray-200"></span>
                </div>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                class="w-full bg-blue-50 border border-blue-200 rounded-xl pl-10 pr-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Enter your email"
                            >
                        </div>
                        <div id="email-error" class="text-red-500 text-sm mt-2 hidden">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span id="email-error-text"></span>
                        </div>
                    </div>
                    
                   
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                required
                                class="w-full bg-blue-50 border border-blue-200 rounded-xl pl-10 pr-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Enter your password"
                            >
                        </div>
                        <div id="password-error" class="text-red-500 text-sm mt-2 hidden">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span id="password-error-text"></span>
                        </div>
                    </div>

                   
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center space-x-2 text-sm text-gray-700">
                            <input type="checkbox" name="remember"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <span>Remember me</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                            Forgot Password?
                        </a>
                    </div>

                    
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl px-4 py-3 font-semibold shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg mb-6"
                    >
                        Sign In
                    </button>
                </form>

                
                <p class="text-center text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>

   
    <footer class="py-4 mt-auto">
        <p class="text-center text-gray-500 text-sm">
            © 2024 ResumeBuilder Pro. All rights reserved.
        </p>
    </footer>

    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            
            resetErrors();
            
            
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            let isValid = true;
            
            
            if (email === '') {
                showError('email', 'Email address is required');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }
            
           
            if (password === '') {
                showError('password', 'Password is required');
                isValid = false;
            } else if (password.length < 6) {
                showError('password', 'Password must be at least 8 characters long');
                isValid = false;
            }
            
           
            if (isValid) {
                this.submit();
            }
        });
        
       
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
       
        function showError(field, message) {
            const errorElement = document.getElementById(`${field}-error`);
            const errorText = document.getElementById(`${field}-error-text`);
            
            if (errorElement && errorText) {
                errorElement.classList.remove('hidden');
                errorText.textContent = message;
                
                
                const inputField = document.getElementById(field);
                if (inputField) {
                    inputField.classList.add('border-red-300');
                    inputField.classList.remove('border-blue-200');
                }
            }
        }
        
        
        function resetErrors() {
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(element => {
                element.classList.add('hidden');
            });
            
            
            const inputFields = document.querySelectorAll('input');
            inputFields.forEach(field => {
                field.classList.remove('border-red-300');
                field.classList.add('border-blue-200');
            });
        }
        
        
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value.trim();
            if (email !== '' && !isValidEmail(email)) {
                showError('email', 'Please enter a valid email address');
            } else {
                resetFieldError('email');
            }
        });
        
        document.getElementById('password').addEventListener('blur', function() {
            const password = this.value;
            if (password !== '' && password.length < 6) {
                showError('password', 'Password must be at least 6 characters long');
            } else {
                resetFieldError('password');
            }
        });
        
       
        function resetFieldError(field) {
            const errorElement = document.getElementById(`${field}-error`);
            if (errorElement) {
                errorElement.classList.add('hidden');
                
                const inputField = document.getElementById(field);
                if (inputField) {
                    inputField.classList.remove('border-red-300');
                    inputField.classList.add('border-blue-200');
                }
            }
        }
    </script>
</body>
</html>
