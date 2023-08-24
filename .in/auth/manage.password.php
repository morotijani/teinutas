<?php 
    require_once ("../../db_connection/conn.php");
    include ("../includes/header.php");

    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }

    $error = '';
    $hashed = $admin_data['admin_password'];
    $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
    $old_password = trim($old_password);
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $password = trim($password);
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $confirm = trim($confirm);
    $new_hashed = password_hash($password, PASSWORD_BCRYPT);
    $admin_id = $admin_data['admin_id'];

    if ($_POST) {
        if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
            $error = 'You must fill out all fields';
        } else {

            if (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters';
            }

            if ($password != $confirm) {
                $error = 'The new password and confirm new password does not match.';
            }

            if (!password_verify($old_password, $hashed)) {
                $error = 'Your old password does not our records.';
            }
        }

        if (!empty($error)) {
            $error;
        } else {
            $query = '
                UPDATE tein_admin 
                SET admin_password = :admin_password 
                WHERE admin_id = :admin_id
            ';
            $satement = $conn->prepare($query);
            $result = $satement->execute(
                array(
                    ':admin_password' => $new_hashed,
                    ':admin_id' => $admin_id
                )
            );
            if (isset($result)) {
                $_SESSION['flash_success'] = 'Password successfully changed</div>';
                redirect(PROOT . ".in/manage.account");
            }
        }
    }

?> 


    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Change password</h2>
                        <a href="<?= PROOT; ?>.in" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> ^ Home</a>
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
                            <a href="<?= PROOT; ?>manage.account" class="btn btn-sm btn-outline-secondary">
                                Update Details
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                            <div class="container-fluid mt-4">
                                <code><?= $error; ?></code>
                                <form action="" method="POST">
                                    <div class="from-group mb-3" >
                                        <label>Old password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control form-control-sm">
                                    </div>
                                    <div class="from-group mb-3" >
                                        <label>New password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-sm">
                                    </div>
                                    <div class="from-group mb-3" >
                                        <label>Confirm new password</label>
                                        <input type="password" name="confirm" id="confirm" class="form-control form-control-sm">
                                    </div>
                                    <div class="from-group mb-3">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Change password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("../includes/footer.php"); ?>
