        
        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-body-tertiary rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                </div>

                <div>
                    <h4 class="fst-italic">Trending posts</h4>
                    <ul class="list-unstyled">
                        <?= $News->popularNews($conn); ?>
                    </ul>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Archives</h4>
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

                                echo '<li><a href="' . PROOT . 'search/' . $row['month'] . '">' . $month. ' ' . $year . '</a></li>';
                            }
                        ?>
                    </ol>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="https://web.facebook.com/teincktutas">Facebook</a></li>
                    </ol>
                </div>
            </div>
        </div>