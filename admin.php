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
                            <h3>Admin Management</h3>
                            <button class="btn btn-primary mb-2" id="btn_Add_New">Add New</button>
                        </div>
                    </div>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Birthdate</th>
                                            <th>Email Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_Selected_Row">
                                        <?php
                                        require("connection/db.php");
                                        $count = 0;
                                        $query = "SELECT * FROM `users` WHERE UserType = 'Admin' ORDER BY ID DESC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){
                                                echo '<tr Password="'.$row['Password'].'">
                                                    <td>'.$row['Firstname'].'</td>
                                                    <td>'.$row['Lastname'].'</td>
                                                    <td>'.$row['Gender'].'</td>
                                                    <td>'.$row['Birthdate'].'</td>
                                                    <td>'.$row['EmailAddress'].'</td>
                                                    <td>
                                                        <a href="#" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-info">Edit</a>&nbsp;&nbsp;
                                                        <a href="#" RecordID="'.$row['ID'].'" class="btn_Action_Delete text-danger">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Enter Admin Fields</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="Firstname" placeholder="Enter First Name">
                                <input type="hidden" class="form-control" id="UserID">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="Lastname" placeholder="Enter Last Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-control" id="Gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="Birthdate">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="text" class="form-control" id="EmailAddress">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="Password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" id="btn_Save_Admin">Save</button>
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
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        });
        $("#tbody_Selected_Row").on("click",".btn_Action_Edit",function(){
            var RecordID = $(this).attr("RecordID");
            var Firstname = $(this).closest('tr').find('td').eq(0).text();
            var Lastname = $(this).closest('tr').find('td').eq(1).text();
            var Gender = $(this).closest('tr').find('td').eq(2).text();
            var Birthdate = $(this).closest('tr').find('td').eq(3).text();
            var EmailAddress = $(this).closest('tr').find('td').eq(4).text();
            var Password = $(this).closest('tr').attr('Password');

            $("#UserID").val(RecordID);
            $("#Firstname").val(Firstname);
            $("#Lastname").val(Lastname);
            $("#Gender").val(Gender);
            $("#Birthdate").val(Birthdate);
            $("#EmailAddress").val(EmailAddress);
            $("#Password").val(Password);
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
                            url: 'function/delete_users.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                            if(evt > 0){
                                    Message(2,"Document successfully deleted");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    setTimeout(function() { 
                                        window.location = "admin.php";
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
        $("#btn_Save_Admin").on("click",function(){
            var ID = $("#UserID").val();
            var Firstname = $("#Firstname").val();
            var Lastname = $("#Lastname").val();
            var Gender = $("#Gender").val();
            var Birthdate = $("#Birthdate").val();
            var EmailAddress = $("#EmailAddress").val();
            var Password = $("#Password").val();
            
            var data = {
                ID : ID,
                Firstname : Firstname,
                Lastname : Lastname,
                Gender : Gender,
                Birthdate : Birthdate,
                EmailAddress : EmailAddress,
                Password : Password,
                UserType : 'Admin',
            };
            $.ajax({
                type: 'POST',
                url: 'function/save_admin.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"User successfully saved");
                        setTimeout(function() { 
                            window.location = "admin.php";
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
            $("#UserID").val("0");
            $("#Firstname").val("");
            $("#Lastname").val("");
            $("#Birthdate").val("");
            $("#EmailAddress").val("");
            $("#Password").val("");
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