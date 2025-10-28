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
        line-height: 1.3;
        margin: 0;
        padding: 0;
        font-size: 13px;
    }

    .container {
        max-width: 800px;
        margin: 10px auto;
        background: #fff;
        padding: 20px 25px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border-radius: 4px;
    }

    .header {
        text-align: center; 
        margin-bottom: 12px;
       
        padding-bottom: 6px;
    }

    .header h1 {
        font-family: "Times New Roman", serif;
        font-size: 26px;
        margin: 0;
        font-weight: bold;
        color: #000;
    }

    .header p.profession {
        font-family: "Times New Roman", serif;
        font-size: 16px;
        margin: 2px 0 4px 0;
        color: #555;
    }

    .header .contact {
        font-size: 12px;
        color: #555;
        line-height: 1.2;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        color: #000;
        margin-bottom: 4px;
        padding-bottom: 2px;
        border-bottom: 2px solid #000;
    }

    .section {
        margin-top: 10px;
    }

    .job-item, .edu-item {
        background: #f9f9f9;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 3px;
        border-left: 2px solid #000;
    }

    .job-header, .edu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3px;
    }

    .job-title, .edu-degree {
        font-weight: bold;
        font-size: 14px;
        color: #000;
        display: inline;
    }

    .company, .school {
        font-weight: bold;
        color: #333;
        margin-left: 3px;
        display: inline;
    }

    .date {
        font-size: 12px;
        color: #555;
        white-space: nowrap;
    }

    .job-item p, .edu-item p {
        margin-top: 3px;
        font-size: 13px;
        color: #333;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    ul {
        padding-left: 16px;
        margin: 0;
    }

    li {
        margin-bottom: 2px;
        font-size: 13px;
    }

    .footer {
        text-align: center;
        font-size: 10px;
        color: #666;
        margin-top: 15px;
        border-top: 1px solid #e5e7eb;
        padding-top: 6px;
    }

    p {
        margin: 2px 0;
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
