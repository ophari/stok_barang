<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editUserModalLabel"><i class="bi bi-pencil-square"></i> Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person"></i> Name</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-at"></i> Username</label>
                                <input type="text" class="form-control" id="editUsername" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-envelope"></i> Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                        </div>

                        <!-- Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-key"></i> New Password (Optional)</label>
                                <input type="password" class="form-control" id="editPassword" name="password">
                                <small class="text-muted">Leave blank if you don't want to change</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-shield-lock"></i> Role</label>
                                <select class="form-select" id="editRole" name="role" required>
                                    <option value="staff">Staff</option>
                                    <option value="supervisor">Supervisor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 mt-3"><i class="bi bi-save"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function loadUserDetails(id, name, username, email, role) {
        let form = document.getElementById("editUserForm");
        form.action = "/users/" + id;
        document.getElementById("editName").value = name;
        document.getElementById("editUsername").value = username;
        document.getElementById("editEmail").value = email;
        document.getElementById("editRole").value = role;
    }
</script>
