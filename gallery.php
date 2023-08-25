<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;
    $Search = new Search;

    include ('news.header.php');

    $query = "
        SELECT * FROM tein_gallery 
        ORDER BY gallery_date_added DESC
    ";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

?>

    
    <!-- =======================
    Inner intro START -->
    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-danger bg-opacity-10 p-4 text-center rounded-3">
                        <h1 class="text-danger m-0">TEIN Gallery</h1>
                        <p class="lead m-0">Checkout out our photos during events, programs, and many more</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =======================
    Inner intro END -->

    <section class="py-5">
        <div class="container-fluid px-sm-5">
            <div class="row filter-container overflow-hidden" data-isotope='{"layoutMode": "masonry"}'>
                <!-- Card item START -->
                <?php foreach ($result as $row): ?>
                <div class="col-sm-6 col-lg-3 grid-item">
                    <div class="card mb-2">
                        <!-- Card img -->
                        <div class="glightbox-bg position-relative">
                            <a href="<?= PROOT . $row['gallery_media']; ?>" class="stretched-link cursor-zoom" data-glightbox data-gallery="image-popup">
                                <img class="card-img" src="<?= PROOT . $row['gallery_media']; ?>" alt="Card image">
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                  <!-- Card item END -->
            </div>
        </div>
    </section>


    
<?php include ('news.footer.php'); ?>


