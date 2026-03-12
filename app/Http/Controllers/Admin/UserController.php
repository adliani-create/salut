<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view('admin.users.index', compact('users'));
    }

    public function students(Request $request)
    {
        $search = $request->get('q');

        $students = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'mahasiswa');
        })->where('status', 'active') // Only show active students
            ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                }
                );
            })
            ->with('registration')->latest()
            ->paginate(10);

        return view('admin.users.students', compact('students', 'search'));
    }

    public function create()
    {
        // Not used, users register themselves or via a different flow
        abort(404);
    }

    public function store(Request $request)
    {
        // Not used
        abort(404);
    }

    public function show(\App\Models\User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(\App\Models\User $user)
    {
        // Ensure we load registration relation
        $user->load('registration', 'auditLogs.user');
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'status' => 'required|string',
            'faculty' => 'nullable|string',
            'major' => 'nullable|string',
            'semester' => 'nullable|integer',
            'ipk' => 'nullable|numeric|between:0,4.00',
            'password_myut' => 'nullable|string',
            'jenjang' => 'nullable|string',
            'jalur' => 'nullable|string',
            'fokus_karir' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:20',
            'angkatan' => 'nullable|integer|digits:4',
        ]);

        $changes = [];
        $description = [];

        // Check columns on User model
        $userFields = ['name', 'email', 'status', 'faculty', 'major', 'semester', 'ipk', 'password_myut', 'angkatan'];
        foreach ($userFields as $field) {
            if ($user->$field != $validated[$field]) {
                $old = $user->$field;
                $new = $validated[$field];
                $changes[$field] = ['old' => $old, 'new' => $new];

                // Sensitive fields logging description
                if (in_array($field, ['ipk', 'status', 'password_myut', 'angkatan'])) {
                    $description[] = "Changed $field from '$old' to '$new'";
                }
                $user->$field = $new;
            }
        }

        $user->save();

        // Update Registration Data
        $registration = $user->registration;
        if ($registration) {
            $regFields = [
                'jenjang' => 'jenjang',
                'jalur' => 'jalur_pendaftaran',
                'fokus_karir' => 'fokus_karir',
                'faculty' => 'fakultas', // sync fallback
                'major' => 'prodi', // sync fallback
                'whatsapp' => 'whatsapp'
            ];

            // Map request keys to ID/DB keys if different. Here input names match DB or logic needs mapping.
            // Form inputs: jenjang, jalur, fokus_karir, faculty, major, whatsapp
            // DB inputs: jenjang, jalur_pendaftaran, fokus_karir, fakultas, prodi, whatsapp

            $inputMap = [
                'jenjang' => 'jenjang',
                'jalur' => 'jalur_pendaftaran',
                'fokus_karir' => 'fokus_karir',
                'faculty' => 'fakultas',
                'major' => 'prodi',
                'whatsapp' => 'whatsapp'
            ];

            foreach ($inputMap as $inputKey => $dbColumn) {
                if (isset($validated[$inputKey]) && $registration->$dbColumn != $validated[$inputKey]) {
                    $old = $registration->$dbColumn;
                    $new = $validated[$inputKey];
                    $changes["registration.$dbColumn"] = ['old' => $old, 'new' => $new];

                    if ($inputKey == 'fokus_karir') {
                        $description[] = "Changed Program Unggulan from '$old' to '$new'";
                    }

                    $registration->$dbColumn = $new;
                }
            }
            $registration->save();
        }

        // Create Audit Log if there were changes
        if (!empty($changes)) {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'Update Student Data',
                'target_model' => 'User',
                'target_id' => $user->id,
                'changes' => $changes,
                'description' => !empty($description) ? implode(", ", $description) : "Updated basic details",
            ]);
        }

        // Redirect based on role or context. User index vs Student index.
        if ($user->isMahasiswa()) {
            return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
}
