<?php 

	class Category {
		private $i = 1;
		private $output = '';
		
		public function listCategory($conn) {
			$query = "
				SELECT * FROM tein_category 
				WHERE category_trash = ? 
				ORDER BY category
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			return $statement->fetchAll();
		}

		public function listCategoryWithLimit($conn) {
			$query = "
				SELECT * FROM tein_category 
				WHERE category_trash = ? 
				ORDER BY category 
				LIMIT 4
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			return $statement->fetchAll();
		}

		public function allCategory($conn) {
			$query = "
		        SELECT * FROM tein_category 
		        ORDER BY category ASC 
		    ";
		    $statement = $conn->prepare($query);
		    $statement->execute();
		    $categories = $statement->fetchAll();
		    if ($statement->rowCount() > 0) {
		    	// code...
			    foreach ($categories as $category) {
	                $this->output .= "
	                	<tr>
		                    <td>
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . ".in/blog/category/edit_category/" . $category['id'] . "'>Edit</a>
		                    </td>
		                    <td>" . ucwords($category['category']) . "</td>
		                    <td>" . pretty_date($category['createdAt']) . "</td>
		                    <td>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>

								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='subscribeModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51);'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . ".in/blog/category/delete/" . $category['id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
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

		public function deleteCategory($conn, $id) {
	        $query = "
	        	DELETE FROM tein_category 
	        	WHERE id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $result = $statement->execute([$id]);
	        return $result;
		}


		// fetch all news base on category
		public function fetchCategoryNews($conn, $url) {
			$query = "
				SELECT *, tein_news.createdAt AS ca FROM tein_category 
				INNER JOIN tein_news 
				ON tein_news.news_category = tein_category.id
				WHERE tein_category.category_url = ? 
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute([$url, 0]);
			$rows = $statement->fetchAll();

			if ($statement->rowCount() > 0) {
				foreach ($rows as $row) {
					$this->output .= '
						<div class="card mb-4">
		                    <div class="row">
		                        <div class="col-md-5">
		                            <img class="rounded-3" src="' . PROOT . $row["news_media"]. '" alt="">
		                        </div>
		                        <div class="col-md-7 mt-3 mt-md-0">
		                            <a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
		                            <h3><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link stretched-link text-reset">' . ucwords($row["news_title"]) . '</a></h3>
		                            <p>' . strip_tags(substr($row['news_content'], 0, 400)) . ' ...</p>
		                            <!-- Card info -->
		                            <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
		                                <li class="nav-item">
		                                    <div class="nav-link">
		                                        <div class="d-flex align-items-center position-relative">
		                                            <div class="avatar avatar-xs">
		                                                <img class="avatar-img rounded-circle" src="' . PROOT . 'dist/media/admin-male.svg" alt="avatar">
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
			} else {
				return false;
			}
			return $this->output;
		}
	}

