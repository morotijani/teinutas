<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    if (isset($_GET['url']) && !empty($_GET['url'])) {
        $url = sanitize($_GET['url']);
    } else {
        redirect(PROOT);
    }

    $total = $conn->query("SELECT * FROM tein_category WHERE category_url = '" . $url . "'")->rowCount();
    $total_news = $conn->query("SELECT * FROM tein_category INNER JOIN tein_news ON tein_news.news_category = tein_category.id WHERE category_url = '" . $url . "'")->rowCount();
    $per_page = 10;
    $current_page = ((isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1);

    $pagination = new Pagination($current_page, $total, $per_page);
    $offset = $pagination->offSet();
    $hasNext = $pagination->hasNextPage();
    $hasPrev = $pagination->hasPrevPage();
?>

    <!-- =======================
    Inner intro START -->
    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark-overlay-4 overflow-hidden card-bg-scale h-300 text-center" style="background-image:url(<?= PROOT; ?>dist/media/bg-1.jpg); background-position: center left; background-size: cover;">
                        <!-- Card Image overlay -->
                        <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
                            <div class="w-100 my-auto">
                                <div class="text-white mb-3">Browsing category:</div>
                                <h1 class="text-white h2">
                                    <span class="badge text-bg-warning mb-2">
                                        <i class="fas fa-circle me-2 small fw-bold"></i><?= strtoupper($url); ?></span>
                                </h1>
                                <div class="text-center position-relative">
                                    <span class="badge text-bg-info fs-6"><?= $total_news; ?> post(s)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =======================
    Inner intro END -->

    <!-- =======================
    Main content START -->
    <section class="position-relative pt-0">
        <div class="container" data-sticky-container>
            <div class="row">
                <!-- Main Post START -->
                <div class="col-lg-9">
                    <!-- Card item START -->
                    <?php 
                        $news = $Category->fetchCategoryNews($conn, $url);
                        if ($news == false) {
                            redirect(PROOT);
                        } else {
                            echo $news;
                        }
                    ?>
                    <!-- Card item END -->

                    <nav class="blog-pagination" aria-label="Pagination">
                        <a class="btn btn-success-soft rounded-pill <?= (($hasPrev) ? '' : 'disabled'); ?>" href="<?= (($hasPrev) ? '?page=' . $current_page - 1 .'' : 'javascript:;'); ?>">Older</a>
                        <a class="btn btn-secondary-soft rounded-pill <?= (($hasNext) ? '' : 'disabled'); ?>" href="<?= (($hasNext) ? '?page=' . $current_page + 1 .'' : 'javascript:;'); ?>">Newer</a>
                    </nav>
                </div>

                <!-- Sidebar START -->
                
                <?php include("news.right.side.php"); ?>
            </div>
        </div>
    </section>

    
<?php include ('news.footer.php'); ?>

