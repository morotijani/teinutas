<?php 
    require_once ("db_connection/conn.php");
    $Category = new Category;
    $News = new News;
    include ('news.header.php');

    session_destroy();
?>

    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto text-center py-5">
                    <div class="rounded-2 bg-dark-overlay-5 overflow-hidden p-4 p-md-5" style="background-image: url(<?= PROOT; ?>dist/media/bg-1.jpg);">
                            <div class="d-md-flex justify-content-between align-items-center">
                                <h4 class="text-white mb-2 mb-md-0">Get membership card . TEIN . <?= date("Y"); ?></h4>
                                <a href="<?= PROOT; ?>" class="btn btn-success mb-0">Go Home</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <form id="membershipForm" enctype="multipart/form-data" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student Id">
                                <label for="student_id">Student Id</label>
                                <div class="form-text text-danger student_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name">
                                <label for="fname">First Name</label>
                                <div class="form-text text-danger fname_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name">
                                <label for="lname">Last Name</label>
                                <div class="form-text text-danger lname_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                <label for="email">Email</label>
                                <div class="form-text text-danger email_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="sex" id="sex">
                                    <option value="">...</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                <label for="sex">Sex</label>
                                <div class="form-text text-danger sex_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="school" id="school" placeholder="School">
                                <label for="school">School</label>
                                <div class="form-text text-danger school_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="department" id="department" placeholder="Department">
                                <label for="department">Department</label>
                                <div class="form-text text-danger department_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="programme" id="programme" placeholder="Programme">
                                <label for="programme">Programme</label>
                                <div class="form-text text-danger programme_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="level" id="level">
                                    <option value="">...</option>
                                    <option>L100</option>
                                    <option>L200</option>
                                    <option>L300</option>
                                    <option>L400</option>
                                </select>
                                <label for="level">Level</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="number" min="1900" max="<?= date('Y');?>" step="1" class="form-control form-control-sm" name="yoa" placeholder="Year of Admission" id="yoa">
                                <label for="yoa">Year of Admission</label>
                                <div class="form-text text-danger yoa_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" min="1900" max="<?= date('Y') - 1;?>" step="1" class="form-control form-control-sm" name="yoc" id="yoc" placeholder="Year of Completion">
                                <label for="yoc">Year of Completion</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm" name="hostel" id="hostel" placeholder="Name of Hostel">
                                <label for="hostel">Name of Hostel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="region" id="region" placeholder="Region">
                                <label for="region">Region</label>
                                <div class="form-text text-danger region_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="constituency" id="constituency" placeholder="Constituency">
                                <label for="constituency">Constituency</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="branch" id="branch"  placeholder="Branch (Polling Station)">
                                <label for="branch">Branch (Polling Station)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="WhatsApp Contact">
                                <label for="whatsapp">WhatsApp Contact</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Telephone">
                                <label for="telephone">Telephone Number</label>
                                <div class="form-text text-danger telephone_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select type="text" class="form-select" name="card_type" id="card_type">
                                    <option value="">...</option>
                                    <option>Plastic</option>
                                    <option>Booklet</option>
                                </select>
                                <label for="card_type">Card Type</label>
                                <div class="form-text text-danger card_type_msg"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <label for="passport" class="form-label">Passpot size Image</label>
                                <input type="file" class="form-control" id="passport" name="passport">
                                <span id="upload_file"></span>
                                <div class="form-text text-danger passport_msg"></div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="executive">Executive/Committee Member</label>
                            <select name="executive" id="executive">
                                <option value=""></option>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

                        <div class="mt-2 mb-2">
                            <input type="hidden" id="ref" name="ref">
                            <button onclick="payWithPaystack()" class="btn btn-outline-success" name="submit" id="submit">Register</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <?php include (".in/includes/footer.php"); ?>
    <?php include ("news.footer.php"); ?>
    <script src="https://js.paystack.co/v1/inline.js"></script> 
    <script>

        $('#email').on('keyup', function(e) {
            e.preventDefault();
            var  email = $('#email').val()

            $.ajax ({
                url: '<?= PROOT; ?>controller/check.exist.php',
                method : 'POST',
                data: {email : email},
                success : function(data) {
                    if (data == '') {
                        $('.email_msg').html();
                        return true
                    } else {
                        $('.email_msg').html(data);
                        return false;
                    }
                }
            })
        })
        
        $('#student_id').on('keyup', function(e) {
            e.preventDefault();
            var  studentId = $('#student_id').val()

            $.ajax ({
                url: '<?= PROOT; ?>controller/check.exist.php',
                method : 'POST',
                data: {studentId : studentId},
                success : function(data) {
                    if (data == '') {
                        $('.student_msg').html();
                        return true
                    } else {
                        $('.student_msg').html(data);
                        return false;
                    }
                }
            })
        })

        const paymentForm = document.getElementById('membershipForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();
            
            var  student_id = $('#student_id').val()
            var  fname = $('#fname').val()
            var  lname = $('#lname').val()
            var  email = $('#email').val()
            var  sex = $('#sex').val()
            var  school = $('#school').val()
            var  department = $('#department').val()
            var  programme = $('#programme').val()
            var  yoa = $('#yoa').val()
            var  region = $('#region').val()
            var  telephone = $('#telephone').val()
            var  card_type = $('#card_type').val()
            var  passport = $('#passport').val()

            if (student_id == '') {
                $('#student_id').focus();
                $('.student_msg').html('Student id is required!');
                return false;
            } else {
                
                $('.student_msg').html('');
                if (fname == '') {
                    $('#fname').focus();
                    $('.fname_msg').html('First name required!');
                    return false;
                } else {
                    $('.student_msg').html('');
                    $('.fname_msg').html('');
                    if (lname == '') {
                        $('#lname').focus();
                        $('.lname_msg').html('Last name required!');
                        return false;
                    } else {
                        $('.student_msg').html('');
                        $('.fname_msg').html('');
                        $('.lname_msg').html('');
                        if (email == '') {
                            $('#email').focus();
                            $('.email_msg').html('Email required!');
                            return false;
                        } else {
                       
                            $('.student_msg').html('');
                            $('.fname_msg').html('');
                            $('.lname_msg').html('');
                            $('.email_msg').html('');
                            if (sex == '') {
                                $('#sex').focus();
                                $('.sex_msg').html('Sex is required!');
                                return false;
                            } else {
                                $('.student_msg').html('');
                                $('.fname_msg').html('');
                                $('.lname_msg').html('');
                                $('.email_msg').html('');
                                $('.sex_msg').html('');
                                if (school == '') {
                                    $('#school').focus();
                                    $('.school_msg').html('School is required!');
                                    return false;
                                } else {
                                    $('.student_msg').html('');
                                    $('.fname_msg').html('');
                                    $('.lname_msg').html('');
                                    $('.email_msg').html('');
                                    $('.sex_msg').html('');
                                    $('.school_msg').html('');
                                    if (department == '') {
                                        $('#department').focus();
                                        $('.department_msg').html('Department is required!');
                                        return false;
                                    } else {
                                        $('.student_msg').html('');
                                        $('.fname_msg').html('');
                                        $('.lname_msg').html('');
                                        $('.email_msg').html('');
                                        $('.sex_msg').html('');
                                        $('.school_msg').html('');
                                        $('.department_msg').html('');
                                        if (programme == '') {
                                            $('#programme').focus();
                                            $('.programme_msg').html('Programme is required!');
                                            return false;
                                        } else {
                                            $('.student_msg').html('');
                                            $('.fname_msg').html('');
                                            $('.lname_msg').html('');
                                            $('.email_msg').html('');
                                            $('.sex_msg').html('');
                                            $('.school_msg').html('');
                                            $('.department_msg').html('');
                                            $('.programme_msg').html('');
                                            if (yoa == '') {
                                                $('#yoa').focus();
                                                $('.yoa_msg').html('Year of admission required!');
                                                return false;
                                            } else {
                                                $('.student_msg').html('');
                                                $('.fname_msg').html('');
                                                $('.lname_msg').html('');
                                                $('.email_msg').html('');
                                                $('.sex_msg').html('');
                                                $('.school_msg').html('');
                                                $('.department_msg').html('');
                                                $('.programme_msg').html('');
                                                $('.yoa_msg').html('');
                                                if (region == '') {
                                                    $('#region').focus();
                                                    $('.region_msg').html('Region is required!');
                                                    return false;
                                                } else {
                                                    $('.student_msg').html('');
                                                    $('.fname_msg').html('');
                                                    $('.lname_msg').html('');
                                                    $('.email_msg').html('');
                                                    $('.sex_msg').html('');
                                                    $('.school_msg').html('');
                                                    $('.department_msg').html('');
                                                    $('.programme_msg').html('');
                                                    $('.yoa_msg').html('');
                                                    $('.region_msg').html('');
                                                    if (telephone == '') {
                                                        $('#telephone').focus();
                                                        $('.telephone_msg').html('Telephone number is required!');
                                                        return false;
                                                    } else {
                                                        $('.student_msg').html('');
                                                        $('.fname_msg').html('');
                                                        $('.lname_msg').html('');
                                                        $('.email_msg').html('');
                                                        $('.sex_msg').html('');
                                                        $('.school_msg').html('');
                                                        $('.department_msg').html('');
                                                        $('.programme_msg').html('');
                                                        $('.yoa_msg').html('');
                                                        $('.region_msg').html('');
                                                        $('.telephone_msg').html('');
                                                        if (card_type == '') {
                                                            $('#card_type').focus();
                                                            $('.card_type_msg').html('Card Type required!');
                                                            return false;
                                                        } else {
                                                            $('.student_msg').html('');
                                                            $('.fname_msg').html('');
                                                            $('.lname_msg').html('');
                                                            $('.email_msg').html('');
                                                            $('.sex_msg').html('');
                                                            $('.school_msg').html('');
                                                            $('.department_msg').html('');
                                                            $('.programme_msg').html('');
                                                            $('.yoa_msg').html('');
                                                            $('.region_msg').html('');
                                                            $('.telephone_msg').html('');
                                                            $('.card_type_msg').html('');
                                                            if (passport == '') {
                                                                $('#passport').focus();
                                                                $('.passport_msg').html('Passport size photo is required!');
                                                                return false;
                                                            } else {
                                                                $('.student_msg').html('');
                                                                $('.fname_msg').html('');
                                                                $('.lname_msg').html('');
                                                                $('.email_msg').html('');
                                                                $('.sex_msg').html('');
                                                                $('.school_msg').html('');
                                                                $('.department_msg').html('');
                                                                $('.programme_msg').html('');
                                                                $('.yoa_msg').html('');
                                                                $('.region_msg').html('');
                                                                $('.telephone_msg').html('');
                                                                $('.card_type_msg').html('');
                                                                $('.passport_msg').html('');

                                                                let handler = PaystackPop.setup({
                                                                    key: '<?php echo PAYSTACK_PUBLIC_KEY; ?>', // Replace with your public key
                                                                    email: document.getElementById("email").value,
                                                                    // amount: document.getElementById("amount").value * 100,
                                                                    amount: 20 * 100,
                                                                    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                                                    // label: "Optional string that replaces customer email"
                                                                    currency: 'GHS',
                                                                    channels: ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'], 
                                                                    onClose: function() {
                                                                      alert('Window closed.');
                                                                    },
                                                                    callback: function(response) {
                                                                        $('#ref').val(response.reference);

                                                                        var data = new FormData();

                                                                        // Form data
                                                                        var form_data = $('#membershipForm').serializeArray();
                                                                        $.each(form_data, function (key, input) {
                                                                            data.append(input.name, input.value);
                                                                        });

                                                                        // File data
                                                                        var property = document.getElementById("passport").files[0];
                                                                        data.append("passport", property);

                                                                        // Custom data
                                                                        data.append('key', 'value');                                                                        
                                                                        $.ajax({
                                                                            url : 'controller/add.member.verify.payment.php',
                                                                            method : 'POST',
                                                                            data: data,
                                                                            contentType: false,
                                                                            cache: false,
                                                                            processData: false,
                                                                            success : function(data) {
                                                                                if (data == '') {
                                                                                    window.location = '<?= PROOT; ?>member.success';
                                                                                } else {
                                                                                    console.log(data);
                                                                                }
                                                                            }
                                                                        });
                                                                        // let message = 'Payment complete! Reference: ' + response.reference;
                                                                        // alert(message);
                                                                    }
                                                                });

                                                                $.ajax ({
                                                                    url: '<?= PROOT; ?>controller/check.exist.php',
                                                                    method : 'POST',
                                                                    data: {studentId : student_id},
                                                                    success : function(data) {
                                                                        if (data == '') {

                                                                            $('.student_msg').html();

                                                                            $.ajax ({
                                                                                url: '<?= PROOT; ?>controller/check.exist.php',
                                                                                method : 'POST',
                                                                                data: {email : email},
                                                                                success : function(data) {
                                                                                    if (data == '') {
                                                                                        $('.email_msg').html();

                                                                                        handler.openIframe();

                                                                                    } else {
                                                                                        $('.email_msg').html(data);
                                                                                        $('#email').focus()
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                            })
                                                                        } else {
                                                                            $('.student_msg').html(data);
                                                                            $('#student_id').focus()
                                                                            return false;
                                                                        }
                                                                    }
                                                                })
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    </script>

</body>
</html>