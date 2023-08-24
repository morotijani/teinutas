<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;
    $Search = new Search;

    include ('news.header.php');

    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $q = sanitize($_GET['q']);
    } else {
        redirect(PROOT);
    }

    $total = $conn->query("SELECT * FROM tein_news WHERE (news_title LIKE '%" . $q . "%' OR MONTH(createdAt) = '" . $q . "')")->rowCount();
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
                <div class="col-lg-9 mx-auto text-center py-5">
                    <span>Search results for</span>
                    <h2 class="display-5"><?= $q; ?></h2>
                    <span class="lead"><?= $total; ?> result found</span>
                    <!-- Search -->
                    <div class="row">
                        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
                            <form class="input-group mt-4" method="GET" action="<?= PROOT; ?>search">
                                <input class="form-control form-control-lg border-success" type="search" name="q" id="q" placeholder="<?= $q; ?>" aria-label="Search">
                                <button class="btn btn-success btn-lg m-0" type="submit">
                                    <span class="d-none d-md-block">Search</span>
                                    <i class="d-block d-md-none fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- =======================
    Main content START -->
    <section class="position-relative pt-0">
        <div class="container" data-sticky-container>
            <div class="row">
                <!-- Main Post START -->
                <div class="col-lg-9 mx-auto">
                    <!-- Card item START -->
                    <?php 
                        $search = $Search->fetchSearchNews($conn, $q);
                        if ($search == false) {
                            redirect(PROOT);
                        } else {
                            echo $search;
                        }
                    ?>
                    <!-- Card item END -->

                    <nav class="blog-pagination" aria-label="Pagination">
                        <a class="btn btn-success-soft rounded-pill <?= (($hasPrev) ? '' : 'disabled'); ?>" href="<?= (($hasPrev) ? '?page=' . $current_page - 1 .'' : 'javascript:;'); ?>">Older</a>
                        <a class="btn btn-secondary-soft rounded-pill <?= (($hasNext) ? '' : 'disabled'); ?>" href="<?= (($hasNext) ? '?page=' . $current_page + 1 .'' : 'javascript:;'); ?>">Newer</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    
<?php include ('news.footer.php'); ?>


