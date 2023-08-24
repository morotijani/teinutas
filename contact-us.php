 <?php 
    require_once ("db_connection/conn.php");

    $News = new News;
    $Category = new Category;

    include ('news.header.php');

    

?>

	<!-- =======================
	Inner intro START -->
	<section>
		<div class="container">
			<div class="row">
	      		<div class="col-md-9 mx-auto text-center">
	        		<h1 class="display-4">Contact us</h1>
			        <!-- breadcrumb -->
			        <nav class="d-flex justify-content-center" aria-label="breadcrumb">
			          	<ol class="breadcrumb breadcrumb-dots mb-0">
			            	<li class="breadcrumb-item"><a href="<?= PROOT; ?>"><i class="bi bi-house me-1"></i> Home</a></li>
			            	<li class="breadcrumb-item active">Contact us</li>
			          	</ol>
			        </nav>      
			    </div>
			</div>
		</div>
	</section>
	<!-- =======================
	Inner intro END -->


	<!-- =======================
	Contact info START -->
	<section class="pt-4">
		<div class="container">
			<div class="row">
      			<div class="col-xl-9 mx-auto">
        			<iframe class="w-100 h-300 grayscale" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.272678026434!2d-1.0808483240715212!3d10.866852957517498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe2b5be5b3e1cb7b%3A0x298ad72ea1404dbe!2sCKT-UTAS!5e0!3m2!1sen!2sgh!4v1692841531393!5m2!1sen!2sgh" height="500" style="border:0;" aria-hidden="false" tabindex="0"></iframe>
       
			        <div class="row mt-5">
			         	<div class="col-sm-6 mb-5 mb-sm-0">
			            	<h3>Advertise / Sponsorships</h3>
			            	<p>Contact us directly related Advertisement</p>
				            <address>CKT UTAS, Navasco Rd, GH, 30102</address>
				            <p>Call: <a href="#" class="text-reset"><u>(+233) 00-000-0000 (Toll-free)</u></a></p>
				            <p>Email: <a href="#" class="text-reset"><u>advertise@teinutas.org</u></a></p>
				            <p>Support time: Monday to Saturday 
				            	<br>
			              		8:30 am to 5:00 pm
			            	</p>
			          	</div>
			          	<div class="col-sm-6">
			            	<h3>Contact Information </h3>
			            	<p>Get in touch with us to see how we can help you with your query</p>
				            <address>CKT UTAS, Navasco Rd, GH, 14845</address>
				            <p>Call: <a href="#" class="text-reset"><u>+233-000-0000-00 (Toll-free)</u></a></p>
				            <p>Email: <a href="#" class="text-reset"><u>contact@teinutas.org</u></a></p>
				            <p>Support time: Monday to Saturday 
				              	<br>
				              	9:00 am to 5:30 pm
				            </p>
				       	</div>
			        </div>
			        
			        <hr class="my-5">
        
			        <div class="row">
			          	<div class="col-12">
			          		<h2>Contact us</h2>
			          		<p>Please fill in the form below and we will contact you very soon. Your email address will not be published.</p>
			          		<!-- Form START -->
			          		<form class="contact-form" id="contact-form" name="contactform" method="POST">
					            <!-- Main form -->
					            <div class="row">
					             	<div class="col-md-6">
					                	<!-- name -->
					                	<div class="mb-3">
					                  		<input required id="con-name" name="name" type="text" class="form-control" placeholder="Name">
					                	</div>
					              	</div>
					              	<div class="col-md-6">
					                	<!-- email -->
					                	<div class="mb-3">
					                  		<input required id="con-email" name="email" type="email" class="form-control" placeholder="E-mail">
						                </div>
						            </div>
						            <div class="col-md-12">
						                <!-- Subject -->
						                <div class="mb-3">
						                 	<input required id="con-subject" name="subject" type="text" class="form-control" placeholder="Subject">
						                </div>
						            </div>
						            <div class="col-md-12">
						                <!-- Message -->
						                <div class="mb-3">
							                <textarea required id="con-message" name="message" cols="40" rows="6" class="form-control" placeholder="Message"></textarea>
							            </div>
							        </div>
						            <!-- submit button -->
						            <div class="col-md-12 text-start"><button class="btn btn-success w-100" type="submit">Send Message</button></div>
								</div>
						    </form>
						   	<!-- Form END -->
				        </div>
				    </div>
				</div>  <!-- Col END -->
			</div>
		</div>
	</section>
	<!-- =======================
	Contact info END -->


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