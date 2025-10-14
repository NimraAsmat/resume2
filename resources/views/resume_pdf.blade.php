<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Resume PDF</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; padding: 20px; }
    h1, h3 { color: #2563eb; }
    p, li { font-size: 14px; line-height: 1.6; }
  </style>
</head>
<body>
  <h1>{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</h1>
  <p><strong>Email:</strong> {{ $data['email'] ?? '' }}</p>
  <p><strong>Phone:</strong> {{ $data['phone'] ?? '' }}</p>
  <p><strong>Occupation:</strong> {{ $data['occupation'] ?? '' }}</p>
  <p><strong>Country:</strong> {{ $data['country'] ?? '' }}</p>
  <p><strong>Nationality:</strong> {{ $data['nationality'] ?? '' }}</p>

  <h3>Professional Summary</h3>
  <p>{{ $data['summary'] ?? '' }}</p>

  <h3>Employment History</h3>
  <ul>
    @if(!empty($data['job_title']))
      @foreach($data['job_title'] as $index => $title)
        <li><strong>{{ $title }}</strong> at {{ $data['company'][$index] ?? '' }} ({{ $data['job_start'][$index] ?? '' }} - {{ $data['job_end'][$index] ?? '' }})
        <br>{{ $data['job_description'][$index] ?? '' }}</li>
      @endforeach
    @endif
  </ul>

  <h3>Education</h3>
  <ul>
    @if(!empty($data['degree']))
      @foreach($data['degree'] as $index => $degree)
        <li><strong>{{ $degree }}</strong> - {{ $data['school'][$index] ?? '' }}
        ({{ $data['edu_start'][$index] ?? '' }} - {{ $data['edu_end'][$index] ?? '' }})
        <br>{{ $data['edu_description'][$index] ?? '' }}</li>
      @endforeach
    @endif
  </ul>

  <h3>Languages</h3>
  <ul>
    @if(!empty($data['languages']))
      @foreach($data['languages'] as $lang)
        <li>{{ $lang }}</li>
      @endforeach
    @endif
  </ul>

  <h3>Skills</h3>
  <ul>
    @if(!empty($data['skills']))
      @foreach($data['skills'] as $skill)
        <li>{{ $skill }}</li>
      @endforeach
    @endif
  </ul>
</body>
</html>
