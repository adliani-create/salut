<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AcademicRecord;
use App\Models\CourseGrade;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;

class AcademicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $students = User::whereHas('role', function ($q) {
                $q->where('name', 'mahasiswa');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.academic.index', compact('students', 'search'));
    }

    public function upload(User $user)
    {
        return view('admin.academic.upload', compact('user'));
    }

    public function parse(Request $request, User $user)
    {
        $request->validate([
            'semester' => 'required',
            'transcript_file' => 'required|mimes:pdf|max:5120',
        ]);

        $file = $request->file('transcript_file');
        $path = $file->store('transcripts', 'public');

        // Parse PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/public/' . $path));
        $text = $pdf->getText();

        // Attempt Regex Extraction
        // Pattern assumes: Code Name SKS Grade (e.g., "MKDU4111 Pendidikan Kewarganegaraan 3 A")
        // This is a naive pattern and might need adjustment based on actual PDF format
        $lines = explode("\n", $text);
        $courses = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            // Example Regex: [Code 3-9 chars] [Name ...] [SKS 1 digit] [Grade 1-2 chars]
            // Matches: MATA4112 Aljabar Linear Elementer I 4 A
            // Regex update: Allow for more flexible spacing
            // Matches: Code (4 char + numbers), Name, SKS (digit), Grade (A-E with/without +/-)
            if (preg_match('/([A-Z]{4}\d{1,6})\s+(.+?)\s+(\d)\s+([A-E][+-]?)/', $line, $matches)) {
                
                // Exclude if regex accidentally matched a header like "KODE MATA KULIAH SKS NILAI"
                if (strlen($matches[2]) > 2 && !str_contains(strtoupper($matches[2]), 'MATA KULIAH')) {
                     $courses[] = [
                        'code' => $matches[1],
                        'name' => trim($matches[2]),
                        'sks' => $matches[3],
                        'grade' => $matches[4],
                    ];
                }
            }
        }

        return view('admin.academic.verify', [
            'user' => $user,
            'semester' => $request->semester,
            'pdf_url' => Storage::url($path),
            'pdf_path' => $path, // Pass raw path to store hidden
            'courses' => $courses, // Pre-filled data
            'raw_text' => $text, // Debugging
        ]);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'semester' => 'required',
            'pdf_path' => 'required',
            'courses' => 'array',
            'courses.*.code' => 'nullable|string',
            'courses.*.name' => 'required|string',
            'courses.*.sks' => 'required|integer',
            'courses.*.grade' => 'required|string',
        ]);

        // Calculate IPK/IPS Logic (Simplified)
        // IPS = Sum(SKS * Point) / Sum(SKS)
        $totalSks = 0;
        $totalPoints = 0;
        
        $gradeMap = [
            'A' => 4.0, 'A-' => 3.7,
            'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
            'D' => 1.0, 'E' => 0.0
        ];

        foreach ($request->courses as $c) {
            $sks = (int)$c['sks'];
            $grade = strtoupper($c['grade']);
            $point = $gradeMap[$grade] ?? 0.0;
            
            $totalSks += $sks;
            $totalPoints += ($sks * $point);
        }

        $ips = $totalSks > 0 ? round($totalPoints / $totalSks, 2) : 0;

        // Create/Update Academic Record
        $record = AcademicRecord::updateOrCreate(
            ['user_id' => $user->id, 'semester' => $request->semester],
            [
                'sks' => $totalSks,
                'ips' => $ips,
                'ipk' => $ips, // For now assuming IPK = IPS if simple import, or needs full recalc logic
                'transcript_file' => $request->pdf_path
            ]
        );

        // Save Grades
        $record->grades()->delete(); // Overwrite existing for this semester
        foreach ($request->courses as $c) {
             $grade = strtoupper($c['grade']);
             $point = $gradeMap[$grade] ?? 0.0;

            $record->grades()->create([
                'course_code' => $c['code'],
                'course_name' => $c['name'],
                'sks' => $c['sks'],
                'grade_letter' => $grade,
                'grade_point' => $point
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Data akademik berhasil disimpan.');
    }
}
