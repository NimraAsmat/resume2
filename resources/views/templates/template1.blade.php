<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $first_name ?? '' }} {{ $last_name ?? '' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.3;
            color: #000;
            padding: 10px;
            margin: 0;
            background: #fff;
            font-size: 12px;
        }

        .container {
            max-width: 8.5in;
            margin: 0 auto;
            background: #fff;
            padding: 15px;
        }

        h1 {
            color: #2563eb;
            font-size: 20px;
            margin-bottom: 4px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 2px;
        }

        h3 {
            color: #2563eb;
            font-size: 14px;
            border-bottom: 1px solid #2563eb;
            padding-bottom: 2px;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .section {
            margin-bottom: 6px;
        }

        .job-item, .edu-item {
            margin-bottom: 6px;
            padding-bottom: 5px;
            page-break-inside: avoid;
        }

        p, li {
            font-size: 12px;
            margin: 2px 0;
        }

        .contact-info {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .contact-info ul {
            list-style-type: disc;
            padding-left: 16px;
            margin: 0;
        }

        .contact-info li {
            margin-bottom: 2px;
        }

        .job-header, .edu-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .job-title, .edu-degree {
            font-weight: bold;
            color: #1e40af;
            font-size: 13px;
        }

        .company, .school {
            font-style: italic;
            color: #4b5563;
            font-size: 11px;
            margin-left: 5px;
        }

        .date {
            color: #6b7280;
            font-size: 10px;
            font-style: italic;
        }

        .job-description, .edu-description {
            margin-top: 2px;
            color: #374151;
        }

        ul.skills, ul.languages {
            padding-left: 16px;
            list-style-type: disc;
            margin-top: 2px;
            columns: 2;
            column-gap: 10px;
        }

        ul.skills li, ul.languages li {
            break-inside: avoid;
            margin-bottom: 2px;
        }

        .footer {
            margin-top: 10px;
            color: #666;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .container {
                box-shadow: none;
                padding: 10px;
                max-width: 100%;
            }
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
