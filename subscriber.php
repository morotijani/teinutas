<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    if (isset($_POST['subscriber_email'])) {
        $email = sanitize($_POST['subscriber_email']);
        if ($email != '' || !empty($email)) {
    ?>


            <!-- =======================
            Inner intro START -->
            <section class="pt-2">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-dark-overlay-5 overflow-hidden card-bg-scale h-400 text-center" style="background-image:url(dist/media/bg-1.jpg); background-position: center left; background-size: cover;">
                                <!-- Card Image overlay -->
                                <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
                                    <div class="w-100 my-auto">
                                        <!-- Card category -->
                                        <a href="#" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>News letter subscribe</a>
                                        <!-- Card title -->
                                        <h2 class="text-white display-5"><?= $News->addSubscriber($conn, $email); ?></h2>
                                        <!-- Card info -->
                                        <ul class="nav nav-divider text-white-force align-items-center justify-content-center">
                                            <li class="nav-item">
                                                <div class="nav-link">
                                                    <div class="d-flex align-items-center text-white position-relative">
                                                        <div class="avatar avatar-sm">
                                                            <img class="avatar-img rounded-circle" src="dist/media/logo/logo.png" alt="avatar">
                                                        </div>
                                                        <span class="ms-3">by <a href="<?= PROOT; ?>" class="stretched-link text-reset btn-link">TEIN</a></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nav-item"><?= date("Y-m-d H:i:s A"); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

    <?php
        } else {
           redirect(PROOT);
        }
    } else {
       redirect(PROOT);
    }
?>


