<?php include('header-scripts.php'); ?>
<link rel="stylesheet" type="text/css" href="src/assets/css/light/apps/blog-post.css">
<link href="src/assets/css/light/elements/custom-pagination.css" rel="stylesheet" type="text/css" />
<link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
<?php
    $glob_Page = 1;
    $Offset = 0;
    $Limit = 10;
    if(isset($_GET['page'])){
        $glob_Page = $_GET['page'];
        $Offset = $_GET['page'] * $Limit - $Limit;
    }
    require("connection/db.php");
    $List = $mysqli->query("SELECT COUNT(*) AS cnt FROM `feedback`")->fetch_array();
    $PageCount = $List['cnt'];

    $RequestID = 0;
    if(isset($_GET['id'])){
        $RequestID = $_GET['id'];
    }
?>
<style>
    .item {
        display: flex;
        justify-content: center;
        align-items: center;
        user-select: none;
        width: 90px;
        height: 90px;
    }
    .radio {
        display: none;
    }
    .radio ~ span {
        font-size: 3rem;
        filter: grayscale(100);
        cursor: pointer;
        transition: 0.3s;
    }
    .radio:checked ~ span {
        filter: grayscale(0);
        font-size: 4rem;
    }
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
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
                                    <li class="breadcrumb-item"><a href="#">Layouts</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                                </ol>
                            </nav>
                        </div>
                    <!-- /BREADCRUMB -->    
    
                    <div class="row layout-top-spacing">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                            <div class="single-post-content">
                                <div class="post-info">
                                    <h2 class="mb-5">Give Feedback</h2>
                                    <div class="post-form mt-5">
                                        <div class="section add-comment">
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">What do you think of the service ?</label>
                                                            <div class="app">
                                                                <div class="d-flex">
                                                                    <div class="item">
                                                                        <label for="1">
                                                                            <input class="radio rad_Emoticons" type="radio" name="feedback" id="1" value="1">
                                                                            <span>🙁</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="item">
                                                                        <label for="2">
                                                                            <input class="radio rad_Emoticons" type="radio" name="feedback" id="2" value="2">
                                                                            <span>😐</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="item">
                                                                        <label for="3">
                                                                            <input class="radio rad_Emoticons" type="radio" name="feedback" id="3" value="3">
                                                                            <span>🙂</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="item">
                                                                        <label for="4">
                                                                            <input class="radio rad_Emoticons" type="radio" name="feedback" id="4" value="4">
                                                                            <span>😁</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="item">
                                                                        <label for="5">
                                                                            <input class="radio rad_Emoticons" type="radio" name="feedback" id="5" value="5">
                                                                            <span>😎</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Do you have any thoughts to share ?</label>
                                                            <textarea class="form-control" cols="30" rows="10" id="Remarks"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end mt-4">
                                                    <button type="button" id="btn_Clear" class="btn btn-primary me-3">Clear</button>
                                                    <button type="button" id="btn_Add_Feedback" class="btn btn-success" <?php if($RequestID == 0) {echo 'disabled';}else{echo '';} ?>>Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-comments">

                                        <?php
                                            require("connection/db.php");
                                            $query = "
                                            SELECT 
                                                A.ID,
                                                A.UserID,
                                                A.Remarks,
                                                A.Emoticon,
                                                A.DateAdded,
                                                B.Firstname,
                                                B.Lastname,
                                                D.DocumentName
                                            FROM `feedback` A
                                            INNER JOIN users B ON B.ID = A.UserID
                                            INNER JOIN request_form C ON C.ID = A.RequestID
                                            INNER JOIN document_list D ON D.ID = C.DocumentID
                                            ORDER BY ID DESC LIMIT $Offset,$Limit";
                                            if ($result = $mysqli->query($query)) {
                                                while($row = $result->fetch_array()){
                                                    $Emoticon  = '';
                                                    switch($row['Emoticon']){
                                                        case 1:
                                                            $Emoticon = '🙁';
                                                        break;
                                                        case 2:
                                                            $Emoticon = '😐';
                                                        break;
                                                        case 3:
                                                            $Emoticon = '🙂';
                                                        break;
                                                        case 4:
                                                            $Emoticon = '😁';
                                                        break;
                                                        case 5:
                                                            $Emoticon = '😎';
                                                        break;
                                                    }
                                                    echo '<div class="media mb-5 pb-5 primary-comment">
                                                        <div class="avatar me-4">
                                                            <img alt="avatar" src="images/profile/'.$row['UserID'].'.webp" class="rounded-circle" />
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading mb-1">'.$row['Firstname'].' '.$row['Lastname'].'</h5>
                                                            <div class="meta-info mb-0">'.$row['DateAdded'].'</div>
                                                            <div class="meta-info mb-0">'.$row['DocumentName'].'</div>
                                                            <p class="media-text mt-2 mb-0">'.$Emoticon.' '.$row['Remarks'].'</p>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        ?>
                                        <div class="post-pagination">
                                            <div class="pagination-no_spacing">
                                                <ul class="pagination paginationHomepage">
                                                    <li><a href="javascript:void(0);" class="prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
                                                    <li><a href="javascript:void(0);" class="active">1</a></li>
                                                    <li><a href="javascript:void(0);">2</a></li>
                                                    <li><a href="javascript:void(0);">3</a></li>
                                                    <li><a href="javascript:void(0);" class="next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                                                </ul>
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
    <?php include('footer-scripts.php'); ?>
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/iziToast.min.js"></script>
    <script>
        var RequestID = '<?=$RequestID?>';
        $("#btn_Clear").on("click",function(){
            $("#Remarks").val("");
            $(".rad_Emoticons").prop('checked',false);
        });
        $("#btn_Add_Feedback").on("click",function(){
            var Emoticon = $('input[name="feedback"]:checked').val();
            var Emoticon = (Emoticon == undefined ? 0 : Emoticon);
            var Remarks = $("#Remarks").val();

            var data = {
                UserID : '<?=$_SESSION['UserID']?>',
                Remarks : Remarks,
                Emoticon : Emoticon,
                RequestID : RequestID,
            }
            $.ajax({
                type: 'POST',
                url: 'function/save_feedback.php',
                data: data,
                dataType:'json',
                beforeSend: function(){},
                complete: function(){},
                success: function(evt){
                    if(evt > 0){
                        Message(2,"Feeback successfully send");
                        setTimeout(function() { 
                            window.location = "feedback.php";
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
        HomepagePage();
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
        function getPageHomepage(totalPages, page, maxLength) {
            if (maxLength < 5) throw "maxLength must be at least 5";

            function range(start, end) {
                return Array.from(Array(end - start + 1), (_, i) => i + start); 
            }

            var sideWidth = maxLength < 9 ? 1 : 2;
            var leftWidth = (maxLength - sideWidth*2 - 3) >> 1;
            var rightWidth = (maxLength - sideWidth*2 - 2) >> 1;
            if (totalPages <= maxLength) {
                return range(1, totalPages);
            }
            if (page <= maxLength - sideWidth - 1 - rightWidth) {
                return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
            }
            if (page >= totalPages - sideWidth - 1 - rightWidth) {
                return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }
            return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth),0, range(totalPages - sideWidth + 1, totalPages));
        }
        function HomepagePage(){
            var numberOfItems = parseInt('<?=$PageCount?>');
            var limitPerPage = 10;
            var totalPages = Math.ceil(numberOfItems / limitPerPage);
            var paginationSize = 5; 
            var currentPage;
            var arrayPage = [];
            function showPageInvoices(whichPage) {
                if (whichPage < 1 || whichPage > totalPages) return false;
                currentPage = whichPage;
                $(".paginationHomepage li").slice(1, -1).remove();
                getPageHomepage(totalPages, currentPage, paginationSize).forEach( item => {
                    $("<li>").addClass("page-item")
                            .addClass(item ? "current-page" : "disabled")
                            .toggleClass("active", item === currentPage).append(
                        $("<a>").addClass(item === currentPage ? "active" : "").attr({
                            href: "javascript:void(0)"}).text(item || "...")
                    ).insertBefore("#next-page-invoices");
                    arrayPage.push(item);
                });
                $("#previous-page-invoices").toggleClass("disabled", currentPage === 1);
                $("#next-page-invoices").toggleClass("disabled", currentPage === totalPages);
                return true;
            }

            $(".paginationHomepage").empty().append(
                $("<li>").attr({ id: "previous-page-invoices" }).append(
                    $("<a>").addClass("prev").attr({
                        href: "javascript:void(0)"}).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>')
                ),
                $("<li>").attr({ id: "next-page-invoices" }).append(
                    $("<a>").addClass("next").attr({
                        href: "javascript:void(0)"}).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>')
                )
            );
            $("#ulHomepageList").show();
            showPageInvoices(parseInt('<?=$glob_Page?>'));
            $(document).on("click", ".paginationHomepage li.current-page:not(.active)", function () {
                var page = +$(this).text();
                window.location.href = "feedback.php?page="+page;
                return showPageInvoices(+$(this).text());
            });
            $("#next-page-invoices").on("click", function () {
                if(!$(this).hasClass('disabled')){
                    var page = currentPage+1;
                    window.location.href = "feedback.php?page="+page;
                    return showPageInvoices(currentPage+1);
                }
            });

            $("#previous-page-invoices").on("click", function () {
                if(!$(this).hasClass('disabled')){
                    var page = currentPage-1;
                    window.location.href = "feedback.php?page="+page;
                    return showPageInvoices(currentPage-1);
                }
            });
        }
    </script>
</body>
</html>