<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public static function allJobs(): array
    {
        $static = [
            1 => [
                'id' => 1, 'slug' => 'frontend-developer',
                'title' => 'Frontend Developer', 'company' => 'Google', 'logo' => 'google',
                'location' => 'Makati, Philippines', 'salary' => '₱75,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 2 days ago', 'experience' => '2+ years',
                'tags' => ['React', 'TypeScript', 'CSS', 'GraphQL'],
                'description' => 'Join Google Philippines as a Frontend Developer and build products used by billions. You will work on Google Search, Maps, and other flagship products.',
                'responsibilities' => ['Develop high-performance web applications using React','Collaborate with UX designers','Optimize for speed and scalability','Write unit and integration tests','Mentor junior developers'],
                'requirements' => ['2+ years frontend experience','Expert React and TypeScript','Web performance optimization','GraphQL and REST APIs','Git and CI/CD'],
                'benefits' => ['Competitive salary', 'Health & dental insurance', 'Stock options', 'Learning budget', 'Flexible hours'],
            ],
            2 => [
                'id' => 2, 'slug' => 'data-scientist',
                'title' => 'Data Scientist', 'company' => 'Netflix', 'logo' => 'netflix',
                'location' => 'Pasig, Philippines', 'salary' => '₱95,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 3 days ago', 'experience' => '2+ years',
                'tags' => ['Python', 'Machine Learning', 'SQL', 'TensorFlow'],
                'description' => 'Drive content strategy and personalization at Netflix using advanced data science and machine learning.',
                'responsibilities' => ['Build ML models for content recommendation','Analyze viewer behavior data','Design A/B experiments','Develop data pipelines','Present insights to stakeholders'],
                'requirements' => ['2+ years data science experience','Expert Python skills','Strong SQL knowledge','A/B testing experience','Cloud platform familiarity'],
                'benefits' => ['Netflix subscription', 'Remote-friendly', 'Learning stipend', 'Health insurance', 'Performance bonuses'],
            ],
            3 => [
                'id' => 3, 'slug' => 'software-engineer',
                'title' => 'Software Engineer', 'company' => 'Microsoft', 'logo' => 'microsoft',
                'location' => 'Taguig, Philippines', 'salary' => '₱80,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 5 days ago', 'experience' => '2+ years',
                'tags' => ['C#', '.NET', 'Azure', 'TypeScript'],
                'description' => 'Build world-class software products at Microsoft Philippines on enterprise-grade applications and Azure cloud services.',
                'responsibilities' => ['Design and implement scalable features','Build Azure cloud services','Mentor junior developers','Participate in architecture decisions','Ensure code quality'],
                'requirements' => ['2+ years software development','Proficiency in C#, Java, or TypeScript','Azure experience','Design patterns knowledge','Agile methodologies'],
                'benefits' => ['Azure certification support', 'Health insurance', 'Stock purchase plan', 'Hybrid work', 'Annual bonus'],
            ],
            4 => [
                'id' => 4, 'slug' => 'backend-engineer',
                'title' => 'Backend Engineer', 'company' => 'Amazon', 'logo' => 'amazon',
                'location' => 'Ortigas, Pasig', 'salary' => '₱85,000 / month',
                'type' => 'full-time', 'setup' => 'On-site',
                'posted' => 'Posted 1 day ago', 'experience' => '3+ years',
                'tags' => ['Java', 'AWS', 'Microservices', 'DynamoDB'],
                'description' => 'Build and scale the backend systems powering Amazon\'s global e-commerce platform and AWS services.',
                'responsibilities' => ['Design scalable microservices','Architect AWS infrastructure','Implement monitoring','Lead technical design reviews','Drive engineering best practices'],
                'requirements' => ['3+ years backend development','Expert Java or Python','Deep AWS experience','Distributed systems knowledge','Database design experience'],
                'benefits' => ['AWS credits', 'Relocation assistance', 'Health & life insurance', 'Employee discount', 'Stock vesting'],
            ],
            5 => [
                'id' => 5, 'slug' => 'devops-engineer',
                'title' => 'DevOps Engineer', 'company' => 'Grab', 'logo' => 'grab',
                'location' => 'BGC, Taguig', 'salary' => '₱90,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 2 days ago', 'experience' => '2+ years',
                'tags' => ['AWS', 'Docker', 'Kubernetes', 'Terraform'],
                'description' => 'Manage and scale the infrastructure powering Grab\'s super-app across Southeast Asia.',
                'responsibilities' => ['Design and manage cloud infrastructure','Build CI/CD pipelines','Manage Kubernetes clusters','Implement infrastructure as code','Monitor system health'],
                'requirements' => ['2+ years DevOps experience','AWS or GCP hands-on','Docker and Kubernetes','Terraform experience','Strong scripting skills'],
                'benefits' => ['Grab credits', 'Health insurance', 'Hybrid work', 'Learning budget', 'Performance bonuses'],
            ],
            6 => [
                'id' => 6, 'slug' => 'full-stack-developer',
                'title' => 'Full Stack Developer', 'company' => 'Shopify', 'logo' => 'shopify',
                'location' => 'Remote', 'salary' => '₱95,000 / month',
                'type' => 'full-time', 'setup' => 'Remote',
                'posted' => 'Posted 1 week ago', 'experience' => '3+ years',
                'tags' => ['React', 'Node.js', 'GraphQL', 'Ruby on Rails'],
                'description' => 'Join Shopify and help millions of merchants build and grow their online businesses.',
                'responsibilities' => ['Build full-stack features','Design GraphQL APIs','Improve platform performance','Collaborate with product teams','Conduct code reviews'],
                'requirements' => ['3+ years full-stack development','Expert React and JavaScript','Node.js or Ruby on Rails','GraphQL proficiency','E-commerce experience preferred'],
                'benefits' => ['Fully remote', 'Home office stipend', 'Health insurance', 'Stock options', 'Unlimited PTO'],
            ],
        ];

        // Merge admin-posted jobs from session
        $adminJobs = session('admin_jobs', []);
        foreach ($adminJobs as $aj) {
            $static[$aj['id']] = $aj;
        }

        return $static;
    }

    public function listings(Request $request)
    {
        $jobs   = array_values(self::allJobs());
        $search = trim($request->get('search', ''));
        $setup  = $request->get('setup', '');
        $sort   = $request->get('sort', 'newest');

        if ($search) {
            $jobs = array_values(array_filter($jobs, fn($j) =>
                str_contains(strtolower($j['title']),    strtolower($search)) ||
                str_contains(strtolower($j['company']),  strtolower($search)) ||
                str_contains(strtolower($j['location']), strtolower($search)) ||
                str_contains(strtolower(implode(' ', $j['tags'] ?? [])), strtolower($search))
            ));
        }
        if ($setup) {
            $jobs = array_values(array_filter($jobs, fn($j) => ($j['setup'] ?? '') === $setup));
        }

        return view('jobs.listings', compact('jobs', 'search', 'sort', 'setup'));
    }

    public function show(int $id)
    {
        $job = self::allJobs()[$id] ?? null;
        abort_if(!$job, 404);
        $related = array_slice(array_values(array_filter(self::allJobs(), fn($j) => $j['id'] !== $id)), 0, 3);
        return view('jobs.show', compact('job', 'related'));
    }

    public function saveJob(Request $request, $id)
    {
        $saved = session('saved_jobs', []);
        $id    = (int) $id;
        if (in_array($id, $saved)) {
            $saved  = array_values(array_diff($saved, [$id]));
            $status = 'removed';
        } else {
            $saved[] = $id;
            $status  = 'saved';
        }
        session(['saved_jobs' => $saved]);
        return response()->json(['status' => $status, 'count' => count($saved)]);
    }

    public function apply($id)
    {
        $applied = session('applied_jobs', []);
        $id      = (int) $id;
        if (!in_array($id, $applied)) {
            $applied[] = $id;
            session(['applied_jobs' => $applied]);
        }
        return back()->with('success', 'Your application has been submitted successfully! 🎉');
    }
}
