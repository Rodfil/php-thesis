<?php include('header-scripts.php'); ?>
    <!--  BEGIN CUSTOM STYLE FILE  -->
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
<link href="src/assets/css/light/apps/invoice-list.css" rel="stylesheet" type="text/css" />
<link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
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
                    <div class="row" id="cancel-row">
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <table id="invoice-list" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Document</th>
                                            <th>Purpose</th>
                                            <th>Date Registered</th>
                                            <th>Transaction No</th>
                                            <th class="text-center">Status</th>
                                        </tr>
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
                                            A.Purpose,
                                            A.DateAdded,
                                            A.Reason,
                                            A.ReferenceNo,
                                            COALESCE(A.ReceiveDate,'N/A') AS ReceiveDate,
                                            B.Price,
                                            A.Status
                                        FROM `request_form` A
                                        INNER JOIN document_list B ON B.ID = A.DocumentID
                                        WHERE A.UserID = $UserID AND A.Status = 1
                                        ORDER BY A.ID DESC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){
                                                echo '
                                                <tr RecordID="'.$row['ID'].'" Price="'.$row['Price'].'">
                                                    <td class="checkbox-column"> 1 </td>
                                                    <td>'.$row['DocumentName'].'</td>
                                                    <td>'.$row['Purpose'].'</td>
                                                    <td>'.$row['DateAdded'].'</td>
                                                    <td>'.$row['ReferenceNo'].'</td>
                                                    <td class="text-center"><span class="badge badge-warning">Pending</span></td>
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
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select type="text" class="form-control" id="PaymentMethod">
                                    <option value="Over the counter">Over the counter</option>
                                    <option value="GCASH">GCASH</option>
                                </select>
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
</body>

<script src="src/plugins/src/global/vendors.min.js"></script>
<script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="src/plugins/src/mousetrap/mousetrap.min.js"></script>
<script src="layouts/collapsible-menu/app.js"></script>
<script src="src/assets/js/custom.js"></script>
<script src="src/plugins/src/table/datatable/datatables.js"></script>
<script src="src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="src/js/iziToast.min.js"></script>
<script>
var invoiceList = $('#invoice-list').DataTable({
    "dom": "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
        "<'table-responsive'tr>" +
        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",

    headerCallback:function(e, a, t, n, s) {
        e.getElementsByTagName("th")[0].innerHTML=`
        <div class="form-check form-check-primary d-block new-control">
            <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
        </div>`
    },
    columnDefs:[{
        targets:0,
        width:"30px",
        className:"",
        orderable:!1,
        render:function(e, a, t, n) {
            return `
            <div class="form-check form-check-primary d-block new-control">
                <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
            </div>`
        },
    }],
    buttons: [
        {
            text: 'Pay Now',
            className: 'btn btn-primary btn_pay_now',
        }
    ],
    "order": [[ 1, "asc" ]],
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [7, 10, 20, 50],
    "pageLength": 10
});

$("div.toolbar").html('<button class="dt-button dt-delete btn btn-danger" tabindex="0" aria-controls="invoice-list"><span>Delete</span></button>');

multiCheck(invoiceList);

$('body').delegate('.dt-delete','click',function(){
    var $row = $("#tbody_Selected_Row").find("tr");
    var data = [];
    var countCheck = 0;
    $row.each(function(){
        if($(this).find(".child-chk").is(":checked")){
            var RecordID = $(this).attr('RecordID');
            data.push({
                RecordID : RecordID
            });
            countCheck++;
        }
    });
    if(countCheck == 0){
        Message(1,"Please click checkbox to select record");
        return false;
    }
    $.ajax({
        type: 'POST',
        url: 'function/delete_request_multi.php',
        data: {data},
        dataType:'json',
        beforeSend: function(){},
        complete: function(){},
        success: function(evt){
            if(evt > 0){
                Message(2,"Request successfully deleted");
                setTimeout(function() { 
                    window.location = "pay.php";
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
$('body').delegate('.btn_pay_now','click',function(){
    var $row = $("#tbody_Selected_Row").find("tr");
    var data = [];
    var TotalAmount = 0;
    var RequestID = "";
    var AmountEach = "";
    var countCheck = 0;
    $row.each(function(){
        if($(this).find(".child-chk").is(":checked")){
            var RecordID = $(this).attr('RecordID');
            var Price = $(this).attr('Price');
            RequestID += RecordID + ",";
            AmountEach += Price + ",";
            TotalAmount += parseFloat(Price);
            countCheck++;
        }
    });

    if(countCheck == 0){
        Message(1,"Please click checkbox to select record");
        return false;
    }

    RequestID = RequestID.slice(0,-1);
    AmountEach = AmountEach.slice(0,-1);

    $("#Date").val('<?php echo date('Y-m-d H:i:s') ?>');
    $("#Amount").val(TotalAmount);
    $("#Amount").attr('Each',AmountEach);
    $("#RequestFormID").val(RequestID);
    $("#ReferenceNo").val("");
    $("#PaymentMethod").val("Over the counter");
    $("#exampleModal2").modal('show');
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
$("#btn_Save_Payment").on("click",function(){
    var RequestFormID = $("#RequestFormID").val();
    var Amount = $("#Amount").attr('Each');
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
        url: 'function/save_payment_multi.php',
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
                    window.location = "pay.php";
                }, 2000);
                $("#exampleModal2").modal("hide");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('error: ' + textStatus + ': ' + errorThrown);
        }
    });
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
</html>