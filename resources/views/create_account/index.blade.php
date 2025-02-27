@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="mb-0"><i class="bi bi-people"></i> Manage Users</h3>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus"></i> Add Staff
            </button>
        </div>
    </div>

    <!-- Table Users -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-success' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-outline-warning btn-sm rounded-circle"
                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                            onclick="loadUserDetails('{{ $user->id }}', '{{ $user->name }}', '{{ $user->username }}',
                            '{{ $user->email }}', '{{ $user->role }}')">
                            <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-sm rounded-circle btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Include Modals -->
@include('create_account.partials.add_user_modal')
@include('create_account.partials.edit_user_modal')

@endsection
