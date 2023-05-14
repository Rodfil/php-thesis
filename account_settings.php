<?php include('header-scripts.php'); ?>
<link href="src/assets/css/light/users/account-setting.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="src/plugins/src/filepond/filepond.min.css">
<link rel="stylesheet" href="src/plugins/src/filepond/FilePondPluginImagePreview.min.css">
<link rel="stylesheet" href="src/plugins/css/light/filepond/custom-filepond.css" type="text/css" />
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<style>
    body.light .profile-image .filepond {
        width: 200px;
        height: 200px !important;
    }
    .ui-sortable-placeholder {
        border: 1px dashed black !important;
        visibility: visible !important;
        background: #eeeeee78 !important;
    }

    .ui-sortable-placeholder * {
        visibility: hidden;
    }

    .RearangeBox.dragElemThumbnail {
        opacity: 0.6;
    }

    .RearangeBox {
        width: 180px;
        height: 240px;
        float: left;
        font-family: sans-serif;
        display: inline-block;
        text-align: center;
        color: #673ab7;
    }

    body {
        font-family: sans-serif;
        margin: 0px;
    }

    .IMGthumbnail {
        max-width: 168px;
        height: 220px;
        margin: auto;
        background-color: #ececec;
        padding: 2px;
        border: none;
    }

    .IMGthumbnail img {
        max-width: 100%;
        max-height: 100%;
    }

    .imgThumbContainer {
        margin: 4px;
        border: solid;
        display: inline-block;
        justify-content: center;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.14);
        -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 0 4px 0 rgba(0, 0, 0, .2);
    }

    .imgThumbContainer>.imgName {
        text-align: center;
        padding: 2px 6px;
        margin-top: 4px;
        font-size: 13px;
        height: 15px;
        overflow: hidden;
    }

    .imgThumbContainer>.imgRemoveBtn {
        position: absolute;
        color: #e91e63ba;
        right: 2px;
        top: 2px;
        cursor: pointer;
        display: none;
    }

    .RearangeBox:hover>.imgRemoveBtn {
        display: block;
    }
    #sortableImgThumbnailPreview{
        display: inline-block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<body class="layout-boxed" layout="full-width">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->
    <!--  BEGIN HEADER  -->
    <?php include('header.php'); ?>
    <!--  END HEADER  -->
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <!--  BEGIN SIDEBAR  -->
        <?php include('nav-sidebar.php'); ?>
        <!--  END SIDEBAR  -->
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="account-settings-container layout-top-spacing">
                        <div class="account-content">
                            <div class="d-flex justify-content-start">
                                <h3>Account Settings</h3>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-danger mb-2" id="btn_Del_Account" type="Update">Delete Account</button>&nbsp;
                                <button class="btn btn-primary mb-2" id="btn_Confirm_Account" type="Update">Update</button>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form class="section general-info">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col-lg-12 mx-auto">
                                                    <?php
                                                        require("connection/db.php");

                                                        $Firstname = "";
                                                        $Lastname = "";
                                                        $EmailAddress = "";
                                                        $ContactNo = "";
                                                        $Address = "";
                                                        $Gender = "";
                                                        $Birthdate = "";
                                                        $RegistrationStatus = "";
                                                        $UserAge = 0;

                                                        $UserID = $_SESSION['UserID'];
                                                        $query = "SELECT * FROM `users` WHERE ID = $UserID";
                                                        if ($result = $mysqli->query($query)) {
                                                            if($result->num_rows > 0){
                                                                $row = $result->fetch_array();
                                                                $Firstname = $row['Firstname'];
                                                                $Lastname = $row['Lastname'];
                                                                $EmailAddress = $row['EmailAddress'];
                                                                $ContactNo = $row['ContactNo'];
                                                                $Address = $row['Address'];
                                                                $Gender = $row['Gender'];
                                                                $Birthdate = $row['Birthdate'];
                                                                $RegistrationStatus = $row['Birthdate'];

                                                                $DateOfBirth = $row['Birthdate'];
                                                                $birthDate = explode("-", $DateOfBirth);
                                                                $UserAge = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1): (date("Y") - $birthDate[0]));
                                                            }
                                                        }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-xl-6 mt-md-0 mt-4">
                                                            <h6 class="mb-2">User Information</h6>
                                                            <p class="mb-4" style="color: #888ea8;"></p>
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="EmailAddress">Email Address</label>
                                                                            <input type="text" value="<?=$EmailAddress?>" class="form-control mb-3" id="EmailAddress" placeholder="Email Address">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="EmailAddress">Contact No</label>
                                                                            <input type="text" value="<?=$ContactNo?>" class="form-control mb-3" id="ContactNo" placeholder="Contact No">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Firstname">First Name</label>
                                                                            <input type="text" value="<?=$Firstname?>" class="form-control mb-3" id="Firstname" placeholder="First Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Lastname">Last Name</label>
                                                                            <input type="text" value="<?=$Lastname?>" class="form-control mb-3" id="Lastname" placeholder="Last Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="Address">Address</label>
                                                                            <input type="text" value="<?=$Address?>" class="form-control mb-3" id="Address" placeholder="Address">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Gender">Gender</label>
                                                                            <select class="form-select mb-3" id="Gender">
                                                                                <option <?php if($Gender == "Male"){ echo "selected";}?> value="Male">Male</option>
                                                                                <option <?php if($Gender == "Female"){ echo "selected";}?> value="Female">Female</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Birthdate">Birthdate</label>
                                                                            <input type="date" value="<?=$Birthdate?>" class="form-control mb-3" id="Birthdate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Age">Age</label>
                                                                            <input type="text" value="<?=$UserAge?>" class="form-control mb-3" id="Age" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="RegistrationStatus">Voter Registration Status</label>
                                                                            <select class="form-select mb-3" id="RegistrationStatus">
                                                                                <option <?php if($Gender == "Registered Voter"){ echo "selected";}?> value="Registered Voter">Registered Voter</option>
                                                                                <option <?php if($Gender == "None registered"){ echo "selected";}?> value="None registered">None registered</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Password">Password</label>
                                                                            <input type="password" class="form-control mb-3" id="Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Password">Confirm Password</label>
                                                                            <input type="password" class="form-control mb-3" id="ConfirmPassword">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <a style="cursor:pointer" id="btn_Change_Password"><u>Change Password</u></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="row mt-4">
                                                                <h6 class="mb-2 text-center">Profile Photo</h6>
                                                                <div class="profile-image mt-4 pe-md-4">
                                                                    <div class="img-uploader-content">
                                                                        <input type="file" class="filepond" id="filepond" name="filepond"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-4 text-center">
                                                                <h6 class="mb-2">File Uploaded</h6>
                                                                <div class="col-md-12">
                                                                    <center>
                                                                        <div id="sortableImgThumbnailPreview">
                                                                            <?php
                                                                                $dirpath_thumbnail = 'images/docs';
                                                                                $dirpath_thumbnail .= "/*";
                                                                                $files = array();
                                                                                $files = glob($dirpath_thumbnail);
                                                                                $data = array();
                                                                                foreach($files as $item){
                                                                                    $sortBy = basename($item);
                                                                                    $sortBy = explode("_", $sortBy);
                                                                                    if( $sortBy[0] == $_SESSION['UserID'] ) {
                                                                                        echo '<div class="RearangeBox imgThumbContainer"><i basename="'.$item.'" class="material-icons imgRemoveBtn" onclick="removeThumbnailIMG(this,0)"><svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z" fill="currentColor" fill-rule="nonzero"></path></svg></i><div class="IMGthumbnail"><img src="'.$item.'"/></div></div>';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </center>
                                                                </div>
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-8">
                                                                    <input id="files" type="file" class="upload__inputfile hidden" multiple/>  
                                                                    <button type="button" class="btn btn-info mb-2" id="btn_Upload_Document_Here">Upload Document Here</button>
                                                                </div>
                                                                <div class="col-md-2"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <?php include('footer-scripts.php'); ?>
    <script src="src/plugins/src/filepond/filepond.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script>

    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/iziToast.min.js"></script>

    <script>

        $(".form-control").attr("disabled",true);

        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
        );
        pond = FilePond.create(
        document.querySelector('#filepond'), {
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            stylePanelLayout: 'compact circle',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            allowMultiple: false,
            instantUpload: false,
            allowProcess: false,
            files: [{
                source: 'images/profile/'+'<?=$UserID?>'+'.webp?v=<?php echo date('Ymdhis') ?>',
            }],
        });
        $("#btn_Upload_Document_Here").on("click",function(){
            $(".upload__inputfile").click();
        });
        $("#btn_Del_Account").on("click",function(){
            var RecordID = '<?=$_SESSION['UserID']?>';
            var data = {
                RecordID : RecordID
            };
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'Hey',
                message: 'Are you sure?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/delete_users.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"User successfully deleted");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "logout.php";
                                    }, 1000);
                                }
                                else{
                                    alert("Error occur while processing data");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                console.log('error: ' + textStatus + ': ' + errorThrown);
                            }
                        });
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast);
                    }]
                ]
            });
        });
        $("#btn_Confirm_Account").on("click",function(){
            if($(this).attr("type") == 'Update'){
                $(this).attr("type","Confirm");
                $(this).text("Confirm");
                $(".form-control").attr("disabled",false);
                return false;
            }
            if($(this).attr('type') == "Confirm"){
                var Firstname = $("#Firstname").val();
                var Lastname = $("#Lastname").val();
                var Gender = $("#Gender").val();
                var Birthdate = $("#Birthdate").val();
                var RegistrationStatus = $("#RegistrationStatus").val();
                var Address = $("#Address").val();
                var EmailAddress = $("#EmailAddress").val();
                var UserID = '<?=$UserID?>';
                var data = {
                    Firstname : Firstname,
                    Lastname : Lastname,
                    Birthdate : Birthdate,
                    RegistrationStatus : RegistrationStatus,
                    Address : Address,
                    EmailAddress : EmailAddress,
                    UserID : UserID,
                };
                $.ajax({
                    type: 'POST',
                    url: 'function/save_accounts.php',
                    data: data,
                    dataType:'json',
                    beforeSend: function(){},
                    complete: function(){},
                    success: function(evt){
                        if(evt > 0){
                            Upload_Image_Profile(evt);
                            Upload_Image_Docs(evt);
                            
                            Message(2,"Account successfully updated");
                            setTimeout(function() { 
                                window.location = "account_settings.php";
                            }, 1000);
                        }
                        else{
                            Message(1,"Error occur while processing data");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log('error: ' + textStatus + ': ' + errorThrown);
                    }
                });
            }
        });
        $("#btn_Change_Password").on("click",function(){
            var Password = $("#Password").val();
            var ConfirmPassword = $("#ConfirmPassword").val();
            var UserID = '<?=$UserID?>';
            if(Password == ''){
                Message(1,'Please input password');
                return false;
            }
            if(ConfirmPassword == ''){
                Message(1,'Please input confirm password');
                return false;
            }
            if(ConfirmPassword != Password){
                Message(1,'Password mismatch');
                return false;
            }
            var data = {
                Password : Password,
                UserID : UserID,
            }
            $.ajax({
                type: 'POST',
                url: 'function/change_password.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"Password successfully updated");
                        $("#Password").val("");
                        $("#ConfirmPassword").val("");
                    }
                    else{
                        Message(1,"Error occur while processing data");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error: ' + textStatus + ': ' + errorThrown);
                }
            });


        });
        document.getElementById('files').addEventListener('change', handleFileSelect, false);

        function Upload_Image_Profile(UserID){
            var form_Data = new FormData();
            pondFiles = pond.getFiles();
            for (var i = 0; i < pondFiles.length; i++) {
                form_Data.append('file[]', pondFiles[i].file);
                form_Data.append('UserID', UserID);
            }
            $.ajax({
                url: 'function/upload_image_user.php',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_Data,
                type: 'post',
                success: function(evt){
                    console.log(evt);
                }
            });
        }
        function Upload_Image_Docs(UserID){
            var file = $('#files').prop('files');
            var len = file.length;
            var form_data = new FormData();
            for (let i = 0; i < len; i++){
                var file_data = $('#files').prop('files')[i];
                form_data.append('file[]', file_data);
                form_data.append('UserID', UserID);
            }
            if (form_data) {
                $.ajax({
                    url: "function/upload_image_docs.php",
                    type: "POST",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(res) {},       
                    error: function(res) {}       
                });
            }
        }
        function handleFileSelect(evt) {
            var files = evt.target.files; 
            var output = document.getElementById("sortableImgThumbnailPreview");
            for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                var imgThumbnailElem = `<div class='RearangeBox imgThumbContainer'><i class='material-icons imgRemoveBtn' onclick='removeThumbnailIMG(this,1,'')'><svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z" fill="currentColor" fill-rule="nonzero"></path></svg></i><div class='IMGthumbnail' ><img  src='${e.target.result}' title='${theFile.name}'/></div></div>`;
                    output.innerHTML = output.innerHTML + imgThumbnailElem; 
                };
            })(f);
            reader.readAsDataURL(f);
            }
        }
        function removeThumbnailIMG(elm,type){
            elm.parentNode.outerHTML = '';
            if(type == 0){
                $.ajax({
                    type: 'POST',
                    url: 'function/delete_image.php',
                    data: {url : elm.getAttribute("basename")},
                    dataType:'json',
                    beforeSend: function(){},
                    complete: function(){},
                    success: function(evt){
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log('error: ' + textStatus + ': ' + errorThrown);
                    }
                });

            }
        }
        function Message(flag,message){
            switch(flag){
                case 1:
                    iziToast.warning({
                        title: 'Warning',
                        position: 'topRight',
                        message: message,
                    });
                break;
                case 2:
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: message,
                    });
                break;
            }
        }
    </script>
</body>
</html>