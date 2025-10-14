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

class ResumeController extends Controller
{
   
    public function index()
    {
        return view('resume');
    }

  
    public function download(Request $request)
    {
        
        \Log::info('=== RESUME FORM SUBMISSION STARTED ===');
        \Log::info('Form Data:', $request->all());

        try {
            
            $data = $request->all();
            
           
            $employment = [];
            if (!empty($data['job_title']) && is_array($data['job_title'])) {
                foreach ($data['job_title'] as $index => $title) {
                    
                    $hasData = !empty(trim($title)) || 
                               !empty(trim($data['company'][$index] ?? '')) ||
                               !empty(trim($data['job_start'][$index] ?? '')) ||
                               !empty(trim($data['job_end'][$index] ?? '')) ||
                               !empty(trim($data['job_description'][$index] ?? ''));
                    
                    if ($hasData) {
                        $employment[] = [
                            'job_title' => trim($title) ?? '',
                            'company' => trim($data['company'][$index] ?? ''),
                            'job_start' => trim($data['job_start'][$index] ?? ''),
                            'job_end' => trim($data['job_end'][$index] ?? ''),
                            'job_description' => trim($data['job_description'][$index] ?? '')
                        ];
                    }
                }
            }
            $data['employment'] = $employment;
            \Log::info('Processed employment records: ' . count($employment));

            
            $education = [];
            if (!empty($data['degree']) && is_array($data['degree'])) {
                foreach ($data['degree'] as $index => $degree) {
                   
                    $hasData = !empty(trim($degree)) || 
                               !empty(trim($data['school'][$index] ?? '')) ||
                               !empty(trim($data['edu_start'][$index] ?? '')) ||
                               !empty(trim($data['edu_end'][$index] ?? '')) ||
                               !empty(trim($data['edu_description'][$index] ?? ''));
                    
                    if ($hasData) {
                        $education[] = [
                            'degree' => trim($degree) ?? '',
                            'school' => trim($data['school'][$index] ?? ''),
                            'edu_start' => trim($data['edu_start'][$index] ?? ''),
                            'edu_end' => trim($data['edu_end'][$index] ?? ''),
                            'edu_description' => trim($data['edu_description'][$index] ?? '')
                        ];
                    }
                }
            }
            $data['education'] = $education;
            \Log::info('Processed education records: ' . count($education));

            
            $skills = [];
            if (isset($data['skills']) && is_array($data['skills'])) {
                foreach ($data['skills'] as $skill) {
                    if (!empty(trim($skill))) {
                        $skills[] = trim($skill);
                    }
                }
            }
            $data['skills'] = $skills;

         
            $languages = [];
            if (isset($data['languages']) && is_array($data['languages'])) {
                foreach ($data['languages'] as $lang) {
                    if (!empty(trim($lang))) {
                        $languages[] = trim($lang);
                    }
                }
            }
            $data['languages'] = $languages;

            
            \Log::info('Starting database save process...');
            \Log::info('Employment records to save: ' . count($employment));
            \Log::info('Education records to save: ' . count($education));
            
            DB::beginTransaction();
            try {
                \Log::info('Creating resume record...');
                
                
                $dob = null;
                if (!empty($request->dob)) {
                    try {
                        $dob = Carbon::createFromFormat('Y-m-d', $request->dob)->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $dob = Carbon::parse($request->dob)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dob = $request->dob;
                        }
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

                \Log::info('Resume data to save:', $resumeData);

                $resume = Resume::create($resumeData);
                \Log::info('Resume created successfully with ID: ' . $resume->id);

                
                if (!empty($employment)) {
                    \Log::info('Saving ' . count($employment) . ' employment histories...');
                    foreach ($employment as $index => $job) {
                        try {
                            $jobStart = null;
                            $jobEnd = null;
                            
                            if (!empty($job['job_start'])) {
                                try {
                                    $jobStart = Carbon::parse($job['job_start'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $jobStart = $job['job_start'];
                                }
                            }
                            
                            if (!empty($job['job_end'])) {
                                try {
                                    $jobEnd = Carbon::parse($job['job_end'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $jobEnd = $job['job_end'];
                                }
                            }
                            
                            EmploymentHistory::create([
                                'resume_id' => $resume->id,
                                'job_title' => $job['job_title'] ?? '',
                                'company' => $job['company'] ?? '',
                                'job_start' => $jobStart,
                                'job_end' => $jobEnd,
                                'job_description' => $job['job_description'] ?? ''
                            ]);
                            \Log::info("   Employment {$index}: " . ($job['job_title'] ?? 'No Title'));
                        } catch (\Exception $e) {
                            \Log::error("Failed to save employment {$index}: " . $e->getMessage());
                            
                        }
                    }
                }

                
                if (!empty($education)) {
                    \Log::info('Saving ' . count($education) . ' education records...');
                    foreach ($education as $index => $edu) {
                        try {
                            $eduStart = null;
                            $eduEnd = null;
                            
                            if (!empty($edu['edu_start'])) {
                                try {
                                    $eduStart = Carbon::parse($edu['edu_start'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $eduStart = $edu['edu_start'];
                                }
                            }
                            
                            if (!empty($edu['edu_end'])) {
                                try {
                                    $eduEnd = Carbon::parse($edu['edu_end'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $eduEnd = $edu['edu_end'];
                                }
                            }
                            
                            Education::create([
                                'resume_id' => $resume->id,
                                'degree' => $edu['degree'] ?? '',
                                'school' => $edu['school'] ?? '',
                                'edu_start' => $eduStart,
                                'edu_end' => $eduEnd,
                                'edu_description' => $edu['edu_description'] ?? ''
                            ]);
                            \Log::info("  Education {$index}: " . ($edu['degree'] ?? 'No Degree'));
                        } catch (\Exception $e) {
                            \Log::error("Failed to save education {$index}: " . $e->getMessage());
                           
                        }
                    }
                }

               
                if (!empty($skills)) {
                    \Log::info('Saving ' . count($skills) . ' skills...');
                    foreach ($skills as $skill) {
                        try {
                            Skill::create([
                                'resume_id' => $resume->id,
                                'skill' => $skill
                            ]);
                        } catch (\Exception $e) {
                            \Log::error("Failed to save skill {$skill}: " . $e->getMessage());
                        }
                    }
                    \Log::info('   Skills saved: ' . implode(', ', $skills));
                }

                
                if (!empty($languages)) {
                    \Log::info('Saving ' . count($languages) . ' languages...');
                    foreach ($languages as $lang) {
                        try {
                            Language::create([
                                'resume_id' => $resume->id,
                                'language' => $lang
                            ]);
                        } catch (\Exception $e) {
                            \Log::error("Failed to save language {$lang}: " . $e->getMessage());
                        }
                    }
                    \Log::info('  Languages saved: ' . implode(', ', $languages));
                }

                DB::commit();
                \Log::info('✓ Database transaction committed successfully!');
                \Log::info('=== RESUME SAVED TO DATABASE SUCCESSFULLY ===');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error(' DATABASE SAVE FAILED: ' . $e->getMessage());
                \Log::error('Error Location: ' . $e->getFile() . ':' . $e->getLine());
                \Log::error('Stack Trace: ' . $e->getTraceAsString());
                
            }

            
            $template = $request->input('template', 'template1');
            
           
            \Log::info('Generating PDF with template: ' . $template);
            $pdf = Pdf::loadView("templates.$template", $data);
            
           
            $pdf->setPaper('A4', 'portrait');
            
            
            \Log::info('PDF generated successfully, initiating download...');
            return $pdf->download('resume.pdf');

        } catch (\Exception $e) {
            \Log::error(' PDF GENERATION FAILED: ' . $e->getMessage());
            \Log::error('Full error trace: ' . $e->getTraceAsString());
            return back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }
}