

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
Footer START -->
<footer class="bg-dark pt-5">
    <div class="container">
        <!-- About and Newsletter START -->
        <div class="row pt-3 pb-4">
            <div class="col-md-3">
                <img src="<?= PROOT; ?>dist/media/logo/logo.png" width="100" alt="footer logo">
            </div>
            <div class="col-md-5">
                <p class="text-muted">We believe in Ghana’s future and whenever in government we strive to put Ghana on the road to real development. Join us to do better than you’re witnessing now.</p>
            </div>
            <div class="col-md-4">
                <!-- Form -->
                <form class="row row-cols-lg-auto g-2 align-items-center justify-content-end" method="POST" action="<?= PROOT; ?>subscriber">
                    <div class="col-12">
                        <input type="email" id="subscriber_email" name="subscriber_email" autocomplete="nope" class="form-control" placeholder="Enter your email address">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger m-0">Subscribe</button>
                    </div>
                    <div class="form-text mt-2">By subscribing you agree to our 
                        <a href="https://ndcgh.org/privacy-policy" class="text-decoration-underline text-reset">Privacy Policy</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- About and Newsletter END -->

        <!-- Divider -->
        <hr>

        <!-- Widgets START -->
        <div class="row pt-5">
            <!-- Footer Widget -->
            <div class="col-md-6 col-lg-3 mb-4">
                <h5 class="mb-4 text-white">Recent post</h5>
                <!-- Item -->
                <?= $News->recentFooterNews($conn); ?>
            </div>

            <!-- Footer Widget -->
            <div class="col-md-6 col-lg-3 mb-4">
                <h5 class="mb-4 text-white">Navigation</h5>
                <div class="row">
                    <div class="col-6">
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link pt-0" href="https://ndcgh.org">NDC</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://johnmahama.org">Meet JM</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= PROOT; ?>contact-us">Contact us</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/the-green-book">The Green Book</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/category/blog">NDC Stories</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/jobs">Jobs</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>">News</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>get-membership-card">TEIN Card</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>pay.dues.php">Dues</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>executives">Executives</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>">National</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>">Regional</a></li>
                            <li class="nav-item"><a class="nav-link pt-0" href="<?= PROOT; ?>gallery">Gallery</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Widget -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <h5 class="mb-4 text-white">Get Regular Updates</h5>
                <ul class="nav flex-column text-primary-hover">
                    <li class="nav-item"><a class="nav-link pt-0" href="#"><i class="fab fa-whatsapp fa-fw me-2"></i>WhatsApp</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fab fa-youtube fa-fw me-2"></i>YouTube</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="far fa-bell fa-fw me-2"></i>Website Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" href="javascript:;" data-bs-toggle="modal" data-bs-target="#subscribeModal"><i class="far fa-envelope fa-fw me-2"></i>Newsletters</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-headphones-alt fa-fw me-2"></i>Podcasts</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROOT; ?>about-us"><i class="fas fa-globe fa-fw me-2"></i>About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROOT; ?>contact-us"><i class="fas fa-phone fa-fw me-2"></i>Contact us</a></li>
                </ul>
            </div>

            <!-- Footer Widget -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <h5 class="mb-4 text-white">Our mobile App</h5>
                <p class="text-muted">Download our App and get the latest Breaking News Alerts and latest headlines and daily articles near you.</p>
                <div class="row g-2">
                    <div class="col">
                        <a href="#"><img class="w-100" src="<?= PROOT; ?>dist/media/logo/app-store.svg" alt="app-store"></a>
                    </div>
                    <div class="col">
                        <a href="#"><img class="w-100" src="<?= PROOT; ?>dist/media/logo/google-play.svg" alt="google-play"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Widgets END -->

        <!-- Hot topics START -->
        <div class="row">
            <h5 class="mb-2 text-white">Hot topics</h5>
            <ul class="list-inline text-primary-hover lh-lg">
                <?php foreach ($Category->listCategory($conn) as $category): ?>
                <li class="list-inline-item"><a href="<?= PROOT . 'category/'. $category['category_url']; ?>"><?= ucwords($category['category']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Hot topics END -->
    </div>

    <!-- Footer copyright START -->
    <div class="bg-dark-overlay-3 mt-5">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4">
                <div class="col-md-6">
                    <!-- Copyright -->
                    <div class="text-center text-md-start text-primary-hover text-muted">Member registration, dues payment and news feed built for <a href="javascript:;" class="text-reset btn-link" target="_blank"> TEIN - UTAS </a> by <a href="https://twitter.com/teincktutas"> @IT COMMITTEE</a>. &copy; 2023 - All rights reserved
                    </div>
                </div>
                <div class="col-md-6 d-sm-flex align-items-center justify-content-center justify-content-md-end">
                    <!-- Language switcher -->
                    <div class="dropup me-0 me-sm-3 mt-3 mt-md-0 text-center text-sm-end">
                        <a class="dropdown-toggle text-primary-hover" href="#" role="button" id="languageSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                            English Edition
                        </a>
                        <ul class="dropdown-menu min-w-auto" aria-labelledby="languageSwitcher">
                            <li><a class="dropdown-item" href="#">English</a></li>
                            <li><a class="dropdown-item" href="#">German </a></li>
                            <li><a class="dropdown-item" href="#">French</a></li>
                        </ul>
                    </div>
                    <!-- Links -->
                    <ul class="nav text-primary-hover text-center text-sm-end justify-content-center justify-content-center mt-3 mt-md-0">
                        <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/privacy-policy">Terms</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://ndcgh.org/privacy-policy">Privacy</a></li>
                        <li class="nav-item"><a class="nav-link pe-0" href="https://ndcgh.org/privacy-policy">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer copyright END -->
</footer>
<!-- =======================
Footer END -->

    <!-- Back to top -->
    <div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

    <!-- =======================
    JS libraries, plugins and custom scripts -->

    <!-- Bootstrap JS -->
    <script src="<?= PROOT; ?>vendor/js/bootstrap.bundle.min.js"></script>

    <!-- Vendors -->
    <script src="<?= PROOT; ?>vendor/js/isotope.pkgd.min.js"></script>
    <script src="<?= PROOT; ?>vendor/js/tiny-slider.js"></script>
    <script src="<?= PROOT; ?>vendor/js/sticky.min.js"></script>
    <script src="<?= PROOT; ?>vendor/js/plyr.js"></script>
    <script src="<?= PROOT; ?>vendor/js/glightbox.js"></script>

    <!-- Template Functions -->
    <script src="<?= PROOT; ?>vendor/js/functions.js"></script>

    <!-- SUBSCRIBE MODAL -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?= PROOT; ?>subscriber">
                    <div class="modal-body">
                        <p class="card-text">Subscribe to our news letter for daily update of news.</p>
                            <div class="form-floating mb-2">
                                <input type="email" id="subscriber_email" name="subscriber_email" autocomplete="nope" class="form-control" placeholder="Email" required>
                                <label>Email</label>
                                <div class="form-text">Your data or information are saved with us. It never be shared to any third party.</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>
