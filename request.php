<?php include('header-scripts.php'); ?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.css">

<link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
<link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
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
                    <div class="page-meta">
                        <div class="d-flex justify-content-between">
                            <h3>List of Requests</h3>
                        </div>
                    </div>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>Document</th>
                                            <th>Purpose</th>
                                            <th>Referece No</th>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Requested Date</th>
                                            <th>Release Date</th>
                                            <th>Release By</th>
                                            <th>User Profile</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th>Attach Document</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_Selected_Row">
                                        <?php
                                        require("connection/db.php");
                                        $count = 0;
                                        $dateToday = new DateTime();    
                                        $query = "
                                        SELECT 
                                            B.ID,
                                            DATE_FORMAT( STR_TO_DATE(A.DateAdded, '%Y-%m-%d' ), '%b %d,%Y' ) AS DateAdded,
                                            B.Amount,
                                            B.PaymentMethod,
                                            A.Purpose,      
                                            B.ReferenceNo,
                                            A.Status,
                                            A.ID AS RequestID,
                                            A.Reason,
                                            B.Status AS PaymentStatus,
                                            C.ID AS UserID,
                                            C.Firstname,
                                            C.Lastname,
                                            D.DocumentName,
                                            A.ReceiveDate,
                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%b %d,%Y' ) AS DateNumber,
                                            E.Firstname AS ReleasedBy,
                                            F.EmailAddress
                                        FROM request_form A
                                        LEFT JOIN payment B ON B.RequestFormID = A.ID
                                        INNER JOIN users C ON C.ID = A.UserID
                                        INNER JOIN document_list D ON D.ID = A.DocumentID
                                        LEFT JOIN users E ON E.ID = A.ReleasedBy
                                        LEFT JOIN users F ON F.ID = C.ID
                                        ORDER BY A.ID ASC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){
                                                $ReferenceNo = "";


                                                if($row['PaymentMethod'] == "GCASH"){
                                                    $ReferenceNo = "<a class='btn_View_Receipt' ReferenceNo='".$row['ReferenceNo']."' href='#'><u>" . $row['ReferenceNo'] . "</u></a>";
                                                }
                                                else{
                                                    $ReferenceNo = $row['ReferenceNo'];
                                                }
                                                $Button = "";

                                                if ($row['Status'] == 0){
                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Confirm_Request text-info">Approve</a>&nbsp;&nbsp;';
                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Decline text-danger">Decline</a>';
                                                }
                                                else if($row['Status'] == 1){
                                                    $Button .= "<span class='badge badge-primary'>For Payment</span>&nbsp;";
                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                }
                                                else if($row['Status'] == 2){
                                                    $Button = '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Set text-info">Set Appointment</a>';
                                                }
                                                else if ($row['Status'] == 3){
                                                    $dateAdded = DateTime::createFromFormat('M d,Y', $row['DateNumber']);
                                                    $daysDiff = $dateAdded->diff($dateToday)->days;
                                                    if ($daysDiff == 0) {
                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                    } else {
                                                        $row['Status'] = "Unclaimed";
                                                        $Button .= "<span class='badge badge-warning'>".$row['Status']."</span>";
                                                    }
                                                } 
                                                else if ($row['Status'] == 5){
                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                }
                                                else{
                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                }
                                                echo '<tr Status="'.$row['Status'].'">
                                                    <td>'.ucfirst($row['Firstname']).' '.$row['Lastname'].'</td>
                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                    <td>'.$row['Purpose'].'</td>
                                                    <td>'.$ReferenceNo.'</td>
                                                    <td>'.$row['PaymentMethod'].'</td>
                                                    <td>'.$row['Amount'].'</td>
                                                    <td>'.$row['DateAdded'].'</td>
                                                    <td>'.$row['DateNumber'].'</td>
                                                    <td>'.$row['ReleasedBy'].'</td>
                                                    <td><a class="btn_view_Profile" RecordID="'.$row['UserID'].'" href="#">View</a></td>
                                                    <td>'.$Button.'</td>
                                                    <td><a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Track text-primary">Track</a></td>
                                                    <td><a href="#" RecordID="'.$row['ID'].'" EmailAddress="'.$row['EmailAddress'].'"Firstname="'.$row['Firstname'].'"Lastname="'.$row['Lastname'].'" class="btn_Upload_Document text-primary">Send Document</a></td>
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
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Receipt Image</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <img style="width:100%;height:100%" id="img_Receipt" src="">
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
    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set Appointment</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Receive Date</label>
                                <input type="date" class="form-control" id="ReceiveDate">
                                <input type="hidden" class="form-control" id="RequestFormID" disabled>
                                <input type="hidden" class="form-control" id="PaymentID" disabled>
                                <input type="hidden" class="form-control" id="UserID" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Set_Appointment">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="text" class="form-control" id="Reason">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Submit_Reason">Submit</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tracking</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="TrackingDescription"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Submit_Tracking">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Information</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6 mt-md-0 mt-4">
                            <h6 class="mb-2">User Information</h6>
                            <div class="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="EmailAddress">Email Address</label>
                                            <input type="text" class="form-control mb-3" id="EmailAddress2" placeholder="Email Address" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="EmailAddress">Contact No</label>
                                            <input type="text" class="form-control mb-3" id="ContactNo2" placeholder="Contact No" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Firstname">First Name</label>
                                            <input type="text" class="form-control mb-3" id="Firstname2" placeholder="First Name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Lastname">Last Name</label>
                                            <input type="text" class="form-control mb-3" id="Lastname2" placeholder="Last Name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Address">Address</label>
                                            <input type="text" class="form-control mb-3" id="Address2" placeholder="Address" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Gender">Gender</label>
                                            <select class="form-select mb-3" id="Gender2" disabled>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Birthdate">Birthdate</label>
                                            <input type="date" class="form-control mb-3" id="Birthdate2" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Age">Age</label>
                                            <input type="text" class="form-control mb-3" id="Age2" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="RegistrationStatus">Voter Registration Status</label>
                                            <select class="form-select mb-3" id="RegistrationStatus2" disabled>
                                                <option value="Registered Voter">Registered Voter</option>
                                                <option value="None registered">None registered</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="row mt-4">
                                <h6 class="mb-2 text-center">Documents</h6>
                            </div>
                            <div class="row mt-4 text-center" id="div_Document_List">

                                <div class="col-xl-4 mb-4">
                                    <a href="src/assets/img/lightbox-2.jpeg" class="defaultGlightbox glightbox-content">
                                        <img src="src/assets/img/lightbox-2.jpeg" alt="image" class="img-fluid" />
                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a href="src/assets/img/lightbox-3.jpeg" class="defaultGlightbox glightbox-content">
                                        <img src="src/assets/img/lightbox-3.jpeg" alt="image" class="img-fluid" />
                                    </a>
                                </div>
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

    <div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 div_Gcash_Column">
                            <div class="mb-3">
                                <label class="form-label">Upload Requested Document</label>
                                <input type="file" class="form-control" onchange="readURL(this);" id="UploadFIle">
                            </div>
                        </div>
                        <div class="col-md-12 div_Gcash_Column">
                            <div class="mb-3">
                                <img id="File" style="width: 100%;height: 100%;" src="http://placehold.it/180" alt="your image" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Save_Document">Upload</button>
                </div>
            </div>
        </div>
    </div>
    <script src="src/plugins/src/global/vendors.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="layouts/collapsible-menu/app.js"></script>
    <script src="src/assets/js/custom.js"></script>


    <script src="src/plugins/src/table/datatable/datatables.js"></script>
    <script src="src/js/iziToast.min.js"></script>

    <script>
        var glob_app_type = '';
        var data = {}
        $.ajax({
            type: 'POST',
            url: 'SMS_API/api.php',
            data: data,
            dataType:'json',
            beforeSend: function(){},
            complete: function(){},
            success: function(evt){
                iziToast.info({
                    title: 'Info',
                    timeout: 20000,
                    position: 'topRight',
                    message: evt,
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('error: ' + textStatus + ': ' + errorThrown);
            }
        });
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('#ReceiveDate').attr('min', maxDate);
        });
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            ordering:false,
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        });
        $("#tbody_Selected_Row").on("click",".btn_View_Receipt",function(){
            var ReferenceNo = $(this).attr("ReferenceNo");
            $("#img_Receipt").attr("src","images/payment/"+ReferenceNo+".webp");
            $("#exampleModal").modal('show');
        });

        var detailsEmail = {};
        $("#tbody_Selected_Row").on("click",".btn_Upload_Document",function() {
            // Call the PHP script that will send the document and email
            var RecordID = $(this).attr("RecordID");
            var EmailAddress = $(this).attr("EmailAddress");
            var Firstname = $(this).attr("Firstname");
            var Lastname = $(this).attr("Lastname");
            detailsEmail = {
                RecordID: RecordID,
                EmailAddress: EmailAddress,
                Firstname: Firstname,
                Lastname: Lastname
            };
            $("#exampleModal7").modal('show');
        });
        $("#tbody_Selected_Row").on("click",".btn_Action_Set",function(){
            var RecordID = $(this).attr("RecordID");
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            $("#UserID").val(UserID);
            $("#PaymentID").val(RecordID);
            $("#RequestFormID").val(RequestID);
            $("#exampleModal2").modal("show");
            $("#ReceiveDate").val("");
            glob_app_type = 'Set';
        });
        $("#tbody_Selected_Row").on("click",".btn_Action_Decline",function(){
            var RecordID = $(this).attr("RecordID");
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            $("#exampleModal3").attr({
                RecordID : RecordID,
                RequestID : RequestID,
                UserID : UserID,
            });
            $("#exampleModal3").modal("show");
        });
        $("#tbody_Selected_Row").on('click','.btn_Action_View_R',function(){
            var Reason = $(this).attr("Reason");
            $("#exampleModal4").modal("show");
            $("#Reason2").val(Reason);
        });
        $("#btn_Submit_Reason").on("click",function(){
            var data = {
                RequestID : $("#exampleModal3").attr('RequestID'),
                UserID : $("#exampleModal3").attr('UserID'),
                Reason : $("#Reason").val(),
            }
            if($("#Reason").val() == ""){
                Message(1,"Reason is required");
                return false;
            }
            $.ajax({
                type: 'POST',
                url: 'function/decline_request.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                if(evt > 0){
                        Message(2,"Request Successfully Declined");
                        setTimeout(function() { 
                            window.location = "request.php";
                        }, 1500);
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

      
        $("#tbody_Selected_Row").on("click",".btn_Action_Confirm_Request",function(){
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            var data = {
                RequestID : RequestID,
                UserID : UserID,
            }
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'System Message',
                message: 'Are you sure you want to proceed?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/confirm_request.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Payment successfully confirmed");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "request.php";
                                    }, 1500);
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
        $("#tbody_Selected_Row").on("click",".btn_Action_Release",function(){
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            var data = {
                RequestID : RequestID,
                UserID : UserID,
            }
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'System Message',
                message: 'Are you sure you want to proceed?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/confirm_release.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Request successfully Released");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "request.php";
                                    }, 1500);
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
        $("#tbody_Selected_Row").on("click",".btn_Action_Edit",function(){
            $("#exampleModal2").modal("show");
            var RecordID = $(this).attr("RecordID");
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            $("#UserID").val(UserID);
            $("#PaymentID").val(RecordID);
            $("#RequestFormID").val(RequestID);
            $("#exampleModal2").modal("show");
            $("#ReceiveDate").val($(this).closest('tr').find('td').eq(7).text());
            glob_app_type = 'Edit';
        });
        $("#tbody_Selected_Row").on("click",".btn_Action_Undo",function(){
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            var data = {
                RequestID : RequestID,
                UserID : UserID,
            }
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'System Message',
                message: 'Are you sure you want to proceed?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/undo.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Payment successfully confirmed");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "request.php";
                                    }, 1500);
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
        $("#btn_Set_Appointment").on("click",function(){
            var ReceiveDate = $("#ReceiveDate").val();
            var RequestFormID = $("#RequestFormID").val();
            var PaymentID = $("#PaymentID").val();
            var UserID = $("#UserID").val();

            var data = {
                ReceiveDate : ReceiveDate,
                RequestFormID : RequestFormID,
                PaymentID : PaymentID,
                UserID : UserID,
            }
            if(ReceiveDate == ""){
                Message(1,"Receive Date is required");
                return false;
            }
            $.ajax({
                type: 'POST',
                url: 'function/set_appointment.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(parseInt(evt) > 0){
                        SendSMS();
                        Message(2,"Appointment successfully submitted");
                        setTimeout(function() { 
                            window.location = "request.php";
                        }, 1500);
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
        $("#tbody_Selected_Row").on("click",".btn_Action_Track",function(){
            var RequestID = $(this).attr("RequestID");
            var UserID = $(this).attr("UserID");
            $("#exampleModal5").modal("show");
            $("#btn_Submit_Tracking").attr('UserID',UserID);
            $("#btn_Submit_Tracking").attr('RequestID',RequestID);
        });
        $("#btn_Submit_Tracking").on("click",function(){
            var TrackingDescription = $("#TrackingDescription").val();
            var RequestID = $("#btn_Submit_Tracking").attr('RequestID');
            var UserID = $("#btn_Submit_Tracking").attr('UserID');
            if(TrackingDescription == ''){
                Message(1,'Please input description');
                return false;
            }
            var data = {
                RequestID : RequestID,
                UserID : UserID,
                Description : TrackingDescription,
            }
            $.ajax({
                type: 'POST',
                url: 'function/save_tracking.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                if(evt > 0){
                        Message(2,"Tracking Successfully Added");
                        $("#exampleModal5").modal("hide");
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
        $("#tbody_Selected_Row").on("click",".btn_view_Profile",function(){
            var RecordID = $(this).attr('RecordID');
            $.ajax({
                type: 'POST',
                url: 'function/get_user_info.php',
                data: {UserID : RecordID},
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    $.each(evt,function(key,dta){
                        $("#EmailAddress2").val(dta['EmailAddress']);
                        $("#ContactNo2").val(dta['ContactNo']);
                        $("#Firstname2").val(dta['Firstname']);
                        $("#Lastname2").val(dta['Lastname']);
                        $("#Address2").val(dta['Address']);
                        $("#Gender2").val(dta['Gender']);
                        $("#Birthdate2").val(dta['Birthdate']);
                        $("#Age2").val(dta['UserAge']);
                        $("#RegistrationStatus2").val(dta['RegistrationStatus']);
                        var list_loop = '';
                        $.each(dta['Documents'],function(key,images){
                            list_loop += `
                            <div class="col-xl-4 mb-4">
                                <a href="images/docs/${images}" class="defaultGlightbox glightbox-content">
                                    <img src="images/docs/${images}" alt="image" class="img-fluid" />
                                </a>
                            </div>`;
                        });
                        $("#div_Document_List").empty().append(list_loop);
                        GLightbox({selector: '.defaultGlightbox'});
                    });
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error: ' + textStatus + ': ' + errorThrown);
                }
            });
            $("#exampleModal6").modal("show");
        });
        function SendSMS(){
            /*
            var data = {}
            $.ajax({
                type: 'POST',
                url: 'SMS_API/api.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    Message(3,evt);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error: ' + textStatus + ': ' + errorThrown);
                }
            });
            */
        }

        function _callAjax(url, data, callback) {
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    callback(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    callback({success: false, error: textStatus});
                }
            });
        }

        function uploadDocument() {
            var UploadFIle = $('#UploadFIle')[0].files;
            var form_data = new FormData();
            form_data.append('file', UploadFIle[0]);
            form_data.append('RecordID',detailsEmail.RecordID);
            form_data.append('EmailAddress',detailsEmail.EmailAddress);
            form_data.append('Firstname',detailsEmail.Firstname);
            form_data.append('Lastname',detailsEmail.Lastname);
            console.log(form_data)
            $.ajax({
                url: 'function/upload_requested_docs.php',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(evt) {
                    if (evt) {
                   
                        _callAjax('mail_send_document.php', form_data, function(response) {
                            console.log(response)
                            if (response == 'Success') {
                                setTimeout(function() { 
                                    window.location = "request.php";
                                }, 2000);
                                Message(2,"You successfully send your document");
                                $("#exampleModal7").modal('hide');
                            } else {
                                alert('Failed to send document: ' + response.error);
                            }
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.warn(xhr.responseText);
                }
            });
        }

        $("#btn_Save_Document").on("click",function() {
            uploadDocument();
        }); 

        function readURL(input) {
            if (input && input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#File').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
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
                case 3:
                    iziToast.info({
                        title: 'Info',
                        position: 'topRight',
                        message: message,
                    });
                break;
            }
        }
    </script>
</body>
</html>