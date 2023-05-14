<?php include('header-scripts.php'); ?>
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
<style>.breadcrumb-item+.breadcrumb-item::before {content: ',';}
    .payment p {
        font-weight: bold;
        font-size: 1.5rem;
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

                    <!-- BREADCRUMB -->
                    <div class="page-meta">
                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Welcome</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$_SESSION['Firstname']?></li>
                            </ol>
                        </nav>
                    </div>
                    <!-- /BREADCRUMB -->    
                    <div class="row layout-top-spacing">
                        <?php
                            $CountDocs = 0;
                            $dirpath_thumbnail = 'images/docs';
                            $dirpath_thumbnail .= "/*";
                            $files = array();
                            $files = glob($dirpath_thumbnail);
                            $data = array();
                            foreach($files as $item){
                                $sortBy = basename($item);
                                $sortBy = explode("_", $sortBy);
                                if( $sortBy[0] == $_SESSION['UserID'] ) {
                                    $CountDocs++;
                                }
                            }
                        ?>
                        <?php if($CountDocs == 0){ ?>
                        <div class="col-12">
                            <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                <strong>Please update your account</strong> and Upload your supporting document <a href="account_settings.php">Account Settings</a>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-12">
                            <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                <strong>Online Appointment and Payment</strong> <a href="#" class="btn_Request_Form" DocumentID="0">Requestion Form</a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                            require("connection/db.php");
                            $RegistrationStatus = "";
                            $UserID = $_SESSION['UserID'];
                            $query = "SELECT * FROM `users` WHERE ID = $UserID";
                            if ($result = $mysqli->query($query)) {
                                if($result->num_rows > 0){
                                    $row = $result->fetch_array();
                                    $DateOfBirth = $row['Birthdate'];
                                    $birthDate = explode("-", $DateOfBirth);
                                    $UserAge = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1): (date("Y") - $birthDate[0]));
                                }
                            }
                        ?>
                        <?php if($UserAge < 18){ ?>
                        <div class="col-12">
                            <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                <strong>This account is under age</strong> Please bring your parents or relatives</a>
                            </div>
                        </div>
                        <?php }?>
                        <div class="col-12">
                            <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                <strong>View </strong> <a href="help.php" DocumentID="0">list of requirements</a>
                            </div>
                        </div>
                        <?php
                            require("connection/db.php");
                            $count = 0;
                            $isDefault = 0;
                            $query = "
                            SELECT 
                                A.ID,
                                A.DocumentID,
                                B.DocumentName,
                                COUNT(A.DocumentID) AS cnt
                            FROM `request_form` A
                            INNER JOIN document_list B ON B.ID = A.DocumentID
                            GROUP BY A.DocumentID 
                            ORDER BY COUNT(A.DocumentID) DESC LIMIT 2";
                            if ($result = $mysqli->query($query)) {
                                $count = $result->num_rows;
                                if($count >= 2){
                                    $countIndex = 0;
                                    while($row = $result->fetch_array()){
                                        $bg = ($countIndex == 0 ? 'primary' : 'secondary');
                                        $IsHidden = ($CountDocs == 0 ? 'hidden' : '');
                                        echo '<div class="col-xl-6 mb-4">
                                            <div class="card bg-'.$bg.'">
                                                <div class="card-body pt-3">
                                                    <h5 class="card-title mb-3">'.$row['DocumentName'].'</h5>
                                                    <p class="card-text">Powerful CRM admin dashboard template based on Bootstrap and Sass for all kind of back-end projects.</p>
                                                </div>
                                                <div class="card-footer px-4 pt-0 border-0">
                                                    <button class="btn btn-warning mb-2 me-4 btn_Request_Form '.$IsHidden.'" DocumentID="'.$row['DocumentID'].'">Request Form</button>
                                                </div>
                                            </div>
                                        </div>';
                                        $countIndex++;
                                        $isDefault = 1;
                                    }
                                }
                            }

                            if($isDefault == 0){
                                $query = "SELECT * FROM `document_list` ORDER BY ID ASC LIMIT 2";
                                if ($result = $mysqli->query($query)) {
                                    $countIndex = 0;
                                    while($row = $result->fetch_array()){
                                        $bg = ($countIndex == 0 ? 'primary' : 'secondary');
                                        $IsHidden = ($CountDocs == 0 ? 'hidden' : '');
                                        echo '<div class="col-xl-6 mb-4">
                                            <div class="card bg-'.$bg.'">
                                                <div class="card-body pt-3">
                                                    <h5 class="card-title mb-3">'.$row['DocumentName'].'</h5>
                                                    <p class="card-text">Powerful CRM admin dashboard template based on Bootstrap and Sass for all kind of back-end projects.</p>
                                                </div>
                                                <div class="card-footer px-4 pt-0 border-0">
                                                    <button class="btn btn-warning mb-2 me-4 btn_Request_Form '.$IsHidden.'" DocumentID="'.$row['ID'].'">Request Form</button>
                                                </div>
                                            </div>
                                        </div>';
                                        $countIndex++;
                                    }
                                }
                            }
                        ?>
                        
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="card">
                                <div class="card-footer" style="border-top: 1px solid transparent;">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-1">
                                            <a href="#" class="btn btn-warning btn-lg w-100 btn_Request_Form" DocumentID="0">Request Document</a>
                                        </div>
                                        <div class="col-md-4 col-12 mb-1">
                                            <a href="account_settings.php" class="btn btn-warning btn-lg w-100">Upload Document</a>
                                        </div>
                                        <div class="col-md-4 col-12 mb-1">
                                            <a href="pay.php?docid=0" class="btn btn-warning btn-lg w-100">Pay Here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Booking Summary</h4>
                                        </div>          
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Document</th>
                                                    <th>Purpose</th>
                                                    <th>Date Requested</th>
                                                    <th>Transaction No</th>
                                                    <th>Release Date</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                            </thead>
                                            <tbody id="tbody_Selected_Row">
                                                <?php
                                                    require("connection/db.php");
                                                    $count = 0;
                                                    $UserID = $_SESSION['UserID'];
                                                    $query = "
                                                    SELECT 
                                                        A.ID,
                                                        B.DocumentName,
                                                        B.ID AS DocumentID,
                                                        A.Purpose,
                                                        DATE_FORMAT(A.DateAdded, '%M %e, %Y') AS DateAdded,
                                                        A.Reason,
                                                        A.ReferenceNo,
                                                        CASE WHEN A.ReceiveDate IS NULL THEN 'N/A' ELSE DATE_FORMAT(A.ReceiveDate, '%M %e, %Y') END AS ReceiveDate,
                                                        B.Price,
                                                        A.IsRated,
                                                        A.Status,
                                                        C.Firstname AS ReleasedBy
                                                       
                                                    FROM `request_form` A
                                                    INNER JOIN document_list B ON B.ID = A.DocumentID
                                                    LEFT JOIN users C ON C.ID = A.ReleasedBy
                                                    WHERE A.UserID = $UserID
                                                    ORDER BY A.ID DESC";
                                                    if ($result = $mysqli->query($query)) {
                                                        while($row = $result->fetch_array()){

                                                            $Status = "";
                                                            $buttonPay = '';
                                                            $buttonDel = '';
                                                            switch($row['Status']){
                                                                case 0: // Pending
                                                                    $Status = '<span class="badge badge-warning">Pending</span>';
                                                                    $buttonPay = '<a href="#" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-info">Edit</a>&nbsp;&nbsp;';
                                                                    $buttonDel = '<a href="#" RecordID="'.$row['ID'].'" class="btn_Action_Delete text-danger">Delete</a>&nbsp;&nbsp;';
                                                                break;
                                                                case 1: // Ready for payment
                                                                    $Status = '<span class="badge badge-primary">Ready for payment</span>';
                                                                    $buttonPay = '<a href="#" dataReferenceNo="'.$row['ReferenceNo'].'" dataDate="'.$row['DateAdded'].'" dataAmount="'.$row['Price'].'" RecordID="'.$row['ID'].'" class="btn_Action_Pay text-info">Pay Now</a>&nbsp;&nbsp;';
                                                                    $buttonDel = '';
                                                                break;
                                                                case 2: // Processing
                                                                    $Status = '<span class="badge badge-info">Processing</span>';
                                                                    $buttonPay = '';
                                                                    $buttonDel = '';
                                                                break;
                                                                case 3: // Approved
                                                                    $Status = '<span class="badge badge-success">Approved</span>';
                                                                    $buttonPay = '';
                                                                    $buttonDel = '';
                                                                break;
                                                                case 4: // Declined
                                                                    $Status = '<span class="badge badge-danger">Declined</span>';
                                                                    $buttonPay = '<a href="#" Reason="'.$row['Reason'].'" RecordID="'.$row['ID'].'" class="btn_Action_Resend text-info">Resend</a>&nbsp;&nbsp;';
                                                                    $buttonDel = '<a href="#" Reason="'.$row['Reason'].'" RecordID="'.$row['ID'].'" class="btn_Action_View_R text-info">View Reason</a>';
                                                                break;
                                                                case 5: // Released
                                                                    $Status = '<span class="badge badge-secondary">Released</span>';
                                                                    if($row['IsRated'] == 0){
                                                                        $buttonPay = '<a href="feedback.php?id='.$row['ID'].'" class="btn_Action_Rate text-info">Rate</a>&nbsp;&nbsp;';
                                                                    }
                                                                    $buttonDel = '<a href="#" ReleasedBy="'.$row['ReleasedBy'].'" ReceiveDate="'.$row['ReceiveDate'].'" Price="'.$row['Price'].'" ReferenceNo="'.$row['ReferenceNo'].'" class="btn_Action_View_Summary text-info">View Summary</a>';
                                                                break;
                                                            }
                                                            echo '<tr RecordID="'.$row['ID'].'" DocumentID="'.$row['DocumentID'].'" Purpose="'.$row['Purpose'].'">
                                                                <td>'.$row['DocumentName'].'</td>
                                                                <td>'.$row['Purpose'].'</td>
                                                                <td>'.$row['DateAdded'].'</td>
                                                                <td>'.$row['ReferenceNo'].'</td>
                                                                <td>'.$row['ReceiveDate'].'</td>
                                                                <td class="text-center">'.$Status.'</td>
                                                                <td class="text-center">
                                                                    '.$buttonPay.'
                                                                    '.$buttonDel.'
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request Document</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Document Name</label>
                                <select class="form-control" id="DocumentID" name="DocumentID">
                                    <option value='0' disabled>Select</option>
                                    <?php
                                        require("connection/db.php");
                                        $RegistrationStatus = "";
                                        $UserID = $_SESSION['UserID'];
                                        $query = "SELECT * FROM `users` WHERE ID = $UserID";
                                        if ($result = $mysqli->query($query)) {
                                            if($result->num_rows > 0){
                                                $row = $result->fetch_array();
                                                $RegistrationStatus = ($row['RegistrationStatus'] == "Registered Voter" ? 1 : 0);
                                            }
                                        }
                                        $query = "SELECT * FROM `document_list` ORDER BY DocumentName DESC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){
                                                if($RegistrationStatus == 0){
                                                    if($row['IsNonVoter'] == 1){
                                                        echo '<option value='.$row['ID'].'>'.$row['DocumentName'].'</option>';
                                                    }
                                                }
                                                if($RegistrationStatus == 1){
                                                    if($row['IsVoter'] == 1){
                                                        echo '<option value='.$row['ID'].'>'.$row['DocumentName'].'</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="mb-3" id="">
                                <label class="form-label">Purpose</label>
                                <select class="form-control" id="Purpose">
                                    <option value='' disabled selected>Select</option>
                                   <!--  <option value='Job / Employment'>Job / Employment</option>   -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p style="color:#000;">Disclaimer : Supporting documents should be attached or else the document will denied</p>
                            <p>Go to account settings : <a href="account_settings.php">My Profile</a></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Save_Request">Request</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control" id="Amount" disabled>
                                <input type="hidden" class="form-control" id="RequestFormID" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" id="Date" disabled>
                            </div>
                        </div>
                        <div class="col-md-12 payment">
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select type="text" class="form-control" id="PaymentMethod">
                                    <option value="Over the counter">Over the counter</option>
                                    <option value="GCASH">GCASH</option>
                                </select>
                                <p>Note: For Gcash Payment, please send your payment to the information below. Please indicate your fullname in the message box as well.</p>
                                <span>Name: Papart Amaya</span><br>
                                <span>Phone Number: 09457163995</span>
                            </div>
                        </div>
                        <div class="col-md-12 div_Gcash_Column">
                            <div class="mb-3">
                                <label class="form-label">Reference No</label>
                                <input type="text" class="form-control" id="ReferenceNo">
                            </div>
                        </div>
                        <div class="col-md-12 div_Gcash_Column">
                            <div class="mb-3">
                                <label class="form-label">Upload Your Receipt</label>
                                <input type="file" class="form-control" onchange="readURL(this);" id="UploadFIle">
                            </div>
                        </div>
                        <div class="col-md-12 div_Gcash_Column">
                            <div class="mb-3">
                                <img id="Image_Receipt" style="width: 100%;height: 100%;" src="http://placehold.it/180" alt="your image" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Save_Payment">Pay</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Reason</label>
                                <textarea class="form-control" id="Reason2" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Summary</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Document Name : <span id="span_DocumentName"></span></p>
                            <p>Purpose : <span id="span_Purpose"></span></p>
                            <p>Price : <span id="span_Price"></span></p>
                            <p>Transaction no. : <span id="span_TransactionNo"></span></p>
                            <p>Release Date : <span id="span_ReleaseDate"></span></p>
                            <p>Release By : <span id="span_ReleaseBy"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer-scripts.php'); ?>
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/iziToast.min.js"></script>
    <script>
        $(function() {
  // Add event listener to the "Document Name" dropdown
            $('#DocumentID').change(function() {
                // Get the selected document ID
                var documentID = $(this).val();
                console.log("its id",documentID);
                
                // Make AJAX call to fetch the corresponding purposes
                $.ajax({
                url: 'function/get_purposes.php',
                data: { documentID: documentID },
                success: function(response) {
                    // Update the "Purpose" dropdown with the fetched purposes
                 
                var purposes = JSON.parse(response);
                console.log(purposes);
                // Clear the existing options from the "Purpose" dropdown
                $('#Purpose').empty();
                
                // Add a default "Select" option
                $('#Purpose').append('<option value="" disabled selected>Select</option>');
                
                // Loop through the fetched purposes and add an option for each purpose
                for (var i = 0; i < purposes.length; i++) {
                    var purpose = purposes[i];
                    $('#Purpose').append('<option value="' + purpose.Purpose_Description + '">' + purpose.Purpose_Description + '</option>');
                }
                }
                });
            });
        });
        var glob_RecordID = 0;
        $(".btn_Request_Form").on("click",function(){
            var DocumentID = $(this).attr('DocumentID');
            glob_RecordID = 0;
            $("#DocumentID").val(DocumentID);
            $("#exampleModal").modal("show");
            
        });
        $("#tbody_Selected_Row").on('click','.btn_Action_Edit',function(){
            var DocumentID = $(this).closest('tr').attr('DocumentID');
            var Purpose = $(this).closest('tr').attr('Purpose');
            var RecordID = $(this).closest('tr').attr('RecordID');
            glob_RecordID = RecordID;
            $("#DocumentID").val(DocumentID);
            $("#Purpose").val(Purpose);
            $("#exampleModal").modal("show");
        });
        $("#btn_Save_Request").on("click",function(){
            var DocumentID = $("#DocumentID").find("option:selected").val();
            var DocumentName = $("#DocumentID").find("option:selected").text();
            var Purpose = $("#Purpose").find("option:selected").val();
            var ReferenceNo = $("#ReferenceNo").val();
            if(DocumentID == "0"){
                Message(1,"Please select document");
                return false;
            }
            if(Purpose == ""){
                Message(1,"Please select purpose");
                return false;
            }
            var data = {
                UserID : '<?=$_SESSION['UserID']?>',
                DocumentID : DocumentID,
                DocumentName : DocumentName,
                RecordID : glob_RecordID,
                Purpose : Purpose,
            }
            $.ajax({
                type: 'POST',
                url: 'function/save_request_form.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"Request successfully sent");
                        setTimeout(function() { 
                            window.location = "home.php";
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
        });
        $("#tbody_Selected_Row").on('click','.btn_Action_Pay',function(){
            var RecordID = $(this).attr('RecordID');
            var Amount = $(this).attr('dataAmount');
            var Date = $(this).attr('dataDate');
            
            $("#Date").val(Date);
            $("#Amount").val(Amount);
            $("#RequestFormID").val(RecordID);
            $("#ReferenceNo").val("");
            $("#PaymentMethod").val("Over the counter");
            $("#exampleModal2").modal("show");
            $(".div_Gcash_Column").addClass("hidden");
        });
        $("#PaymentMethod").on("change",function(){
            var PaymentMethod = $(this).find("option:selected").val();
            switch(PaymentMethod){
                case "Over the counter":
                    $(".div_Gcash_Column").addClass("hidden");
                break;
                case "GCASH":
                    $(".div_Gcash_Column").removeClass("hidden");
                break;
            }
        });
        $("#tbody_Selected_Row").on('click','.btn_Action_Resend',function(){
            var RecordID = $(this).attr('RecordID');
            var data = {
                UserID : '<?=$_SESSION['UserID']?>',
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
                            url: 'function/resend_request.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Request form successfully resend");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "home.php";
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
        $("#tbody_Selected_Row").on('click','.btn_Action_Delete',function(){
            var RecordID = $(this).attr('RecordID');
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
                            url: 'function/delete_request.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Request form successfully deleted");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "home.php";
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
        $("#tbody_Selected_Row").on('click','.btn_Action_View_Summary',function(){
            var row = $(this).closest('tr');
            $("#exampleModal5").modal("show");
            $("#span_DocumentName").text(row.find('td').eq(0).text());
            $("#span_Purpose").text(row.find('td').eq(1).text());
            $("#span_Price").text($(this).attr('Price'));
            $("#span_TransactionNo").text($(this).attr('ReferenceNo'));
            $("#span_ReleaseDate").text($(this).attr('ReceiveDate'));
            $("#span_ReleaseBy").text($(this).attr('ReleasedBy'));
        });

       
        $("#btn_Save_Payment").on("click",function(){
            var RequestFormID = $("#RequestFormID").val();
            var Amount = $("#Amount").val();
            var PaymentMethod = $("#PaymentMethod").val();
            var ReferenceNo = $("#ReferenceNo").val();
            if(PaymentMethod == "Over the counter"){
                var currentdate = new Date(); 
                var rowCount = currentdate.getDate()+""+(currentdate.getMonth()+1)+""+currentdate.getFullYear()+""+currentdate.getHours()+""+currentdate.getMinutes()+""+currentdate.getSeconds();
                var data = {
                    RequestFormID : RequestFormID,
                    UserID : '<?=$_SESSION['UserID']?>',
                    Amount : Amount,
                    PaymentMethod : PaymentMethod,
                    ReferenceNo : 'OTC' + rowCount
                }
            }
            else{
                if(ReferenceNo == ""){
                    Message(1,"Reference No is required");
                    return false;
                }
                if( document.getElementById("UploadFIle").files.length == 0 ){
                    Message(1,"Image receipt is required");
                    return false;
                }
                var data = {
                    RequestFormID : RequestFormID,
                    UserID : '<?=$_SESSION['UserID']?>',
                    Amount : Amount,
                    PaymentMethod : PaymentMethod,
                    ReferenceNo : ReferenceNo,
                }
            }
            $.ajax({
                type: 'POST',
                url: 'function/save_payment.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt == "Exists"){
                        Message(1,"Payment Already Exists");
                    }
                    else{
                        if(PaymentMethod == "GCASH"){
                            UploadImage_Receipt(ReferenceNo);
                        }
                        Message(2,"You successfully completed your online requestion, Please wait for approval");
                        setTimeout(function() { 
                            window.location = "home.php";
                        }, 2000);
                        $("#exampleModal2").modal("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error: ' + textStatus + ': ' + errorThrown);
                }
            });
            
        });
        $("#tbody_Selected_Row").on('click','.btn_Action_View_R',function(){
            var Reason = $(this).attr("Reason");
            $("#exampleModal4").modal("show");
            $("#Reason2").val(Reason);
        });
        function UploadImage_Receipt(RefNo){
            var UploadFIle = $('#UploadFIle')[0].files;
            var form_Data = new FormData();
            form_Data.append('file', UploadFIle[0]);
            form_Data.append('ReferenceNo', RefNo);
            $.ajax({
                url: 'function/upload_image_transaction.php',
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
                case 3:
                    iziToast.info({
                        title: 'Info',
                        position: 'topRight',
                        message: message,
                    });
                break;
            }
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#Image_Receipt').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>