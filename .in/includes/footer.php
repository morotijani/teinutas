    
    <script src="<?= PROOT; ?>dist/js/jquery-3.6.0.js"></script>
    <script src="<?= PROOT; ?>dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Accept only numbers (no negative or decimal number)
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }

        $(document).ready(function() {
            // Fade out messages
            $("#temporary").fadeOut(5000);

            // Upload IMAGE Temporary
            $(document).on('change','#passport', function() {

                var property = document.getElementById("passport").files[0];
                var image_name = property.name;

                var image_extension = image_name.split(".").pop().toLowerCase();
                if (jQuery.inArray(image_extension, ['jpeg', 'png', 'jpg']) == -1) {
                    alert("The file extension must be .jpg, .png, .jpeg");
                    $('#passport').val('');
                    return false;
                }

                var image_size = property.size;
                if (image_size > 15000000) {
                    alert('The file size must be under 15MB');
                    return false;
                } else {

                    var form_data = new FormData();
                    form_data.append("passport", property);
                    $.ajax({
                        url: "<?= PROOT; ?>.in/auth/temporary.upload.php",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#upload_file").html("<div class='text-success font-weight-bolder'>Uploading member image ...</div>");
                        },
                        success: function(data) {
                            $("#upload_file").html(data);
                            $('#passport').css('visibility', 'hidden');
                        }
                    });
                }
            });

            // DELETE TEMPORARY UPLOADED IMAGE
            $(document).on('click', '.removeImg', function() {
                var tempuploded_file_id = $(this).attr('id');

                $.ajax ({
                    url: "<?= PROOT; ?>.in/auth/delete.temporary.uploaded.php",
                    method: "POST",
                    data:{
                        tempuploded_file_id : tempuploded_file_id
                    },
                    success: function(data) {
                        $('#removeTempuploadedFile').remove();
                        $('#passport').css('visibility', 'visible');
                        $('#passport').val('');

                        $('#news_media').css('visibility', 'visible');
                        $('#news_media').val('');
                    }
                });
            });


            // Upload IMAGE Temporary
            $(document).on('change','#news_media', function() {

                var property = document.getElementById("news_media").files[0];
                var image_name = property.name;

                var image_extension = image_name.split(".").pop().toLowerCase();
                if (jQuery.inArray(image_extension, ['jpeg', 'png', 'jpg', 'gif']) == -1) {
                    alert("The file extension must be .jpg, .png, .jpeg, .gif");
                    $('#news_media').val('');
                    return false;
                }

                var image_size = property.size;
                if (image_size > 15000000) {
                    alert('The file size must be under 15MB');
                    return false;
                } else {

                    var form_data = new FormData();
                    form_data.append("news_media", property);
                    $.ajax({
                        url: "<?= PROOT; ?>.in/auth/temporary.upload.news.php",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#upload_file").html("<div class='text-success font-weight-bolder'>Uploading news image ...</div>");
                        },
                        success: function(data) {
                            $("#upload_file").html(data);
                            $('#news_media').css('visibility', 'hidden');
                        }
                    });
                }
            });

        });
    </script>   
</body>
</html>