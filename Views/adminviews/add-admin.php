<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9"> <div class="card shadow mb-5">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-user-shield"></i> Create New Admin</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo FRONT_ROOT ?>Admin/addAdmin" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email">Admin Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="example@admin.com" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" minlength="4" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="confirm_password">Confirm</label>
                                    <input type="password" id="confirm_password" class="form-control" required>
                                </div>
                            </div>
                            
                            <div id="pass-error" class="text-danger small mb-3" style="display:none;">Passwords do not match</div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="btn btn-outline-secondary">Back</a>
                                <button type="submit" id="submit-btn" class="btn btn-primary px-4">Create Administrator</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if(isset($this->viewMessage) && !empty($this->viewMessage)) { ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?php echo $this->viewMessage; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="mt-5">
                    <h4 class="mb-4 text-primary"><i class="fas fa-users-cog"></i> Active Administrators</h4>
                    <div class="table-responsive shadow-sm border rounded">
                        <table class="table table-hover bg-white mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($adminList)) {
                                    foreach($adminList as $admin) { ?>
                                    <tr>
                                        <td class="align-middle"><strong><?php echo $admin->getEmail(); ?></strong></td>
                                        <td class="align-middle"><span class="badge bg-info text-dark">ADMIN</span></td>
                                        <td class="text-center">
                                            <?php if($admin->getUserId() != $_SESSION["loggedUser"]->getUserId()) { ?>
                                                <form action="<?php echo FRONT_ROOT ?>Admin/removeAdmin" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to deactivate this admin?')">
                                                    <input type="hidden" name="userId" value="<?php echo $admin->getUserId(); ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-user-minus"></i> Remove
                                                    </button>
                                                </form>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Current Session</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } 
                                } else { ?>
                                    <tr><td colspan="3" class="text-center text-muted">No active admins found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-5 pt-3">
                    <details class="border rounded p-3 bg-light">
                        <summary class="text-muted" style="cursor: pointer;">
                            <i class="fas fa-history"></i> Show Recently Deleted Administrators
                        </summary>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr class="text-muted">
                                        <th>Email</th>
                                        <th class="text-center">Restore</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($inactiveAdmins)) {
                                        foreach($inactiveAdmins as $inactive) { ?>
                                        <tr>
                                            <td><?php echo $inactive->getEmail(); ?></td>
                                            <td class="text-center">
                                                <form action="<?php echo FRONT_ROOT ?>Admin/restoreAdmin" method="POST" class="m-0">
                                                    <input type="hidden" name="userId" value="<?php echo $inactive->getUserId(); ?>">
                                                    <button type="submit" class="btn btn-link text-success p-0">
                                                        <i class="fas fa-undo"></i> Restore Access
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } 
                                    } else { ?>
                                        <tr><td colspan="2" class="text-center text-muted small pt-3">No inactive accounts found.</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </details>
                </div>

            </div> </div> </div> </main>

<script>
    const pass = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');
    const btn = document.getElementById('submit-btn');
    const error = document.getElementById('pass-error');

    function validate() {
        if(pass.value !== confirmInput.value && confirmInput.value !== "") {
            error.style.display = "block";
            btn.disabled = true;
        } else {
            error.style.display = "none";
            btn.disabled = false;
        }
    }

    pass.addEventListener('input', validate);
    confirmInput.addEventListener('input', validate);
</script>