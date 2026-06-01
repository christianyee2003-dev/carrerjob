-- ============================================================
-- CareerHub — Supabase SQL Setup
-- Run this in Supabase SQL Editor
-- ============================================================

-- ── 1. USERS TABLE ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id            BIGSERIAL PRIMARY KEY,
    name          VARCHAR(255) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password      VARCHAR(255) NOT NULL,
    role          VARCHAR(50)  NOT NULL DEFAULT 'student' CHECK (role IN ('superadmin','admin','student','employer')),
    status        VARCHAR(50)  NOT NULL DEFAULT 'active'  CHECK (status IN ('active','banned')),
    email_verified_at TIMESTAMP WITH TIME ZONE,
    remember_token VARCHAR(100),
    created_at    TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at    TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 2. EMAIL VERIFICATIONS TABLE ────────────────────────────
CREATE TABLE IF NOT EXISTS email_verifications (
    id         BIGSERIAL PRIMARY KEY,
    user_id    BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    token      VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP WITH TIME ZONE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 3. PASSWORD RESETS TABLE ─────────────────────────────────
CREATE TABLE IF NOT EXISTS password_resets (
    id         BIGSERIAL PRIMARY KEY,
    email      VARCHAR(255) NOT NULL,
    token      VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP WITH TIME ZONE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 4. COMPANIES TABLE ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS companies (
    id         BIGSERIAL PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    logo       VARCHAR(255),
    industry   VARCHAR(255),
    website    VARCHAR(255),
    description TEXT,
    posted_by  BIGINT REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 5. JOB LISTINGS TABLE ────────────────────────────────────
CREATE TABLE IF NOT EXISTS job_listings (
    id              BIGSERIAL PRIMARY KEY,
    title           VARCHAR(255) NOT NULL,
    company_id      BIGINT REFERENCES companies(id) ON DELETE CASCADE,
    company_name    VARCHAR(255) NOT NULL,
    location        VARCHAR(255) NOT NULL,
    salary          VARCHAR(255),
    setup           VARCHAR(50)  NOT NULL DEFAULT 'On-site' CHECK (setup IN ('On-site','Hybrid','Remote')),
    type            VARCHAR(50)  NOT NULL DEFAULT 'full-time' CHECK (type IN ('full-time','part-time','contract')),
    experience      VARCHAR(255),
    description     TEXT NOT NULL,
    responsibilities TEXT,
    requirements    TEXT,
    benefits        TEXT,
    tags            TEXT,
    posted_by       BIGINT REFERENCES users(id) ON DELETE SET NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at      TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 6. INTERNSHIPS TABLE ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS internships (
    id              BIGSERIAL PRIMARY KEY,
    slug            VARCHAR(255) NOT NULL UNIQUE,
    title           VARCHAR(255) NOT NULL,
    company_id      BIGINT REFERENCES companies(id) ON DELETE CASCADE,
    company_name    VARCHAR(255) NOT NULL,
    location        VARCHAR(255) NOT NULL,
    salary          VARCHAR(255),
    setup           VARCHAR(50)  NOT NULL DEFAULT 'On-site' CHECK (setup IN ('On-site','Hybrid','Remote')),
    duration        VARCHAR(100),
    slots           INT DEFAULT 1,
    experience      VARCHAR(255) DEFAULT 'No experience required',
    description     TEXT NOT NULL,
    responsibilities TEXT,
    requirements    TEXT,
    benefits        TEXT,
    tags            TEXT,
    posted_by       BIGINT REFERENCES users(id) ON DELETE SET NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at      TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 7. SAVED JOBS TABLE ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS saved_jobs (
    id         BIGSERIAL PRIMARY KEY,
    user_id    BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    job_id     BIGINT REFERENCES job_listings(id) ON DELETE CASCADE,
    intern_id  BIGINT REFERENCES internships(id) ON DELETE CASCADE,
    type       VARCHAR(20) NOT NULL CHECK (type IN ('job','internship')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    UNIQUE(user_id, job_id),
    UNIQUE(user_id, intern_id)
);

-- ── 8. APPLICATIONS TABLE ────────────────────────────────────
CREATE TABLE IF NOT EXISTS applications (
    id          BIGSERIAL PRIMARY KEY,
    user_id     BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    job_id      BIGINT REFERENCES job_listings(id) ON DELETE CASCADE,
    intern_id   BIGINT REFERENCES internships(id) ON DELETE CASCADE,
    type        VARCHAR(20) NOT NULL CHECK (type IN ('job','internship')),
    status      VARCHAR(50) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','under_review','accepted','rejected')),
    cover_letter TEXT,
    applied_at  TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at  TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- ── 9. SESSIONS TABLE (Laravel) ──────────────────────────────
CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR(255) PRIMARY KEY,
    user_id       BIGINT REFERENCES users(id) ON DELETE CASCADE,
    ip_address    VARCHAR(45),
    user_agent    TEXT,
    payload       TEXT NOT NULL,
    last_activity INT  NOT NULL
);

-- ── 10. CACHE TABLE (Laravel) ────────────────────────────────
CREATE TABLE IF NOT EXISTS cache (
    key        VARCHAR(255) PRIMARY KEY,
    value      TEXT NOT NULL,
    expiration INT  NOT NULL
);

CREATE TABLE IF NOT EXISTS cache_locks (
    key        VARCHAR(255) PRIMARY KEY,
    owner      VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

-- ============================================================
-- INDEXES
-- ============================================================
CREATE INDEX IF NOT EXISTS idx_users_email          ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_role           ON users(role);
CREATE INDEX IF NOT EXISTS idx_job_listings_type    ON job_listings(type);
CREATE INDEX IF NOT EXISTS idx_job_listings_setup   ON job_listings(setup);
CREATE INDEX IF NOT EXISTS idx_job_listings_active  ON job_listings(is_active);
CREATE INDEX IF NOT EXISTS idx_internships_slug     ON internships(slug);
CREATE INDEX IF NOT EXISTS idx_internships_active   ON internships(is_active);
CREATE INDEX IF NOT EXISTS idx_applications_user    ON applications(user_id);
CREATE INDEX IF NOT EXISTS idx_applications_status  ON applications(status);
CREATE INDEX IF NOT EXISTS idx_saved_jobs_user      ON saved_jobs(user_id);
CREATE INDEX IF NOT EXISTS idx_sessions_last        ON sessions(last_activity);

-- ============================================================
-- ROW LEVEL SECURITY (RLS)
-- ============================================================
ALTER TABLE users              ENABLE ROW LEVEL SECURITY;
ALTER TABLE job_listings       ENABLE ROW LEVEL SECURITY;
ALTER TABLE internships        ENABLE ROW LEVEL SECURITY;
ALTER TABLE companies          ENABLE ROW LEVEL SECURITY;
ALTER TABLE saved_jobs         ENABLE ROW LEVEL SECURITY;
ALTER TABLE applications       ENABLE ROW LEVEL SECURITY;
ALTER TABLE email_verifications ENABLE ROW LEVEL SECURITY;

-- Allow Laravel backend (service role) full access
CREATE POLICY "service_role_all_users"       ON users              FOR ALL USING (true);
CREATE POLICY "service_role_all_jobs"        ON job_listings       FOR ALL USING (true);
CREATE POLICY "service_role_all_internships" ON internships        FOR ALL USING (true);
CREATE POLICY "service_role_all_companies"   ON companies          FOR ALL USING (true);
CREATE POLICY "service_role_all_saved"       ON saved_jobs         FOR ALL USING (true);
CREATE POLICY "service_role_all_apps"        ON applications       FOR ALL USING (true);
CREATE POLICY "service_role_all_verif"       ON email_verifications FOR ALL USING (true);

-- ============================================================
-- AUTO-UPDATE updated_at TRIGGER
-- ============================================================
CREATE OR REPLACE FUNCTION update_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_users_updated        BEFORE UPDATE ON users        FOR EACH ROW EXECUTE FUNCTION update_updated_at();
CREATE TRIGGER trg_jobs_updated         BEFORE UPDATE ON job_listings  FOR EACH ROW EXECUTE FUNCTION update_updated_at();
CREATE TRIGGER trg_internships_updated  BEFORE UPDATE ON internships   FOR EACH ROW EXECUTE FUNCTION update_updated_at();
CREATE TRIGGER trg_companies_updated    BEFORE UPDATE ON companies     FOR EACH ROW EXECUTE FUNCTION update_updated_at();
CREATE TRIGGER trg_applications_updated BEFORE UPDATE ON applications  FOR EACH ROW EXECUTE FUNCTION update_updated_at();

-- ============================================================
-- SEED DATA
-- ============================================================

-- Users (passwords are bcrypt hashed — 'password' = $2y$12$...)
INSERT INTO users (name, email, password, role, status, email_verified_at) VALUES
('Super Admin',   'superadmin@careerhub.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 'active', NOW()),
('Admin One',     'admin1@careerhub.com',     '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',      'active', NOW()),
('Juan dela Cruz','student@careerhub.com',    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student',    'active', NOW()),
('HR Manager',    'employer@careerhub.com',   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employer',   'active', NOW())
ON CONFLICT (email) DO NOTHING;

-- Companies
INSERT INTO companies (name, logo, industry, posted_by) VALUES
('Google',    'google',    'Technology',    2),
('Meta',      'meta',      'Social Media',  2),
('Amazon',    'amazon',    'E-Commerce',    2),
('Microsoft', 'microsoft', 'Technology',    2),
('Apple',     'apple',     'Technology',    2),
('Netflix',   'netflix',   'Entertainment', 2),
('Shopify',   'shopify',   'E-Commerce',    2),
('Grab',      'grab',      'Super App',     2)
ON CONFLICT DO NOTHING;

-- Job Listings
INSERT INTO job_listings (title, company_name, location, salary, setup, type, experience, description, responsibilities, requirements, benefits, tags, posted_by) VALUES
('Frontend Developer',  'Google',    'Makati, PH',    '₱75,000/mo',  'Hybrid',   'full-time', '2+ years', 'Build products used by billions at Google Philippines.', 'Build React apps|Collaborate with designers|Write tests', 'React expertise|TypeScript|2+ years experience', 'Health insurance|Stock options|Learning budget', 'React,TypeScript,CSS,GraphQL', 2),
('Data Scientist',      'Netflix',   'Pasig, PH',     '₱95,000/mo',  'Hybrid',   'full-time', '2+ years', 'Drive content strategy using data science at Netflix.',  'Build ML models|Analyze viewer data|A/B testing',        'Python expertise|SQL|ML knowledge',              'Netflix subscription|Remote-friendly|Bonuses',  'Python,ML,SQL,TensorFlow', 2),
('Software Engineer',   'Microsoft', 'Taguig, PH',    '₱80,000/mo',  'Hybrid',   'full-time', '2+ years', 'Build enterprise software at Microsoft Philippines.',    'Design features|Build Azure services|Mentor juniors',    'C# or TypeScript|Azure experience|2+ years',     'Azure certification|Health insurance|Bonus',    'C#,.NET,Azure,TypeScript', 2),
('Backend Engineer',    'Amazon',    'Ortigas, PH',   '₱85,000/mo',  'On-site',  'full-time', '3+ years', 'Scale backend systems powering Amazon globally.',        'Build microservices|Architect AWS infra|Lead reviews',   'Java or Python|AWS|3+ years',                    'AWS credits|Health insurance|Stock vesting',    'Java,AWS,Microservices,DynamoDB', 2),
('DevOps Engineer',     'Grab',      'BGC, Taguig',   '₱90,000/mo',  'Hybrid',   'full-time', '2+ years', 'Manage infrastructure for Grab super-app.',              'Manage cloud infra|Build CI/CD|Monitor systems',         'AWS or GCP|Docker|Kubernetes',                   'Grab credits|Health insurance|Bonuses',         'AWS,Docker,Kubernetes,Terraform', 2),
('Full Stack Developer','Shopify',   'Remote',        '₱95,000/mo',  'Remote',   'full-time', '3+ years', 'Help merchants build online businesses at Shopify.',     'Build full-stack features|Design GraphQL APIs',          'React|Node.js|GraphQL|3+ years',                 'Fully remote|Home office stipend|Stock options','React,Node.js,GraphQL,Ruby', 2)
ON CONFLICT DO NOTHING;

-- Internships
INSERT INTO internships (slug, title, company_name, location, salary, setup, duration, slots, description, responsibilities, requirements, benefits, tags, posted_by) VALUES
('google',    'Frontend Developer Intern', 'Google',    'Makati, PH',    '₱15,000/mo', 'Hybrid',   '6 months', 5, 'Work on cutting-edge web apps at Google Philippines.', 'Build React UI|Collaborate with designers|Code reviews', 'HTML/CSS/JS knowledge|CS student|React familiarity', 'Mentorship|Certificate|Transportation allowance', 'HTML,CSS,JavaScript,React', 2),
('microsoft', 'Software Engineering Intern','Microsoft','Taguig, PH',   '₱18,000/mo', 'Hybrid',   '6 months', 3, 'Contribute to enterprise products at Microsoft.',      'Develop features|Write tests|Participate in sprints',   'C# or Python knowledge|CS student|Git skills',       'Azure voucher|Mentorship|Health insurance',       'C#,.NET,Azure,TypeScript', 2),
('amazon',    'Backend Developer Intern',  'Amazon',    'Ortigas, PH',   '₱18,000/mo', 'On-site',  '6 months', 4, 'Work on scalable backend systems at Amazon.',          'Develop REST APIs|Optimize databases|Write tests',      'PHP or Python|SQL basics|CS student',                'AWS credits|On-site meals|Possible full-time',    'PHP,Python,MySQL,REST API', 2),
('meta',      'UI/UX Design Intern',       'Meta',      'BGC, Taguig',   '₱12,000/mo', 'Remote',   '3 months', 2, 'Design interfaces for Meta products used by billions.','Create wireframes|User research|Design systems',        'Figma proficiency|Design portfolio|CS or Design',    'Remote work|Equipment provided|Mentorship',       'Figma,Prototyping,User Research,Adobe XD', 2),
('apple',     'Mobile Developer Intern',   'Apple',     'Makati, PH',    '₱20,000/mo', 'Hybrid',   '4 months', 2, 'Develop iOS apps for Apple ecosystem.',                'Build iOS features|Test on devices|Fix bugs',           'Swift knowledge|Xcode familiarity|CS student',       'MacBook Pro|Apple dev account|Mentorship',        'Swift,iOS,Xcode,SwiftUI', 2),
('netflix',   'Data Science Intern',       'Netflix',   'Remote',        '₱16,000/mo', 'Remote',   '3 months', 3, 'Help Netflix improve content recommendations.',        'Analyze datasets|Build ML models|Create dashboards',    'Python and SQL|ML fundamentals|Data Science student','Netflix subscription|Flexible hours|Mentorship',  'Python,Machine Learning,SQL,Tableau', 2)
ON CONFLICT (slug) DO NOTHING;

-- ============================================================
-- USEFUL QUERIES FOR SQL EDITOR
-- ============================================================

-- View all users:
-- SELECT id, name, email, role, status, created_at FROM users ORDER BY id;

-- View all jobs:
-- SELECT id, title, company_name, salary, setup, type, is_active FROM job_listings ORDER BY id;

-- View all internships:
-- SELECT id, slug, title, company_name, salary, setup, duration FROM internships ORDER BY id;

-- View all applications:
-- SELECT a.id, u.name, u.email, a.type, a.status, a.applied_at FROM applications a JOIN users u ON a.user_id = u.id ORDER BY a.applied_at DESC;

-- Ban a user:
-- UPDATE users SET status = 'banned' WHERE email = 'user@example.com';

-- Make someone admin:
-- UPDATE users SET role = 'admin' WHERE email = 'user@example.com';

-- Delete a job:
-- DELETE FROM job_listings WHERE id = 1;
