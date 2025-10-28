<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | ResumeBuilder Pro</title>

    <!-- Tailwind CDN -->
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
        }
        .glass-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
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
        .btn-tertiary {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            transition: 0.3s ease;
        }
        .btn-tertiary:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        .gradient-text {
            background: linear-gradient(120deg, #fff, #c1e8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
    </style>
</head>

<body class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 min-h-screen font-sans antialiased">

    <section class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-8 py-16">

        <div class="text-center w-full max-w-4xl mx-auto mb-16">
            
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-white mb-6">
                <span class="gradient-text">ResumeBuilder</span> Pro
            </h1>

            <p class="text-white/80 text-base sm:text-lg mb-10 max-w-2xl mx-auto leading-relaxed px-2">
                Craft your professional story with stunning templates, real-time editing and seamless PDF export
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center w-full">
                <a href="{{ route('register') }}" class="btn-primary w-full sm:w-auto text-center text-white px-8 sm:px-12 py-4 rounded-xl font-semibold flex justify-center gap-3">
                    Start for Free <i class="fas fa-arrow-right mt-1"></i>
                </a>

                <a href="{{ route('login') }}" class="btn-secondary w-full sm:w-auto text-center text-white px-8 sm:px-12 py-4 rounded-xl font-semibold">
                    Sign In
                </a>
                
                <!-- Browse All Button Added Here -->
                <a href="{{ route('templates.show') }}" class="btn-tertiary w-full sm:w-auto text-center text-white px-8 sm:px-12 py-4 rounded-xl font-semibold flex justify-center gap-3">
                    Browse All Templates <i class="fas fa-eye mt-1"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-10 max-w-6xl w-full">

            <div class="glass-card text-center">
                <div class="icon-box"><i class="fa-solid fa-layer-group"></i></div>
                <h3 class="text-xl sm:text-2xl font-semibold text-white mt-6 mb-3">Choose Template</h3>
                <p class="text-white/70 text-sm sm:text-base leading-relaxed">
                    Select beautifully designed layouts that stand out in every industry
                </p>
            </div>

            <div class="glass-card text-center">
                <div class="icon-box"><i class="fa-solid fa-file-pdf"></i></div>
                <h3 class="text-xl sm:text-2xl font-semibold text-white mt-6 mb-3">Export as PDF</h3>
                <p class="text-white/70 text-sm sm:text-base leading-relaxed">
                    Download your resume instantly in high-quality PDF with one click
                </p>
            </div>

            <div class="glass-card text-center">
                <div class="icon-box"><i class="fa-solid fa-display"></i></div>
                <h3 class="text-xl sm:text-2xl font-semibold text-white mt-6 mb-3">Live Preview</h3>
                <p class="text-white/70 text-sm sm:text-base leading-relaxed">
                    Watch changes update in real time while you type your experience
                </p>
            </div>
        </div>
    </section>

</body>
</html>