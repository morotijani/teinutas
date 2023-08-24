    <!-- Sidebar START -->
    <div class="col-lg-3 mt-5 mt-lg-0">
        <div data-sticky data-margin-top="80" data-sticky-for="767">

            <!-- Social widget START -->
            <div class="row g-2">
                <div class="col-4">
                    <a href="#" class="bg-facebook rounded text-center text-white-force p-3 d-block">
                        <i class="fab fa-facebook-square fs-5 mb-2"></i>
                        <h6 class="m-0">1.5K</h6>
                        <span class="small">Fans</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="bg-instagram-gradient rounded text-center text-white-force p-3 d-block">
                        <i class="fab fa-instagram fs-5 mb-2"></i>
                        <h6 class="m-0">1.8M</h6>
                        <span class="small">Followers</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="bg-youtube rounded text-center text-white-force p-3 d-block">
                        <i class="fab fa-youtube-square fs-5 mb-2"></i>
                        <h6 class="m-0">22K</h6>
                        <span class="small">Subs</span>
                    </a>
                </div>
            </div>
            <!-- Social widget END -->

            <!-- Trending topics widget START -->
            <div>
                <h4 class="mt-4 mb-3">Trending topics</h4>
                <!-- Category item -->
                <?php foreach ($Category->listCategoryWithLimit($conn) as $category): ?>                    
                    <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-6" style="background-image:url(dist/media/bg-1.jpg); background-position: center left; background-size: cover;">
                        <div class="p-3">
                            <a href="<?= PROOT . 'category/'. $category['category_url']; ?>" class="stretched-link btn-link fw-bold text-white h5"><?= ucwords($category['category']); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Category item -->
               
                <!-- View All Category button -->
                <div class="text-center mt-3">
                    <a href="javascript:;" class="fw-bold text-body text-primary-hover"><u>View all categories</u></a>
                </div>
            </div>
            <!-- Trending topics widget END -->

            <div class="row">
                <!-- Recent post widget START -->
                <div class="col-12 col-sm-6 col-lg-12">
                    <h4 class="mt-4 mb-3">Recent post</h4>
                    <!-- Recent post item -->
                    <?= $News->fetchRecentNews($conn); ?>
                    <!-- Recent post widget END -->

                    <h4 class="mt-4 mb-3">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <?php 
                            $sql = "
                                SELECT *, MONTH(createdAt) AS month, YEAR(createdAt) AS year 
                                FROM `tein_news` 
                                GROUP BY MONTH(createdAt) 
                                LIMIT 12
                            ";
                            $statement = $conn->prepare($sql);
                            $statement->execute();
                            $rows = $statement->fetchAll();

                            foreach ($rows as $row) {
                                $time = strtotime($row['createdAt']);
                                $month = date("F", $time);
                                $year = date("Y", $time);

                                echo '<li><a href="' . PROOT . 'search/' . $row['month'] . '" class="text-danger">' . $month. ' ' . $year . '</a></li>';
                            }
                        ?>
                    </ol>

                <!-- ADV widget START -->
                <div class="col-12 col-sm-6 col-lg-12 my-4">
                    <a href="<?= PROOT; ?>dist/media/ads-1.jpeg" class="d-block card-img-flash">
                        <img src="<?= PROOT; ?>dist/media/ads-1.jpeg" alt="">
                    </a>
                    <div class="smaller text-end mt-2">ads via <a href="#" class="text-body"><u>TEIN</u></a></div>
                </div>
                <!-- ADV widget END -->
            </div>
        </div>
    </div>
    <!-- Sidebar END -->