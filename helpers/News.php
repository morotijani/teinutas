<?php 

	class News {
		private $i = 1;
		private $output = '';
		private $output_recent = '';
		private $output_featured = '';
		private $output_onefeatured = '';
		private $output_single = '';
		private $output_subscribers = '';
		private $output_poupular = '';
		private $output_trending = '';
		private $output_footer = '';
		
		private function findNews($conn, $id) {
			$query = " 
				SELECT * FROM tein_news 
				WHERE id = ? 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([$id]);

			return $statement->rowCount();
		}

		public function allNews($conn) {
			$query = "
		        SELECT *, tein_news.id AS news_id FROM tein_news 
		        INNER JOIN tein_category 
		        ON tein_category.id = tein_news.news_category 
		        INNER JOIN tein_admin 
		        ON tein_admin.admin_id = tein_news.news_created_by 
		        WHERE tein_news.news_status = ?
		        ORDER BY tein_news.id DESC 
		    ";
		    $statement = $conn->prepare($query);
		    $statement->execute([0]);
		    $news = $statement->fetchAll();
		    if ($statement->rowCount() > 0) {
		    	// code...
			    foreach ($news as $new) {
	                $this->output .= "
	                	<tr>
	                		<td>" . $this->i . "</td>
		                    <td>" . $new['news_title'] . "</td>
		                    <td>" . ucwords($new['category']) . "</td>
		                    <td>" . $new['news_views'] . "</td>
		                    <td>" . pretty_date($new['createdAt']) . "</td>
		                    <td>" . ucwords($new['admin_fullname']) . "</td>
		                    <td>
		                    	<a class='badge bg-" . (($new['news_featured'] == 1) ? 'secondary' : 'primary') . " text-decoration-none' href='" . PROOT . '.in/blog/add/featured/' . $new['news_id'] . '/' . (($new['news_featured'] == 0) ? 1 : 2) . "'>" . (($new['news_featured'] == 1) ? 'featured' : '+ featured') . "</a>
		                    </td>
		                    <td>
		                        <a class='badge bg-primary text-decoration-none' href='javascript:;' data-bs-toggle='modal' data-bs-target='#viewModal" . $this->i . "'>View</a>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . ".in/blog/add/edit_news/" . $new['news_id'] . "'>Edit</a>

		                        <!-- VIEW DETAILS MODAL -->
								<div class='modal fade' id='viewModal" . $this->i . "' tabindex='-1' aria-labelledby='viewModalLabel' aria-hidden='true' data-bs-backdrop='static' data-bs-keyboard='false'>
								  	<div class='modal-dialog modal-dialog-centered'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-header'>
								    			<h1 class='modal-title fs-5' id='viewModalLabel'>" . $new['news_title'] . "</h1>
        										<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
								    		</div>
								    		<img class='img-fluid' src='" . PROOT . $new['news_media'] ."' />
								    		<div class='modal-body'>
								    			<span class='badge bg-info'>" . ucwords($new['category']) . "</span>
								    			<br>
								      			<p>" . nl2br($new['news_content']) . "</p>
								      			<br>
								      			<small class='text-secondary'>
								      				Created By; " . ucwords($new['admin_fullname']) . " <br>
								      				Add On; " . pretty_date($new['createdAt']) . " <br>
								      				Views; " . $new['news_views'] . " <br>
								      			</small>
								      			<br>
								        		<button type='button' class='btn btn-sm btn-secondary rounded-0' data-bs-dismiss='modal'>Close</button>
								        		<a href='javascript:;' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "' class='btn btn-sm btn-outline-danger rounded-0'>Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>

								<!-- DELETE MODAL -->
								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='newsModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . ".in/blog/add/delete/" . $new['news_id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>
		                    </td>
		                </tr>
		             ";
	            	$this->i++;
			    }
		    } else {
		    	$this->output = "
		    		<tr>
		    			<td colspan='3'>No data found!</td>
		    		</tr>
		    	";
		    }
		    return $this->output;
		}

		public function deleteNewsMedia($conn, $id, $image) {
	        $mediaLocation = BASEURL . $image;
	        $delete = unlink($mediaLocation);
	        unset($image);

	        if ($delete) {
		        $update = "
		            UPDATE tein_news 
		            SET news_media = ? 
		            WHERE id = ?
		        ";
		        $statement = $conn->prepare($update);
		        $result = $statement->execute(['', $id]);
		        return $result;
		    } else {
		    	return false;
		    }
		}

		// get number of featured
		private function get_number_of_featured($conn) {
			$query = " 
				SELECT * FROM tein_news 
				WHERE news_featured = ? 
			";
			$statement = $conn->prepare($query);
			$statement->execute([1]);

			return $statement->rowCount();
		}

		// set featured or un featured
		public function featuredNews($conn, $feature, $id) {
			$featured = 0;
			if ($feature != 0) {
				$featured = $this->get_number_of_featured($conn);
			}
			$news = $this->findNews($conn, $id);
			if ($featured < 3) {
				if ($news > 0) {
					// code...
			        $query = "
			        	UPDATE tein_news 
			        	SET news_featured = ?
			        	WHERE id = ?
			        ";
			        $statement = $conn->prepare($query);
			        $result = $statement->execute([$feature, $id]);
			        return $result;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		// delete news by setting status to 1
		public function deleteNews($conn, $id) {
	        $query = "
	        	UPDATE tein_news 
	        	SET news_status = ?
	        	WHERE id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $result = $statement->execute([1, $id]);
	        return $result;
		}

		// fetch all news except featured
		public function fetchNews($conn, $offset, $per_page) {
			$today = date("d");
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ? 
				AND tein_news.news_status = ? 
				-- AND (tein_news.news_views > 1 AND DAY(tein_news.createdAt) = ?) 
				-- OR (tein_news.news_views <= 1 AND DAY(tein_news.createdAt) <= ?)
				ORDER BY tein_news.createdAt DESC 
				LIMIT {$offset}, {$per_page}
			";
			$statement = $conn->prepare($query);
			// $statement->execute([0, 0, $today, $today]);
			$statement->execute([0, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {

				$this->output .= '
					<div class="col-sm-6">
                        <div class="card">
                            <!-- Card img -->
                            <div class="position-relative">
                                <img class="card-img" src="' . PROOT . $row["news_media"]. '" alt="Card image" style="height: 280px; object-fit: cover">
                                <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                    <!-- Card overlay bottom -->
                                    <div class="w-100 mt-auto">
                                        <!-- Card category -->
                                        <a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-3">
                                <h4 class="card-title"><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link text-reset fw-bold">' . ucwords($row["news_title"]) . '</a></h4>
                                <p class="card-text">' . strip_tags(substr($row['news_content'], 0, 90)) . ' ...</p>
                                <!-- Card info -->
                                <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
                                    <li class="nav-item">
                                        <div class="nav-link">
                                            <div class="d-flex align-items-center position-relative">
                                                <div class="avatar avatar-xs">
                                                    <img class="avatar-img rounded-circle" src="dist/media/admin-male.svg" alt="avatar">
                                                </div>
                                                <span class="ms-3">by <a href="#" class="stretched-link text-reset btn-link">C.O</a></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">' . pretty_date_notime($row["ca"]) . '</li>
                                </ul>
                            </div>
                        </div>
                    </div>
				';
			}

			return $this->output;
		}

		// fetch all news except featured
		public function fetchRecentNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC 
				LIMIT 4
			";
			$statement = $conn->prepare($query);
			$statement->execute([0, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {

				$this->output_recent .= '
					<div class="card mb-3">
                        <div class="row g-3">
                            <div class="col-4">
                                <img class="rounded" src="' . PROOT . $row["news_media"]. '" alt="" style="width: 75px; height: 55px; object-fit: cover;">
                            </div>
                            <div class="col-8">
                                <h6><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link stretched-link text-reset fw-bold">' . ucwords($row["news_title"]) . '</a></h6>
                                <div class="small mt-1">' . pretty_date_notime($row["ca"]) . '</div>
                            </div>
                        </div>
                    </div>
				';
			}

			return $this->output_recent;
		}
		
		// fetch the 2 featured news
		public function fetchFeaturedNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt ASC 
				LIMIT 2
			";
			$statement = $conn->prepare($query);
			$statement->execute([1, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {
				$this->output_featured .= '
					<div class="col-md-6">
                        <div class="card card-overlay-bottom card-grid-sm card-bg-scale" style="background-image:url(' . PROOT . $row["news_media"]. '); background-position: center left; background-size: cover;">
                            <!-- Card Image overlay -->
                            <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
                                <div class="w-100 mt-auto">
                                    <!-- Card category -->
                                    <a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-success mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
                                    <!-- Card title -->
                                    <h4 class="text-white"><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link stretched-link text-reset">' . ucwords($row["news_title"]) . '</a></h4>
                                    <!-- Card info -->
                                    <ul class="nav nav-divider text-white-force align-items-center d-none d-sm-inline-block">
                                        <li class="nav-item position-relative">
                                            <div class="nav-link">by <a href="#" class="stretched-link text-reset btn-link">C.O</a>
                                            </div>
                                        </li>
                                        <li class="nav-item">' . pretty_date_notime($row["ca"]) . '</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
				';
			}
			return $this->output_featured;
		}
		
		// fetch the random 1 news
		public function fetchOneRandomNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY RAND()
				LIMIT 1 
			";
			$statement = $conn->prepare($query);
			$statement->execute([1, 0]);
			$row = $statement->fetchAll();

			return '
				<div class="col-12 d-none d-lg-block">
                    <div class="card card-overlay-bottom card-grid-sm card-bg-scale" style="background-image:url(' . PROOT . $row[0]["news_media"] . '); background-position: center left; background-size: cover;">
                        <!-- Card Image -->
                        <!-- Card Image overlay -->
                        <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
                            <div class="w-100 mt-auto">
                                <!-- Card category -->
                                <a href="' . PROOT . 'category/' . $row[0]["category_url"] . '" class="badge text-bg-warning mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row[0]["category"]) . '</a>
                                <!-- Card title -->
                                <h4 class="text-white"><a href="' . PROOT . 'view/' . $row[0]["news_url"] . '" class="btn-link stretched-link text-reset">' . ucwords($row[0]["news_title"]) . '</a></h4>
                                <!-- Card info -->
                                <ul class="nav nav-divider text-white-force align-items-center d-none d-sm-inline-block">
                                    <li class="nav-item position-relative">
                                        <div class="nav-link">by <a href="#" class="stretched-link text-reset btn-link">C.O</a>
                                        </div>
                                    </li>
                                    <li class="nav-item">' . pretty_date_notime($row[0]["ca"]) . '</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			';
		}

		// get main or one feature post for the news
		public function fetch_oneFeaturedNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([1, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {
				$this->output_onefeatured .= '
					<div class="col-lg-6">
		                <div class="card card-overlay-bottom card-grid-lg card-bg-scale" style="background-image:url(' . PROOT . $row["news_media"] . '); background-position: center left; background-size: cover;">
		                    <!-- Card featured -->
		                    <span class="card-featured" title="Featured post"><i class="fas fa-star"></i></span>
		                    <!-- Card Image overlay -->
		                    <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
		                        <div class="w-100 mt-auto">
		                            <!-- Card category -->
		                            <a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
		                            <!-- Card title -->
		                            <h2 class="text-white h1"><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link stretched-link text-reset">' . ucwords($row["news_title"]) . '</a></h2>
		                            <p class="text-white">' . strip_tags(substr($row['news_content'], 0, 130)) . ' ...</p>
		                            <!-- Card info -->
		                            <ul class="nav nav-divider text-white-force align-items-center d-none d-sm-inline-block">
		                                <li class="nav-item">
		                                    <div class="nav-link">
		                                        <div class="d-flex align-items-center text-white position-relative">
		                                            <div class="avatar avatar-sm">
		                                                <img class="avatar-img rounded-circle" src="dist/media/admin-male.svg" alt="avatar">
		                                            </div>
		                                            <span class="ms-3">by <a href="#" class="stretched-link text-reset btn-link">C.O</a></span>
		                                        </div>
		                                    </div>
		                                </li>
		                                <li class="nav-item">' . pretty_date_notime($row["ca"]) . '</li>
		                                <li class="nav-item">5 min read</li>
		                            </ul>
		                        </div>
		                    </div>
		                </div>
		            </div>
				';
			}
			return $this->output_onefeatured;
		}

		// single view for news
		public function singleView($conn, $newsUrl) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category 
				INNER JOIN tein_admin 
				ON tein_admin.admin_id = tein_news.news_created_by 
				WHERE tein_news.news_url = ?
				AND tein_news.news_status = ? 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([$newsUrl, 0]);
			$row = $statement->fetchAll();
			//dnd($row);
			if ($statement->rowCount() > 0) {
				return '
					<!-- =======================
				    Inner intro START -->
				    <section class="pt-2">
				        <div class="container">
				            <div class="row">
				                <div class="col-12">
				                    <div class="card bg-dark-overlay-5 overflow-hidden card-bg-scale h-400 text-center" style="background-image:url(' . PROOT . $row[0]["news_media"] . '); background-position: center left; background-size: cover;">
				                        <!-- Card Image overlay -->
				                        <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
				                            <div class="w-100 my-auto">
				                                <!-- Card category -->
				                                <a href="' . PROOT . 'category/' . $row[0]["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row[0]["category"]) . '</a>
				                                <!-- Card title -->
				                                <h2 class="text-white display-5">' . ucwords($row[0]["news_title"]) . '</h2>
				                                <!-- Card info -->
				                                <ul class="nav nav-divider text-white-force align-items-center justify-content-center">
				                                    <li class="nav-item">
				                                        <div class="nav-link">
				                                            <div class="d-flex align-items-center text-white position-relative">
				                                                <div class="avatar avatar-sm">
				                                                    <img class="avatar-img rounded-circle" src="' . PROOT . 'dist/media/admin-male.svg" alt="avatar">
				                                                </div>
				                                                <span class="ms-3">by <a href="#" class="stretched-link text-reset btn-link">C.O</a></span>
				                                            </div>
				                                        </div>
				                                    </li>
				                                    <li class="nav-item">' . pretty_date_notime($row[0]['ca']) . '</li>
				                                    <li class="nav-item">5 min read</li>
				                                    <li class="nav-item">' . $row[0]["news_views"] . ' view' . (($row[0]["news_views"] > 1) ? 's' : '') . '</li>
				                                </ul>
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
				    Main START -->
				    <section class="pt-0">
				        <div class="container position-relative" data-sticky-container>
				            <div class="row">
				                <!-- Main Content START -->
				                <div class="col-lg-9 mb-5">
				                    <p>' . nl2br($row[0]['news_content']) . ' </p>
				                </div>

				                
				';
			} else {
				return false;
			}
		}

		//
		public function updateViews($conn, $newsUrl) {
			$query = "
	        	UPDATE tein_news 
	        	SET news_views = news_views + 1
	        	WHERE news_url = ?
	        ";
	        $statement = $conn->prepare($query);
	        $statement->execute([$newsUrl]);
		}


		// popular post
		public function get_popular_post($conn) {}

		// News subscriber
		public function addSubscriber($conn, $email) {
			// check if email already exist
			$sql = "
				SELECT * FROM tein_subscribers 
				WHERE subscriber_email = ? 
			";
			$statement = $conn->prepare($sql);
			$statement->execute([$email]);

			if ($statement->rowCount() > 0) {
				return 'This email has already been used to subscribed.';
			} else {
				$query = "
					INSERT INTO tein_subscribers (subscriber_email) 
					VALUES (?)
				";
				$statement = $conn->prepare($query);
				$result = $statement->execute([$email]);
				if (isset($result)) {
					return 'You have successfully subscribed for daily news update.';
				} else {
					return false;
				}
			}
		}

		// all subscribers
		public function allSubscribers($conn) {
			$query = "
				SELECT * FROM tein_subscribers 
				ORDER BY id DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute();
			$rows = $statement->fetchAll();
			$count = $statement->rowCount();

			if ($count > 0) {
				foreach ($rows as $row) {
					$this->output_subscribers .= '
						<tr>
							<td>' . $this->i . '</td>
							<td>' . $row['subscriber_email'] . '</td>
							<td>' . pretty_date_notime($row['createdAt']) . '</td>
							<td>
								<a href="javascript:;" class="badge bg-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteSubscriberModal' . $this->i . '">Delete</a>
								<!-- DELETE MODAL -->
								<div class="modal fade" id="deleteSubscriberModal' . $this->i . '" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-dialog-centered modal-sm">
								    	<div class="modal-content" style="background-color: rgb(51, 51, 51);"">
								    		<div class="modal-body">
								      			<p>When you delete this subscriber, this subscriber will no longer be able to receive daily updates on news.</p>
								        		<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
								        		<a href=' . PROOT . ".in/blog/subscribers/delete_subscriber/" . $row['id'] . ' class="btn btn-sm btn-outline-secondary">Confirm Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>
							</td>
						</tr>
					';
					$this->i++;
				}
			} else {
				$this->output_subscribers .= '
					<tr>
						<td colspan="4">No data found</td>
					</tr>
				';
			}

			return $this->output_subscribers;
		}

		public function deleteSubscriber($conn, $id) {
			$query = "
				DELETE FROM tein_subscribers 
				WHERE id = ? 
			";
			$statement = $conn->prepare($query);
			$result = $statement->execute([$id]);

			if ($result) {
				// code...
				return true;
			} else {
				return false;
			}
		}

		// fetch popular news
		public function popularNews($conn) {
			$thisMonth = date('m');
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_status = ? 
				AND tein_news.news_views > ? 
				AND MONTH(tein_news.createdAt) = ?
				ORDER BY tein_news.news_views DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute([0, 10, $thisMonth]);
			$rows = $statement->fetchAll();
			if ($statement->rowCount() > 0) {
				// code...
				foreach ($rows as $row) {
					// code...
					$this->output_poupular .= '
						<div class="card">
                            <!-- Card img -->
                            <div class="position-relative">
                                <img class="card-img" src="' . PROOT . $row["news_media"]. '" alt="Card image">
                                <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                    <!-- Card overlay bottom -->
                                    <div class="w-100 mt-auto">
                                        <a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-secondary mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-3">
                                <h5 class="card-title"><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link text-reset fw-bold">' . ucwords($row["news_title"]) . '</a></h5>
                                <!-- Card info -->
                                <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
                                    <li class="nav-item">
                                        <div class="nav-link">
                                            <div class="d-flex align-items-center position-relative">
                                                <div class="avatar avatar-xs">
                                                    <img class="avatar-img rounded-circle" src="dist/media/admin-male.svg" alt="avatar">
                                                </div>
                                                <span class="ms-3">by <a href="#" class="stretched-link text-reset btn-link">C.O</a></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">' . pretty_date_notime($row["ca"]) . '</li>
                                </ul>
                            </div>
                        </div>
					';
				}
			} else {
				// return 'asem';
			}
			return $this->output_poupular;
		}

		// fetch popular news
		public function trendingNews($conn) {
			$thisMonth = date('m');
			$query = "
				SELECT * FROM tein_news 
				WHERE news_views > ? 
				AND MONTH(createdAt) = ? 
				ORDER BY news_views DESC
				LIMIT 4 
			";
			$statement = $conn->prepare($query);
			$statement->execute([10, $thisMonth]);
			$rows = $statement->fetchAll();
			if ($statement->rowCount() > 0) {
				foreach ($rows as $row) {
					// code...
					$this->output_trending .= '
						<div> <a href="' . PROOT . 'view/' . $row["news_url"] . '" class="text-reset btn-link">' . ucwords($row["news_title"]) . '</a></div>
					';
				}
			} else {
				$this->output_trending .= '
						<div> <a href="' . PROOT . 'get-membership-card" class="text-reset btn-link">Register TEIN membership card</a></div>
						<div> <a href="' . PROOT . 'pay.dues" class="text-reset btn-link">Pay TEIN membership dues</a></div>
					';
			}
			return $this->output_trending;
		}

		// fetch popular news
		public function recentFooterNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_status = ? 
				ORDER BY tein_news.id DESC 
				LIMIT 2
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			$rows = $statement->fetchAll();
			if ($statement->rowCount() > 0) {
				foreach ($rows as $row) {
					// code...
					$this->output_footer .= '
					<div class="mb-4 position-relative">
		                    <div><a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a></div>
		                    <a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link text-white fw-normal">' . ucwords($row["news_title"]) . '</a>
		                    <ul class="nav nav-divider align-items-center small mt-2 text-muted">
		                        <li class="nav-item position-relative">
		                            <div class="nav-link">by <a href="#" class="stretched-link text-reset btn-link">C.O</a>
		                            </div>
		                        </li>
		                        <li class="nav-item">' . pretty_date_notime($row["ca"]) . '</li>
		                    </ul>
		                </div>
					';
				}
			} else {;
			}
			return $this->output_footer;
		}


	}

