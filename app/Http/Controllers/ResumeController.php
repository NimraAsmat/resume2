<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Resume;
use App\Models\Education;
use App\Models\EmploymentHistory;
use App\Models\Skill;
use App\Models\Language;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resume');
    }

    public function showTemplates()
    {
        $templates = [
            [
                'id' => 'template1',
                'name' => 'Professional Blue',
                'category' => 'Professional',
                'image' => '/images/templates/professional-blue.jpg',
                'description' => 'Clean and professional design with blue accents, perfect for corporate environments.',
                'view_name' => 'template1'
            ],
            [
                'id' => 'template2', 
                'name' => 'Modern Black',
                'category' => 'Modern',
                'image' => '/images/templates/modern-black.jpg',
                'description' => 'Contemporary design with dark accents and clean lines for modern industries.',
                'view_name' => 'template2'
            ],
            [
                'id' => 'template3',
                'name' => 'Creative Green', 
                'category' => 'Creative',
                'image' => '/images/templates/creative-green.jpg',
                'description' => 'Fresh and creative design with green theme for design and marketing fields.',
                'view_name' => 'template3'
            ]
        ];

        return view('templates-selection', compact('templates'));
    }

    public function preview(Request $request)
    {
        try {
            $data = $this->preparePreviewData($request->all());
            $template = $request->input('template', 'template1');
            
            if (!view()->exists("templates.{$template}")) {
                return response()->json(['error' => 'Template not found'], 404);
            }
            
            return view("templates.{$template}", $data);
        } catch (\Exception $e) {
            Log::error('PREVIEW GENERATION FAILED: ' . $e->getMessage());
            return response()->json(['error' => 'Preview generation failed: ' . $e->getMessage()], 500);
        }
    }

    private function preparePreviewData($formData)
    {
        Log::info('Form Data Received for Preview:', $formData);

        $dob = null;
        if (!empty($formData['dob'])) {
            try {
                $dob = Carbon::createFromFormat('Y-m-d', $formData['dob'])->format('F j, Y');
            } catch (\Exception $e) {
                $dob = $formData['dob'];
            }
        }

        
        $employmentData = [];
        if (isset($formData['job_title']) && is_array($formData['job_title'])) {
            foreach ($formData['job_title'] as $index => $title) {
                if (!empty(trim($title))) {
                    $startDate = '';
                    $endDate = '';
                    
                    if (!empty($formData['job_start'][$index])) {
                        $startDate = $this->parseDateForDisplay($formData['job_start'][$index]);
                    }
                    
                    if (!empty($formData['job_end'][$index])) {
                        $endDate = $this->parseDateForDisplay($formData['job_end'][$index]);
                    }
                    
                    $employmentData[] = [
                        'job_title' => $title,
                        'company' => $formData['company'][$index] ?? '',
                        'job_start' => $startDate,
                        'job_end' => $endDate,
                        'job_description' => $formData['job_description'][$index] ?? ''
                    ];
                }
            }
        }

        
        $educationData = [];
        if (isset($formData['degree']) && is_array($formData['degree'])) {
            foreach ($formData['degree'] as $index => $degree) {
                if (!empty(trim($degree))) {
                    $startDate = '';
                    $endDate = '';
                    
                    if (!empty($formData['edu_start'][$index])) {
                        $startDate = $this->parseDateForDisplay($formData['edu_start'][$index]);
                    }
                    
                    if (!empty($formData['edu_end'][$index])) {
                        $endDate = $this->parseDateForDisplay($formData['edu_end'][$index]);
                    }
                    
                    $educationData[] = [
                        'degree' => $degree,
                        'school' => $formData['school'][$index] ?? '',
                        'edu_start' => $startDate,
                        'edu_end' => $endDate,
                        'edu_description' => $formData['edu_description'][$index] ?? ''
                    ];
                }
            }
        }

    
        $skillsData = [];
        if (isset($formData['skills']) && is_array($formData['skills'])) {
            foreach ($formData['skills'] as $index => $skill) {
                if (!empty(trim($skill))) {
                    $skillsData[] = [
                        'skill' => $skill,
                        'skill_level' => $formData['skill_level'][$index] ?? 'Intermediate'
                    ];
                }
            }
        }

        
        $languagesData = [];
        if (isset($formData['languages']) && is_array($formData['languages'])) {
            foreach ($formData['languages'] as $index => $language) {
                if (!empty(trim($language))) {
                    $languagesData[] = [
                        'language' => $language,
                        'language_level' => $formData['language_level'][$index] ?? 'Intermediate'
                    ];
                }
            }
        }

        return [
            'first_name' => $formData['first_name'] ?? '',
            'last_name' => $formData['last_name'] ?? '',
            'email' => $formData['email'] ?? '',
            'phone' => $formData['phone'] ?? '',
            'occupation' => $formData['occupation'] ?? '',
            'country' => $formData['country'] ?? '',
            'dob' => $dob,
            'nationality' => $formData['nationality'] ?? '',
            'gender' => $formData['gender'] ?? '',
            'hobbies' => $formData['hobbies'] ?? '',
            'interests' => $formData['interests'] ?? '',
            'summary' => $formData['summary'] ?? '',
            
            
            'job_title' => $formData['job_title'] ?? [],
            'company' => $formData['company'] ?? [],
            'job_start' => $formData['job_start'] ?? [],
            'job_end' => $formData['job_end'] ?? [],
            'job_description' => $formData['job_description'] ?? [],
            
            'degree' => $formData['degree'] ?? [],
            'school' => $formData['school'] ?? [],
            'edu_start' => $formData['edu_start'] ?? [],
            'edu_end' => $formData['edu_end'] ?? [],
            'edu_description' => $formData['edu_description'] ?? [],
            
            'skills' => $formData['skills'] ?? [],
            'skill_level' => $formData['skill_level'] ?? [],
            'languages' => $formData['languages'] ?? [],
            'language_level' => $formData['language_level'] ?? [],
            
          
            'employment_data' => $employmentData,
            'education_data' => $educationData,
            'skills_data' => $skillsData,
            'languages_data' => $languagesData,
        ];
    }

    private function parseDateForDisplay($dateString)
    {
        if (empty($dateString)) {
            return '';
        }

        
        if (preg_match('/[a-zA-Z]/', $dateString)) {
            return $dateString;
        }

        $formats = ['Y-m', 'Y-m-d', 'm/Y', 'd/m/Y', 'm-Y'];
        
        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateString);
                if ($format === 'Y-m') {
                    return $date->format('M Y');
                }
                return $date->format('M Y');
            } catch (\Exception $e) {
                continue;
            }
        }

       
        return $dateString;
    }

    public function save(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string',
                'template' => 'required|string'
            ]);

            $allData = $request->all();
            
            $user = auth()->user();
            
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $template = Template::where('view_name', $request->template)->first();
            if (!$template) {
                throw new \Exception('Template not found');
            }

            $resume = Resume::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'template_id' => $template->id
                ],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'occupation' => $request->occupation,
                    'country' => $request->country,
                    'nationality' => $request->nationality,
                    'dob' => $request->dob ? Carbon::createFromFormat('Y-m-d', $request->dob) : null,
                    'gender' => $request->gender,
                    'summary' => $request->summary,
                    'hobbies' => $request->hobbies,
                    'interests' => $request->interests,
                ]
            );

            
            if (isset($allData['job_title'])) {
                $resume->employmentHistories()->delete();
                foreach ($allData['job_title'] as $index => $title) {
                    if (!empty(trim($title))) {
                        EmploymentHistory::create([
                            'resume_id' => $resume->id,
                            'job_title' => $title,
                            'company' => $allData['company'][$index] ?? null,
                            'start_date' => $this->normalizeDate($allData['job_start'][$index] ?? null),
                            'end_date' => $this->normalizeDate($allData['job_end'][$index] ?? null),
                            'description' => $allData['job_description'][$index] ?? null,
                        ]);
                    }
                }
            }

            
            if (isset($allData['degree'])) {
                $resume->educations()->delete();
                foreach ($allData['degree'] as $index => $degree) {
                    if (!empty(trim($degree))) {
                        Education::create([
                            'resume_id' => $resume->id,
                            'degree' => $degree,
                            'institution' => $allData['school'][$index] ?? null,
                            'start_date' => $this->normalizeDate($allData['edu_start'][$index] ?? null),
                            'end_date' => $this->normalizeDate($allData['edu_end'][$index] ?? null),
                            'description' => $allData['edu_description'][$index] ?? null,
                        ]);
                    }
                }
            }

           
            if (isset($allData['skills'])) {
                $resume->skills()->delete();
                foreach ($allData['skills'] as $index => $skill) {
                    if (!empty(trim($skill))) {
                        Skill::create([
                            'resume_id' => $resume->id,
                            'skill' => $skill,
                            'level' => $allData['skill_level'][$index] ?? 'Intermediate',
                        ]);
                    }
                }
            }

          
            if (isset($allData['languages'])) {
                $resume->languages()->delete();
                foreach ($allData['languages'] as $index => $language) {
                    if (!empty(trim($language))) {
                        $proficiency = $allData['language_level'][$index] ?? 'Intermediate';
                        Language::create([
                            'resume_id' => $resume->id,
                            'language' => $language,
                            'proficiency' => $proficiency,
                        ]);
                    }
                }
            }

            DB::commit();

            session(['resume_draft' => $allData]);
            
            Log::info('Resume saved to database successfully', ['resume_id' => $resume->id, 'user_id' => $user->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully to database',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'resume_id' => $resume->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DATABASE SAVE FAILED: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save to database: ' . $e->getMessage()
            ], 500);
        }
    }

 
    private function normalizeDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

       
        if (preg_match('/^\d{4}-\d{2}$/', $dateString)) {
            return $dateString;
        }

        
        $formats = ['Y-m', 'Y-m-d', 'm/Y', 'd/m/Y', 'm-Y'];
        
        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateString);
                return $date->format('Y-m'); 
            } catch (\Exception $e) {
                continue;
            }
        }

     
        return $dateString;
    }

    public function download(Request $request)
    {
        Log::info('=== RESUME DOWNLOAD REQUEST STARTED ===');
        Log::info('Form Data Received for Download:', $request->all());

        try {
            if (!auth()->check()) {
                Log::error('User not authenticated for download');
                return redirect('/login');
            }

            $requiredFields = ['first_name', 'last_name', 'email', 'template'];
            foreach ($requiredFields as $field) {
                if (empty($request->$field)) {
                    Log::error("Required field missing: {$field}");
                    return back()->with('error', "Please fill in {$field}");
                }
            }

            
            $saveResponse = $this->saveToDatabase($request);
            if (!$saveResponse['success']) {
                throw new \Exception('Failed to save resume data: ' . $saveResponse['message']);
            }

            Log::info('Resume saved to database, now generating PDF');

            $data = $this->prepareDownloadData($request->all());
            $selectedTemplate = $request->template;
            
            Log::info("Generating PDF with template: {$selectedTemplate}");
            
            if (!view()->exists("templates.{$selectedTemplate}")) {
                Log::error("Template view not found: templates.{$selectedTemplate}");
                return back()->with('error', "Selected template not found");
            }

            $pdf = Pdf::loadView("templates.{$selectedTemplate}", $data);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('enable_html5_parser', true);
            $pdf->setOption('enable_remote', true);
            
            $filename = "resume-{$data['first_name']}-{$data['last_name']}-" . time() . ".pdf";
            
            Log::info("PDF generated successfully, downloading: {$filename}");
            
            session()->forget('resume_draft');
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('PDF GENERATION FAILED: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function saveToDatabase($request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $template = Template::where('view_name', $request->template)->first();
            if (!$template) {
                throw new \Exception('Template not found');
            }

            $resume = Resume::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'template_id' => $template->id
                ],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'occupation' => $request->occupation,
                    'country' => $request->country,
                    'nationality' => $request->nationality,
                    'dob' => $request->dob ? Carbon::createFromFormat('Y-m-d', $request->dob) : null,
                    'gender' => $request->gender,
                    'summary' => $request->summary,
                    'hobbies' => $request->hobbies,
                    'interests' => $request->interests,
                ]
            );

            $this->saveRelatedData($resume, $request->all());

            DB::commit();

            return ['success' => true, 'resume_id' => $resume->id];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DATABASE SAVE IN DOWNLOAD FAILED: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function saveRelatedData($resume, $allData)
    {
        
        if (isset($allData['job_title'])) {
            $resume->employmentHistories()->delete();
            foreach ($allData['job_title'] as $index => $title) {
                if (!empty(trim($title))) {
                    EmploymentHistory::create([
                        'resume_id' => $resume->id,
                        'job_title' => $title,
                        'company' => $allData['company'][$index] ?? null,
                        'start_date' => $this->normalizeDate($allData['job_start'][$index] ?? null),
                        'end_date' => $this->normalizeDate($allData['job_end'][$index] ?? null),
                        'description' => $allData['job_description'][$index] ?? null,
                    ]);
                }
            }
        }

        
        if (isset($allData['degree'])) {
            $resume->educations()->delete();
            foreach ($allData['degree'] as $index => $degree) {
                if (!empty(trim($degree))) {
                    Education::create([
                        'resume_id' => $resume->id,
                        'degree' => $degree,
                        'institution' => $allData['school'][$index] ?? null,
                        'start_date' => $this->normalizeDate($allData['edu_start'][$index] ?? null),
                        'end_date' => $this->normalizeDate($allData['edu_end'][$index] ?? null),
                        'description' => $allData['edu_description'][$index] ?? null,
                    ]);
                }
            }
        }

      
        if (isset($allData['skills'])) {
            $resume->skills()->delete();
            foreach ($allData['skills'] as $index => $skill) {
                if (!empty(trim($skill))) {
                    $level = $allData['skill_level'][$index] ?? 'Intermediate';
                    Skill::create([
                        'resume_id' => $resume->id,
                        'skill' => $skill,
                        'level' => $level,
                    ]);
                }
            }
        }

       
        if (isset($allData['languages'])) {
            $resume->languages()->delete();
            foreach ($allData['languages'] as $index => $language) {
                if (!empty(trim($language))) {
                    $proficiency = $allData['language_level'][$index] ?? 'Intermediate';
                    Language::create([
                        'resume_id' => $resume->id,
                        'language' => $language,
                        'proficiency' => $proficiency,
                    ]);
                }
            }
        }
    }

    private function prepareDownloadData($formData)
    {
        Log::info('Preparing download data from form data');

        $dob = null;
        if (!empty($formData['dob'])) {
            try {
                $dob = Carbon::createFromFormat('Y-m-d', $formData['dob'])->format('F j, Y');
            } catch (\Exception $e) {
                $dob = $formData['dob'];
            }
        }

        
        $employmentData = [];
        if (isset($formData['job_title']) && is_array($formData['job_title'])) {
            foreach ($formData['job_title'] as $index => $title) {
                if (!empty(trim($title))) {
                    $startDate = '';
                    $endDate = '';
                    
                    if (!empty($formData['job_start'][$index])) {
                        $startDate = $this->parseDateForDisplay($formData['job_start'][$index]);
                    }
                    
                    if (!empty($formData['job_end'][$index])) {
                        $endDate = $this->parseDateForDisplay($formData['job_end'][$index]);
                    }
                    
                    $employmentData[] = [
                        'job_title' => $title,
                        'company' => $formData['company'][$index] ?? '',
                        'job_start' => $startDate,
                        'job_end' => $endDate,
                        'job_description' => $formData['job_description'][$index] ?? ''
                    ];
                }
            }
        }

        
        $educationData = [];
        if (isset($formData['degree']) && is_array($formData['degree'])) {
            foreach ($formData['degree'] as $index => $degree) {
                if (!empty(trim($degree))) {
                    $startDate = '';
                    $endDate = '';
                    
                    if (!empty($formData['edu_start'][$index])) {
                        $startDate = $this->parseDateForDisplay($formData['edu_start'][$index]);
                    }
                    
                    if (!empty($formData['edu_end'][$index])) {
                        $endDate = $this->parseDateForDisplay($formData['edu_end'][$index]);
                    }
                    
                    $educationData[] = [
                        'degree' => $degree,
                        'school' => $formData['school'][$index] ?? '',
                        'edu_start' => $startDate,
                        'edu_end' => $endDate,
                        'edu_description' => $formData['edu_description'][$index] ?? ''
                    ];
                }
            }
        }

       
        $skillsData = [];
        if (isset($formData['skills']) && is_array($formData['skills'])) {
            foreach ($formData['skills'] as $index => $skill) {
                if (!empty(trim($skill))) {
                    $skillsData[] = [
                        'skill' => $skill,
                        'skill_level' => $formData['skill_level'][$index] ?? ''
                    ];
                }
            }
        }

       
        $languagesData = [];
        if (isset($formData['languages']) && is_array($formData['languages'])) {
            foreach ($formData['languages'] as $index => $language) {
                if (!empty(trim($language))) {
                    $languagesData[] = [
                        'language' => $language,
                        'language_level' => $formData['language_level'][$index] ?? ''
                    ];
                }
            }
        }

        return [
            'first_name' => $formData['first_name'] ?? '',
            'last_name' => $formData['last_name'] ?? '',
            'email' => $formData['email'] ?? '',
            'phone' => $formData['phone'] ?? '',
            'occupation' => $formData['occupation'] ?? '',
            'country' => $formData['country'] ?? '',
            'dob' => $dob,
            'nationality' => $formData['nationality'] ?? '',
            'gender' => $formData['gender'] ?? '',
            'hobbies' => $formData['hobbies'] ?? '',
            'interests' => $formData['interests'] ?? '',
            'summary' => $formData['summary'] ?? '',
            
            
            'job_title' => $formData['job_title'] ?? [],
            'company' => $formData['company'] ?? [],
            'job_start' => $formData['job_start'] ?? [],
            'job_end' => $formData['job_end'] ?? [],
            'job_description' => $formData['job_description'] ?? [],
            
            'degree' => $formData['degree'] ?? [],
            'school' => $formData['school'] ?? [],
            'edu_start' => $formData['edu_start'] ?? [],
            'edu_end' => $formData['edu_end'] ?? [],
            'edu_description' => $formData['edu_description'] ?? [],
            
            'skills' => $formData['skills'] ?? [],
            'skill_level' => $formData['skill_level'] ?? [],
            'languages' => $formData['languages'] ?? [],
            'language_level' => $formData['language_level'] ?? [],
            
           
            'employment_data' => $employmentData,
            'education_data' => $educationData,
            'skills_data' => $skillsData,
            'languages_data' => $languagesData,
        ];
    }

    public function getDraft()
    {
        $draft = session('resume_draft');
        return response()->json([
            'success' => true,
            'draft' => $draft
        ]);
    }

    public function getTemplates()
    {
        $templates = Template::active()->ordered()->get();
        
        return response()->json($templates);
    }
    
    public function testPreview(Request $request)
    {
        Log::info('Test Preview Request:', $request->all());
        return response()->json([
            'received_data' => $request->all(),
            'arrays_received' => [
                'job_title' => $request->job_title ?? [],
                'degree' => $request->degree ?? [],
                'skills' => $request->skills ?? [],
                'languages' => $request->languages ?? []
            ],
            'date_fields' => [
                'job_start' => $request->job_start ?? [],
                'job_end' => $request->job_end ?? [],
                'edu_start' => $request->edu_start ?? [],
                'edu_end' => $request->edu_end ?? []
            ]
        ]);
    }

    public function testDateParsing(Request $request)
    {
        $testDates = [
            '2023-12', 
            '2023-12-15', 
            '12/2023', 
            '12-2023', 
            'Invalid Date' 
        ];

        $results = [];
        foreach ($testDates as $date) {
            $results[$date] = $this->parseDateForDisplay($date);
        }

        return response()->json([
            'test_results' => $results,
            'current_system_time' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function loadSaved($id)
    {
        try {
            $resume = Resume::with(['employmentHistories', 'educations', 'skills', 'languages'])
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'resume' => $resume
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resume not found'
            ], 404);
        }
    }

    public function listSaved()
    {
        try {
            $resumes = Resume::with('template')
                ->where('user_id', auth()->id())
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'resumes' => $resumes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load resumes'
            ], 500);
        }
    }

    
    public function getSavedDrafts()
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $drafts = Resume::with(['template', 'employmentHistories', 'educations', 'skills', 'languages'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get()
                ->map(function ($resume) {
                    return [
                        'id' => $resume->id,
                        'first_name' => $resume->first_name,
                        'last_name' => $resume->last_name,
                        'email' => $resume->email,
                        'phone' => $resume->phone,
                        'occupation' => $resume->occupation,
                        'country' => $resume->country,
                        'nationality' => $resume->nationality,
                        'dob' => $resume->dob ? $resume->dob->format('Y-m-d') : null,
                        'gender' => $resume->gender,
                        'summary' => $resume->summary,
                        'hobbies' => $resume->hobbies,
                        'interests' => $resume->interests,
                        'template' => $resume->template->view_name ?? 'template1',
                        'updated_at' => $resume->updated_at->format('Y-m-d H:i:s'),
                        'employment_data' => $resume->employmentHistories->map(function ($employment) {
                            return [
                                'job_title' => $employment->job_title,
                                'company' => $employment->company,
                                'job_start' => $employment->start_date,
                                'job_end' => $employment->end_date,
                                'job_description' => $employment->description
                            ];
                        })->toArray(),
                        'education_data' => $resume->educations->map(function ($education) {
                            return [
                                'degree' => $education->degree,
                                'school' => $education->institution,
                                'edu_start' => $education->start_date,
                                'edu_end' => $education->end_date,
                                'edu_description' => $education->description
                            ];
                        })->toArray(),
                        'skills_data' => $resume->skills->map(function ($skill) {
                            return [
                                'skill' => $skill->skill,
                                'skill_level' => $skill->level
                            ];
                        })->toArray(),
                        'languages_data' => $resume->languages->map(function ($language) {
                            return [
                                'language' => $language->language,
                                'language_level' => $language->proficiency
                            ];
                        })->toArray()
                    ];
                });

            return response()->json([
                'success' => true,
                'drafts' => $drafts
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch saved drafts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load saved drafts'
            ], 500);
        }
    }

    
    public function deleteDraft($id)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $resume = Resume::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$resume) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found'
                ], 404);
            }

            $resume->delete();

            return response()->json([
                'success' => true,
                'message' => 'Draft deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete draft: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete draft'
            ], 500);
        }
    }

 
    public function exportPdf($id)
    {
        try {
            $resume = Resume::with(['employmentHistories', 'educations', 'skills', 'languages', 'template'])
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $data = $this->prepareResumeData($resume);
            $template = $resume->template->view_name ?? 'template1';

            $pdf = Pdf::loadView("templates.{$template}", $data);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = "resume-{$data['first_name']}-{$data['last_name']}.pdf";
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('PDF EXPORT FAILED: ' . $e->getMessage());
            return back()->with('error', 'Failed to export PDF: ' . $e->getMessage());
        }
    }

    
    private function prepareResumeData($resume)
    {
        return [
            'first_name' => $resume->first_name,
            'last_name' => $resume->last_name,
            'email' => $resume->email,
            'phone' => $resume->phone,
            'occupation' => $resume->occupation,
            'country' => $resume->country,
            'dob' => $resume->dob ? $resume->dob->format('F j, Y') : null,
            'nationality' => $resume->nationality,
            'gender' => $resume->gender,
            'hobbies' => $resume->hobbies,
            'interests' => $resume->interests,
            'summary' => $resume->summary,
            
            'employment_data' => $resume->employmentHistories->map(function ($employment) {
                return [
                    'job_title' => $employment->job_title,
                    'company' => $employment->company,
                    'job_start' => $this->parseDateForDisplay($employment->start_date),
                    'job_end' => $this->parseDateForDisplay($employment->end_date),
                    'job_description' => $employment->description
                ];
            })->toArray(),
            
            'education_data' => $resume->educations->map(function ($education) {
                return [
                    'degree' => $education->degree,
                    'school' => $education->institution,
                    'edu_start' => $this->parseDateForDisplay($education->start_date),
                    'edu_end' => $this->parseDateForDisplay($education->end_date),
                    'edu_description' => $education->description
                ];
            })->toArray(),
            
            'skills_data' => $resume->skills->map(function ($skill) {
                return [
                    'skill' => $skill->skill,
                    'skill_level' => $skill->level
                ];
            })->toArray(),
            
            'languages_data' => $resume->languages->map(function ($language) {
                return [
                    'language' => $language->language,
                    'language_level' => $language->proficiency
                ];
            })->toArray(),
        ];
    }
}