<?php 

	class Search {
		private $i = 1;
		private $output = '';
		
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

		// fetch all news base on category
		public function fetchSearchNews($conn, $q) {
			$query = "
				SELECT *, tein_news.createdAt AS ca FROM tein_category 
				INNER JOIN tein_news 
				ON tein_news.news_category = tein_category.id
				WHERE (tein_news.news_title LIKE '%" . $q . "%' 
								OR MONTH(tein_news.createdAt) = '" . $q . "') 
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			$rows = $statement->fetchAll();

			if ($statement->rowCount() > 0) {
				foreach ($rows as $row) {
					$this->output .= '
		                <div class="card border rounded-3 up-hover p-4 mb-4">
							<div class="row g-3">
								<div class="col-sm-9">
									<!-- Categories -->
									<a href="' . PROOT . 'category/' . $row["category_url"] . '" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>' . ucwords($row["category"]) . '</a>
									<!-- Title -->
									<h3 class="card-title">
										<a href="' . PROOT . 'view/' . $row["news_url"] . '" class="btn-link text-reset stretched-link">' . ucwords($row["news_title"]) . '</a>
									</h3>
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
								<!-- Image -->
								<div class="col-sm-3">
									<img class="rounded-3" src="' . PROOT . $row["news_media"]. '" alt="Card image">
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

