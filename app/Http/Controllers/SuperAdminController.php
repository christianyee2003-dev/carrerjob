<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // ── All static + registered users ────────────────────────────
    public static function allUsers(): array
    {
        $static = [
            ['id' => 1, 'name' => 'Super Admin',    'email' => 'superadmin@careerhub.com', 'role' => 'superadmin', 'status' => 'active',   'created_at' => 'Jan 01, 2024'],
            ['id' => 2, 'name' => 'Admin One',       'email' => 'admin1@careerhub.com',     'role' => 'admin',      'status' => 'active',   'created_at' => 'Jan 05, 2024'],
            ['id' => 3, 'name' => 'Juan dela Cruz',  'email' => 'student@careerhub.com',    'role' => 'student',    'status' => 'active',   'created_at' => 'Feb 10, 2024'],
            ['id' => 4, 'name' => 'HR Manager',      'email' => 'employer@careerhub.com',   'role' => 'employer',   'status' => 'active',   'created_at' => 'Feb 15, 2024'],
        ];
        // Merge session-registered users
        return array_merge($static, session('registered_users', []));
    }

    private function requireSuperAdmin()
    {
        if (session('user.role') !== 'superadmin') {
            abort(403, 'Access denied. Super Admins only.');
        }
    }

    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard()
    {
        $this->requireSuperAdmin();
        $users     = self::allUsers();
        $admins    = array_values(array_filter($users, fn($u) => $u['role'] === 'admin'));
        $students  = array_values(array_filter($users, fn($u) => $u['role'] === 'student'));
        $employers = array_values(array_filter($users, fn($u) => $u['role'] === 'employer'));
        $banned    = array_values(array_filter($users, fn($u) => ($u['status'] ?? 'active') === 'banned'));
        return view('superadmin.dashboard', compact('users', 'admins', 'students', 'employers', 'banned'));
    }

    // ── Create Admin ──────────────────────────────────────────────
    public function createAdmin()
    {
        $this->requireSuperAdmin();
        return view('superadmin.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        $this->requireSuperAdmin();
        $request->validate([
            'name'     => 'required|min:2',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $users   = session('registered_users', []);
        $allIds  = array_column(self::allUsers(), 'id');
        $newId   = count($allIds) ? max($allIds) + 1 : 10;

        $users[] = [
            'id'         => $newId,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => $request->password,
            'role'       => 'admin',
            'status'     => 'active',
            'created_at' => now()->format('M d, Y'),
            'created_by' => session('user.name'),
        ];
        session(['registered_users' => $users]);
        return redirect()->route('superadmin.dashboard')->with('success', 'Admin account created: ' . $request->email);
    }

    // ── Ban / Unban User ──────────────────────────────────────────
    public function banUser(int $id)
    {
        $this->requireSuperAdmin();
        $this->toggleStatus($id, 'banned');
        return back()->with('success', 'User has been banned.');
    }

    public function unbanUser(int $id)
    {
        $this->requireSuperAdmin();
        $this->toggleStatus($id, 'active');
        return back()->with('success', 'User has been unbanned.');
    }

    // ── Change Role ───────────────────────────────────────────────
    public function changeRole(Request $request, int $id)
    {
        $this->requireSuperAdmin();
        $request->validate(['role' => 'required|in:student,employer,admin']);
        $users = session('registered_users', []);
        foreach ($users as &$u) {
            if ($u['id'] === $id) {
                $u['role'] = $request->role;
            }
        }
        session(['registered_users' => $users]);
        return back()->with('success', 'User role updated.');
    }

    // ── Delete User ───────────────────────────────────────────────
    public function deleteUser(int $id)
    {
        $this->requireSuperAdmin();
        // Only allow deleting session-registered users (not static ones)
        $users = array_values(array_filter(session('registered_users', []), fn($u) => $u['id'] !== $id));
        session(['registered_users' => $users]);
        return back()->with('success', 'User deleted.');
    }

    // ── Reset Admin Password ──────────────────────────────────────
    public function resetPassword(Request $request, int $id)
    {
        $this->requireSuperAdmin();
        $request->validate(['password' => 'required|min:6']);
        $users = session('registered_users', []);
        foreach ($users as &$u) {
            if ($u['id'] === $id) {
                $u['password'] = $request->password;
            }
        }
        session(['registered_users' => $users]);
        return back()->with('success', 'Password reset successfully.');
    }

    // ── Toggle Admin Access ───────────────────────────────────────
    public function toggleAdmin(int $id)
    {
        $this->requireSuperAdmin();
        $users = session('registered_users', []);
        foreach ($users as &$u) {
            if ($u['id'] === $id) {
                $u['role'] = $u['role'] === 'admin' ? 'student' : 'admin';
            }
        }
        session(['registered_users' => $users]);
        return back()->with('success', 'Admin access toggled.');
    }

    // ── Private helper ────────────────────────────────────────────
    private function toggleStatus(int $id, string $status)
    {
        $users = session('registered_users', []);
        foreach ($users as &$u) {
            if ($u['id'] === $id) {
                $u['status'] = $status;
            }
        }
        session(['registered_users' => $users]);
    }
}
