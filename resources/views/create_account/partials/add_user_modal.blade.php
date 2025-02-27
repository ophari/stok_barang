<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel"><i class="bi bi-person-plus"></i> Add Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person"></i> Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-at"></i> Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-envelope"></i> Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>

                        <!-- Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-key"></i> Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-shield-lock"></i> Role</label>
                                <select class="form-select" name="role" required>
                                    <option value="staff">Staff</option>
                                    <option value="supervisor">Supervisor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3"><i class="bi bi-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
