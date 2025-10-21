<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $first_name ?? '' }} {{ $last_name ?? '' }}</title>
    <style>
        body {
            font-family: Calibri, Arial, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px 50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .header h1 {
            font-family: "Times New Roman", serif;
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            color: #000;
        }

        .header p.profession {
            font-family: "Times New Roman", serif;
            font-size: 20px;
            margin: 5px 0 10px 0;
            color: #555;
        }

        .header .contact {
            font-size: 14px;
            color: #555;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000; 
        }

        .section {
            margin-top: 25px;
        }

        .job-item, .edu-item {
            background: #f9f9f9;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            border-left: 3px solid #000;
        }

        .job-header, .edu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .job-title, .edu-degree {
            font-weight: bold;
            font-size: 16px;
            color: #000;
            display: inline;
        }

        .company, .school {
            font-weight: bold;
            color: #333;
            margin-left: 5px;
            display: inline;
        }

        .date {
            font-size: 14px;
            color: #555;
            white-space: nowrap;
        }

        .job-item p, .edu-item p {
            margin-top: 8px;
            font-size: 15px;
            color: #333;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 40px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $first_name ?? 'First Name' }} {{ $last_name ?? 'Last Name' }}</h1>
            <p class="profession">{{ $occupation ?? 'Professional' }}</p>
            <div class="contact">
                {{ $email ?? '' }}
                @if(!empty($email) && !empty($phone)) | @endif
                {{ $phone ?? '' }}
                @if((!empty($email) || !empty($phone)) && !empty($country)) | @endif
                {{ $country ?? '' }}
                @if(!empty($nationality)) | {{ $nationality }} @endif
            </div>
        </div>

        @if(!empty($summary))
        <div class="section">
            <div class="section-title">Professional Summary</div>
            <p>{{ $summary }}</p>
        </div>
        @endif

        @if(!empty($job_title) && count($job_title) > 0)
        <div class="section">
            <div class="section-title">Work Experience</div>
            @foreach($job_title as $index => $title)
            <div class="job-item">
                <div class="job-header">
                    <div>
                        <span class="job-title">{{ $title ?? 'Job Title' }}</span>
                        @if(!empty($company[$index]))
                        <span class="company">at {{ $company[$index] }}</span>
                        @endif
                    </div>
                    <div class="date">
                        {{ $job_start[$index] ?? '' }} 
                        @if(!empty($job_start[$index]) && !empty($job_end[$index])) – @endif 
                        {{ $job_end[$index] ?? '' }}
                    </div>
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
            <div class="section-title">Education</div>
            @foreach($degree as $index => $deg)
            <div class="edu-item">
                <div class="edu-header">
                    <div>
                        <span class="edu-degree">{{ $deg ?? 'Degree' }}</span>
                        @if(!empty($school[$index]))
                        <span class="school">at {{ $school[$index] }}</span>
                        @endif
                    </div>
                    <div class="date">
                        {{ $edu_start[$index] ?? '' }} 
                        @if(!empty($edu_start[$index]) && !empty($edu_end[$index])) – @endif 
                        {{ $edu_end[$index] ?? '' }}
                    </div>
                </div>
                @if(!empty($edu_description[$index]))
                <p>{{ $edu_description[$index] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if((!empty($skills) && count($skills) > 0) || (!empty($languages) && count($languages) > 0))
        <div class="section">
            <div class="grid-2">
                @if(!empty($skills) && count($skills) > 0)
                <div>
                    <div class="section-title">Skills</div>
                    <ul>
                        @foreach($skills as $index => $skill)
                            <li>{{ $skill }} @if(!empty($skill_level[$index])) ({{ $skill_level[$index] }}) @endif</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(!empty($languages) && count($languages) > 0)
                <div>
                    <div class="section-title">Languages</div>
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

        @if(!empty($hobbies) || !empty($interests))
        <div class="section">
            <div class="section-title">Additional Details</div>
            @if(!empty($hobbies))
            <p><strong>Hobbies:</strong> {{ $hobbies }}</p>
            @endif
            @if(!empty($interests))
            <p><strong>Interests:</strong> {{ $interests }}</p>
            @endif
        </div>
        @endif

        @if(!empty($dob) || !empty($gender))
        <div class="section">
            <div class="section-title">Personal Information</div>
            @if(!empty($dob))
            <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($dob)->format('F j, Y') }}</p>
            @endif
            @if(!empty($gender))
            <p><strong>Gender:</strong> {{ $gender }}</p>
            @endif
        </div>
        @endif

        <div class="footer">
            Generated on: {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>