<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternshipController extends Controller
{
    // All internship data keyed by slug
    public static function all(): array
    {
        // Merge static internships + admin-posted internships from session
        $adminInternships = session('admin_internships', []);
        return array_merge([
            'google' => [
                'slug'            => 'google',
                'company'         => 'Google',
                'logo'            => 'google',
                'title'           => 'Frontend Developer Intern',
                'location'        => 'Makati, Philippines',
                'salary'          => '₱15,000 / month',
                'setup'           => 'Hybrid',
                'duration'        => '6 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 2 days ago',
                'slots'           => 5,
                'tags'            => ['HTML', 'CSS', 'JavaScript', 'React'],
                'description'     => 'Join Google Philippines as a Frontend Developer Intern and work on cutting-edge web applications used by millions of users worldwide. You will collaborate with senior engineers and designers to build beautiful, performant, and accessible user interfaces that make a real impact.',
                'responsibilities'=> [
                    'Build responsive UI components using React and modern CSS',
                    'Collaborate with the design team to implement new features',
                    'Write clean, maintainable, and well-documented code',
                    'Participate in daily stand-ups and sprint planning',
                    'Conduct code reviews and provide constructive feedback',
                    'Optimize web performance and ensure accessibility standards',
                ],
                'requirements'    => [
                    'Currently enrolled in BS Computer Science, IT, or related field',
                    'Solid knowledge of HTML5, CSS3, and JavaScript (ES6+)',
                    'Familiarity with React, Vue.js, or Angular',
                    'Understanding of responsive design and cross-browser compatibility',
                    'Strong problem-solving and communication skills',
                    'Portfolio or GitHub profile is a plus',
                ],
                'benefits'        => ['Mentorship from senior engineers', 'Certificate of completion', 'Possible regularization', 'Free meals on-site', 'Transportation allowance'],
            ],
            'microsoft' => [
                'slug'            => 'microsoft',
                'company'         => 'Microsoft',
                'logo'            => 'microsoft',
                'title'           => 'Software Engineering Intern',
                'location'        => 'Taguig, Philippines',
                'salary'          => '₱18,000 / month',
                'setup'           => 'Hybrid',
                'duration'        => '6 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 1 day ago',
                'slots'           => 3,
                'tags'            => ['C#', '.NET', 'Azure', 'TypeScript'],
                'description'     => 'Join Microsoft Philippines as a Software Engineering Intern and contribute to enterprise-grade products used by organizations worldwide. You will work alongside world-class engineers on real projects that ship to millions of customers.',
                'responsibilities'=> [
                    'Develop and test software features in C# and TypeScript',
                    'Work on Azure cloud services and integrations',
                    'Participate in agile ceremonies and sprint reviews',
                    'Write unit tests and maintain code quality standards',
                    'Collaborate with cross-functional teams across time zones',
                    'Document technical designs and implementation details',
                ],
                'requirements'    => [
                    'Currently enrolled in BS Computer Science or Software Engineering',
                    'Knowledge of C#, Java, Python, or TypeScript',
                    'Basic understanding of cloud computing concepts',
                    'Familiarity with Git and version control workflows',
                    'Strong analytical and problem-solving skills',
                    'Good written and verbal communication in English',
                ],
                'benefits'        => ['Azure certification voucher', 'Mentorship program', 'Hybrid work setup', 'Learning & development budget', 'Health insurance'],
            ],
            'amazon' => [
                'slug'            => 'amazon',
                'company'         => 'Amazon',
                'logo'            => 'amazon',
                'title'           => 'Backend Developer Intern',
                'location'        => 'Ortigas, Pasig',
                'salary'          => '₱18,000 / month',
                'setup'           => 'On-site',
                'duration'        => '6 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 1 day ago',
                'slots'           => 4,
                'tags'            => ['PHP', 'Python', 'MySQL', 'REST API'],
                'description'     => 'Work on scalable backend systems that power Amazon\'s e-commerce and AWS cloud services. You will gain hands-on experience with distributed systems, high-performance databases, and API development at massive scale.',
                'responsibilities'=> [
                    'Design and develop RESTful APIs using Python or PHP',
                    'Optimize database queries and data models in MySQL/PostgreSQL',
                    'Write comprehensive unit and integration tests',
                    'Document APIs and technical specifications',
                    'Collaborate with frontend teams on API contracts',
                    'Participate in on-call rotations and incident response',
                ],
                'requirements'    => [
                    'Knowledge of PHP, Python, or Java backend development',
                    'Basic understanding of relational databases and SQL',
                    'Familiarity with REST API design principles',
                    'Currently enrolled in CS, IT, or Engineering program',
                    'Analytical mindset and strong attention to detail',
                    'Ability to work in a fast-paced environment',
                ],
                'benefits'        => ['AWS credits for learning', 'On-site meals', 'Transportation allowance', 'Mentorship from senior engineers', 'Possible full-time offer'],
            ],
            'meta' => [
                'slug'            => 'meta',
                'company'         => 'Meta',
                'logo'            => 'meta',
                'title'           => 'UI/UX Design Intern',
                'location'        => 'BGC, Taguig',
                'salary'          => '₱12,000 / month',
                'setup'           => 'Remote',
                'duration'        => '3 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 3 days ago',
                'slots'           => 2,
                'tags'            => ['Figma', 'Prototyping', 'User Research', 'Adobe XD'],
                'description'     => 'Design beautiful and intuitive user interfaces for Meta products used by billions of people worldwide. You will work closely with product managers and engineers to create seamless user experiences across Facebook, Instagram, and WhatsApp.',
                'responsibilities'=> [
                    'Create wireframes, mockups, and interactive prototypes in Figma',
                    'Conduct user research, interviews, and usability testing',
                    'Design and maintain UI component libraries and design systems',
                    'Present design concepts and rationale to stakeholders',
                    'Iterate designs based on user feedback and A/B test results',
                    'Collaborate with engineers to ensure pixel-perfect implementation',
                ],
                'requirements'    => [
                    'Proficiency in Figma or Adobe XD',
                    'Portfolio showcasing at least 2 design projects',
                    'Understanding of UX principles and design thinking methodology',
                    'Currently enrolled in Design, CS, or related course',
                    'Strong visual communication and presentation skills',
                    'Familiarity with accessibility standards is a plus',
                ],
                'benefits'        => ['Remote work setup', 'Equipment provided', 'Design tool subscriptions', 'Mentorship from senior designers', 'Certificate of completion'],
            ],
            'apple' => [
                'slug'            => 'apple',
                'company'         => 'Apple',
                'logo'            => 'apple',
                'title'           => 'Mobile Developer Intern',
                'location'        => 'Makati, Philippines',
                'salary'          => '₱20,000 / month',
                'setup'           => 'Hybrid',
                'duration'        => '4 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 4 days ago',
                'slots'           => 2,
                'tags'            => ['Swift', 'iOS', 'Xcode', 'SwiftUI'],
                'description'     => 'Develop next-generation iOS applications for Apple\'s ecosystem. You will work with Swift and SwiftUI to build features that delight millions of Apple users across iPhone, iPad, and Mac platforms.',
                'responsibilities'=> [
                    'Build and test iOS app features using Swift and SwiftUI',
                    'Implement UI components following Apple Human Interface Guidelines',
                    'Test on multiple device configurations and iOS versions',
                    'Fix bugs and improve app performance and memory usage',
                    'Write technical documentation and unit tests',
                    'Participate in design reviews and sprint retrospectives',
                ],
                'requirements'    => [
                    'Knowledge of Swift programming language',
                    'Familiarity with Xcode IDE and iOS SDK',
                    'Currently enrolled in CS or IT program',
                    'Understanding of iOS Human Interface Guidelines',
                    'Apple device (iPhone or Mac) for development preferred',
                    'Experience with Git version control',
                ],
                'benefits'        => ['MacBook Pro provided', 'Apple developer account', 'Mentorship program', 'Hybrid work setup', 'Possible regularization'],
            ],
            'netflix' => [
                'slug'            => 'netflix',
                'company'         => 'Netflix',
                'logo'            => 'netflix',
                'title'           => 'Data Science Intern',
                'location'        => 'Remote',
                'salary'          => '₱16,000 / month',
                'setup'           => 'Remote',
                'duration'        => '3 months',
                'experience'      => 'No experience required',
                'posted'          => 'Posted 5 days ago',
                'slots'           => 3,
                'tags'            => ['Python', 'Machine Learning', 'SQL', 'Tableau'],
                'description'     => 'Help Netflix understand viewer behavior and improve content recommendations using data science and machine learning. You will work with petabytes of data to uncover insights that shape what 260 million subscribers watch every day.',
                'responsibilities'=> [
                    'Analyze large datasets to extract actionable insights',
                    'Build, train, and evaluate machine learning models',
                    'Create interactive data visualizations and dashboards',
                    'Present findings to product and business stakeholders',
                    'Collaborate with data engineers on ETL pipelines',
                    'Document methodologies and model performance metrics',
                ],
                'requirements'    => [
                    'Proficiency in Python (pandas, numpy, scikit-learn)',
                    'Strong SQL skills for data querying and analysis',
                    'Knowledge of machine learning fundamentals',
                    'Experience with Tableau, Power BI, or similar tools',
                    'Currently enrolled in Data Science, CS, or Statistics',
                    'Strong analytical and statistical reasoning skills',
                ],
                'benefits'        => ['Full remote work', 'Netflix subscription', 'Learning stipend', 'Flexible hours', 'Mentorship from data scientists'],
            ],
        ] + $adminInternships);
    }

    public function index()
    {
        $internships = array_values(self::all());
        return view('internships.index', compact('internships'));
    }

    public function show(string $company)
    {
        $internship = self::all()[$company] ?? null;
        abort_if(!$internship, 404);
        $others = array_values(array_filter(self::all(), fn($i) => $i['slug'] !== $company));
        return view('internships.show', compact('internship', 'others'));
    }
}
