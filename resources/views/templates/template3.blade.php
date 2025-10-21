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
            border-radius: 0 0 10px 10px;
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
            
            padding-left: 10px; 
            margin-bottom: 15px; 
        }
        .job-item, .edu-item { 
            background: #f0fdf4; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px; 
            border-left: 3px solid #059669;
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
        .personal-info {
            background: #ecfdf5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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

        @if(!empty($dob) || !empty($gender) || !empty($nationality))
        <div class="personal-info">
            <div class="section-title">PERSONAL INFORMATION</div>
            @if(!empty($dob))
            <p><strong>Date of Birth:</strong> {{ $dob }}</p>
            @endif
            @if(!empty($gender))
            <p><strong>Gender:</strong> {{ $gender }}</p>
            @endif
            @if(!empty($nationality))
            <p><strong>Nationality:</strong> {{ $nationality }}</p>
            @endif
        </div>
        @endif

        @if(!empty($summary))
        <div class="section">
            <div class="section-title">PROFESSIONAL SUMMARY</div>
            <p>{{ $summary }}</p>
        </div>
        @endif

        @if(!empty($job_title) && count($job_title) > 0)
        <div class="section">
            <div class="section-title">WORK EXPERIENCE</div>
            @foreach($job_title as $index => $title)
            <div class="job-item">
                <div class="job-title">{{ $title ?? 'Job Title' }}</div>
                <div class="company">{{ $company[$index] ?? '' }}</div>
                <div class="date">
                    {{ $job_start[$index] ?? '' }} 
                    @if(!empty($job_start[$index]) && !empty($job_end[$index])) - @endif 
                    {{ $job_end[$index] ?? '' }}
                </div>
                @if(!empty($job_description[$index]))
                <p>{{ $job_description[$index] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($degree) && count($degree) > 0)
        <div class="section">
            <div class="section-title">EDUCATION</div>
            @foreach($degree as $index => $deg)
            <div class="edu-item">
                <div class="edu-degree">{{ $deg ?? 'Degree' }}</div>
                <div class="school">{{ $school[$index] ?? '' }}</div>
                <div class="date">
                    {{ $edu_start[$index] ?? '' }} 
                    @if(!empty($edu_start[$index]) && !empty($edu_end[$index])) - @endif 
                    {{ $edu_end[$index] ?? '' }}
                </div>
                @if(!empty($edu_description[$index]))
                <p>{{ $edu_description[$index] }}</p>
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
                        @foreach($skills as $index => $skill)
                            <li>{{ $skill }} @if(!empty($skill_level[$index])) ({{ $skill_level[$index] }}) @endif</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if(!empty($languages) && count($languages) > 0)
                <div>
                    <div class="section-title">LANGUAGES</div>
                    <ul>
                        @foreach($languages as $index => $lang)
                            <li>{{ $lang }} @if(!empty($language_level[$index])) ({{ $language_level[$index] }}) @endif</li>
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