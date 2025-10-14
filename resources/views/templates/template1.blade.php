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
        }

        p, li {
            font-size: 16px;
        }

        em { font-style: italic; } 

        .contact-info {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .contact-info ul {
            list-style-type: disc; 
            padding-left: 20px;
            margin: 0;
        }

        .contact-info li {
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 15px; 
        }

        .job-item, .edu-item p {
            margin: 5px 0; 
        }

        strong {
            color: #000; 
        }

        .edu-item strong {
            color: #000; 
            font-weight: bold;
        }

        ul.skills, ul.languages {
            padding-left: 20px;
            list-style-type: disc;
        }

        ul {
            margin: 5px 0; 
            padding-left: 20px; 
        }

        .footer {
            margin-top: 40px;
            color: #666;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        
        h1, h3, p, li {
            margin: 0;
            padding: 0;
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
                <li><strong>Country:</strong> {{ $country ?? 'N/A' }}</li>
                @if(!empty($nationality))
                    <li><strong>Nationality:</strong> {{ $nationality }}</li>
                @endif
            </ul>
        </div>

        @if(!empty($summary))
        <div class="section">
            <h3>Professional Summary</h3>
            <p>{{ $summary }}</p>
        </div>
        @endif

        @if(!empty($employment) && count($employment) > 0)
        <div class="section">
            <h3>Employment History</h3>
            @foreach($employment as $job)
            <div class="job-item">
                <strong>{{ $job['job_title'] ?? 'Job Title' }}
                @if(!empty($job['company']))
                    at {{ $job['company'] }}
                @endif
                </strong>
                <br>
                @if(!empty($job['job_start']) || !empty($job['job_end']))
                    <em>
                        {{ $job['job_start'] ?? 'Start' }}
                        @if(!empty($job['job_start']) && !empty($job['job_end'])) - @endif
                        {{ $job['job_end'] ?? 'End' }}
                    </em>
                    <br>
                @endif
                @if(!empty($job['job_description']))
                    {{ $job['job_description'] }}
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($education) && count($education) > 0)
        <div class="section">
            <h3>Education</h3>
            @foreach($education as $edu)
            <div class="edu-item">
                <strong>
                    {{ $edu['degree'] ?? 'Degree' }}
                    @if(!empty($edu['school']))
                        at {{ $edu['school'] }}
                    @endif
                </strong>
                <br>
                @if(!empty($edu['edu_start']) || !empty($edu['edu_end']))
                    <em>
                        {{ $edu['edu_start'] ?? 'Start' }}
                        @if(!empty($edu['edu_start']) && !empty($edu['edu_end'])) - @endif
                        {{ $edu['edu_end'] ?? 'End' }}
                    </em>
                    <br>
                @endif
                @if(!empty($edu['edu_description']))
                    {{ $edu['edu_description'] }}
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($skills) && count($skills) > 0)
        <div class="section">
            <h3>Skills</h3>
            <ul class="skills">
                @foreach($skills as $skill)
                    <li>{{ $skill }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(!empty($languages) && count($languages) > 0)
        <div class="section">
            <h3>Languages</h3>
            <ul class="languages">
                @foreach($languages as $lang)
                    <li>{{ $lang }}</li>
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
