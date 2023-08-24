<?php 
    require_once ("../db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");


    $error = '';
    if ($_POST) {

        // code...
        $check = $conn->query("SELECT * FROM tein_admin WHERE admin_email = '".sanitize($_POST['admin_email'])."' AND admin_id != '".(int)$admin_data['admin_id']."'")->rowCount();
        if ($check > 0) {
            $error = "Email already exits";
        } else {
            if (!empty($_POST['admin_email']) && !empty($_POST['admin_fullname'])) {
                // code...
                if (empty($error)) {
                    // code...
                    $sql = "
                        UPDATE tein_admin 
                        SET admin_fullname = ?, admin_email = ? 
                        WHERE admin_id = ?
                    ";
                    $statement = $conn->prepare($sql);
                    $result = $statement->execute([
                        sanitize($_POST['admin_fullname']), 
                        sanitize($_POST['admin_email']), 
                        $admin_data['admin_id']
                    ]);
                    if (isset($result)) {
                        // code...
                        $_SESSION['flash_success'] = 'Account info updated!';
                        redirect(PROOT . '.in/manage.account');
                    } else {
                        $_SESSION['flash_error'] = 'Something went wrong, please try again!';
                        redirect(PROOT . '.in/manage.account');
                    }
                }
            } else {
                $error = 'Empty fields required!';
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
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Dashboard</h2>
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
                            <a href="<?= PROOT; ?>.in/auth/manage.password" class="btn btn-sm btn-outline-secondary">
                                Change password
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                            <div class="container-fluid mt-4">
                                <code><?= $error; ?></code>
                                <form action="" method="POST">
                                    <div class="from-group mb-3" >
                                        <label>Full name</label>
                                        <input type="text" name="admin_fullname" id="admin_fullname" class="form-control form-control-sm" placeholder="Enter email" value="<?= ((isset($_POST['admin_fullname'])) ? $_POST['admin_fullname'] : $admin_data['admin_fullname']); ?>">
                                    </div>
                                    <div class="from-group mb-3" >
                                        <label>Email</label>
                                        <input type="text" name="admin_email" id="admin_email" class="form-control form-control-sm" placeholder="Enter email" value="<?= ((isset($_POST['admin_email'])) ? $_POST['admin_email'] : $admin_data['admin_email']); ?>">
                                    </div>
                                    <div class="from-group mb-3">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

<?php include ("includes/footer.php"); ?>
