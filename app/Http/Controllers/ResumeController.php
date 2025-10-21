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

    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email',
                'phone' => 'sometimes|string',
            ]);

            session(['resume_draft' => $request->all()]);

            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save draft'
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
                // Process date of birth
                $dob = null;
                if (!empty($request->dob)) {
                    try {
                        $dob = Carbon::createFromFormat('Y-m-d', $request->dob)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $dob = $request->dob;
                    }
                }

                // Create resume
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
                Log::info('✓ Resume created with ID: ' . $resume->id);

                // Save employment history
                if ($request->has('job_title')) {
                    foreach ($request->job_title as $index => $title) {
                        if (!empty(trim($title))) {
                            // Convert month format to date format
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
                    Log::info('✓ Employment records created');
                }

                // Save education
                if ($request->has('degree')) {
                    foreach ($request->degree as $index => $degree) {
                        if (!empty(trim($degree))) {
                            // Convert month format to date format
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
                    Log::info('✓ Education records created');
                }

                // Save skills
                if ($request->has('skills')) {
                    foreach ($request->skills as $index => $skill) {
                        if (!empty(trim($skill))) {
                            Skill::create([
                                'resume_id' => $resume->id,
                                'skill' => $skill,
                                'skill_level' => $request->skill_level[$index] ?? null,
                            ]);
                        }
                    }
                    Log::info('✓ Skill records created');
                }

                // Save languages
                if ($request->has('languages')) {
                    foreach ($request->languages as $index => $language) {
                        if (!empty(trim($language))) {
                            Language::create([
                                'resume_id' => $resume->id,
                                'language' => $language,
                                'language_level' => $request->language_level[$index] ?? null,
                            ]);
                        }
                    }
                    Log::info('✓ Language records created');
                }

                DB::commit();
                Log::info('✓ Database transaction committed successfully!');

                // Prepare data for PDF
                $data = $this->prepareDataForPdf($resume);

                // Generate PDF
                $template = $request->input('template', 'template1');
                Log::info('Generating PDF with template: ' . $template);
                
                // Check if template exists
                if (!view()->exists("templates.{$template}")) {
                    throw new \Exception("Template '{$template}' not found");
                }
                
                $pdf = Pdf::loadView("templates.{$template}", $data);
                $pdf->setPaper('A4', 'portrait');
                
                Log::info('PDF generated successfully, initiating download...');
                
                // Return PDF download
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
            'job_start' => $resume->employmentHistories->pluck('job_start')->toArray(),
            'job_end' => $resume->employmentHistories->pluck('job_end')->toArray(),
            'job_description' => $resume->employmentHistories->pluck('job_description')->toArray(),
            'degree' => $resume->educations->pluck('degree')->toArray(),
            'school' => $resume->educations->pluck('school')->toArray(),
            'edu_start' => $resume->educations->pluck('edu_start')->toArray(),
            'edu_end' => $resume->educations->pluck('edu_end')->toArray(),
            'edu_description' => $resume->educations->pluck('edu_description')->toArray(),
            'skills' => $resume->skills->pluck('skill')->toArray(),
            'skill_level' => $resume->skills->pluck('skill_level')->toArray(),
            'languages' => $resume->languages->pluck('language')->toArray(),
            'language_level' => $resume->languages->pluck('language_level')->toArray(),
        ];
    }

    private function formatMonthToDate($monthValue)
    {
        if (empty($monthValue)) {
            return null;
        }
        
        try {
            // Convert "YYYY-MM" to "YYYY-MM-01" (first day of month)
            return Carbon::createFromFormat('Y-m', $monthValue)->format('Y-m-d');
        } catch (\Exception $e) {
            return $monthValue;
        }
    }
}