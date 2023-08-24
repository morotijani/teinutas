<?php 
    require_once ("../db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");

?> 


    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Personal Info</h2>
                        <a href="<?= PROOT; ?>.in" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> << Go Back</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;">TEIN - CKT-UTAS</h1>
                                <span style="font-size: 12px; line-height: 16px;">@tein.cktutas.org</span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 singed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <a href="<?= PROOT; ?>.in/manage.account" class="btn btn-sm btn-outline-secondary">
                                Update Details
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                            <ul class="list-group">
                                <a href="javascript:;" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-house"></i> Full name</span>
                                    <span class=""><?= ucwords($admin_data['admin_fullname']); ?></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="javascript:;" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-check"></i> Email</span>
                                    <span class=""><?= $admin_data['admin_email']; ?></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="javascript:;" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-check"></i> Joined Date</span>
                                    <span class=""><?= pretty_date($admin_data['admin_joined_date']); ?></span>
                                </a>
                                <hr aria-hidden="true" class="menu-hr">
                                <a href="javascript:;" class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-0">
                                    <span class="menu-item"><i class="bi bi-person-check"></i> Last Login</span>
                                    <span class=""><?= pretty_date($admin_data['admin_joined_date']); ?></span>
                                </a>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("includes/footer.php"); ?>
