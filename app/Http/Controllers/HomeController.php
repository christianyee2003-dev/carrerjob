<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // Add required keys so job-card partial works for internships
    private static function mapInternships(array $items): array
    {
        return array_values(array_map(fn($i) => array_merge($i, [
            'id'   => $i['slug'],
            'type' => 'internship',
        ]), $items));
    }

    public function landing()
    {
        $featuredInternships = array_slice(self::mapInternships(InternshipController::all()), 0, 3);
        $featuredJobs        = array_slice(array_values(JobController::allJobs()), 0, 3);
        $companies           = self::allCompanies();
        return view('landing', compact('featuredInternships', 'featuredJobs', 'companies'));
    }

    public function companies()
    {
        $companies   = self::allCompanies();
        $internships = self::mapInternships(InternshipController::all());
        $jobs        = array_values(JobController::allJobs());
        $allJobs     = array_merge($internships, $jobs);
        return view('companies', compact('companies', 'allJobs'));
    }

    public function dashboard()
    {
        $featuredInternships = array_slice(self::mapInternships(InternshipController::all()), 0, 3);
        $recommendedJobs     = array_slice(array_values(JobController::allJobs()), 0, 3);
        $savedCount          = count(session('saved_jobs', [])) + count(session('saved_internships', []));
        $appliedCount        = count(session('applied_jobs', [])) + count(session('applied_internships', []));
        return view('dashboard', compact('featuredInternships', 'recommendedJobs', 'savedCount', 'appliedCount'));
    }

    public static function allJobs(): array
    {
        return [
            [
                'id' => 1, 'title' => 'Frontend Developer Intern', 'company' => 'Google', 'logo' => 'google',
                'location' => 'Makati, PH', 'salary' => '₱15,000/mo', 'type' => 'internship', 'setup' => 'Hybrid',
                'posted' => '2 days ago', 'duration' => '6 months', 'experience' => 'No experience required',
                'tags' => ['HTML', 'CSS', 'JavaScript', 'React'],
                'description' => 'Join Google Philippines as a Frontend Developer Intern and work on cutting-edge web applications used by millions of users. You will collaborate with senior engineers and designers to build beautiful, performant user interfaces.',
                'responsibilities' => ['Build responsive UI components using React', 'Collaborate with the design team on new features', 'Write clean, maintainable, and well-documented code', 'Participate in daily stand-ups and code reviews', 'Optimize web performance and accessibility'],
                'requirements' => ['Currently enrolled in BS Computer Science or IT', 'Knowledge of HTML, CSS, and JavaScript', 'Familiarity with React or Vue.js', 'Strong problem-solving and communication skills', 'Portfolio or GitHub profile preferred'],
            ],
            [
                'id' => 2, 'title' => 'UI/UX Design Intern', 'company' => 'Meta', 'logo' => 'meta',
                'location' => 'BGC, Taguig', 'salary' => '₱12,000/mo', 'type' => 'internship', 'setup' => 'Remote',
                'posted' => '3 days ago', 'duration' => '3 months', 'experience' => 'No experience required',
                'tags' => ['Figma', 'Prototyping', 'User Research', 'Adobe XD'],
                'description' => 'Design beautiful and intuitive user interfaces for Meta products used by billions of people worldwide. You will work closely with product managers and engineers to create seamless user experiences.',
                'responsibilities' => ['Create wireframes, mockups, and interactive prototypes', 'Conduct user research and usability testing', 'Design UI components and maintain design systems', 'Present design concepts to stakeholders', 'Iterate based on user feedback and data'],
                'requirements' => ['Proficiency in Figma or Adobe XD', 'Portfolio showcasing design work', 'Understanding of UX principles and design thinking', 'Currently enrolled in Design, CS, or related course', 'Strong visual communication skills'],
            ],
            [
                'id' => 3, 'title' => 'Backend Developer Intern', 'company' => 'Amazon', 'logo' => 'amazon',
                'location' => 'Ortigas, Pasig', 'salary' => '₱18,000/mo', 'type' => 'internship', 'setup' => 'On-site',
                'posted' => '1 day ago', 'duration' => '6 months', 'experience' => 'No experience required',
                'tags' => ['PHP', 'Python', 'MySQL', 'REST API'],
                'description' => 'Work on scalable backend systems that power Amazon\'s e-commerce and cloud services. You will gain hands-on experience with distributed systems, databases, and API development.',
                'responsibilities' => ['Develop and maintain REST APIs', 'Optimize database queries and schemas', 'Write comprehensive unit and integration tests', 'Document code and technical specifications', 'Collaborate with frontend teams on API contracts'],
                'requirements' => ['Knowledge of PHP, Python, or Java', 'Basic understanding of SQL and databases', 'Familiarity with REST API concepts', 'Currently enrolled in CS, IT, or Engineering', 'Analytical mindset and attention to detail'],
            ],
            [
                'id' => 4, 'title' => 'Mobile Developer Intern', 'company' => 'Apple', 'logo' => 'apple',
                'location' => 'Makati, PH', 'salary' => '₱20,000/mo', 'type' => 'internship', 'setup' => 'Hybrid',
                'posted' => '4 days ago', 'duration' => '4 months', 'experience' => 'No experience required',
                'tags' => ['Swift', 'iOS', 'Xcode', 'SwiftUI'],
                'description' => 'Develop next-generation iOS applications for Apple\'s ecosystem. You will work with Swift and SwiftUI to build features that delight millions of Apple users.',
                'responsibilities' => ['Build and test iOS app features using Swift', 'Implement UI using SwiftUI and UIKit', 'Test on multiple device configurations', 'Fix bugs and improve app performance', 'Write technical documentation'],
                'requirements' => ['Knowledge of Swift programming language', 'Familiarity with Xcode IDE', 'Currently enrolled in CS or IT program', 'Understanding of iOS Human Interface Guidelines', 'Apple device for development preferred'],
            ],
            [
                'id' => 5, 'title' => 'Data Science Intern', 'company' => 'Netflix', 'logo' => 'netflix',
                'location' => 'Remote', 'salary' => '₱16,000/mo', 'type' => 'internship', 'setup' => 'Remote',
                'posted' => '5 days ago', 'duration' => '3 months', 'experience' => 'No experience required',
                'tags' => ['Python', 'Machine Learning', 'SQL', 'Tableau'],
                'description' => 'Help Netflix understand viewer behavior and improve content recommendations using data science and machine learning techniques.',
                'responsibilities' => ['Analyze large datasets to extract insights', 'Build and evaluate machine learning models', 'Create data visualizations and dashboards', 'Present findings to product and business teams', 'Collaborate with data engineers on pipelines'],
                'requirements' => ['Proficiency in Python and SQL', 'Knowledge of machine learning fundamentals', 'Experience with data visualization tools', 'Currently enrolled in Data Science, CS, or Statistics', 'Strong analytical and statistical skills'],
            ],
            [
                'id' => 6, 'title' => 'Software Engineer', 'company' => 'Microsoft', 'logo' => 'microsoft',
                'location' => 'Taguig, PH', 'salary' => '₱80,000/mo', 'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => '5 days ago', 'duration' => null, 'experience' => '2+ years',
                'tags' => ['C#', '.NET', 'Azure', 'TypeScript'],
                'description' => 'Build world-class software products at Microsoft Philippines. You will work on enterprise-grade applications and cloud services that empower organizations globally.',
                'responsibilities' => ['Design and implement scalable software features', 'Mentor junior developers and conduct code reviews', 'Participate in architecture and technical decisions', 'Ensure high code quality through testing and CI/CD', 'Collaborate with cross-functional teams globally'],
                'requirements' => ['3+ years of software development experience', 'Proficiency in C#, Java, or TypeScript', 'Experience with Azure or other cloud platforms', 'Strong understanding of software design patterns', 'Excellent communication and collaboration skills'],
            ],
            [
                'id' => 7, 'title' => 'Full Stack Developer', 'company' => 'Shopify', 'logo' => 'shopify',
                'location' => 'Remote', 'salary' => '₱95,000/mo', 'type' => 'full-time', 'setup' => 'Remote',
                'posted' => '1 week ago', 'duration' => null, 'experience' => '3+ years',
                'tags' => ['React', 'Node.js', 'GraphQL', 'Ruby'],
                'description' => 'Join Shopify and help millions of merchants build and grow their online businesses. You will work on the core platform that powers e-commerce worldwide.',
                'responsibilities' => ['Build full-stack features for the Shopify platform', 'Improve platform performance and scalability', 'Collaborate with product and design teams', 'Conduct thorough code reviews', 'Contribute to technical roadmap planning'],
                'requirements' => ['3+ years of full-stack development experience', 'Expertise in React and Node.js', 'Experience with GraphQL APIs', 'E-commerce or SaaS background preferred', 'Strong problem-solving skills'],
            ],
            [
                'id' => 8, 'title' => 'Data Analyst', 'company' => 'Netflix', 'logo' => 'netflix',
                'location' => 'Pasig, PH', 'salary' => '₱70,000/mo', 'type' => 'full-time', 'setup' => 'On-site',
                'posted' => '3 days ago', 'duration' => null, 'experience' => '1+ year',
                'tags' => ['Python', 'SQL', 'Tableau', 'Excel'],
                'description' => 'Analyze data to drive content strategy and business decisions at Netflix Philippines. You will work with massive datasets to uncover insights that shape what millions of viewers watch.',
                'responsibilities' => ['Analyze large datasets to identify trends and patterns', 'Build interactive dashboards and reports', 'Present data-driven insights to leadership', 'Develop predictive models for content performance', 'Partner with engineering on data infrastructure'],
                'requirements' => ['1+ year of data analysis experience', 'Proficiency in Python and SQL', 'Experience with Tableau or Power BI', 'Strong statistical analysis skills', 'Bachelor\'s degree in related field'],
            ],
            [
                'id' => 9, 'title' => 'DevOps Engineer', 'company' => 'Grab', 'logo' => 'grab',
                'location' => 'BGC, Taguig', 'salary' => '₱90,000/mo', 'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => '2 days ago', 'duration' => null, 'experience' => '2+ years',
                'tags' => ['AWS', 'Docker', 'Kubernetes', 'CI/CD'],
                'description' => 'Manage and scale the infrastructure powering Grab\'s super-app across Southeast Asia. You will ensure high availability, performance, and security of critical systems.',
                'responsibilities' => ['Design and manage cloud infrastructure on AWS/GCP', 'Automate deployment pipelines using CI/CD tools', 'Monitor system health and respond to incidents', 'Improve reliability and reduce operational toil', 'Collaborate with development teams on DevOps practices'],
                'requirements' => ['2+ years of DevOps or SRE experience', 'Hands-on experience with AWS or GCP', 'Proficiency with Docker and Kubernetes', 'Experience building CI/CD pipelines', 'Strong scripting skills (Bash, Python)'],
            ],
            [
                'id' => 10, 'title' => 'Product Manager', 'company' => 'Google', 'logo' => 'google',
                'location' => 'Makati, PH', 'salary' => '₱110,000/mo', 'type' => 'full-time', 'setup' => 'Hybrid',
                'posted' => '6 days ago', 'duration' => null, 'experience' => '3+ years',
                'tags' => ['Product Strategy', 'Agile', 'Analytics', 'Roadmapping'],
                'description' => 'Lead product strategy and execution for Google products in the Philippines market. You will define the vision, roadmap, and success metrics for products used by millions.',
                'responsibilities' => ['Define product vision, strategy, and roadmap', 'Work with engineering, design, and business teams', 'Analyze user data and market trends', 'Write detailed product requirements and specs', 'Drive product launches and go-to-market strategies'],
                'requirements' => ['3+ years of product management experience', 'Strong analytical and data-driven mindset', 'Experience with Agile/Scrum methodologies', 'Excellent communication and leadership skills', 'Technical background preferred'],
            ],
        ];
    }

    public static function allCompanies(): array
    {
        return [
            ['name' => 'Google',    'logo' => 'google',    'jobs' => 2, 'industry' => 'Technology'],
            ['name' => 'Meta',      'logo' => 'meta',      'jobs' => 1, 'industry' => 'Social Media'],
            ['name' => 'Amazon',    'logo' => 'amazon',    'jobs' => 1, 'industry' => 'E-Commerce'],
            ['name' => 'Microsoft', 'logo' => 'microsoft', 'jobs' => 1, 'industry' => 'Technology'],
            ['name' => 'Apple',     'logo' => 'apple',     'jobs' => 1, 'industry' => 'Technology'],
            ['name' => 'Netflix',   'logo' => 'netflix',   'jobs' => 2, 'industry' => 'Entertainment'],
            ['name' => 'Shopify',   'logo' => 'shopify',   'jobs' => 1, 'industry' => 'E-Commerce'],
            ['name' => 'Grab',      'logo' => 'grab',      'jobs' => 1, 'industry' => 'Super App'],
        ];
    }
}
