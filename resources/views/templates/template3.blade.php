<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $first_name ?? '' }} {{ $last_name ?? '' }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: #fff; 
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .header { 
            background: #059669; 
            color: white; 
            padding: 30px; 
            margin: -40px -40px 30px -40px; 
            text-align: center; 
        }
        .header h1 { 
            font-size: 32px; 
            margin: 0; 
        }
        .header p { 
            margin: 5px 0; 
            opacity: 0.9; 
        }
        .section { 
            margin-bottom: 25px; 
        }
        .section-title { 
            color: #059669; 
            font-size: 18px; 
            font-weight: bold; 
            border-left: 4px solid #059669; 
            padding-left: 10px; 
            margin-bottom: 15px; 
        }
        .job-item, .edu-item { 
            background: #f0fdf4; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px; 
        }
        .job-title, .edu-degree { 
            font-weight: bold; 
            color: #065f46; 
        }
        .company, .school { 
            color: #047857; 
        }
        .date { 
            color: #064e3b; 
            font-size: 14px; 
        }
        .grid-2 { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 20px; 
        }
        ul { 
            padding-left: 20px; 
        }
        li { 
            margin-bottom: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>{{ $first_name ?? 'First Name' }} {{ $last_name ?? 'Last Name' }}</h1>
            <p>{{ $occupation ?? 'Professional' }}</p>
            <p>
                {{ $email ?? '' }} 
                @if(!empty($email) && !empty($phone)) | @endif 
                {{ $phone ?? '' }} 
                @if((!empty($email) || !empty($phone)) && !empty($country)) | @endif 
                {{ $country ?? '' }}
            </p>
        </div>

       
        @if(!empty($summary))
        <div class="section">
            <div class="section-title">PROFESSIONAL SUMMARY</div>
            <p>{{ $summary }}</p>
        </div>
        @endif

   
        @if(!empty($employment) && count($employment) > 0)
        <div class="section">
            <div class="section-title">WORK EXPERIENCE</div>
            @foreach($employment as $job)
            <div class="job-item">
                <div class="job-title">{{ $job['job_title'] ?? 'Job Title' }}</div>
                <div class="company">{{ $job['company'] ?? '' }}</div>
                <div class="date">
                    {{ $job['job_start'] ?? '' }} 
                    @if(!empty($job['job_start']) && !empty($job['job_end'])) - @endif 
                    {{ $job['job_end'] ?? '' }}
                </div>
                @if(!empty($job['job_description']))
                <p>{{ $job['job_description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

      
        @if(!empty($education) && count($education) > 0)
        <div class="section">
            <div class="section-title">EDUCATION</div>
            @foreach($education as $edu)
            <div class="edu-item">
                <div class="edu-degree">{{ $edu['degree'] ?? 'Degree' }}</div>
                <div class="school">{{ $edu['school'] ?? '' }}</div>
                <div class="date">
                    {{ $edu['edu_start'] ?? '' }} 
                    @if(!empty($edu['edu_start']) && !empty($edu['edu_end'])) - @endif 
                    {{ $edu['edu_end'] ?? '' }}
                </div>
                @if(!empty($edu['edu_description']))
                <p>{{ $edu['edu_description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

     
        @if(!empty($hobbies) || !empty($interests))
        <div class="section">
            <div class="section-title">ADDITIONAL DETAILS</div>
            @if(!empty($hobbies))
                <p><strong>Hobbies:</strong> {{ $hobbies }}</p>
            @endif
            @if(!empty($interests))
                <p><strong>Interests:</strong> {{ $interests }}</p>
            @endif
        </div>
        @endif

       
        @if((!empty($skills) && count($skills) > 0) || (!empty($languages) && count($languages) > 0))
        <div class="section">
            <div class="grid-2">
                @if(!empty($skills) && count($skills) > 0)
                <div>
                    <div class="section-title">SKILLS</div>
                    <ul>
                        @foreach($skills as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if(!empty($languages) && count($languages) > 0)
                <div>
                    <div class="section-title">LANGUAGES</div>
                    <ul>
                        @foreach($languages as $lang)
                            <li>{{ $lang }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        @endif

    
        <div style="margin-top: 40px; font-size: 12px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px;">
            Generated on: {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>
