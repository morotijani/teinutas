<?php 
    require_once ("../db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");

    $message = '';
    $position = (isset($_POST['position']) ? sanitize($_POST['position']) : '');

    if (isset($_GET['edit'])) {
        $id = sanitize((int)$_GET['edit']);

        $sql = "
            SELECT * FROM tein_position 
            WHERE id = ? 
            LIMIT 1
        ";
        $statement = $conn->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetchAll();
        
        if ($row) {
            // code...
            $position =  (isset($_POST['position']) ? sanitize($_POST['position']) : $row[0]['position_name']);
        } else {
            $_SESSION['flash_error'] = 'Something went wrong, please try again';
            redirect(PROOT . '.in/positions');
        }
    }

    // ADD POSITION
    if (isset($_POST['submit'])) {
        if (!empty($position)) {

            $check = $conn->query("SELECT * FROM tein_position WHERE position_name = '".$position."'")->rowCount();
            if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                $check = $conn->query("SELECT * FROM tein_position WHERE position_name = '".$position."' AND id != '".$id."'")->rowCount();
            }
            if ($check > 0) {
                $message = $position . ' already exists.';
            } else {

                // code...
                $q = "
                    INSERT INTO tein_position (position_name) 
                    VALUES (?)
                ";
                if (isset($_GET['edit'])) {
                    $q = "
                        UPDATE tein_position 
                        SET position_name = ?  
                        WHERE id = '".$id."'
                    ";
                }
                $statement = $conn->prepare($q);
                $result = $statement->execute([$position]);
                if (isset($result)) {
                    $_SESSION['flash_success'] = ucwords($position) . ' successfully '.((isset($_GET['edit'])) ? 'updated' : 'added') . '!';            
                    redirect(PROOT . '.in/positions');
                } else {
                    echo js_alert('Something went wrong, please try again');
                    redirect(PROOT . '.in/positions');
                }
            }
        } else {
            $message = 'Position name required.';
        }
    }

    // DELETE A POSITION
    if (isset($_GET['delete'])) {
        $delete = sanitize((int)$_GET['delete']);

        $query = $conn->query("DELETE FROM tein_position WHERE id = $delete")->execute();
        if ($query) {
            $_SESSION['flash_success'] = 'Position deleted!';            
            redirect(PROOT . '.in/positions');
        } else {
            echo js_alert('Something went wrong, please try again');
            redirect(PROOT . '.in/positions');
        }
    }
    

    // FETAH ALL POSITIONS
    $query = "
        SELECT * FROM tein_position 
        ORDER BY position_name ASC 
    ";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
?> 

    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Positions</h2>
                        <a href="<?= PROOT; ?>.in/add.member" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> + Add Member</a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;"><?= strtoupper($admin_data['admin_fullname']); ?></h1>
                                <span style="font-size: 12px; line-height: 16px;"><?= $admin_data['admin_email'] ?>g</span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 singed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="text-white" style="background-color: transparent; border: none;">...</button>
                            </div>
                            <a href="<?= PROOT; ?>.in/index" class="btn btn-sm btn-outline-secondary">
                                Menu
                            </a>
                        </div>
                    </div>

                    <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                        <div class="container-fluid mt-4">
                            <div>
                                <code><?= $message; ?></code>
                                <form method="POST" action="positions<?= ((isset($_GET['edit'])) ? '?edit='.(int)$_GET['edit'] : ''); ?>">
                                    <div class="mb-3">
                                        <div>
                                            <label for="position" class="form-label">Position name</label>
                                            <input type="text" class="form-control form-control-sm" id="position" name="position" placeholder="Position name" value="<?= $position; ?>" required>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-2">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" name="submit" id="submit"><?= (isset($_GET['edit']))? 'Update': 'Add'; ?> Position</button>
                                    </div>
                                </form>
                            </div>

                             <table class="table table-sm text-white table-bordered" style="width: auto; margin: 0 auto;">
                                <thead>
                                    <tr style="color: #A7A7A7; font-weight: 700;">
                                        <th></th>
                                        <th>Position</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($result as $row): ?>
                                    <tr>
                                        <td>
                                            <a class="badge bg-secondary text-decoration-none" href="<?= PROOT; ?>.in/positions?edit=<?= $row['id']; ?>">Edit</a>
                                        </td>
                                        <td><?= ucwords($row['position_name']); ?></td>
                                        <td>
                                            <a class="badge bg-danger text-decoration-none" href="<?= PROOT; ?>.in/positions?delete=<?= $row['id']; ?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </main>
    </div>
<?php include ("includes/footer.php"); ?>
