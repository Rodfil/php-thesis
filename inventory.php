<?php include('header-scripts.php'); ?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.css">

<link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
<link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="src/plugins/src/glightbox/glightbox.min.css">
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
                            <h3>User List</h3>
                        </div>
                    </div>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <div class="row mb-4 mt-3">
                                    <div class="col-sm-3 col-12">
                                        <div class="nav flex-column nav-pills mb-sm-0 mb-3 text-center mx-auto" id="v-line-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active mb-3" id="v-line-pills-pending-tab" data-bs-toggle="pill" href="#v-line-pills-pending" role="tab" aria-controls="v-line-pills-pending" aria-selected="true">Pending</a>
                                            <a class="nav-link mb-3  text-center" id="v-line-pills-forpayment-tab" data-bs-toggle="pill" href="#v-line-pills-forpayment" role="tab" aria-controls="v-line-pills-forpayment" aria-selected="false">For Payment</a>
                                            <a class="nav-link mb-3  text-center" id="v-line-pills-forreleasing-tab" data-bs-toggle="pill" href="#v-line-pills-forreleasing" role="tab" aria-controls="v-line-pills-forreleasing" aria-selected="false">For Releasing</a>
                                            <a class="nav-link  text-center" id="v-line-pills-released-tab" data-bs-toggle="pill" href="#v-line-pills-released" role="tab" aria-controls="v-line-pills-released" aria-selected="false">Released</a>
                                            <a class="nav-link  text-center" id="v-line-pills-declined-tab" data-bs-toggle="pill" href="#v-line-pills-declined" role="tab" aria-controls="v-line-pills-declined" aria-selected="false">Declined</a>
                                            <a class="nav-link  text-center" id="v-line-pills-unclaimed-tab" data-bs-toggle="pill" href="#v-line-pills-unclaimed" role="tab" aria-controls="v-line-pills-unclaimed" aria-selected="false">Unclaimed</a>
                                        </div>
                                    </div>

                                    <div class="col-sm-9 col-12">
                                        <div class="tab-content" id="v-line-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-line-pills-pending" role="tabpanel" aria-labelledby="v-line-pills-pending-tab">
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                        $query = "
                                                        SELECT 
                                                            B.ID,
                                                            DATE_FORMAT( STR_TO_DATE(A.DateAdded, '%Y-%m-%d'), '%b %d, %Y') AS DateAdded,
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                            FROM request_form A
                                                            LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                            INNER JOIN users C ON C.ID = A.UserID
                                                            INNER JOIN document_list D ON D.ID = A.DocumentID
                                                            LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                            WHERE A.Status = 0
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
                                                                    if($row['DateNumber'] > date('Ymd')){
                                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                                    }
                                                                    else{
                                                                        $Button .= "<span class='badge badge-warning'>Delayed</span>";
                                                                    }
                                                                }
                                                                else if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                    <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                                    <td>'.$row['Purpose'].'</td>
                                                                    <td>'.$ReferenceNo.'</td>
                                                                    <td>'.$row['PaymentMethod'].'</td>
                                                                    <td>'.$row['Amount'].'</td>
                                                                    <td>'.$row['DateAdded'].'</td>
                                                                </tr>';
                                                                
                                                            }
                                                          
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-line-pills-forpayment" role="tabpanel" aria-labelledby="v-line-pills-forpayment-tab">
                                                <table id="zero-config2" class="table dt-table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Document</th>
                                                            <th>Purpose</th>
                                                            <th>Referece No</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                        $query = "
                                                        SELECT 
                                                            B.ID,
                                                            DATE_FORMAT( STR_TO_DATE(A.DateAdded, '%Y-%m-%d'), '%b %d, %Y') AS DateAdded,
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                        FROM request_form A
                                                        LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                        INNER JOIN users C ON C.ID = A.UserID
                                                        INNER JOIN document_list D ON D.ID = A.DocumentID
                                                        LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                        WHERE A.Status = 1
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
                                                                    if($row['DateNumber'] > date('Ymd')){
                                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                                    }
                                                                    else{
                                                                        $Button .= "<span class='badge badge-warning'>Delayed</span>";
                                                                    }
                                                                }
                                                                else if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                    <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                                    <td>'.$row['Purpose'].'</td>
                                                                    <td>'.$ReferenceNo.'</td>
                                                                    <td>'.$row['PaymentMethod'].'</td>
                                                                    <td>'.$row['Amount'].'</td>
                                                                    <td>'.$row['DateAdded'].'</td>
                                                                </tr>';
                                                            
                                                            }
                                                           
                                                        }
                                                      
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-line-pills-forreleasing" role="tabpanel" aria-labelledby="v-line-pills-forreleasing-tab">
                                                <table id="zero-config3" class="table dt-table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Document</th>
                                                            <th>Purpose</th>
                                                            <th>Referece No</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                      
                                                        $query = "
                                                        SELECT 
                                                            B.ID,
                                                            Date_Format( STR_TO_DATE(A.DateAdded, '%Y-%m-%d'), '%b %d, %Y') AS DateAdded,
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                        FROM request_form A
                                                        LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                        INNER JOIN users C ON C.ID = A.UserID
                                                        INNER JOIN document_list D ON D.ID = A.DocumentID
                                                        LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                        WHERE A.Status = 3
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
                                                                    if($row['DateNumber'] > date('Ymd')){
                                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                                    }
                                                                    else{
                                                                        $Button .= "<span class='badge badge-warning'>Delayed</span>";
                                                                    }
                                                                }
                                                                else if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                    <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                                    <td>'.$row['Purpose'].'</td>
                                                                    <td>'.$ReferenceNo.'</td>
                                                                    <td>'.$row['PaymentMethod'].'</td>
                                                                    <td>'.$row['Amount'].'</td>
                                                                    <td>'.$row['DateAdded'].'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="tab-pane fade" id="v-line-pills-released" role="tabpanel" aria-labelledby="v-line-pills-released-tab">
                                            <button class="btn btn-primary" id="generate-pdf-btn">Generate PDF</button>
                                                <table id="zero-config4" class="table dt-table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Document</th>
                                                            <th>Purpose</th>
                                                            <th>Reference No</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                        $totalAmount = 0;
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%b%d,%Y' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                        FROM request_form A
                                                        LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                        INNER JOIN users C ON C.ID = A.UserID
                                                        INNER JOIN document_list D ON D.ID = A.DocumentID
                                                        LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                        WHERE A.Status = 5
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
                                                                    if($row['DateNumber'] > date('Ymd')){
                                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                                    }
                                                                    else{
                                                                        $Button .= "<span class='badge badge-warning'>Delayed</span>";
                                                                    }
                                                                }
                                                                 if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                <td>'.ucfirst($row['DocumentName']).'</td>
                                                                <td>'.$row['Purpose'].'</td>
                                                                <td>'.$ReferenceNo.'</td>
                                                                <td>'.$row['PaymentMethod'].'</td>
                                                                <td>'.$row['Amount'].'</td>
                                                                <td>'.$row['DateAdded'].'</td>
                                                            </tr>';
                                                            $totalAmount += $row['Amount'];
                                                            }
                                                            echo '</tbody>
                                                            <tfoot>
                                                              <tr>
                                                                <td colspan="5" style="text-align:right; margin-left:5px">Total Amount:</td>
                                                                <td>'.$totalAmount.'</td>
                                                                <td></td>
                                                              </tr>
                                                            </tfoot>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-line-pills-declined" role="tabpanel" aria-labelledby="v-line-pills-declined-tab">
                                                <table id="zero-config5" class="table dt-table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Document</th>
                                                            <th>Purpose</th>
                                                            <th>Referece No</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                        $query = "
                                                        SELECT 
                                                            B.ID,
                                                            DATE_FORMAT( STR_TO_DATE(A.DateAdded, '%Y-%m-%d'), '%b %d, %Y') AS DateAdded,
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                            FROM request_form A
                                                            LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                            INNER JOIN users C ON C.ID = A.UserID
                                                            INNER JOIN document_list D ON D.ID = A.DocumentID
                                                            LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                            WHERE A.Status = 4
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
                                                                    if($row['DateNumber'] > date('Ymd')){
                                                                        $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                                                                        $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                                                                    }
                                                                    else{
                                                                        $Button .= "<span class='badge badge-warning'>Delayed</span>";
                                                                    }
                                                                }
                                                                else if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                    <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                                    <td>'.$row['Purpose'].'</td>
                                                                    <td>'.$ReferenceNo.'</td>
                                                                    <td>'.$row['PaymentMethod'].'</td>
                                                                    <td>'.$row['Amount'].'</td>
                                                                    <td>'.$row['DateAdded'].'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-line-pills-declined" role="tabpanel" aria-labelledby="v-line-pills-declined-tab">
                                                <table id="zero-config5" class="table dt-table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Document</th>
                                                            <th>Purpose</th>
                                                            <th>Referece No</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require("connection/db.php");
                                                        $count = 0;
                                                        $dateToday = new DateTime();
                                                        $dateTodayStr = $dateToday->format('Y-m-d');
                                                        $query = "
                                                        SELECT 
                                                            B.ID,
                                                            DATE_FORMAT( STR_TO_DATE(A.DateAdded, '%Y-%m-%d'), '%b %d, %Y') AS DateAdded,
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
                                                            DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                                                            E.Firstname AS ReleasedBy
                                                            FROM request_form A
                                                            LEFT JOIN payment B ON B.RequestFormID = A.ID
                                                            INNER JOIN users C ON C.ID = A.UserID
                                                            INNER JOIN document_list D ON D.ID = A.DocumentID
                                                            LEFT JOIN users E ON E.ID = A.ReleasedBy
                                                            WHERE A.Status = 3 AND A.ReceiveDate = '$dateTodayStr' -- compare with the string version of the date
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
                                                                else if ($row['Status'] == 3 && $row['ReceiveDate'] == $dateTodayStr){
                                                                    $Button .= "<span class='badge badge-warning'>Unclaimed</span>";
                                                                }
                                                                else if ($row['Status'] == 5){
                                                                    $Button .= "<span class='badge badge-info'>Released</span>";
                                                                }
                                                                else{
                                                                    $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                                                                    $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                                                                }
                                                                echo '<tr>
                                                                    <td>'.ucfirst($row['Firstname']).' '.ucfirst($row['Lastname']).'</td>
                                                                    <td>'.ucfirst($row['DocumentName']).'</td>
                                                                    <td>'.$row['Purpose'].'</td>
                                                                    <td>'.$ReferenceNo.'</td>
                                                                    <td>'.$row['PaymentMethod'].'</td>
                                                                    <td>'.$row['Amount'].'</td>
                                                                    <td>'.$row['DateAdded'].'</td>
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
                </div>
            </div>
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <!-- Modal -->
    <script src="src/plugins/src/global/vendors.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="layouts/collapsible-menu/app.js"></script>
    <script src="src/assets/js/custom.js"></script>

    <script src="src/plugins/src/table/datatable/datatables.js"></script>
    
    <script src="src/js/iziToast.min.js"></script>
    <script src="src/plugins/src/glightbox/glightbox.min.js"></script>
    <script src="src/plugins/src/glightbox/custom-glightbox.min.js"></script>
    <script>
        
      const generatePdfButton =  document.getElementById('generate-pdf-btn');

      generatePdfButton.addEventListener('click', () => {
        fetch('pdf.php',{
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({ html: document.querySelector('table').outerHTML})
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(new Blob([blob]));
            const a = document.createElement('a');
            a.href = url;
            a.download = 'reports.pdf';
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error(error));
      })

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
        $('#zero-config2').DataTable({
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
        $('#zero-config3').DataTable({
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
        $('#zero-config4').DataTable({
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
        $('#zero-config5').DataTable({
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
        $('#zero-config6').DataTable({
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
    </script>
</body>
</html>