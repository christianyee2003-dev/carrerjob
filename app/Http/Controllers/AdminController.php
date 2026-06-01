<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ── Middleware check ──────────────────────────────────────────
    private function requireAdmin()
    {
        if (session('user.role') !== 'admin') {
            abort(403, 'Access denied. Admins only.');
        }
    }

    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard()
    {
        $this->requireAdmin();
        $jobs        = session('admin_jobs', []);
        $internships = session('admin_internships', []);
        $companies   = session('admin_companies', []);
        return view('admin.dashboard', compact('jobs', 'internships', 'companies'));
    }

    // ── JOBS ──────────────────────────────────────────────────────
    public function createJob()
    {
        $this->requireAdmin();
        return view('admin.job-form', ['job' => null, 'editId' => null]);
    }

    public function storeJob(Request $request)
    {
        $this->requireAdmin();
        $request->validate([
            'title'    => 'required|min:3',
            'company'  => 'required',
            'location' => 'required',
            'salary'   => 'required',
            'setup'    => 'required',
            'description' => 'required|min:10',
        ]);

        $jobs   = session('admin_jobs', []);
        $newId  = count($jobs) ? max(array_column($jobs, 'id')) + 1 : 100;
        $jobs[] = [
            'id'          => $newId,
            'title'       => $request->title,
            'company'     => $request->company,
            'logo'        => strtolower(preg_replace('/\s+/', '', $request->company)),
            'location'    => $request->location,
            'salary'      => $request->salary,
            'setup'       => $request->setup,
            'type'        => 'full-time',
            'posted'      => 'Just now',
            'experience'  => $request->experience ?? 'Not specified',
            'tags'        => array_filter(array_map('trim', explode(',', $request->tags ?? ''))),
            'description' => $request->description,
            'responsibilities' => array_filter(array_map('trim', explode("\n", $request->responsibilities ?? ''))),
            'requirements'     => array_filter(array_map('trim', explode("\n", $request->requirements ?? ''))),
            'benefits'         => array_filter(array_map('trim', explode(',', $request->benefits ?? ''))),
            'posted_by'   => session('user.name'),
            'created_at'  => now()->format('M d, Y h:i A'),
        ];
        session(['admin_jobs' => $jobs]);
        return redirect()->route('admin.dashboard')->with('success', 'Job posted successfully!');
    }

    public function editJob(int $id)
    {
        $this->requireAdmin();
        $jobs = session('admin_jobs', []);
        $job  = collect($jobs)->firstWhere('id', $id);
        abort_if(!$job, 404);
        return view('admin.job-form', ['job' => $job, 'editId' => $id]);
    }

    public function updateJob(Request $request, int $id)
    {
        $this->requireAdmin();
        $request->validate([
            'title'    => 'required|min:3',
            'company'  => 'required',
            'location' => 'required',
            'salary'   => 'required',
            'setup'    => 'required',
            'description' => 'required|min:10',
        ]);

        $jobs = session('admin_jobs', []);
        foreach ($jobs as &$job) {
            if ($job['id'] === $id) {
                $job['title']           = $request->title;
                $job['company']         = $request->company;
                $job['logo']            = strtolower(preg_replace('/\s+/', '', $request->company));
                $job['location']        = $request->location;
                $job['salary']          = $request->salary;
                $job['setup']           = $request->setup;
                $job['experience']      = $request->experience ?? 'Not specified';
                $job['tags']            = array_filter(array_map('trim', explode(',', $request->tags ?? '')));
                $job['description']     = $request->description;
                $job['responsibilities']= array_filter(array_map('trim', explode("\n", $request->responsibilities ?? '')));
                $job['requirements']    = array_filter(array_map('trim', explode("\n", $request->requirements ?? '')));
                $job['benefits']        = array_filter(array_map('trim', explode(',', $request->benefits ?? '')));
            }
        }
        session(['admin_jobs' => $jobs]);
        return redirect()->route('admin.dashboard')->with('success', 'Job updated successfully!');
    }

    public function deleteJob(int $id)
    {
        $this->requireAdmin();
        $jobs = array_values(array_filter(session('admin_jobs', []), fn($j) => $j['id'] !== $id));
        session(['admin_jobs' => $jobs]);
        return back()->with('success', 'Job deleted.');
    }

    // ── INTERNSHIPS ───────────────────────────────────────────────
    public function createInternship()
    {
        $this->requireAdmin();
        return view('admin.internship-form', ['internship' => null, 'editSlug' => null]);
    }

    public function storeInternship(Request $request)
    {
        $this->requireAdmin();
        $request->validate([
            'title'    => 'required|min:3',
            'company'  => 'required',
            'location' => 'required',
            'salary'   => 'required',
            'setup'    => 'required',
            'duration' => 'required',
            'description' => 'required|min:10',
        ]);

        $slug         = strtolower(preg_replace('/\s+/', '-', $request->company)) . '-' . time();
        $internships  = session('admin_internships', []);
        $internships[$slug] = [
            'slug'        => $slug,
            'title'       => $request->title,
            'company'     => $request->company,
            'logo'        => strtolower(preg_replace('/\s+/', '', $request->company)),
            'location'    => $request->location,
            'salary'      => $request->salary,
            'setup'       => $request->setup,
            'duration'    => $request->duration,
            'type'        => 'internship',
            'posted'      => 'Just now',
            'experience'  => 'No experience required',
            'slots'       => (int)($request->slots ?? 1),
            'tags'        => array_filter(array_map('trim', explode(',', $request->tags ?? ''))),
            'description' => $request->description,
            'responsibilities' => array_filter(array_map('trim', explode("\n", $request->responsibilities ?? ''))),
            'requirements'     => array_filter(array_map('trim', explode("\n", $request->requirements ?? ''))),
            'benefits'         => array_filter(array_map('trim', explode(',', $request->benefits ?? ''))),
            'posted_by'   => session('user.name'),
            'created_at'  => now()->format('M d, Y h:i A'),
        ];
        session(['admin_internships' => $internships]);
        return redirect()->route('admin.dashboard')->with('success', 'Internship posted successfully!');
    }

    public function deleteInternship(string $slug)
    {
        $this->requireAdmin();
        $internships = session('admin_internships', []);
        unset($internships[$slug]);
        session(['admin_internships' => $internships]);
        return back()->with('success', 'Internship deleted.');
    }

    // ── COMPANIES ─────────────────────────────────────────────────
    public function createCompany()
    {
        $this->requireAdmin();
        return view('admin.company-form', ['company' => null, 'editIdx' => null]);
    }

    public function storeCompany(Request $request)
    {
        $this->requireAdmin();
        $request->validate([
            'name'     => 'required|min:2',
            'industry' => 'required',
        ]);

        $companies   = session('admin_companies', []);
        $companies[] = [
            'name'       => $request->name,
            'logo'       => strtolower(preg_replace('/\s+/', '', $request->name)),
            'industry'   => $request->industry,
            'jobs'       => 0,
            'posted_by'  => session('user.name'),
            'created_at' => now()->format('M d, Y h:i A'),
        ];
        session(['admin_companies' => $companies]);
        return redirect()->route('admin.dashboard')->with('success', 'Company added successfully!');
    }

    public function deleteCompany(int $idx)
    {
        $this->requireAdmin();
        $companies = session('admin_companies', []);
        array_splice($companies, $idx, 1);
        session(['admin_companies' => $companies]);
        return back()->with('success', 'Company deleted.');
    }
}
