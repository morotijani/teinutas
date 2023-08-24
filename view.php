<?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    $newsUrl = '';
    if (isset($_GET['url']) && !empty($_GET['url'])) {
        $newsUrl = $_GET['url'];
    } else {
        redirect(PROOT . 'news/');
    }

    include ('news.header.php');
    
    $view = $News->singleView($conn, $newsUrl);
    if ($view == false) {
        redirect(PROOT);
    } else {
        $News->updateViews($conn, $newsUrl);
        echo $view;
        include ("news.right.side.php");
        echo '
                    </div>
                </div>
            </section>
            '
        ;
    }

    include ('news.footer.php'); 


?>    
