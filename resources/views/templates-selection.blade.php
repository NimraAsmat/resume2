<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Template - ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.10);
            border-radius: 26px;
            padding: 2.2rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            transition: all 0.4s ease;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            cursor: pointer;
        }
        .glass-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }
        .glass-card.selected {
            background: rgba(59, 130, 246, 0.25);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            box-shadow: 0 4px 18px rgba(59, 130, 246, 0.35);
            transition: 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0284c7, #2563eb);
            box-shadow: 0 8px 27px rgba(59, 130, 246, 0.5);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.28);
            transition: 0.3s ease;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.18);
            transform: translateY(-2px);
        }
        .gradient-text {
            background: linear-gradient(120deg, #fff, #c1e8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .template-image {
            height: 280px;
            object-fit: cover;
            width: 100%;
            border-radius: 16px;
            transition: transform 0.5s ease;
        }
        .glass-card:hover .template-image {
            transform: scale(1.05);
        }
        .icon-box {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.28);
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            font-size: 1.8rem;
            transition: 0.3s ease;
        }
        .glass-card:hover .icon-box {
            transform: scale(1.12);
        }
        .category-badge {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.28);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 min-h-screen font-sans antialiased">


    <header class="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">
                    <h1 class="text-3xl font-bold text-white">
                        <span class="gradient-text">ResumeBuilder</span> Pro
                    </h1>
                    <p class="text-white/80 text-sm">Choose Your Template</p>
                </div>
                
                @auth
                <div class="relative group">
                    <button class="flex items-center space-x-3 transition-all duration-200">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                            <span class="text-blue-600 font-semibold text-lg uppercase">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                    </button>

                 
                    <div class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible 
                        group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">

                        
                        <div class="p-4 border-b border-gray-200">
                            <p class="text-gray-900 font-semibold text-sm truncate">
                                {{ ucfirst(Auth::user()->name ?? 'User') }}
                            </p>
                            <p class="text-gray-600 text-xs truncate">
                                {{ Auth::user()->email ?? '' }}
                            </p>
                        </div>

                       
                        <div class="p-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200">
                                    <i class="fas fa-sign-out-alt text-sm mr-2"></i>
                                    <span class="font-medium text-sm">Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </header>

   
    <main class="max-w-7xl mx-auto py-12 px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-6">
                Choose Your <span class="gradient-text">Template</span>
            </h1>
            <p class="text-white/80 text-lg max-w-3xl mx-auto leading-relaxed">
                Select beautifully designed layouts that stand out in every industry. Start building your professional resume after choosing a template.
            </p>
        </div>

       
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" id="templatesContainer">
            @foreach($templates as $template)
            <div class="glass-card text-center group"
                 onclick="selectTemplate('{{ $template['id'] }}', '{{ $template['name'] }}', '{{ $template['description'] }}', this)">
                <div class="h-72 rounded-xl overflow-hidden mb-6">
                    <img src="{{ $template['image'] }}" alt="{{ $template['name'] }}" 
                         class="template-image w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjI1MCIgdmlld0JveD0iMCAwIDMwMCAyNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMjUwIiBmaWxsPSIjRjNGNEY2Ii8+Cjx0ZXh0IHg9IjUwJSIgeT0iNDUlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iOTlBQUFCIiBmb250LXNpemU9IjE2IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPlJlc3VtZSBUZW1wbGF0ZTwvdGV4dD4KPHRleHQgeD0iNTAlIiB5PSI2NSUiIGRvbWluYW50LWJhc2VsaW5lPSJjZW50cmFsIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjNjY3Nzg4IiBmb250LXNpemU9IjEyIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkltYWdlIG5vdCBhdmFpbGFibGU8L3RleHQ+Cjwvc3ZnPg=='">
                </div>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 category-badge text-white text-sm font-semibold rounded-full mb-4">
                        {{ $template['category'] }}
                    </span>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ $template['name'] }}</h3>
                    <p class="text-white/70 text-sm leading-relaxed mb-6">{{ $template['description'] }}</p>
                    <div class="flex justify-center items-center text-white/60 group-hover:text-white transition-colors">
                        <span class="text-sm font-semibold mr-2">Select Template</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

      
        <div id="selectedTemplateInfo" class="hidden glass-card mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <div class="text-center lg:text-left">
                    <h3 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        Template Selected: <span id="selectedTemplateName" class="font-extrabold gradient-text"></span>
                    </h3>
                    <p id="selectedTemplateDescription" class="text-white/80 text-lg"></p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="startWithSelectedTemplate()" 
                            class="btn-primary text-white px-8 py-4 rounded-xl font-semibold flex items-center gap-3 justify-center">
                        <i class="fas fa-rocket"></i>
                        Start Building Resume
                    </button>
                    <a href="{{ url('/') }}" 
                       class="btn-secondary text-white px-6 py-4 rounded-xl font-semibold text-center">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        let selectedTemplate = null;

        function selectTemplate(templateId, templateName, templateDescription, element) {
          
            document.querySelectorAll('.glass-card').forEach(card => {
                card.classList.remove('selected');
            });
            
           
            element.classList.add('selected');
            
            
            selectedTemplate = {
                id: templateId,
                name: templateName,
                description: templateDescription
            };
            
           
            document.getElementById('selectedTemplateName').textContent = templateName;
            document.getElementById('selectedTemplateDescription').textContent = templateDescription;
            document.getElementById('selectedTemplateInfo').classList.remove('hidden');
            
           
            document.getElementById('selectedTemplateInfo').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }

        function startWithSelectedTemplate() {
            if (!selectedTemplate) {
                alert('Please select a template first.');
                return;
            }

           
            localStorage.setItem('selectedTemplate', JSON.stringify(selectedTemplate));
            
            
            window.location.href = '{{ route("resume.index") }}';
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            const savedTemplate = localStorage.getItem('selectedTemplate');
            if (savedTemplate) {
                const template = JSON.parse(savedTemplate);
                
               
                const templateCards = document.querySelectorAll('.glass-card');
                templateCards.forEach(card => {
                    if (card.querySelector('h3').textContent === template.name) {
                        selectTemplate(template.id, template.name, template.description, card);
                    }
                });
            }
        });
    </script>
</body>
</html>