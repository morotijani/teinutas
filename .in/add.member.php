<?php 
    require_once ("../db_connection/conn.php");
    include ("includes/header.php");

    $Allfunctions = new AllFunctions();

    $message = '';
    $student_id = ((isset($_POST['student_id']) && !empty($_POST['student_id'])) ? sanitize($_POST['student_id']) : '');
    $fname = ((isset($_POST['fname']) && !empty($_POST['fname'])) ? sanitize($_POST['fname']) : '');
    $lname = ((isset($_POST['lname']) && !empty($_POST['lname'])) ? sanitize($_POST['lname']) : '');
    $email = ((isset($_POST['email']) && !empty($_POST['email'])) ? sanitize($_POST['email']) : '');
    $sex = ((isset($_POST['sex']) && !empty($_POST['sex'])) ? sanitize($_POST['sex']) : '');
    $school = ((isset($_POST['school']) && !empty($_POST['school'])) ? sanitize($_POST['school']) : '');
    $department = ((isset($_POST['department']) && !empty($_POST['department'])) ? sanitize($_POST['department']) : '');
    $programme = ((isset($_POST['programme']) && !empty($_POST['programme'])) ? sanitize($_POST['programme']) : '');
    $level = ((isset($_POST['level']) && !empty($_POST['level'])) ? sanitize($_POST['level']) : '');
    $yoa = ((isset($_POST['yoa']) && !empty($_POST['yoa'])) ? sanitize($_POST['yoa']) : '');
    $yoc = ((isset($_POST['yoc']) && !empty($_POST['yoc'])) ? sanitize($_POST['yoc']) : '');
    $hostel = ((isset($_POST['hostel']) && !empty($_POST['hostel'])) ? sanitize($_POST['hostel']) : '');
    $region = ((isset($_POST['region']) && !empty($_POST['region'])) ? sanitize($_POST['region']) : '');
    $constituency = ((isset($_POST['constituency']) && !empty($_POST['constituency'])) ? sanitize($_POST['constituency']) : '');
    $branch = ((isset($_POST['branch']) && !empty($_POST['branch'])) ? sanitize($_POST['branch']) : '');
    $whatsapp = ((isset($_POST['whatsapp']) && !empty($_POST['whatsapp'])) ? sanitize($_POST['whatsapp']) : '');
    $telephone = ((isset($_POST['telephone']) && !empty($_POST['telephone'])) ? sanitize($_POST['telephone']) : '');
    $card_type = ((isset($_POST['card_type']) && !empty($_POST['card_type'])) ? sanitize($_POST['card_type']) : '');
    $executive = ((isset($_POST['executive']) && !empty($_POST['executive'])) ? sanitize($_POST['executive']) : '');
    $position = ((isset($_POST['position']) && !empty($_POST['position'])) ? sanitize($_POST['position']) : '');
    $paid = ((isset($_POST['paid']) && !empty($_POST['paid'])) ? sanitize($_POST['paid']) : '');
    $registered_date = date("Y-m-d H:i:s A");
    $passport = '';

    // Fetch Product details on edit
    if (isset($_GET['edit']) && !empty($_GET['id'])) {
        $edit_id = (int)$_GET['id'];
        $edit_id = sanitize($edit_id);

        $editQ = "
            SELECT * FROM tein_membership 
            WHERE id = :id 
            LIMIT 1
        ";
        $statement = $conn->prepare($editQ);
        $statement->execute(
            [
                ':id'   => $edit_id
            ]
        );
        $result_edit = $statement->fetchAll();

        foreach ($result_edit as $row) {
            $student_id = ((isset($_POST['student_id']) && $_POST['student_id'] != '') ? sanitize($_POST['student_id']) : $row['membership_student_id']);
            $fname = ((isset($_POST['fname']) && $_POST['fname'] != '') ? sanitize($_POST['fname']) : $row['membership_fname']);
            $lname = ((isset($_POST['lname']) && $_POST['lname'] != '') ? sanitize($_POST['lname']) : $row['membership_lname']);
            $email = ((isset($_POST['email']) && $_POST['email'] != '') ? sanitize($_POST['email']) : $row['membership_email']);
            $sex = ((isset($_POST['sex']) && $_POST['sex'] != '') ? sanitize($_POST['sex']) : $row['membership_sex']);
            $school = ((isset($_POST['school']) && $_POST['school'] != '') ? sanitize($_POST['school']) : $row['membership_school']);
            $department = ((isset($_POST['department']) && $_POST['department'] != '') ? sanitize($_POST['department']) : $row['membership_department']);
            $programme = ((isset($_POST['programme']) && $_POST['programme'] != '') ? sanitize($_POST['programme']) : $row['membership_programme']);
            $level = ((isset($_POST['level']) && $_POST['level'] != '') ? sanitize($_POST['level']) : $row['membership_level']);
            $yoa = ((isset($_POST['yoa']) && $_POST['yoa'] != '') ? sanitize($_POST['yoa']) : $row['membership_yoa']);
            $yoc = ((isset($_POST['yoc']) && $_POST['yoc'] != '') ? sanitize($_POST['yoc']) : $row['membership_yoc']);
            $hostel = ((isset($_POST['hostel']) && $_POST['hostel'] != '') ? sanitize($_POST['hostel']) : $row['membership_name_of_hostel']);
            $region = ((isset($_POST['region']) && $_POST['region'] != '') ? sanitize($_POST['region']) : $row['membership_region']);
            $constituency = ((isset($_POST['constituency']) && $_POST['constituency'] != '') ? sanitize($_POST['constituency']) : $row['membership_constituency']);
            $branch = ((isset($_POST['branch']) && $_POST['branch'] != '') ? sanitize($_POST['branch']) : $row['membership_branch']);
            $whatsapp = ((isset($_POST['whatsapp']) && $_POST['whatsapp'] != '') ? sanitize($_POST['whatsapp']) : $row['membership_whatsapp_contact']);
            $telephone = ((isset($_POST['telephone']) && $_POST['telephone'] != '') ? sanitize($_POST['telephone']) : $row['membership_telephone_number']);
            $card_type = ((isset($_POST['card_type']) && $_POST['card_type'] != '') ? sanitize($_POST['card_type']) : $row['membership_card_type']);
            $executive = ((isset($_POST['executive']) && $_POST['executive'] != '') ? sanitize($_POST['executive']) : $row['membership_executive']);
            $position = ((isset($_POST['position']) && $_POST['position'] != '') ? sanitize($_POST['position']) : $row['membership_position']);
            $paid = ((isset($_POST['paid']) && $_POST['paid'] != '') ? sanitize($_POST['paid']) : $row['membership_paid']);
            $registered_date = $row['membership_registered_date'];
            $passport = (($row['membership_passport'] != '') ? $row['membership_passport'] : '');
        }
    }

    if (isset($_POST['submit'])) {
        if ($_POST['uploaded_image'] != '') {
            unlink($_POST['uploaded_image']);
        }
                    
        $memberQuery = "
            SELECT * FROM tein_membership 
            WHERE membership_email = '".$_POST['email']."'
        ";
        if (isset($_GET['edit']) && !empty($_GET['id'])) {
            $memberQuery = "
                SELECT * FROM tein_membership 
                WHERE membership_email = '".$_POST['email']."' 
                AND id != '".(int)$_GET['id']."'
            ";
        }
        $statement = $conn->prepare($memberQuery);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $message = '<div class="alert alert-danger">'.$email.' already exists.</div>';
        } else {

            // UPLOAD PASSPORT PICTURE TO uploadedprofile IF FIELD IS NOT EMPTY
            if ($_POST['uploaded_passport'] == '') {
                if (!empty($_FILES)) {

                    $image_test = explode(".", $_FILES["passport"]["name"]);
                    $image_extension = end($image_test);
                    $image_name = md5(microtime()).'.'.$image_extension;

                    $location = 'dist/media/membership/'.$image_name;
                    move_uploaded_file($_FILES["passport"]["tmp_name"], BASEURL . $location);
                    
                    
                } else {
                    $message = '<div class="alert alert-danger">Passport Picture Can not be Empty</div>';
                }
            } else {
                $location = $_POST['uploaded_passport'];
            }

            if (empty($message)) {
                $data = array(
                    $student_id, $fname, $lname, $email, $sex, $school, $department, $programme, $level, $yoa, $yoc, $hostel, $region, $constituency, $branch, $location, $whatsapp, $telephone, $card_type, $executive, $position, $paid, $registered_date
                );
                if (isset($_GET['edit']) && !empty($_GET['id'])) {
                    $edit_id = sanitize((int)$_GET['id']);
                    $dataOne = array($edit_id);
                    $mergeData = array_merge($data, $dataOne);
                    $updateQ = "
                        UPDATE tein_membership 
                        SET `membership_student_id` = ?, `membership_fname` = ?, `membership_lname` = ?, `membership_email` = ?, `membership_sex` = ?, `membership_school` = ?, `membership_department` = ?, `membership_programme` = ?, `membership_level` = ?, `membership_yoa` = ?, `membership_yoc` = ?, `membership_name_of_hostel` = ?, `membership_region` = ?, `membership_constituency` = ?, `membership_branch` = ?, `membership_passport` = ?, `membership_whatsapp_contact` = ?, `membership_telephone_number` = ?, `membership_card_type` = ?, `membership_executive` = ?, `membership_position` = ?, `membership_paid` = ?, `membership_registered_date` = ? 
                        WHERE id = ?";
                    $statement = $conn->prepare($updateQ);
                    $resultQ = $statement->execute($mergeData);
                    if (isset($resultQ)) {
                        $_SESSION['flash_success'] = ucwords($row["membership_fname"]) .' successfully <span class="bg-info">Updated</span>';
                        redirect(PROOT . '.in/members');
                    }
                } else {
                    $query = "
                        INSERT INTO `tein_membership`(`membership_student_id`, `membership_fname`, `membership_lname`, `membership_email`, `membership_sex`, `membership_school`, `membership_department`, `membership_programme`, `membership_level`, `membership_yoa`, `membership_yoc`, `membership_name_of_hostel`, `membership_region`, `membership_constituency`, `membership_branch`, `membership_passport`, `membership_whatsapp_contact`, `membership_telephone_number`, `membership_card_type`, `membership_executive`, `membership_position`, `membership_paid`, `membership_registered_date`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ";
                    $statement = $conn->prepare($query);
                    $result = $statement->execute($data);

                    $inserted_id = $conn->lastInsertId();
                    $identity = $Allfunctions->generate_identity_number($inserted_id);

                    $conn->query("UPDATE tein_membership SET membership_identity = '".$identity."' WHERE id = $inserted_id")->execute();

                    if (isset($result)) {
                        $_SESSION['flash_success'] = 'New Member successfully <span class="bg-info">Added</span>';
                        redirect(PROOT . '.in/members');
                    }
                }
            } else {
                $message;
            }

        }
    }

    // Delete uploaded passport for change
    if (isset($_GET['dpp']) && !empty($_GET['pp'])) {

        $passport = $_GET['pp'];
        $passportLocation = BASEURL . $passport;
        unlink($passportLocation);
        unset($passport);

        $update = "
            UPDATE tein_membership 
            SET membership_passport = :membership_passport 
            WHERE id =  :id
        ";
        $statement = $conn->prepare($update);
        $statement->execute(
            [
                ':membership_passport'   => '',
                ':id'   => (int)$_GET["mid"]
            ]
        );
        $_SESSION['flash_success'] = 'Member Passport deleted, upload new one';
        redirect(PROOT . '.in/add.member?edit=1&id='.(int)$_GET["mid"]);
    }

    // DELETE MEMBER TEMPORARY
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $delete_id = (int)$_GET['delete'];
        $delete_id = sanitize($delete_id);

        $query = "
            UPDATE tein_membership 
            SET product_trash = :product_trash 
            WHERE id = :product_id
        ";
        $statement = $conn->prepare($query);
        $statement->execute(array(
            ':product_trash'    => 1,
            ':id'       => $delete_id
        ));
        $_SESSION['flash_success'] = 'Product has been temporary <span class="bg-info">DELETED</span>';
        echo '<script>window.location = "'.PROOT.'admin/products"</script>';
    }

    // RESTORE MEMBER
    if (isset($_GET['restore']) && !empty($_GET['restore'])) {
        $restore_id = (int)$_GET['restore'];
        $restore_id = sanitize($restore_id);

        $query = "
            UPDATE tein_membership 
            SET product_trash = :product_trash 
            WHERE id = :product_id
        ";
        $statement = $conn->prepare($query);
        $statement->execute([
            ':product_trash'    => 0,
            ':product_id'    => $restore_id
        ]);

        $_SESSION['flash_success'] = 'Member successfully <span class="bg-info">Restored</span>';
        echo '<script>window.location = "'.PROOT.'.in/members"</script>';
    }
?> 

    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Add Member</h2>
                        <a href="members" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> * Members</a>
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
                                <div class="dropdown">
                                    <button  class="text-white" style="background-color: transparent; border: none;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>members">Refresh</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>positions">Position</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>executives">Executives</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>logout">Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="<?= PROOT; ?>index" class="btn btn-sm btn-outline-secondary">
                                Menu
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                        <div class="container-fluid mt-4">
                            <?= $message; ?>
                            <form method="POST" enctype="multipart/form-data" action="add.member<?= ((isset($_GET['edit']))?'?edit=1&id='.(int)$_GET['id'] : ''); ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div>
                                            <label for="student_id">Student Id</label>
                                            <input type="text" class="form-control form-control-sm" name="student_id" id="student_id" value="<?= $student_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div>
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control form-control-sm" name="fname" id="fname" value="<?= $fname; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div>
                                            <label for="lname">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" name="lname" id="lname" value="<?= $lname; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div>
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control form-control-sm" name="email" id="email" value="<?= $email; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div>
                                            <label for="sex">Sex</label>
                                            <select type="text" class="form-control form-control-sm" name="sex" id="sex">
                                                <option value="">...</option>
                                                <option <?= ($sex == 'Male') ? "selected" : ""; ?>>Male</option>
                                                <option <?= ($sex == 'Female') ? "selected" : ""; ?>>Female</option>
                                                <option <?= ($sex == 'Other') ? "selected" : ""; ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="school">School</label>
                                            <input type="text" class="form-control form-control-sm" name="school" id="school" value="<?= $school ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="department">Department</label>
                                            <input type="text" class="form-control form-control-sm" name="department" id="department" value="<?= $department ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="programme">Programme</label>
                                            <input type="text" class="form-control form-control-sm" name="programme" id="programme" value="<?= $programme ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="level">Level</label>
                                            <select type="text" class="form-control form-control-sm" name="level" id="level">
                                                <option value="">...</option>
                                                <option <?= ($level == 'L100')? "selected" : ""; ?>>L100</option>
                                                <option <?= ($level == 'L200')? "selected" : ""; ?>>L200</option>
                                                <option <?= ($level == 'L300')? "selected" : ""; ?>>L300</option>
                                                <option <?= ($level == 'L400')? "selected" : ""; ?>>L400</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="yoa">Year of Admission</label>
                                            <input type="year" class="form-control form-control-sm" name="yoa" id="yoa" value="<?= $yoa; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="yoc">Year of Completion</label>
                                            <input type="year" class="form-control form-control-sm" name="yoc" id="yoc" value="<?= $yoc; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="hostel">Name of Hostel</label>
                                            <input type="text" class="form-control form-control-sm" name="hostel" id="hostel" value="<?= $hostel; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="region">Region</label>
                                            <input type="text" class="form-control form-control-sm" name="region" id="region" value="<?= $region; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="constituency">Constituency</label>
                                            <input type="text" class="form-control form-control-sm" name="constituency" id="constituency" value="<?= $constituency; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="branch">Branch (Polling Station)</label>
                                            <input type="text" class="form-control form-control-sm" name="branch" id="branch" value="<?= $branch; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="whatsapp">WhatsApp Contact</label>
                                            <input type="text" class="form-control form-control-sm" name="whatsapp" id="whatsapp" value="<?= $whatsapp; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="telephone">Telephone Number</label>
                                            <input type="text" class="form-control form-control-sm" name="telephone" id="telephone" value="<?= $telephone; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div>
                                            <label for="card_type">Card Type</label>
                                            <select type="text" class="form-control form-control-sm" name="card_type" id="card_type" value="<?= $card_type; ?>">
                                                <option value="">...</option>
                                                <option <?= ($card_type == 'Plastic')? "selected" : ""; ?>>Plastic</option>
                                                <option <?= ($card_type == 'Booklet')? "selected" : ""; ?>>Booklet</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php if ($passport != ''): ?>
                                    <div class="mb-3">
                                        <label>Product Image</label><br>
                                        <img src="<?= PROOT . $passport; ?>" class="img-fluid img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                                        <a href="<?= PROOT; ?>.in/add.member?dpp=1&mid=<?= $edit_id; ?>&pp=<?= $passport; ?>" class="badge bg-danger">Change Image</a>
                                    </div>
                                    <?php else: ?>
                                    <div class="mb-3">
                                        <div>
                                            <label for="passport" class="form-label">Product Image</label>
                                            <input type="file" class="form-control form-control-sm" id="passport" name="passport" required>
                                            <span id="upload_file"></span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="uploaded_passport" id="uploaded_passport" value="<?= $passport; ?>">

                                    <div class="col-md-12 mb-4">
                                        <label for="executive">Executive/Committee Member</label>
                                        <select name="executive" id="executive">
                                            <option value=""></option>
                                            <option value="No" <?= ($executive == 'No')? "selected" : ""; ?>>No</option>
                                            <option value="Yes" <?= ($executive == 'Yes')? "selected" : ""; ?>>Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4 executive <?= ($executive == 'Yes') ? '' : 'd-none'; ?>">
                                        <label for="position">Position</label>
                                        <select name="position" id="position" class="form-control form-control-sm">
                                            <option value="">...</option>
                                            <?php foreach ($conn->query("SELECT * FROM tein_position ORDER BY position_name ASC")->fetchAll() as $row): ?>
                                            <option <?= (($position == ucwords($row['position_name'])) ? 'selected' : ''); ?>><?= ucwords($row['position_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mt-2 mb-2">
                                        <label for="paid">Paid</label>
                                        <input type="checkbox" name="paid" id="paid" <?= ($paid == '1')? "checked" : ""; ?> value="1" class="control-checkbox">
                                    </div>
                                    <div class="mt-2 mb-2">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" name="submit" id="submit"><?= (isset($_GET['edit']))? 'Update': 'Add'; ?> Member</button>
                                        <?php if (isset($_GET['edit'])): ?>
                                            <br><br>
                                            <a href="<?= PROOT; ?>members" class="button text-secondary">Cancel</a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
<?php include ("includes/footer.php"); ?>

    <script>
        $("#executive").change(function(e) {
            e.preventDefault();

            var executive = $("#executive option:selected").val();
            if (executive != '') {
                if (executive == 'Yes') {
                    $(".executive").removeClass('d-none');
                } else {
                    $('#executive').prop('selected', false);
                    $(".executive").addClass('d-none');
                }
            } else {
                return false;
            }
        })
    </script>
