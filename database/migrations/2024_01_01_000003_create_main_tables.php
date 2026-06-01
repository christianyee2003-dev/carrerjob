<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Companies
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('industry')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Job Listings
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('company_name');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->enum('setup', ['On-site', 'Hybrid', 'Remote'])->default('On-site');
            $table->enum('type', ['full-time', 'part-time', 'contract'])->default('full-time');
            $table->string('experience')->nullable();
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->text('tags')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Internships
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('company_name');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->enum('setup', ['On-site', 'Hybrid', 'Remote'])->default('On-site');
            $table->string('duration')->nullable();
            $table->integer('slots')->default(1);
            $table->string('experience')->default('No experience required');
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->text('tags')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Saved Jobs
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('intern_id')->nullable()->constrained('internships')->onDelete('cascade');
            $table->enum('type', ['job', 'internship']);
            $table->timestamp('created_at')->useCurrent();
        });

        // Applications
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('intern_id')->nullable()->constrained('internships')->onDelete('cascade');
            $table->enum('type', ['job', 'internship']);
            $table->enum('status', ['pending', 'under_review', 'accepted', 'rejected'])->default('pending');
            $table->text('cover_letter')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
        Schema::dropIfExists('saved_jobs');
        Schema::dropIfExists('internships');
        Schema::dropIfExists('job_listings');
        Schema::dropIfExists('companies');
    }
};
