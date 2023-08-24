<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    $total = $conn->query("SELECT * FROM tein_news WHERE news_featured = 0 AND news_status = 0")->rowCount();
    $per_page = 10;
    $current_page = ((isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1);

    $pagination = new Pagination($current_page, $total, $per_page);
    $offset = $pagination->offSet();
    $hasNext = $pagination->hasNextPage();
    $hasPrev = $pagination->hasPrevPage();

?>



<!-- =======================
Trending START -->
<section class="py-2">
    <div class="container">
        <div class="row g-0">
            <div class="col-12 bg-success bg-opacity-10 p-2 rounded">
                <div class="d-sm-flex align-items-center text-center text-sm-start">
                    <!-- Title -->
                    <div class="me-3">
                        <span class="badge bg-success p-2 px-3">Trending:</span>
                    </div>
                    <!-- Slider -->
                    <div class="tiny-slider arrow-end arrow-xs arrow-white arrow-round arrow-md-none">
                        <div class="tiny-slider-inner"
                            data-autoplay="true"
                            data-hoverpause="true"
                            data-gutter="0"
                            data-arrow="true"
                            data-dots="false"
                            data-items="1">
                            <!-- Slider items -->
                            <?= $News->trendingNews($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Row END -->
    </div>
</section>
<!-- =======================
Trending END -->

<!-- =======================
Main hero START -->
<section class="pt-4 pb-0 card-grid">
    <div class="container">
        <div class="row g-4">
            <!-- Left big card -->
            <?php echo $News->fetch_oneFeaturedNews($conn); ?>
            <!-- Right small cards -->
            <div class="col-lg-6">
                <div class="row g-4">
                    <!-- Card item START -->
                    <?= $News->fetchOneRandomNews($conn); ?>
                    <!-- Card item END -->
                    <!-- Card item START -->
                    <?= $News->fetchFeaturedNews($conn); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =======================
Main hero END -->

<!-- =======================
Main content START -->
<section class="position-relative">
    <div class="container" data-sticky-container>
        <div class="row">
            <!-- Main Post START -->
            <div class="col-lg-9">
                <!-- Title -->
                <div class="mb-4">
                    <h2 class="m-0"><i class="bi bi-hourglass-top me-2"></i>Today's top highlights</h2>
                    <p>Latest breaking news, pictures, videos, and special reports</p>
                </div>
                <div class="row gy-4">
                    <!-- Card item START -->
                    <?= $News->fetchNews($conn, $offset, $per_page); ?>
                    <!-- Card item END -->
                    <!-- Pagination -->
                    <nav class="blog-pagination" aria-label="Pagination">
                        <a class="btn btn-success-soft rounded-pill <?= (($hasPrev) ? '' : 'disabled'); ?>" href="<?= (($hasPrev) ? '?page=' . $current_page - 1 .'' : 'javascript:;'); ?>">Older</a>
                        <a class="btn btn-secondary-soft rounded-pill <?= (($hasNext) ? '' : 'disabled'); ?>" href="<?= (($hasNext) ? '?page=' . $current_page + 1 .'' : 'javascript:;'); ?>">Newer</a>
                    </nav>

                </div>
            </div>
            <!-- Main Post END -->
            <?php include("news.right.side.php"); ?>
        </div> <!-- Row end -->
    </div>
</section>
<!-- =======================
Main content END -->

<!-- Divider -->
<div class="container"><div class="border-bottom border-primary border-2 opacity-1"></div></div>

<!-- =======================
Section START -->
<section class="pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Title -->
                <div class="mb-4 d-md-flex justify-content-between align-items-center">
                    <h2 class="m-0"><i class="bi bi-megaphone"></i> Popular news</h2>
                    <a href="#" class="text-body small"><u>Content by: TEIN</u></a>
                </div>
                <div class="tiny-slider arrow-hover arrow-blur arrow-dark arrow-round">
                    <div class="tiny-slider-inner"
                        data-autoplay="true"
                        data-hoverpause="true"
                        data-gutter="24"
                        data-arrow="true"
                        data-dots="false"
                        data-items-xl="4" 
                        data-items-md="3" 
                        data-items-sm="2" 
                        data-items-xs="1">

                        <!-- Card item START -->
                        <?= $News->popularNews($conn); ?>
                        <!-- Card item END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =======================
Section END -->


<?php include ('news.footer.php'); ?>


<!-- AUTO POP UP Modal -->
<div class="modal fade" id="autoModal" tabindex="-1" aria-labelledby="autoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="autoModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              pay dues
              get membership card
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
          </div>
      </div>
    </div>
</div>

<script>
    $(window).on('load', function() {
        var delayMs = 1500; // delay in milliseconds

        setTimeout(function() {
            $('#autoModal').modal('show');
        }, delayMs);
    });
</script>