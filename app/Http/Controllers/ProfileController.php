<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index()
    {
        $user = session('user');
        if (!$user) return redirect()->route('login');

        $savedIds = session('saved_jobs', []);
        $appliedIds = session('applied_jobs', []);
        $allJobs = HomeController::allJobs();

        $savedJobs = array_values(array_filter($allJobs, fn($j) => in_array($j['id'], $savedIds)));
        $appliedJobs = array_values(array_filter($allJobs, fn($j) => in_array($j['id'], $appliedIds)));

        $skills = ['JavaScript', 'PHP', 'Python', 'React', 'Figma'];
        return view('profile.index', compact('user', 'savedJobs', 'appliedJobs', 'skills'));
    }
}
