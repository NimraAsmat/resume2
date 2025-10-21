<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Resume;
use App\Models\Education;
use App\Models\EmploymentHistory;
use App\Models\Skill;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resume');
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
       
        Log::info('Form Data Received:', $formData);

       
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
                        try {
                            $startDate = Carbon::createFromFormat('Y-m', $formData['job_start'][$index])->format('M Y');
                        } catch (\Exception $e) {
                            $startDate = $formData['job_start'][$index];
                        }
                    }
                    
                    if (!empty($formData['job_end'][$index])) {
                        try {
                            $endDate = Carbon::createFromFormat('Y-m', $formData['job_end'][$index])->format('M Y');
                        } catch (\Exception $e) {
                            $endDate = $formData['job_end'][$index];
                        }
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
                        try {
                            $startDate = Carbon::createFromFormat('Y-m', $formData['edu_start'][$index])->format('M Y');
                        } catch (\Exception $e) {
                            $startDate = $formData['edu_start'][$index];
                        }
                    }
                    
                    if (!empty($formData['edu_end'][$index])) {
                        try {
                            $endDate = Carbon::createFromFormat('Y-m', $formData['edu_end'][$index])->format('M Y');
                        } catch (\Exception $e) {
                            $endDate = $formData['edu_end'][$index];
                        }
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

    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email',
                'phone' => 'sometimes|string',
            ]);

            
            $allData = $request->all();
            
           
            session(['resume_draft' => $allData]);
            
           
            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'data' => $allData 
            ]);

        } catch (\Exception $e) {
            Log::error('DRAFT SAVE FAILED: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save draft: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(Request $request)
    {
        Log::info('=== RESUME FORM SUBMISSION STARTED ===');
        Log::info('Form Data:', $request->all());

        try {
            DB::beginTransaction();
            
            try {
                
                $dob = null;
                if (!empty($request->dob)) {
                    try {
                        $dob = Carbon::createFromFormat('Y-m-d', $request->dob)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $dob = $request->dob;
                    }
                }

               
                $resumeData = [
                    'first_name' => $request->first_name ?? 'Unknown',
                    'last_name' => $request->last_name ?? 'Unknown',
                    'email' => $request->email ?? null,
                    'phone' => $request->phone ?? null,
                    'occupation' => $request->occupation ?? null,
                    'country' => $request->country ?? null,
                    'nationality' => $request->nationality ?? null,
                    'dob' => $dob,
                    'gender' => $request->gender ?? null,
                    'summary' => $request->summary ?? null,
                    'hobbies' => $request->hobbies ?? null,
                    'interests' => $request->interests ?? null,
                    'template' => $request->template ?? 'template1',
                ];

                Log::info('Creating resume with data:', $resumeData);
                $resume = Resume::create($resumeData);
                Log::info('Resume created with ID: ' . $resume->id);

               
                if ($request->has('job_title') && is_array($request->job_title)) {
                    foreach ($request->job_title as $index => $title) {
                        if (!empty(trim($title))) {
                            
                            $jobStart = $this->formatMonthToDate($request->job_start[$index] ?? '');
                            $jobEnd = $this->formatMonthToDate($request->job_end[$index] ?? '');
                            
                            EmploymentHistory::create([
                                'resume_id' => $resume->id,
                                'job_title' => $title,
                                'company' => $request->company[$index] ?? '',
                                'job_start' => $jobStart,
                                'job_end' => $jobEnd,
                                'job_description' => $request->job_description[$index] ?? ''
                            ]);
                        }
                    }
                    Log::info('Employment records created: ' . count($request->job_title));
                }

                
                if ($request->has('degree') && is_array($request->degree)) {
                    foreach ($request->degree as $index => $degree) {
                        if (!empty(trim($degree))) {
                           
                            $eduStart = $this->formatMonthToDate($request->edu_start[$index] ?? '');
                            $eduEnd = $this->formatMonthToDate($request->edu_end[$index] ?? '');
                            
                            Education::create([
                                'resume_id' => $resume->id,
                                'degree' => $degree,
                                'school' => $request->school[$index] ?? '',
                                'edu_start' => $eduStart,
                                'edu_end' => $eduEnd,
                                'edu_description' => $request->edu_description[$index] ?? ''
                            ]);
                        }
                    }
                    Log::info('Education records created: ' . count($request->degree));
                }

                
                if ($request->has('skills') && is_array($request->skills)) {
                    foreach ($request->skills as $index => $skill) {
                        if (!empty(trim($skill))) {
                            Skill::create([
                                'resume_id' => $resume->id,
                                'skill' => $skill,
                                'skill_level' => $request->skill_level[$index] ?? null,
                            ]);
                        }
                    }
                    Log::info('Skill records created: ' . count($request->skills));
                }

                
                if ($request->has('languages') && is_array($request->languages)) {
                    foreach ($request->languages as $index => $language) {
                        if (!empty(trim($language))) {
                            Language::create([
                                'resume_id' => $resume->id,
                                'language' => $language,
                                'language_level' => $request->language_level[$index] ?? null,
                            ]);
                        }
                    }
                    Log::info('Language records created: ' . count($request->languages));
                }

                DB::commit();
                Log::info('Database transaction committed successfully!');

               
                $data = $this->prepareDataForPdf($resume);

                
                $template = $request->input('template', 'template1');
                Log::info('Generating PDF with template: ' . $template);
                
               
                if (!view()->exists("templates.{$template}")) {
                    throw new \Exception("Template '{$template}' not found");
                }
                
                $pdf = Pdf::loadView("templates.{$template}", $data);
                $pdf->setPaper('A4', 'portrait');
                
                Log::info('PDF generated successfully, initiating download...');
                
                
                session()->forget('resume_draft');
              
                return $pdf->download("resume-{$resume->id}.pdf");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('DATABASE SAVE FAILED: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('PDF GENERATION FAILED: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function prepareDataForPdf(Resume $resume)
    {
      
        $jobStarts = [];
        $jobEnds = [];
        foreach ($resume->employmentHistories as $job) {
            if ($job->job_start) {
                try {
                    $jobStarts[] = Carbon::parse($job->job_start)->format('M Y');
                } catch (\Exception $e) {
                    $jobStarts[] = $job->job_start;
                }
            } else {
                $jobStarts[] = '';
            }
            
            if ($job->job_end) {
                try {
                    $jobEnds[] = Carbon::parse($job->job_end)->format('M Y');
                } catch (\Exception $e) {
                    $jobEnds[] = $job->job_end;
                }
            } else {
                $jobEnds[] = '';
            }
        }

        $eduStarts = [];
        $eduEnds = [];
        foreach ($resume->educations as $edu) {
            if ($edu->edu_start) {
                try {
                    $eduStarts[] = Carbon::parse($edu->edu_start)->format('M Y');
                } catch (\Exception $e) {
                    $eduStarts[] = $edu->edu_start;
                }
            } else {
                $eduStarts[] = '';
            }
            
            if ($edu->edu_end) {
                try {
                    $eduEnds[] = Carbon::parse($edu->edu_end)->format('M Y');
                } catch (\Exception $e) {
                    $eduEnds[] = $edu->edu_end;
                }
            } else {
                $eduEnds[] = '';
            }
        }

        return [
            'first_name' => $resume->first_name,
            'last_name' => $resume->last_name,
            'email' => $resume->email,
            'phone' => $resume->phone,
            'occupation' => $resume->occupation,
            'country' => $resume->country,
            'dob' => $resume->dob ? Carbon::parse($resume->dob)->format('F j, Y') : null,
            'nationality' => $resume->nationality,
            'gender' => $resume->gender,
            'hobbies' => $resume->hobbies,
            'interests' => $resume->interests,
            'summary' => $resume->summary,
            'job_title' => $resume->employmentHistories->pluck('job_title')->toArray(),
            'company' => $resume->employmentHistories->pluck('company')->toArray(),
            'job_start' => $jobStarts,
            'job_end' => $jobEnds,
            'job_description' => $resume->employmentHistories->pluck('job_description')->toArray(),
            'degree' => $resume->educations->pluck('degree')->toArray(),
            'school' => $resume->educations->pluck('school')->toArray(),
            'edu_start' => $eduStarts,
            'edu_end' => $eduEnds,
            'edu_description' => $resume->educations->pluck('edu_description')->toArray(),
            'skills' => $resume->skills->pluck('skill')->toArray(),
            'skill_level' => $resume->skills->pluck('skill_level')->toArray(),
            'languages' => $resume->languages->pluck('language')->toArray(),
            'language_level' => $resume->languages->pluck('language_level')->toArray(),
            
          
            'employment_data' => $resume->employmentHistories->map(function($job) {
                return [
                    'job_title' => $job->job_title,
                    'company' => $job->company,
                    'job_start' => $job->job_start ? Carbon::parse($job->job_start)->format('M Y') : '',
                    'job_end' => $job->job_end ? Carbon::parse($job->job_end)->format('M Y') : '',
                    'job_description' => $job->job_description
                ];
            })->toArray(),
            
            'education_data' => $resume->educations->map(function($edu) {
                return [
                    'degree' => $edu->degree,
                    'school' => $edu->school,
                    'edu_start' => $edu->edu_start ? Carbon::parse($edu->edu_start)->format('M Y') : '',
                    'edu_end' => $edu->edu_end ? Carbon::parse($edu->edu_end)->format('M Y') : '',
                    'edu_description' => $edu->edu_description
                ];
            })->toArray(),
            
            'skills_data' => $resume->skills->map(function($skill) {
                return [
                    'skill' => $skill->skill,
                    'skill_level' => $skill->skill_level
                ];
            })->toArray(),
            
            'languages_data' => $resume->languages->map(function($language) {
                return [
                    'language' => $language->language,
                    'language_level' => $language->language_level
                ];
            })->toArray(),
        ];
    }

    private function formatMonthToDate($monthValue)
    {
        if (empty($monthValue)) {
            return null;
        }
        
        try {
            return Carbon::createFromFormat('Y-m', $monthValue)->format('Y-m-d');
        } catch (\Exception $e) {
            return $monthValue;
        }
    }

   
    public function getDraft()
    {
        $draft = session('resume_draft');
        return response()->json([
            'success' => true,
            'draft' => $draft
        ]);
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
            ]
        ]);
    }
}