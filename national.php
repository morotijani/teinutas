<?php 
    require_once ("db_connection/conn.php");
    $Category = new Category;
    $News = new News;
    include ('news.header.php');

    $query = "
        SELECT * FROM tein_membership 
        WHERE membership_executive = ?
    ";
    $statement = $conn->prepare($query);
    $statement->execute(['Yes']);
    $rows = $statement->fetchAll();

?>


    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto text-center py-5">
                    <div class="rounded-2 bg-dark-overlay-5 overflow-hidden p-4 p-md-5" style="background-image: url(<?= PROOT; ?>dist/media/bg-1.jpg);">
                            <div class="d-md-flex justify-content-between align-items-center">
                                <h4 class="text-white mb-2 mb-md-0">National . TEIN . <?= date("Y"); ?></h4>
                                <a href="<?= PROOT; ?>executives" class="btn btn-success mb-0">Executives</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
    Best selling product START -->
    <section class="pt-0 pt-md-5">
        <div class="container">
            <!-- Title -->
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h2 class="m-0">National</h2>
                <a href="#" class="text-body small"><u>View all</u></a>
            </div>

            <div class="row g-4">

                <div class="col-sm-6 col-lg-6">
                    <div class="card border p-3 h-100">
                        <div class="position-relative">
                            <!-- Image -->
                            <a href="javascript:;" class="position-relative z-index-10"><img class="card-img" src="<?= PROOT; ?>dist/media/national/george-opare-addo.jfif" alt="" style="width: 100%; height: 500px; object-fit: cover; object-position: top;"></a>
                            <!-- Overlay -->
                            <div class="card-img-overlay p-0">
                                <span class="badge text-bg-success">National Youth Organizer</span>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="card-body text-center p-3 px-0">
                            <!-- Title -->
                            <h5 class="card-title"><a href="javascript:;">George Opare Addo</a></h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                    <div class="card border p-3 h-100">
                        <div class="position-relative">
                            <!-- Image -->
                            <a href="javascript:;" class="position-relative z-index-10"><img class="card-img" src="<?= PROOT; ?>dist/media/national/osman-ayariga.jfif" alt="" style="width: 100%; height: 500px; object-fit: cover; object-position: top;"></a>
                            <!-- Overlay -->
                            <div class="card-img-overlay p-0">
                                <span class="badge text-bg-success">National Deputy Youth Organizer</span>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="card-body text-center p-3 px-0">
                            <!-- Title -->
                            <h5 class="card-title"><a href="javascript:;">Osman Ayariga</a></h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                    <div class="card border p-3 h-100">
                        <div class="position-relative">
                            <!-- Image -->
                            <a href="javascript:;" class="position-relative z-index-10"><img class="card-img" src="<?= PROOT; ?>dist/media/national/ruth-dela-seddoh.jfif" alt="" style="width: 100%; height: 500px; object-fit: cover; object-position: top;"></a>
                            <!-- Overlay -->
                            <div class="card-img-overlay p-0">
                                <span class="badge text-bg-success">Deputy National Youth Organizer</span>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="card-body text-center p-3 px-0">
                            <!-- Title -->
                            <h5 class="card-title"><a href="javascript:;">Ruth Dela Seddoh</a></h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    
<?php include ('news.footer.php'); ?>


