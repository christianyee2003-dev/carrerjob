<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────
        DB::table('users')->upsert([
            ['name' => 'Super Admin',    'email' => 'superadmin@careerhub.com', 'password' => Hash::make('super123'),  'role' => 'superadmin', 'status' => 'active', 'email_verified_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin One',      'email' => 'admin1@careerhub.com',     'password' => Hash::make('admin123'),  'role' => 'admin',      'status' => 'active', 'email_verified_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Juan dela Cruz', 'email' => 'student@careerhub.com',    'password' => Hash::make('password'),  'role' => 'student',    'status' => 'active', 'email_verified_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Manager',     'email' => 'employer@careerhub.com',   'password' => Hash::make('password'),  'role' => 'employer',   'status' => 'active', 'email_verified_at' => now(), 'created_at' => now(), 'updated_at' => now()],
        ], ['email'], ['name', 'password', 'role', 'updated_at']);

        $adminId = DB::table('users')->where('email', 'admin1@careerhub.com')->value('id');

        // ── Companies ──────────────────────────────────────────
        $companyData = [
            ['name' => 'Google',    'logo' => 'google',    'industry' => 'Technology'],
            ['name' => 'Meta',      'logo' => 'meta',      'industry' => 'Social Media'],
            ['name' => 'Amazon',    'logo' => 'amazon',    'industry' => 'E-Commerce'],
            ['name' => 'Microsoft', 'logo' => 'microsoft', 'industry' => 'Technology'],
            ['name' => 'Apple',     'logo' => 'apple',     'industry' => 'Technology'],
            ['name' => 'Netflix',   'logo' => 'netflix',   'industry' => 'Entertainment'],
            ['name' => 'Shopify',   'logo' => 'shopify',   'industry' => 'E-Commerce'],
            ['name' => 'Grab',      'logo' => 'grab',      'industry' => 'Super App'],
        ];
        foreach ($companyData as &$c) {
            $c['posted_by']  = $adminId;
            $c['created_at'] = now();
            $c['updated_at'] = now();
        }
        DB::table('companies')->upsert($companyData, ['name'], ['logo', 'industry', 'updated_at']);

        $companies = DB::table('companies')->pluck('id', 'name');

        // ── Job Listings ───────────────────────────────────────
        $jobs = [
            ['title'=>'Frontend Developer',   'company_name'=>'Google',    'location'=>'Makati, PH',   'salary'=>'₱75,000/mo', 'setup'=>'Hybrid',  'experience'=>'2+ years', 'tags'=>'React,TypeScript,CSS,GraphQL',       'description'=>'Build products used by billions at Google Philippines.'],
            ['title'=>'Data Scientist',        'company_name'=>'Netflix',   'location'=>'Pasig, PH',    'salary'=>'₱95,000/mo', 'setup'=>'Hybrid',  'experience'=>'2+ years', 'tags'=>'Python,ML,SQL,TensorFlow',           'description'=>'Drive content strategy using data science at Netflix.'],
            ['title'=>'Software Engineer',     'company_name'=>'Microsoft', 'location'=>'Taguig, PH',   'salary'=>'₱80,000/mo', 'setup'=>'Hybrid',  'experience'=>'2+ years', 'tags'=>'C#,.NET,Azure,TypeScript',           'description'=>'Build enterprise software at Microsoft Philippines.'],
            ['title'=>'Backend Engineer',      'company_name'=>'Amazon',    'location'=>'Ortigas, PH',  'salary'=>'₱85,000/mo', 'setup'=>'On-site', 'experience'=>'3+ years', 'tags'=>'Java,AWS,Microservices,DynamoDB',    'description'=>'Scale backend systems powering Amazon globally.'],
            ['title'=>'DevOps Engineer',       'company_name'=>'Grab',      'location'=>'BGC, Taguig',  'salary'=>'₱90,000/mo', 'setup'=>'Hybrid',  'experience'=>'2+ years', 'tags'=>'AWS,Docker,Kubernetes,Terraform',    'description'=>'Manage infrastructure for Grab super-app.'],
            ['title'=>'Full Stack Developer',  'company_name'=>'Shopify',   'location'=>'Remote',       'salary'=>'₱95,000/mo', 'setup'=>'Remote',  'experience'=>'3+ years', 'tags'=>'React,Node.js,GraphQL,Ruby',         'description'=>'Help merchants build online businesses at Shopify.'],
        ];
        foreach ($jobs as &$j) {
            $j['company_id']  = $companies[$j['company_name']] ?? null;
            $j['type']        = 'full-time';
            $j['posted_by']   = $adminId;
            $j['is_active']   = true;
            $j['created_at']  = now();
            $j['updated_at']  = now();
        }
        DB::table('job_listings')->upsert($jobs, ['title', 'company_name'], ['salary', 'setup', 'updated_at']);

        // ── Internships ────────────────────────────────────────
        $internships = [
            ['slug'=>'google',    'title'=>'Frontend Developer Intern',  'company_name'=>'Google',    'location'=>'Makati, PH',   'salary'=>'₱15,000/mo', 'setup'=>'Hybrid',  'duration'=>'6 months', 'slots'=>5, 'tags'=>'HTML,CSS,JavaScript,React',          'description'=>'Work on cutting-edge web apps at Google Philippines.'],
            ['slug'=>'microsoft', 'title'=>'Software Engineering Intern', 'company_name'=>'Microsoft', 'location'=>'Taguig, PH',   'salary'=>'₱18,000/mo', 'setup'=>'Hybrid',  'duration'=>'6 months', 'slots'=>3, 'tags'=>'C#,.NET,Azure,TypeScript',            'description'=>'Contribute to enterprise products at Microsoft.'],
            ['slug'=>'amazon',    'title'=>'Backend Developer Intern',    'company_name'=>'Amazon',    'location'=>'Ortigas, PH',  'salary'=>'₱18,000/mo', 'setup'=>'On-site', 'duration'=>'6 months', 'slots'=>4, 'tags'=>'PHP,Python,MySQL,REST API',           'description'=>'Work on scalable backend systems at Amazon.'],
            ['slug'=>'meta',      'title'=>'UI/UX Design Intern',         'company_name'=>'Meta',      'location'=>'BGC, Taguig',  'salary'=>'₱12,000/mo', 'setup'=>'Remote',  'duration'=>'3 months', 'slots'=>2, 'tags'=>'Figma,Prototyping,User Research',      'description'=>'Design interfaces for Meta products used by billions.'],
            ['slug'=>'apple',     'title'=>'Mobile Developer Intern',     'company_name'=>'Apple',     'location'=>'Makati, PH',   'salary'=>'₱20,000/mo', 'setup'=>'Hybrid',  'duration'=>'4 months', 'slots'=>2, 'tags'=>'Swift,iOS,Xcode,SwiftUI',             'description'=>'Develop iOS apps for Apple ecosystem.'],
            ['slug'=>'netflix',   'title'=>'Data Science Intern',         'company_name'=>'Netflix',   'location'=>'Remote',       'salary'=>'₱16,000/mo', 'setup'=>'Remote',  'duration'=>'3 months', 'slots'=>3, 'tags'=>'Python,Machine Learning,SQL,Tableau', 'description'=>'Help Netflix improve content recommendations.'],
        ];
        foreach ($internships as &$i) {
            $i['company_id']  = $companies[$i['company_name']] ?? null;
            $i['experience']  = 'No experience required';
            $i['posted_by']   = $adminId;
            $i['is_active']   = true;
            $i['created_at']  = now();
            $i['updated_at']  = now();
        }
        DB::table('internships')->upsert($internships, ['slug'], ['title', 'salary', 'updated_at']);
    }
}
