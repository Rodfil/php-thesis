<?php include('header-scripts.php'); ?>
<link href="src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css" />
<link href="src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item active" aria-current="page">Tracking</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- /BREADCRUMB -->    
                    <div class="row layout-top-spacing">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <?php
                                require("connection/db.php");
                                $count = 0;
                                $UserID = $_SESSION['UserID'];
                                $query = "
                                SELECT 
                                *,
                                DATE_FORMAT(a.DateAdded, '%M %e, %Y %h:%i %p') as DateAddedFormatted 
                                FROM `tracking` a
                                INNER JOIN request_form b ON b.ID = a.RequestID
                                INNER JOIN document_list c on c.ID = b.DocumentID
                                WHERE b.UserID = $UserID
                                ORDER BY a.DateAdded DESC";
                                if ($result = $mysqli->query($query)) {
                                    while($row = $result->fetch_array()){
                                        echo '<div class="col-lg-12 layout-spacing">
                                            <div class="statbox widget box box-shadow">
                                                <div class="widget-header">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                            <h4>'.$row['DocumentName'].'</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content widget-content-area notation-text">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="media-text">'.$row['Description'].'</p>
                                                            <p class="media-text">'.$row['DateAddedFormatted'].'</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer-wrapper.php'); ?>
        </div>
    </div>
    <?php include('footer-scripts.php'); ?>
</body>
</html>