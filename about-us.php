 <?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    

?>

	<!-- =======================
	Inner intro START -->
	<section class="pt-4">
		<div class="container">
			<div class="row">
	      		<div class="col-12">
			        <div class="card bg-dark-overlay-4 overflow-hidden card-bg-scale h-400 text-center" style="background-image:url(<?= PROOT; ?>dist/media/bg-2.jpg); background-position: center left; background-size: cover;">
			          	<!-- Card Image overlay -->
			          	<div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
			            	<div class="w-100 my-auto">
			              		<h1 class="text-white display-4">About us</h1>
			              		<!-- breadcrumb -->
			              		<nav class="d-flex justify-content-center" aria-label="breadcrumb">
			                		<ol class="breadcrumb breadcrumb-dark breadcrumb-dots mb-0">
			                  			<li class="breadcrumb-item"><a href="<?= PROOT; ?>"><i class="bi bi-house me-1"></i> Home</a></li>
			                  			<li class="breadcrumb-item active">About us</li>
			                		</ol>
			              		</nav>
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
	About START -->
	<section class="pt-4 pb-0">
		<div class="container">
			<div class="row">
	      		<div class="col-xl-9 mx-auto">
	        		<h2>Our story</h2>
	        		<p class="lead">
				        Tertiary | Education Institutions Network (TEIN) is the Tertiary students wing of the National Democratic Congress (NDC), the experimentation of the University students network of the NDC which will later be known as TEIN, started at KNUST in 1992.
				    </p>
	        		<p class="lead">
	        			The association was however, known as TEIN as an umbrella name for all NDC students network in all Tertiary institutions in Ghana in 1994, under the Hon. E.T. Mensah, then National Youth Organiser of the NDC, because TEIN is an intellectual structure under the Youth Wing of the NDC! Dr. Rashid Pelpuo then became the first TEIN University of Cape Coast (UCC) President among other pioneers in the University of Ghana (UG)!
	        		</p>
				    <p>The association as envisioned by the poineer included Senior comrades (Teaching and non teaching stuff) and junior comrades (Students)! The Party and the country have benefited greatly from this association over the years! After about ten years of it's existence, the NDC recognized TEIN in it's constitution with some voting rights. But it was not until 2019, that a full TEIN structure was established in the Youth Wing Under the Leadership of Lawyer George Opare Addo, National Youth Organiser. A well organized National TEIN Secretariat was established with a National TEIN Coordinators to Coordinates the activities of the students wing and established a database for the use of the party! Regional TEIN Secretariats were established to serve as an interphase between the campuses in their regions and the National TEIN Secretariat.</p>
	        	</div>
	    	</div>
		</div>
	</section>


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
              <button type="button" class="btn btn-success">Save changes</button>
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