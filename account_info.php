<?php include('header-scripts.php'); ?>
<link href="src/assets/css/light/users/account-setting.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="src/plugins/src/filepond/filepond.min.css">
<link rel="stylesheet" href="src/plugins/src/filepond/FilePondPluginImagePreview.min.css">
<link rel="stylesheet" href="src/plugins/css/light/filepond/custom-filepond.css" type="text/css" />
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<style>
    body.dark .profile-image .filepond {
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
    .filepond--file-action-button{
        display:none;
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
                            <div class="d-flex justify-content-between">
                                <h3>User Information</h3>
                                <a href="users.php" class="btn btn-primary mb-2">Back to User List</a>
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

                                                        $UserID = $_GET['id'];
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
                                                            <p class="mb-4" style="color: #888ea8;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="EmailAddress">Email Address</label>
                                                                            <input type="text" value="<?=$EmailAddress?>" class="form-control mb-3" id="EmailAddress" placeholder="Email Address" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="EmailAddress">Contact No</label>
                                                                            <input type="text" value="<?=$ContactNo?>" class="form-control mb-3" id="ContactNo" placeholder="Contact No" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Firstname">First Name</label>
                                                                            <input type="text" value="<?=$Firstname?>" class="form-control mb-3" id="Firstname" placeholder="First Name" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Lastname">Last Name</label>
                                                                            <input type="text" value="<?=$Lastname?>" class="form-control mb-3" id="Lastname" placeholder="Last Name" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="Address">Address</label>
                                                                            <input type="text" value="<?=$Address?>" class="form-control mb-3" id="Address" placeholder="Address" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Gender">Gender</label>
                                                                            <select class="form-select mb-3" id="Gender" disabled>
                                                                                <option <?php if($Gender == "Male"){ echo "selected";}?> value="Male">Male</option>
                                                                                <option <?php if($Gender == "Female"){ echo "selected";}?> value="Female">Female</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="Birthdate">Birthdate</label>
                                                                            <input type="date" value="<?=$Birthdate?>" class="form-control mb-3" id="Birthdate" disabled>
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
                                                                            <select class="form-select mb-3" id="RegistrationStatus" disabled>
                                                                                <option <?php if($Gender == "Registered Voter"){ echo "selected";}?> value="Registered Voter">Registered Voter</option>
                                                                                <option <?php if($Gender == "None registered"){ echo "selected";}?> value="None registered">None registered</option>
                                                                            </select>
                                                                        </div>
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
                                                                                    if( $sortBy[0] == $_GET['id'] ) {
                                                                                        echo '<div class="RearangeBox imgThumbContainer"><div class="IMGthumbnail"><img src="'.$item.'"/></div></div>';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </center>
                                                                </div>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 0px solid transparent !important;">
                    <h5 class="modal-title" id="exampleModalLabel">Document Image</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <img style="width:100%;height:100%" id="img_Document" src="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 0px solid transparent !important">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                </div>
            </div>
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

        $("img").on("click",function(){
            $("#img_Document").attr("src",$(this).attr('src'));
            $("#exampleModal").modal("show");
        });
    </script>
</body>
</html>