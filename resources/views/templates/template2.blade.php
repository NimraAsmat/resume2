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
        }

        .header h1 {
            font-family: "Times New Roman", serif;
            font-size: 36px;
            margin: 0;
            font-weight: bold;
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
        }

        .job-title, .edu-degree {
            font-weight: bold;
            font-size: 16px;
            color: #000;
        }

        .company, .school {
            font-style: normal;
            font-weight: bold;
            color: #000;
            margin-left: 5px;
        }

        .date {
            font-size: 14px;
            font-style: italic;
            color: #555;
            margin-top: 5px;
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
            </div>
        </div>

       
        @if(!empty($summary))
        <div class="section">
            <div class="section-title">Professional Summary</div>
            <p>{{ $summary }}</p>
        </div>
        @endif

       
        @if(!empty($employment) && count($employment) > 0)
        <div class="section">
            <div class="section-title">Work Experience</div>
            @foreach($employment as $job)
            <div class="job-item">
                <div class="job-title">{{ $job['job_title'] ?? 'Job Title' }}</div>
                @if(!empty($job['company']))
                <div class="company">at {{ $job['company'] }}</div>
                @endif
                <div class="date">
                    {{ $job['job_start'] ?? '' }} @if(!empty($job['job_start']) && !empty($job['job_end'])) – @endif {{ $job['job_end'] ?? '' }}
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
            <div class="section-title">Education</div>
            @foreach($education as $edu)
            <div class="edu-item">
                <div class="edu-degree">{{ $edu['degree'] ?? 'Degree' }}</div>
                @if(!empty($edu['school']))
                <div class="school">at {{ $edu['school'] }}</div>
                @endif
                <div class="date">
                    {{ $edu['edu_start'] ?? '' }} @if(!empty($edu['edu_start']) && !empty($edu['edu_end'])) – @endif {{ $edu['edu_end'] ?? '' }}
                </div>
                @if(!empty($edu['edu_description']))
                <p>{{ $edu['edu_description'] }}</p>
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
                        @foreach($skills as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(!empty($languages) && count($languages) > 0)
                <div>
                    <div class="section-title">Languages</div>
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

       
        <div class="footer">
            Generated on: {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>
