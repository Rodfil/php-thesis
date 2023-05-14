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
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Age</th>
                                            <th>Email Address</th>
                                            <th>Contact No</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_Selected_Row">
                                        <?php
                                        require("connection/db.php");
                                        $count = 0;
                                        $query = "SELECT * FROM `users` WHERE UserType = 'Client' ORDER BY ID DESC";
                                        if ($result = $mysqli->query($query)) {
                                            while($row = $result->fetch_array()){

                                                $Status = "";
                                                $ButtonAction = "";
                                                if($row['Status'] == 0){
                                                    $ButtonAction .= '<a RecordID="'.$row['ID'].'" Firstname="'.$row['Firstname'].'" EmailAddress="'.$row['EmailAddress'].'"Gender="'.$row['Gender'].'" class="text-info btn_Approved" href="#">Approved</a>&nbsp;&nbsp;';
                                                    $ButtonAction .= '<a RecordID="'.$row['ID'].'" Firstname="'.$row['Firstname'].'" EmailAddress="'.$row['EmailAddress'].'" class="text-primary btn_Decline" href="#">Decline</a>&nbsp;&nbsp;';
                                                    $Status = "Pending";
                                                }
                                                if($row['Status'] == 1){
                                                    $Status = "Approved";
                                                }
                                                if($row['Status'] == 2){
                                                    $Status = "Declined";
                                                }
                                                $ButtonAction .= '<a RecordID="'.$row['ID'].'" class="text-danger btn_Action_Delete" href="#">Delete</a>';
                                                $DateOfBirth = $row['Birthdate'];
                                                $birthDate = explode("-", $DateOfBirth);
                                                $UserAge = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1): (date("Y") - $birthDate[0]));

                                                echo '<tr Password="'.$row['Password'].'">
                                                    <td>'.ucfirst($row['Firstname']).'</td>
                                                    <td>'.ucfirst($row['Lastname']).'</td>
                                                    <td>'.$UserAge.'</td>
                                                    <td>'.$row['EmailAddress'].'</td>
                                                    <td>'.$row['ContactNo'].'</td>
                                                    <td>'.$row['Gender'].'</td>
                                                    <td>'.$Status.'</td>
                                                    <td><a class="btn_view_Profile" RecordID="'.$row['ID'].'" href="#">View Profile</a></td>
                                                    <td>'.$ButtonAction.'&nbsp;</td>
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
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                message: 'Are you sure you want delete this user?',
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
                                        window.location = "users.php";
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
        $("#tbody_Selected_Row").on("click",".btn_Approved",function(){
            var RecordID = $(this).attr("RecordID");
            var EmailAddress = $(this).attr("EmailAddress");
            var Firstname = $(this).attr("Firstname");
            var Gender = $(this).attr("Gender");
            var data = {
                RecordID : RecordID,
                EmailAddress : EmailAddress,
                Firstname : Firstname,
                Gender: Gender
            };
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'Hey',
                message: 'Are you sure you want to approve this user ?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/approve_user.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                                if(evt > 0){
                                    Message(2,"User successfully Approved");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    _CallAjax('mail_send.php',data);
                                }
                                else{alert(evt);}
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
        $("#tbody_Selected_Row").on("click",".btn_Decline",function(){
            var RecordID = $(this).attr("RecordID");
            var EmailAddress = $(this).attr("EmailAddress");
            var Firstname = $(this).attr("Firstname");
            var data = {
                RecordID : RecordID,
                EmailAddress : EmailAddress,
                Firstname : Firstname,
            };
            iziToast.question({
                overlay: true,
                toastOnce: true,
                id: 'question',
                title: 'Hey',
                message: 'Are you sure you want to declined this user ?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        $.ajax({
                            type: 'POST',
                            url: 'function/decline_user.php',
                            data: data,
                            dataType:'json',
                            beforeSend: function(){},
                            complete: function(){},
                            success: function(evt){
                                if(evt > 0){
                                    Message(2,"User successfully Declined");
                                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                                    _CallAjax('mail_send_declined.php',data);
                                }
                                else{alert(evt);}
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
            $("#exampleModal2").modal("show");
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
        function _CallAjax(url,data){
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt == "Success"){window.location = "users.php";}
                    else{alert(evt);}
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error: ' + textStatus + ': ' + errorThrown);
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
            }
        }
    </script>
</body>
</html>