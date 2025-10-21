<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $first_name ?? '' }} {{ $last_name ?? '' }}</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            line-height: 1.6; 
            color: #000; 
            padding: 40px;
            margin: 0;
            background: #fff; 
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff; 
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }

        h1 { 
            color: #2563eb; 
            font-size: 36px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        h3 {
            color: #2563eb; 
            font-size: 20px;
            border-bottom: 1px solid #2563eb;
            padding-bottom: 5px;
            margin-top: 20px; 
            margin-bottom: 12px; 
        }

        p, li {
            font-size: 16px;
        }

        .contact-info {
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 25px; 
        }

        .contact-info ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0;
        }

        .contact-info li {
            margin-bottom: 8px;
        }

        .section {
            margin-bottom: 15px; 
        }

        .job-item, .edu-item {
            margin-bottom: 15px; 
            padding-bottom: 12px; 
            
        }

        .job-header, .edu-header {
            display: block;
            margin-bottom: 6px; 
        }

        .job-title, .edu-degree {
            font-weight: bold;
            color: #1e40af;
            font-size: 18px;
        }

        .company, .school {
            font-style: italic;
            color: #4b5563;
            font-size: 16px;
            margin-left: 5px;
        }

        .date {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
            margin-top: 5px; 
        }

        .job-description, .edu-description {
            margin-top: 8px; 
            color: #374151;
        }

        ul.skills, ul.languages {
            padding-left: 20px;
            list-style-type: disc;
            margin-top: 8px; 
        }

        .footer {
            margin-top: 30px; 
            color: #666;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $first_name ?? 'First Name' }} {{ $last_name ?? 'Last Name' }}</h1>
        
        <div class="contact-info">
            <ul>
                <li><strong>Email:</strong> {{ $email ?? 'N/A' }}</li>
                <li><strong>Phone:</strong> {{ $phone ?? 'N/A' }}</li>
                <li><strong>Occupation:</strong> {{ $occupation ?? 'N/A' }}</li>
                @if(!empty($country))
                    <li><strong>Country:</strong> {{ $country }}</li>
                @endif
                @if(!empty($nationality))
                    <li><strong>Nationality:</strong> {{ $nationality }}</li>
                @endif
                @if(!empty($dob))
                    <li><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($dob)->format('F j, Y') }}</li>
                @endif
                @if(!empty($gender))
                    <li><strong>Gender:</strong> {{ $gender }}</li>
                @endif
            </ul>
        </div>

        @if(!empty($summary))
        <div class="section">
            <h3>Professional Summary</h3>
            <p>{{ $summary }}</p>
        </div>
        @endif

        @if(!empty($job_title) && count($job_title) > 0)
        <div class="section">
            <h3>Employment History</h3>
            @foreach($job_title as $index => $title)
            <div class="job-item">
                <div class="job-header">
                    <div>
                        <span class="job-title">{{ $title ?? 'Job Title' }}</span>
                        <span class="company">at {{ $company[$index] ?? '' }}</span>
                    </div>
                    <div class="date">
                        {{ $job_start[$index] ?? '' }} 
                        @if(!empty($job_start[$index]) && !empty($job_end[$index])) - @endif 
                        {{ $job_end[$index] ?? '' }}
                    </div>
                </div>
                @if(!empty($job_description[$index]))
                <div class="job-description">{{ $job_description[$index] }}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($degree) && count($degree) > 0)
        <div class="section">
            <h3>Education</h3>
            @foreach($degree as $index => $deg)
            <div class="edu-item">
                <div class="edu-header">
                    <div>
                        <span class="edu-degree">{{ $deg ?? 'Degree' }}</span>
                        <span class="school">at {{ $school[$index] ?? '' }}</span>
                    </div>
                    <div class="date">
                        {{ $edu_start[$index] ?? '' }} 
                        @if(!empty($edu_start[$index]) && !empty($edu_end[$index])) - @endif 
                        {{ $edu_end[$index] ?? '' }}
                    </div>
                </div>
                @if(!empty($edu_description[$index]))
                <div class="edu-description">{{ $edu_description[$index] }}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($skills) && count($skills) > 0)
        <div class="section">
            <h3>Skills</h3>
            <ul class="skills">
                @foreach($skills as $index => $skill)
                    <li>{{ $skill }} @if(!empty($skill_level[$index])) ({{ $skill_level[$index] }}) @endif</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(!empty($languages) && count($languages) > 0)
        <div class="section">
            <h3>Languages</h3>
            <ul class="languages">
                @foreach($languages as $index => $lang)
                    <li>{{ $lang }} @if(!empty($language_level[$index])) ({{ $language_level[$index] }}) @endif</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(!empty($hobbies) || !empty($interests))
        <div class="section">
            <h3>Additional Information</h3>
            @if(!empty($hobbies))
                <p><strong>Hobbies:</strong> {{ $hobbies }}</p>
            @endif
            @if(!empty($interests))
                <p><strong>Interests:</strong> {{ $interests }}</p>
            @endif
        </div>
        @endif

        <div class="footer">
            Generated on: {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>