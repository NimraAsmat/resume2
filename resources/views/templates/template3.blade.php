<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $first_name ?? '' }} {{ $last_name ?? '' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1.2;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .header {
            background: #059669;
            color: white;
            padding: 15px;
            margin: -15px -15px 10px -15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0 0 3px 0;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            opacity: 0.9;
            font-size: 12px;
        }
        .section {
            margin-bottom: 12px;
        }
        .section-title {
            color: #059669;
            font-size: 14px;
            font-weight: bold;
            padding-left: 5px;
            margin-bottom: 6px;
            border-bottom: 1px solid #059669;
            padding-bottom: 2px;
        }
        .job-item, .edu-item {
            background: #f0fdf4;
            padding: 8px 10px;
            margin-bottom: 8px;
            border-radius: 3px;
            border-left: 2px solid #059669;
        }
        .job-header, .edu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }
        .job-info, .edu-info {
            flex: 1;
        }
        .job-title, .edu-degree {
            font-weight: bold;
            color: #065f46;
            font-size: 12px;
            display: inline;
        }
        .company, .school {
            color: #047857;
            font-size: 11px;
            margin-left: 4px;
            display: inline;
        }
        .date {
            color: #064e3b;
            font-size: 11px;
            white-space: nowrap;
            text-align: left;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        ul {
            padding-left: 16px;
            margin: 4px 0;
        }
        li {
            margin-bottom: 2px;
            font-size: 11px;
        }
        .personal-info {
            background: #ecfdf5;
            padding: 8px 10px;
            border-radius: 3px;
            margin-bottom: 12px;
        }
        .personal-info p {
            margin: 3px 0;
        }
        p {
            margin: 4px 0;
            font-size: 12px;
        }
        .job-description, .edu-description {
            margin-top: 6px;
            font-size: 11px;
            line-height: 1.3;
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
                <div class="job-header">
                    <div class="job-info">
                        <span class="job-title">{{ $title ?? 'Job Title' }}</span>
                        @if(!empty($company[$index]))
                        <span class="company">at {{ $company[$index] }}</span>
                        @endif
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
            <div class="section-title">EDUCATION</div>
            @foreach($degree as $index => $deg)
            <div class="edu-item">
                <div class="edu-header">
                    <div class="edu-info">
                        <span class="edu-degree">{{ $deg ?? 'Degree' }}</span>
                        @if(!empty($school[$index]))
                        <span class="school">at {{ $school[$index] }}</span>
                        @endif
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

        <div style="margin-top: 15px; font-size: 10px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 8px;">
            Generated on: {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>