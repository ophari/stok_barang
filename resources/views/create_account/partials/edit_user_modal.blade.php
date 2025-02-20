<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalEditUserContent">
                <!-- Data akan dimuat dari controller -->
            </div>
        </div>
    </div>
</div>

<script>
    function loadUserDetails(userId) {
        fetch(`/users/view/${userId}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('modalEditUserContent').innerHTML = data;
            })
            .catch(error => console.error('Error fetching user details:', error));
    }
</script>
