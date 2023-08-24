<?php 
    require_once ("../../db_connection/conn.php");
    include ("../includes/header.php");

    if (admin_is_logged_in()) {
        redirect(PROOT . 'index');
    }

    $error = '';
    if ($_POST) {
        if (empty($_POST['admin_email']) || empty($_POST['admin_password'])) {
            $error = 'You must provide email and password.';
        }
        $query = "
            SELECT * FROM tein_admin 
            WHERE admin_email = :admin_email 
            LIMIT 1
        ";
        $statement = $conn->prepare($query);
        $statement->execute(['admin_email' => $_POST['admin_email']]);
        $count_row = $statement->rowCount();
        $result = $statement->fetchAll();

        if ($count_row < 1) {
            $error = 'Unkown admin.';
        }

        foreach ($result as $row) {
            if (!password_verify($_POST['admin_password'], $row['admin_password'])) {
                $error = 'Unkown admin.';
            }

            if (!empty($error)) {
                $error;
            } else {
                $admin_id = $row['admin_id'];
                adminLogin($admin_id);
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
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN LOGIN</h2>
                        <a href="<?= PROOT; ?>executives" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> * Executives</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;">TEIN CKT-UTAS</h1>
                                <span style="font-size: 12px; line-height: 16px;">email@tein.cktutas.org</span><br>   
                                <span style="align-items: center; flex-direction: row;">📥 LOG IN.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                View site
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                            <div class="container-fluid mt-4">
                                <code><?= $error; ?></code>
                                <form action="" method="POST">
                                    <div class="from-group mb-3" >
                                        <label>Email</label>
                                        <input type="text" name="admin_email" id="admin_email" class="form-control form-control-sm" placeholder="Enter email">
                                    </div>
                                    <div class="from-group mb-3" >
                                        <label>Secret key</label>
                                        <input type="password" class="form-control form-control-sm" name="admin_password" id="admin_password" placeholder="*******" style="">
                                    </div>
                                    <div class="from-group mb-3">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Login</button>
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