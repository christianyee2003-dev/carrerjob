@extends('layouts.app')
@section('title', 'Super Admin Panel')

@section('content')

{{-- Header --}}
<div style="background:linear-gradient(135deg,#0f172a,#1e293b)" class="text-white py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:12px;display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-crown text-white fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Super Admin Panel</h4>
                    <p class="mb-0 opacity-75 small">Logged in as <strong>{{ session('user.name') }}</strong></p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('superadmin.create-admin') }}" class="btn btn-warning rounded-pill px-4 fw-semibold">
                    <i class="fas fa-user-shield me-2"></i>Create Admin
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-3">
                    <i class="fas fa-tools me-1"></i>Admin Panel
                </a>
                <a href="{{ route('landing') }}" class="btn btn-outline-light rounded-pill px-3">
                    <i class="fas fa-eye me-1"></i>View Site
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    @if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-2">
        <i class="fas fa-check-circle fs-5"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-5">
        @foreach([
            ['icon'=>'fas fa-users',       'color'=>'primary', 'value'=>count($users),     'label'=>'Total Users'],
            ['icon'=>'fas fa-user-shield', 'color'=>'warning', 'value'=>count($admins),    'label'=>'Admins'],
            ['icon'=>'fas fa-graduation-cap','color'=>'success','value'=>count($students),  'label'=>'Students'],
            ['icon'=>'fas fa-building',    'color'=>'info',    'value'=>count($employers),  'label'=>'Employers'],
            ['icon'=>'fas fa-ban',         'color'=>'danger',  'value'=>count($banned),     'label'=>'Banned'],
        ] as $s)
        <div class="col-6 col-md-4 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="stat-icon bg-{{ $s['color'] }}-soft text-{{ $s['color'] }} rounded-3 mx-auto mb-2">
                    <i class="{{ $s['icon'] }}"></i>
                </div>
                <div class="fw-bold fs-3">{{ $s['value'] }}</div>
                <div class="text-muted small">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs border-0 mb-4 gap-1">
        <li class="nav-item">
            <a class="nav-link active rounded-pill px-4" data-bs-toggle="tab" href="#tabAll">
                <i class="fas fa-users me-1"></i>All Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4" data-bs-toggle="tab" href="#tabAdmins">
                <i class="fas fa-user-shield me-1"></i>Admins
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4" data-bs-toggle="tab" href="#tabBanned">
                <i class="fas fa-ban me-1"></i>Banned
            </a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ALL USERS --}}
        <div class="tab-pane fade show active" id="tabAll">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr class="{{ ($u['status'] ?? 'active') === 'banned' ? 'table-danger' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:.85rem;background:{{ $u['role'] === 'superadmin' ? 'linear-gradient(135deg,#f59e0b,#d97706)' : ($u['role'] === 'admin' ? 'linear-gradient(135deg,#4f46e5,#818cf8)' : 'linear-gradient(135deg,#10b981,#059669)') }}">
                                            {{ strtoupper(substr($u['name'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">{{ $u['name'] }}</div>
                                            <div style="font-size:10px" class="text-muted">ID: {{ $u['id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $u['email'] }}</td>
                                <td>
                                    @if($u['role'] === 'superadmin')
                                        <span class="badge rounded-pill bg-warning text-dark"><i class="fas fa-crown me-1"></i>Super Admin</span>
                                    @elseif($u['role'] === 'admin')
                                        <span class="badge rounded-pill bg-primary-soft text-primary"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                    @elseif($u['role'] === 'employer')
                                        <span class="badge rounded-pill bg-info-soft text-info"><i class="fas fa-building me-1"></i>Employer</span>
                                    @else
                                        <span class="badge rounded-pill bg-success-soft text-success"><i class="fas fa-graduation-cap me-1"></i>Student</span>
                                    @endif
                                </td>
                                <td>
                                    @if(($u['status'] ?? 'active') === 'banned')
                                        <span class="badge rounded-pill bg-danger"><i class="fas fa-ban me-1"></i>Banned</span>
                                    @else
                                        <span class="badge rounded-pill bg-success"><i class="fas fa-check me-1"></i>Active</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $u['created_at'] }}</td>
                                <td class="text-end pe-4">
                                    @if($u['role'] !== 'superadmin')
                                    <div class="d-flex gap-1 justify-content-end flex-wrap">
                                        {{-- Ban / Unban --}}
                                        @if(($u['status'] ?? 'active') === 'banned')
                                        <form action="{{ route('superadmin.unban', $u['id']) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm rounded-pill px-2" title="Unban">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('superadmin.ban', $u['id']) }}" method="POST" onsubmit="return confirm('Ban this user?')">
                                            @csrf
                                            <button class="btn btn-warning btn-sm rounded-pill px-2" title="Ban">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Toggle Admin --}}
                                        @if(isset($u['created_by']))
                                        <form action="{{ route('superadmin.toggle-admin', $u['id']) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-{{ $u['role'] === 'admin' ? 'secondary' : 'primary' }} btn-sm rounded-pill px-2"
                                                    title="{{ $u['role'] === 'admin' ? 'Remove Admin' : 'Make Admin' }}">
                                                <i class="fas fa-user-shield"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Reset Password --}}
                                        @if(isset($u['created_by']))
                                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-2"
                                                onclick="showResetModal({{ $u['id'] }}, '{{ $u['name'] }}')"
                                                title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        @endif

                                        {{-- Delete --}}
                                        @if(isset($u['created_by']))
                                        <form action="{{ route('superadmin.delete', $u['id']) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ADMINS TAB --}}
        <div class="tab-pane fade" id="tabAdmins">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Admin Accounts</h6>
                <a href="{{ route('superadmin.create-admin') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i>Create New Admin
                </a>
            </div>
            <div class="row g-3">
                @foreach($admins as $admin)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.2rem">
                                {{ strtoupper(substr($admin['name'], 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $admin['name'] }}</div>
                                <div class="text-muted small">{{ $admin['email'] }}</div>
                                <span class="badge bg-primary-soft text-primary rounded-pill mt-1" style="font-size:10px">
                                    <i class="fas fa-user-shield me-1"></i>Admin
                                </span>
                            </div>
                            <span class="badge rounded-pill {{ ($admin['status'] ?? 'active') === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($admin['status'] ?? 'active') }}
                            </span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            @if(($admin['status'] ?? 'active') === 'banned')
                            <form action="{{ route('superadmin.unban', $admin['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm rounded-pill px-3"><i class="fas fa-check me-1"></i>Unban</button>
                            </form>
                            @else
                            <form action="{{ route('superadmin.ban', $admin['id']) }}" method="POST" onsubmit="return confirm('Ban this admin?')">
                                @csrf
                                <button class="btn btn-warning btn-sm rounded-pill px-3"><i class="fas fa-ban me-1"></i>Ban</button>
                            </form>
                            @endif
                            @if(isset($admin['created_by']))
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                                    onclick="showResetModal({{ $admin['id'] }}, '{{ $admin['name'] }}')">
                                <i class="fas fa-key me-1"></i>Reset Password
                            </button>
                            <form action="{{ route('superadmin.delete', $admin['id']) }}" method="POST" onsubmit="return confirm('Delete this admin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="fas fa-trash me-1"></i>Delete</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- BANNED TAB --}}
        <div class="tab-pane fade" id="tabBanned">
            @if(count($banned) === 0)
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-3x text-success opacity-50 mb-3 d-block"></i>
                <p class="text-muted">No banned users.</p>
            </div>
            @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banned as $u)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $u['name'] }}</td>
                                <td class="text-muted small">{{ $u['email'] }}</td>
                                <td><span class="badge bg-light text-muted rounded-pill">{{ ucfirst($u['role']) }}</span></td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('superadmin.unban', $u['id']) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-pill px-3">
                                            <i class="fas fa-check me-1"></i>Unban
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Reset Password Modal --}}
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="fas fa-key me-2 text-primary"></i>Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">Set new password for <strong id="resetUserName"></strong></p>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="New password (min 6 chars)" minlength="6" required>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showResetModal(userId, userName) {
    document.getElementById('resetUserName').textContent = userName;
    document.getElementById('resetForm').action = `/superadmin/users/${userId}/reset-password`;
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}
</script>
@endsection
