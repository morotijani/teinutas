<?php 

    require_once ("../db_connection/conn.php");
    if (!admin_is_logged_in()) {
        admn_login_redirect();
    }
    include ("includes/header.php");

    $sql = "
        SELECT * FROM tein_gallery 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $images = $statement->fetchAll();

    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        // code..
        $id = sanitize((int)$_GET['delete']);
        $delete_image = unlink(BASEURL . $_GET['location']);

        if ($delete_image) {
            // code...
            $deleteQuery = "
                DELETE FROM tein_gallery 
                WHERE id = ?
            ";
            $statement = $conn->prepare($deleteQuery);
            $result = $statement->execute([$id]);
            if ($result) {
                // code...
                redirect(PROOT . '.in/Gallery');
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
                                <!-- <h1 class="mt-3 mb-3">Gallery</h1> -->

                                <label for="">Gallery, Select File</label>
                                <input type="file" id="select_file" class="form-control form-control-sm" multiple />
                                
                                <br />
                                <div class="progress" id="progress_bar" style="display:none; ">

                                    <div class="progress-bar" id="progress_bar_process" role="progressbar" style="width:0%">0%</div>

                                </div>

                                <div id="uploaded_image_info" class="row mt-5"></div>
                                <div id="uploaded_image" class="row mt-5">
                                    <?php 
                                        foreach ($images as $image) {
                                            echo '
                                                <div class="col-md-4 mb-2">
                                                    <div class="card">
                                                        <img class="img-fluid" src="' . PROOT . $image['gallery_media'].'">
                                                        <a href="?delete='.$image['id'].'&location='.$image['gallery_media'].'" class="text-danger">delete</a>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>


    <script>

        function _(element) {
            return document.getElementById(element);
        }

        _('select_file').onchange = function(event) {

            var form_data = new FormData();

            var image_number = 1;

            var error = '';

            for (var count = 0; count < _('select_file').files.length; count++) {
                if (!['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4'].includes(_('select_file').files[count].type)) {
                    error += '<div class="alert alert-danger"><b>'+image_number+'</b> Selected File must be .jpg or .png Only.</div>';
                } else {
                    form_data.append("images[]", _('select_file').files[count]);
                }

                image_number++;
            }

            if (error != '') {
                _('uploaded_image_info').innerHTML = error;

                _('select_file').value = '';
            } else {
                _('progress_bar').style.display = 'block';

                var ajax_request = new XMLHttpRequest();

                ajax_request.open("POST", "auth/gallery.upload.php");

                ajax_request.upload.addEventListener('progress', function(event){

                var percent_completed = Math.round((event.loaded / event.total) * 100);

                _('progress_bar_process').style.width = percent_completed + '%';

                _('progress_bar_process').innerHTML = percent_completed + '% completed';

            });

            ajax_request.addEventListener('load', function(event) {

                _('uploaded_image_info').innerHTML = '<div class="alert alert-success">Files Uploaded Successfully</div>';

                _('select_file').value = '';
                
                setTimeout(function () {
                    window.location = '<?= PROOT; ?>.in/Gallery';
                }, 1050);

            });

            ajax_request.send(form_data);
        }

    };

    </script>
<?php include ("includes/footer.php"); ?>
