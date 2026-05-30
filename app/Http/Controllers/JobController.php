<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public static function allJobs(): array
    {
        return [
            1 => [
                'id' => 1, 'slug' => 'frontend-developer',
                'title' => 'Frontend Developer',
                'company' => 'Google', 'logo' => 'google',
                'location' => 'Makati, Philippines', 'salary' => '₱75,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 2 days ago', 'experience' => '2+ years',
                'tags' => ['React', 'TypeScript', 'CSS', 'GraphQL'],
                'description' => 'Join Google Philippines as a Frontend Developer and build products used by billions. You will work on Google Search, Maps, and other flagship products, collaborating with world-class engineers and designers to deliver exceptional user experiences.',
                'responsibilities' => [
                    'Develop high-performance web applications using React and TypeScript',
                    'Collaborate with UX designers to implement pixel-perfect interfaces',
                    'Optimize applications for maximum speed and scalability',
                    'Write comprehensive unit and integration tests',
                    'Mentor junior developers and conduct code reviews',
                    'Contribute to frontend architecture decisions',
                ],
                'requirements' => [
                    '2+ years of professional frontend development experience',
                    'Expert-level knowledge of React and TypeScript',
                    'Strong understanding of web performance optimization',
                    'Experience with GraphQL and REST APIs',
                    'Proficiency with Git and CI/CD pipelines',
                    'Bachelor\'s degree in CS or equivalent experience',
                ],
                'benefits' => ['Competitive salary', 'Health & dental insurance', 'Stock options', 'Annual learning budget', 'Flexible work hours'],
            ],
            2 => [
                'id' => 2, 'slug' => 'data-science',
                'title' => 'Data Scientist',
                'company' => 'Netflix', 'logo' => 'netflix',
                'location' => 'Pasig, Philippines', 'salary' => '₱95,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 3 days ago', 'experience' => '2+ years',
                'tags' => ['Python', 'Machine Learning', 'SQL', 'TensorFlow'],
                'description' => 'Drive content strategy and personalization at Netflix using advanced data science and machine learning. You will work with petabytes of viewer data to build recommendation systems and predictive models that shape what 260 million subscribers watch.',
                'responsibilities' => [
                    'Build and deploy machine learning models for content recommendation',
                    'Analyze viewer behavior data to identify trends and opportunities',
                    'Design and run A/B experiments to improve user engagement',
                    'Develop data pipelines and ETL processes',
                    'Present insights and model results to business stakeholders',
                    'Collaborate with engineering teams on model productionization',
                ],
                'requirements' => [
                    '2+ years of data science or ML engineering experience',
                    'Expert Python skills (pandas, scikit-learn, TensorFlow/PyTorch)',
                    'Strong SQL and data warehousing knowledge',
                    'Experience with A/B testing and statistical analysis',
                    'Familiarity with cloud platforms (AWS, GCP)',
                    'Bachelor\'s or Master\'s in Data Science, Statistics, or CS',
                ],
                'benefits' => ['Netflix subscription', 'Remote-friendly', 'Learning stipend', 'Health insurance', 'Performance bonuses'],
            ],
            3 => [
                'id' => 3, 'slug' => 'software-engineer',
                'title' => 'Software Engineer',
                'company' => 'Microsoft', 'logo' => 'microsoft',
                'location' => 'Taguig, Philippines', 'salary' => '₱80,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 5 days ago', 'experience' => '2+ years',
                'tags' => ['C#', '.NET', 'Azure', 'TypeScript'],
                'description' => 'Build world-class software products at Microsoft Philippines. You will work on enterprise-grade applications and Azure cloud services that empower organizations globally, collaborating with engineers across multiple time zones.',
                'responsibilities' => [
                    'Design and implement scalable software features in C# and TypeScript',
                    'Build and maintain Azure cloud services and integrations',
                    'Mentor junior developers and conduct thorough code reviews',
                    'Participate in architecture and technical design decisions',
                    'Ensure high code quality through automated testing and CI/CD',
                    'Collaborate with product managers and designers on requirements',
                ],
                'requirements' => [
                    '2+ years of software development experience',
                    'Proficiency in C#, Java, or TypeScript',
                    'Experience with Azure or other cloud platforms',
                    'Strong understanding of software design patterns and SOLID principles',
                    'Experience with agile/scrum development methodologies',
                    'Excellent communication and collaboration skills',
                ],
                'benefits' => ['Azure certification support', 'Health insurance', 'Stock purchase plan', 'Hybrid work setup', 'Annual performance bonus'],
            ],
            4 => [
                'id' => 4, 'slug' => 'backend-engineer',
                'title' => 'Backend Engineer',
                'company' => 'Amazon', 'logo' => 'amazon',
                'location' => 'Ortigas, Pasig', 'salary' => '₱85,000 / month',
                'type' => 'full-time', 'setup' => 'On-site',
                'posted' => 'Posted 1 day ago', 'experience' => '3+ years',
                'tags' => ['Java', 'AWS', 'Microservices', 'DynamoDB'],
                'description' => 'Build and scale the backend systems powering Amazon\'s global e-commerce platform and AWS services. You will work on distributed systems handling millions of transactions per second, ensuring reliability, performance, and security at massive scale.',
                'responsibilities' => [
                    'Design and build highly scalable microservices using Java',
                    'Architect and optimize AWS infrastructure and services',
                    'Implement robust monitoring, alerting, and observability',
                    'Lead technical design reviews and architecture discussions',
                    'Drive engineering best practices and coding standards',
                    'Participate in on-call rotations and incident response',
                ],
                'requirements' => [
                    '3+ years of backend development experience',
                    'Expert knowledge of Java or Python',
                    'Deep experience with AWS services (EC2, Lambda, DynamoDB, SQS)',
                    'Strong understanding of distributed systems and microservices',
                    'Experience with database design and optimization',
                    'Bachelor\'s degree in CS or equivalent',
                ],
                'benefits' => ['AWS credits', 'Relocation assistance', 'Health & life insurance', 'Employee discount', 'Stock vesting plan'],
            ],
            5 => [
                'id' => 5, 'slug' => 'devops-engineer',
                'title' => 'DevOps Engineer',
                'company' => 'Grab', 'logo' => 'grab',
                'location' => 'BGC, Taguig', 'salary' => '₱90,000 / month',
                'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => 'Posted 2 days ago', 'experience' => '2+ years',
                'tags' => ['AWS', 'Docker', 'Kubernetes', 'Terraform'],
                'description' => 'Manage and scale the infrastructure powering Grab\'s super-app across Southeast Asia. You will ensure high availability, performance, and security of critical systems serving millions of daily active users across ride-hailing, food delivery, and fintech.',
                'responsibilities' => [
                    'Design and manage cloud infrastructure on AWS and GCP',
                    'Build and maintain CI/CD pipelines using Jenkins and GitHub Actions',
                    'Manage Kubernetes clusters and containerized workloads',
                    'Implement infrastructure as code using Terraform',
                    'Monitor system health and respond to production incidents',
                    'Drive reliability engineering and SRE practices',
                ],
                'requirements' => [
                    '2+ years of DevOps or SRE experience',
                    'Hands-on experience with AWS or GCP',
                    'Proficiency with Docker and Kubernetes',
                    'Experience with Terraform or other IaC tools',
                    'Strong scripting skills in Bash and Python',
                    'Experience with monitoring tools (Prometheus, Grafana, Datadog)',
                ],
                'benefits' => ['Grab credits', 'Health insurance', 'Hybrid work', 'Learning budget', 'Performance bonuses'],
            ],
            6 => [
                'id' => 6, 'slug' => 'full-stack-developer',
                'title' => 'Full Stack Developer',
                'company' => 'Shopify', 'logo' => 'shopify',
                'location' => 'Remote', 'salary' => '₱95,000 / month',
                'type' => 'full-time', 'setup' => 'Remote',
                'posted' => 'Posted 1 week ago', 'experience' => '3+ years',
                'tags' => ['React', 'Node.js', 'GraphQL', 'Ruby on Rails'],
                'description' => 'Join Shopify and help millions of merchants build and grow their online businesses. You will work on the core commerce platform that powers over 1.7 million businesses worldwide, building features that directly impact merchant success.',
                'responsibilities' => [
                    'Build full-stack features using React, Node.js, and Ruby on Rails',
                    'Design and implement GraphQL APIs and data models',
                    'Improve platform performance, scalability, and reliability',
                    'Collaborate with product managers and designers on new features',
                    'Conduct thorough code reviews and maintain code quality',
                    'Contribute to technical roadmap and architecture planning',
                ],
                'requirements' => [
                    '3+ years of full-stack development experience',
                    'Expertise in React and modern JavaScript/TypeScript',
                    'Experience with Node.js or Ruby on Rails',
                    'Proficiency with GraphQL API design',
                    'E-commerce or SaaS product experience preferred',
                    'Strong problem-solving and communication skills',
                ],
                'benefits' => ['Fully remote', 'Home office stipend', 'Health insurance', 'Stock options', 'Unlimited PTO'],
            ],
        ];
    }

    public function listings(Request $request)
    {
        $jobs  = array_values(self::allJobs());
        $search = trim($request->get('search', ''));
        $setup  = $request->get('setup', '');
        $sort   = $request->get('sort', 'newest');

        if ($search) {
            $jobs = array_values(array_filter($jobs, fn($j) =>
                str_contains(strtolower($j['title']),    strtolower($search)) ||
                str_contains(strtolower($j['company']),  strtolower($search)) ||
                str_contains(strtolower($j['location']), strtolower($search)) ||
                str_contains(strtolower(implode(' ', $j['tags'])), strtolower($search))
            ));
        }
        if ($setup) {
            $jobs = array_values(array_filter($jobs, fn($j) => $j['setup'] === $setup));
        }

        return view('jobs.listings', compact('jobs', 'search', 'sort', 'setup'));
    }

    public function show(int $id)
    {
        $job = self::allJobs()[$id] ?? null;
        abort_if(!$job, 404);
        $related = array_values(array_filter(self::allJobs(), fn($j) => $j['id'] !== $id));
        $related = array_slice($related, 0, 3);
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
