<?php 
    require_once ("../db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");

?> 


    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Dashboard</h2>
                        <a href="<?= PROOT; ?>.in/add.member" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> + Add Member</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;"><?= strtoupper($admin_data['admin_fullname']); ?></h1>
                                <span style="font-size: 12px; line-height: 16px;"><?= $admin_data['admin_email'] ?></span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 singed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <a href="<?= PROOT; ?>.in/auth/logout" class="btn btn-sm btn-outline-secondary">
                                Sign out
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                            <ul class="list-group">
                                <a href="<?= PROOT; ?>.in/index" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-house"></i> Home</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/positions" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-check"></i> Positions</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/executives" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-check"></i> Executives</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/members" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-people"></i> Members</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/blog" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-newspaper"></i> News</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/manage.account" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person"></i> Manage account</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/personal.info" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-lock"></i> Personal info</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-arrow-clockwise"></i> Refresh</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="<?= PROOT; ?>.in/auth/logout" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-box-arrow-left"></i> Log out</span>
                                    <span class=""><i class="bi bi-arrow-right"></i></span>
                                </a>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("includes/footer.php"); ?>
