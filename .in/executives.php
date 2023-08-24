<?php 
    require_once ("../db_connection/conn.php");
    include ("includes/header.php");

    // DELETE A MEMBER PERMANENTLY
    if (isset($_GET['permanent_delete']) && !empty($_GET['permanent_delete'])) {
        $permanent_delete = (int)$_GET['permanent_delete'];
        $permanent_delete = sanitize($permanent_delete);

        $uploaded_passport_location = BASEURL . $_GET['uploaded_passport'];
        $DEL = unlink($uploaded_passport_location);

        if ($DEL) {
            $query = "
                DELETE FROM tein_membership 
                WHERE id = ?
            ";
            $statement = $conn->prepare($query);
            $statement->execute([$permanent_delete]);
            $_SESSION['flash_success'] = 'Member permanently <span class="bg-info">DELETED</span>';
            redirect(PROOT . '.in/members');
        }
    }

    $query = "
        SELECT * FROM tein_membership 
        WHERE membership_executive = ? 
        AND membership_trash = ?
        ORDER BY id DESC 
    ";
    $statement = $conn->prepare($query);
    $statement->execute(['Yes', 0]);
    $result = $statement->fetchAll();
?> 

    <?= $flash; ?>
    <div class="container-fluid">
        <main style="background-color: rgb(51, 51, 51);">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="margin-top: 34px;">
                        <h2 class="text-white" style="font-weight: 600; font-size: 20px; line-height: 28px;">TEIN . Executives</h2>
                        <?php if (!admin_is_logged_in()): ?>
                            <a href="<?= PROOT; ?>.in/auth/signin" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> . Sign in</a>
                        <?php else: ?>
                            <a href="<?= PROOT; ?>.in/add.member" class="btn btn-sm btn-outline-secondary" style="background: #333333;"> + Add Member</a>
                        <?php endif ?>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm text-white user-banner">
                        <div class="btn-group me-2">

                            <img class="me-3" src="<?= PROOT; ?>dist/media/logo/logo.png" alt="" width="48" height="38">
                            <div class="lh-1">
                                <h1 class="h6 mb-0 text-white lh-1" style="font-size: 16px; white-space: nowrap; text-overflow: ellipsis; font-weight: 700;"><?= (!admin_is_logged_in()) ? 'TEIN - CKT-UTAS' : strtoupper($admin_data['admin_fullname']); ?></h1>
                                <span style="font-size: 12px; line-height: 16px;"><?= (!admin_is_logged_in()) ? '@tein.cktutas.org' : $admin_data['admin_email']; ?></span><br>   
                                <span style="align-items: center; flex-direction: row;">😎 signed in.</span>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <div class="dropdown">
                                    <button  class="text-white" style="background-color: transparent; border: none;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>executives">Refresh</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>executives">Export</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>positions">Position</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>members">Members</a></li>
                                        <li><a class="dropdown-item" href="<?= PROOT; ?>logout">Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="index" class="btn btn-sm btn-outline-secondary">
                                Menu
                            </a>
                        </div>
                    </div>

                </div>
            </div>
           

            <div class="text-white w-100 h-100" style="z-index: 5; padding: 4px 0px; margin-bottom: 20px; transition: all 0.2s ease-in-out; background: #3B3B3B; border-radius: 4px; box-shadow: 0px 1.6px 3.6px rgb(0 0 0 / 25%), 0px 0px 2.9px rgb(0 0 0 / 22%);">
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                         <table class="table table-sm text-white table-bordered">
                            <thead>
                                <tr style="color: #A7A7A7; font-weight: 700;">
                                    <th></th>
                                    <th>Membership Id</th>
                                    <th>Student Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Sex</th>
                                    <th>Department</th>
                                    <th>Programme</th>
                                    <th>Level</th>
                                    <th>Name of Hostel</th>
                                    <th>WhatsApp Contact</th>
                                    <th>Telephone Number</th>
                                    <th>Passport</th>
                                    <th>Registered Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($result as $row): ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td>
                                        <?= $row['membership_identity']; ?>
                                        <?= ($row['membership_paid'] == 1) ? '<span class="badge bg-success">Paid</span>' : ''; ?>        
                                        <?= ($row['membership_executive'] == 'Yes') ? '<span class="badge bg-info">' . ucwords($row["membership_position"]) . '</span>' : ''; ?>        
                                    </td>
                                    <td><?= $row['membership_student_id']; ?></td>
                                    <td><?= ucwords($row['membership_fname']); ?></td>
                                    <td><?= ucwords($row['membership_lname']); ?></td>
                                    <td><?= $row['membership_email']; ?></td>
                                    <td><?= ucwords($row['membership_sex']); ?></td>
                                    <td><?= ucwords($row['membership_department']); ?></td>
                                    <td><?= ucwords($row['membership_programme']); ?></td>
                                    <td><?= ucwords($row['membership_level']); ?></td>
                                    <td><?= ucwords($row['membership_name_of_hostel']); ?></td>
                                    <td><?= $row['membership_whatsapp_contact']; ?></td>
                                    <td><?= $row['membership_telephone_number']; ?></td>
                                    <td>
                                        <a href="<?= PROOT . $row['membership_passport']; ?>" target="_blank">
                                            <img src="<?= PROOT . $row['membership_passport']; ?>" width="100" height="100" class="img-thumbnail">  
                                        </a>
                                    </td>
                                    <td><?= pretty_date_notime($row['membership_registered_date']); ?></td>
                                    <td>
                                        <a class="badge bg-dark text-decoration-none" href="javascript:;" data-bs-toggle="modal" data-bs-target="#memberModal<?= $row['id']; ?>">Details</a>
                                        <?php if (admin_is_logged_in()): ?>
                                            <a class="badge bg-secondary text-decoration-none" href="<?= PROOT; ?>.in/add.member?edit=1&id=<?= $row['id']; ?>">Edit</a>
                                            <!-- <a class="badge bg-danger text-decoration-none" href="<?= PROOT; ?>members?delete=1&id=<?= $row['id']; ?>">Delete</a> -->
                                            <a class="badge bg-danger text-decoration-none" href="<?= PROOT; ?>.in/members?permanent_delete=<?= $row['id']; ?>&uploaded_passport=<?= $row['membership_passport']; ?>">Delete</a>
                                        <?php endif ?>

                                        <div class="modal fade" id="memberModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="memberModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="background: #3B3B3B;">
                                                    <div class="modal-body text-center">
                                                        <div>
                                                            <?= ($row['membership_paid'] == 1) ? '<span class="badge bg-success mb-2">Paid</span>' : ''; ?>        
                                                            <?= ($row['membership_executive'] == 'Yes') ? '<span class="badge bg-info mb-2">' . ucwords($row["membership_position"]) . '</span>' : ''; ?>
                                                        </div>
                                                        <img src="<?= PROOT . $row['membership_passport']; ?>" alt="" class="img-fluid rounded" style="height: 200px; width: auto; margin: 0 auto;">
                                                        <table class="table table-sm table-bordered mt-3" style="width: auto; margin: 0 auto;">
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Identity</td>
                                                                <td><?= $row['membership_identity']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Full name</td>
                                                                <td><?= ucwords($row['membership_fname'] . ' ' . $row['membership_lname']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Email</td>
                                                                <td><?= $row['membership_email']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Sex</td>
                                                                <td><?= ucwords($row['membership_sex']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">School</td>
                                                                <td><?= ucwords($row['membership_school']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Department</td>
                                                                <td><?= ucwords($row['membership_department']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Programme</td>
                                                                <td><?= ucwords($row['membership_programme']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Level</td>
                                                                <td><?= ucwords($row['membership_level']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Year of Admission</td>
                                                                <td><?= $row['membership_yoa']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Year of Completion</td>
                                                                <td><?= $row['membership_yoc']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Name of Hostel</td>
                                                                <td><?= ucwords($row['membership_name_of_hostel']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Region</td>
                                                                <td><?= ucwords($row['membership_region']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Constituency</td>
                                                                <td><?= ucwords($row['membership_constituency']); ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">WhatsApp Contact</td>
                                                                <td><?= $row['membership_whatsapp_contact']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Telephone Number</td>
                                                                <td><?= $row['membership_telephone_number']; ?></td>
                                                            </tr>
                                                            <tr class="text-white">
                                                                <td style="color: #A7A7A7; font-weight: 700;">Card Type</td>
                                                                <td><?= $row['membership_card_type']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Print</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                <?php $i++; endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
               
        </main>
    </div>
<?php include ("includes/footer.php"); ?>
