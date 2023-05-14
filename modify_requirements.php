<?php include('header-scripts.php'); ?>
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

                    <!-- BREADCRUMB -->
                    <div class="page-meta">
                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="documents.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$_GET['name']?></li>
                            </ol>
                        </nav>
                    </div>
                    <!-- /BREADCRUMB -->    
                    <div class="row layout-top-spacing">
                        <div class="col-12 mb-4">
                            <button class="btn btn-info" id="btn_Add_Row">Add Row</button>
                            <button class="btn btn-success" id="btn_Save_Requirement">Save</button>
                        </div>
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Requirement List</h4>
                                        </div>          
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area" id="div_Requirement_List">
                                <?php
                                    require("connection/db.php");
                                    $ID = $_GET['id'];
                                    $query = "SELECT * FROM `requirements` WHERE DocumentID = $ID";
                                    if ($result = $mysqli->query($query)) {
                                        while($row = $result->fetch_array()){
                                            echo '<div class="input-group mb-3" dataRow="'.$row['ID'].'">
                                                <input type="text" class="form-control input_Description" RecordID="'.$row['ID'].'" value="'.$row['Description'].'">
                                                <button class="btn btn-danger btn_Remove" type="old" dataRow="'.$row['ID'].'" type="button">Remove</button>
                                            </div>';
                                        }
                                    }
                                ?>
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
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/iziToast.min.js"></script>
    <script>
        var DocumentID = '<?=$_GET['id']?>';
        $("#btn_Add_Row").on("click",function(){
            $("#div_Requirement_List").append(`
            <div class="input-group mb-3" dataRow="${UniqueID()}">
                <input type="text" class="form-control input_Description" RecordID="0">
                <button class="btn btn-danger btn_Remove" type="new" dataRow="${UniqueID()}" type="button">Remove</button>
            </div>`);
        });
        $("#div_Requirement_List").on("click",".btn_Remove",function(){
            var Type = $(this).attr("type");
            var dataRow = $(this).attr('dataRow');

            switch(Type){
                case "new":
                    $("#div_Requirement_List").find('.input-group').each(function(){
                        if($(this).attr('dataRow') == dataRow){
                            $(this).remove();
                        }
                    });
                break;
                case "old":
                    $.ajax({
                        type: 'POST',
                        url: 'function/del_requirement.php',
                        data: {RecordID : dataRow},
                        dataType:'json',
                        beforeSend: function(){},
                        complete: function(){},
                        success: function(evt){
                            if(evt > 0){
                                Message(2,"Requirement successfully deleted");
                                setTimeout(function() { 
                                    location.reload();
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
                break;
            }
        });
        $("#btn_Save_Requirement").on("click",function(){
            var resultArray = [];
            $("#div_Requirement_List").find('.input-group').each(function(){
                var Description = $(this).find('.input_Description').val();
                var RecordID = $(this).find('.input_Description').attr('RecordID');
                if(Description != ''){
                    resultArray.push({
                        DocumentID : DocumentID,
                        Description : Description,
                        RecordID : RecordID,
                    });
                }
            });
            $.ajax({
                type: 'POST',
                url: 'function/save_requirement.php',
                data: {resultArray},
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"Requirement successfully saved");
                        setTimeout(function() { 
                            location.reload();
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
        function UniqueID(){
            var count = $("#div_Requirement_List").find('.input-group').length;
            var currentdate = new Date(); 
            var rowCount = currentdate.getDate()+""+(currentdate.getMonth()+1)+""+currentdate.getFullYear()+""+currentdate.getHours()+""+currentdate.getMinutes()+""+currentdate.getSeconds();
            return count+rowCount;
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
                    iziToast.danger({
                        title: 'Error',
                        position: 'topRight',
                        message: message,
                    });
                break;
            }
        }
    </script>
</body>
</html>