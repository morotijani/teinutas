<?php
    require_once ("db_connection/conn.php");

    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Membership Dues . TEIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="<?= PROOT; ?>dist/media/logo/logo.png" class="img-fluid" alt="TEIN's LOGO">
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="display-5 fw-bold">Pay membership dues</h1>
                        <p class="small text-muted">Any registed member of TEIN is supposed to pay dues every year till completion of school.</p>
                        <a href="<?= PROOT; ?>" class="text-secondary">^ go home.</a>
                    </div>
                </div>

                 <form id="membershipForm" method="POST">
                    <div class="row">
                        <div class="col-12" id="first">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="member_id" id="member_id" placeholder="Membership Id">
                                <label for="member_id">Membership Id</label>
                                <div class="form-text text-danger membership_msg"></div>
                            </div>
                        </div>

                        <div class="mt-2 mb-2" id="next-button">
                            <button class="btn btn-dark" type="button" id="next-1">Next >></button>
                        </div>

                        <span id="second" class="d-none">
                            <div class="col mb-2">
                                <input class="form-control form-control-lg member_level" id="level" type="text" disabled readonly>
                            </div>

                            <div class="mt-2 mb-2">
                                <input type="hidden" id="ref" name="ref">
                                <input type="hidden" id="mID" name="mID">
                                <input type="hidden" id="email" name="email">
                                <button onclick="payWithPaystack()" class="btn btn-outline-success" name="submit" id="submit">Pay dues</button>
                                <br>
                                <div class="form-text"><a href="javascript:;" id="prev-1"><< Back</a></div>
                            </div>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include (".in/includes/footer.php"); ?>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        
        $('#next-1').click(function(e) {
            e.preventDefault();
            $('.membership_msg').html('');

            if ($("#member_id").val() == '') {
                $('.membership_msg').html('* Membership id needed!');
                $("#member_id").focus()
                $('#level').val('');
                return false;
            } else {
                var  member_id = $('#member_id').val()

                $.ajax ({
                    url: '<?= PROOT; ?>controller/check.exist.php',
                    method : 'POST',
                    data: {member_id : member_id},
                    success : function(data) {
                        const response = JSON.parse(data);
                        if (response["msg"] == '') {
                            $('.membership_msg').html('Membership Id do not exist, you can claim a membership id <a href="<?= PROOT; ?>get-membership-card">here</a>');
                            $("#member_id").attr('readonly', false);
                            return false
                        } else {
                            if (response["msg"] == 'done') {
                                $('#level').val('All dues paid');
                                $('#level').addClass('text-success fw-bolder');
                                
                                $('#submit').attr('disabled', true)
                                $('#submit').addClass('d-none')
                            } else {
                                $('#mID').val(response["mid"]);
                                $('#email').val(response["email"]);
                                $('#level').val(response["level"]);

                                $('#submit').attr('disabled', false)
                                $('#submit').removeClass('d-none')
                            }

                            $('.membership_msg').html('');
                            $('#second').removeClass('d-none');
                            $("#member_id").attr('readonly', true);
                            $('#next-button').addClass('d-none');

                            return true;
                        }
                    }
                })
            }
        })

        $("#prev-1").click(function() {
            $('#second').addClass('d-none')
            $('#next-button').removeClass('d-none')
            $("#member_id").attr('readonly', false);
            $('#first').removeClass('d-none')
            $('#level').val('');
        })

        $('#member_id').on('keyup', function(e) {
            e.preventDefault();
            var  member_id = $('#member_id').val()
            $.ajax ({
                url: '<?= PROOT; ?>controller/check.exist.php',
                method : 'POST',
                data: {member_id : member_id},
                success : function(data) {
                    const response = JSON.parse(data);
                    if (response["msg"] == '') {
                        $('.membership_msg').html('Membership Id do not exist, you can claim a membership ID <a href="<?= PROOT; ?>get-membership-card">here</a>');
                        return false
                    } else {
                        if (response["msg"] == 'done') {
                            $('#level').val('All dues paid');
                            $('#level').addClass('text-success fw-bolder');
                            
                            $('#submit').attr('disabled', true)
                            $('#submit').addClass('d-none')
                        } else {
                            $('#mID').val(response["mid"]);
                            $('#email').val(response["email"]);
                            $('#level').val(response["level"]);

                            $('#submit').attr('disabled', false)
                            $('#submit').removeClass('d-none')
                        }

                        $('.membership_msg').html('');
                        return true;
                    }
                }
            })
        })

        const paymentForm = document.getElementById('membershipForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();
            
            var  member_id = $('#member_id').val()

            if (member_id == '') {
                $('#member_id').focus();
                $('.membership_msg').html('Student ID is required!');
                return false;
            } else {
                $('.membership_msg').html('');
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

                        var reference = $('#ref').val();
                        var id = $('#mID').val();
                        var level = $('#level').val();
                        $.ajax ({
                            url: '<?= PROOT; ?>controller/dues.payment.php',
                            method : 'POST',
                            data: {
                                id : id, 
                                level : level, 
                                reference : reference
                            },
                            success : function(data) {
                                if (data == '') {
                                    window.location = '<?= PROOT; ?>dues.paid/' + level;
                                }
                            }
                        })
                    }
                })

                var  member_id = $('#member_id').val()
                $.ajax ({
                    url: '<?= PROOT; ?>controller/check.exist.php',
                    method : 'POST',
                    data: {member_id : member_id},
                    success : function(data) {
                        const response = JSON.parse(data);
                        if (response["msg"] == '') {
                            $('.membership_msg').html('Membership Id do not exist, you can claim a membership ID <a href="<?= PROOT; ?>get-membership-card">here</a>');
                            return false
                        } else {
                            if (response["msg"] == 'done') {
                                $('#level').val('All dues paid');
                                $('#level').addClass('text-success fw-bolder');
                                
                                $('#submit').attr('disabled', true)
                                $('#submit').addClass('d-none')
                            } else {
                                $('#mID').val(response["mid"]);
                                $('#email').val(response["email"]);
                                $('#level').val(response["level"]);

                                $('#submit').attr('disabled', false)
                                $('#submit').removeClass('d-none')
                            }

                            $('.membership_msg').html('');

                            handler.openIframe();
                        }
                    }
                })
            }
        }               
    </script>

</body>
</html>