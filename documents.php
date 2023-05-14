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
                            <h3>Document Management</h3>
                            <button class="btn btn-primary mb-2" id="btn_Add_New">Add New</button>
                        </div>
                    </div>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Document Name</th>
                                            <th>Price</th>
                                            <th>Voter</th>
                                            <th>Non-Voter</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_Selected_Row">
                                        <?php
                                        require("connection/db.php");
                                        $count = 0;
                                        $query = "SELECT * FROM `document_list` ORDER BY DocumentName DESC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){

                                                $IsVoter = ($row['IsVoter'] == 1 ? 'YES' : 'NO');
                                                $IsNonVoter = ($row['IsNonVoter'] == 1 ? 'YES' : 'NO');

                                                echo '<tr>
                                                    <td>'.$row['DocumentName'].'</td>
                                                    <td>'.$row['Price'].'</td>
                                                    <td>'.$IsVoter.'</td>
                                                    <td>'.$IsNonVoter.'</td>
                                                    <td>'.date('M j, Y h:i', strtotime($row['DateAdded'])).'</td>
                                                    <td>
                                                        <a href="#" IsVoter="'.$row['IsVoter'].'" IsNonVoter="'.$row['IsNonVoter'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-info">Edit</a>&nbsp;&nbsp;
                                                        <a href="#" RecordID="'.$row['ID'].'" class="btn_Action_Delete text-danger">Delete</a>&nbsp;&nbsp;
                                                        <a href="modify_requirements.php?id='.$row['ID'].'&name='.$row['DocumentName'].'" RecordID="'.$row['ID'].'" class="btn_Action_Requirements text-default">Requirements</a>
                                                        <a href="purpose.php?id='.$row['ID'].'&name='.$row['DocumentName'].'" RecordID="'.$row['ID'].'" class="btn_Action_Requirements text-default">Purpose</a>
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
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter Document Fields</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Document Name</label>
                                <input type="text" class="form-control" id="DocumentName" placeholder="Enter Document Name">
                                <input type="hidden" class="form-control" id="DocumentID">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="Price" placeholder="Enter Price">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_Voter">
                                    <label class="form-check-label" for="check_Voter">Voter</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_Non_Voter">
                                    <label class="form-check-label" for="check_Non_Voter">Non-Voter</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Save_Document">Save</button>
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
        $("#tbody_Selected_Row").on("click",".btn_Action_Edit",function(){
            var RecordID = $(this).attr("RecordID");
            var IsVoter = $(this).attr("IsVoter");
            var IsNonVoter = $(this).attr("IsNonVoter");
            var DocumentName = $(this).closest('tr').find('td').eq(0).text();
            var Price = $(this).closest('tr').find('td').eq(1).text();

            if(IsVoter == "1"){
                $("#check_Voter").prop("checked",true);
            }
            else{
                $("#check_Voter").prop("checked",false);
            }
            if(IsNonVoter == "1"){
                $("#check_Non_Voter").prop("checked",true);
            }
            else{
                $("#check_Non_Voter").prop("checked",false);
            }
            $("#DocumentID").val(RecordID);
            $("#DocumentName").val(DocumentName);
            $("#Price").val(Price);
            $("#exampleModal").modal('show');
        });
        $("#tbody_Selected_Row").on("click",".btn_Action_Delete",function(){
            var RecordID = $(this).attr("RecordID");
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
                            url: 'function/delete_documents.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Document successfully deleted");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "documents.php";
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
        $("#btn_Save_Document").on("click",function(){
            var ID = $("#DocumentID").val();
            var DocumentName = $("#DocumentName").val();
            var Price = $("#Price").val();
            var IsVoter = 0;
            var IsNonVoter = 0;

            if($("#check_Voter").is(":checked")){
                IsVoter = 1;
            }
            if($("#check_Non_Voter").is(":checked")){
                IsNonVoter = 1;
            }
            var data = {
                ID : ID,
                DocumentName : DocumentName,
                Price : Price,
                IsVoter : IsVoter,
                IsNonVoter : IsNonVoter,
            };
            $.ajax({
                type: 'POST',
                url: 'function/save_documents.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"Document successfully saved");
                        setTimeout(function() { 
                            window.location = "documents.php";
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
        $("#btn_Add_New").on("click",function(){
            $("#DocumentID").val("0");
            $("#DocumentName").val("");
            $("#Price").val("");
            $("#exampleModal").modal('show');
        });
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