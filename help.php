<?php include('header-scripts.php'); ?>
<link href="src/assets/css/light/pages/faq.css" rel="stylesheet" type="text/css" /> 
<style>
    .purpose-description {
        display: grid;
        position: relative;
        top: -2rem;
    }

    .purpose {
        text-align: left !important;
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
    <div class="main-container " id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <?php include('nav-sidebar.php'); ?>
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="faq">
                        <div class="faq-layouting layout-spacing">

                            <div class="fq-tab-section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Document <span>Requirements</span></h2>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion" id="simple_faq">
                                                    <?php
                                                        require("connection/db.php");
                                                        $query = "SELECT * FROM `document_list` ORDER BY ID ASC";
                                                        if ($result = $mysqli->query($query)) {
                                                            while($row = $result->fetch_array()){
                                                                $DocumentID = $row['ID'];
                                                                $IsVoters = "";
                                                                $IsNonVoter = "";
                                                                if($row['IsVoter'] == 1){
                                                                    $IsVoters = "<li>Allowed Voters only</li>";
                                                                }
                                                                if($row['IsNonVoter'] == 1){
                                                                    $IsNonVoter = "<li>Allowed Non-Voter only</li>";
                                                                }

                                                                echo '<div class="card">
                                                                    <div class="card-header" id="fqheadingOne">
                                                                        <div class="mb-0" data-bs-toggle="collapse" role="navigation" data-bs-target="#fqcollapseOne-'.$row['ID'].'" aria-expanded="false" aria-controls="fqcollapseOne-'.$row['ID'].'">
                                                                            <span class="faq-q-title">'.$row['DocumentName'].'</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="fqcollapseOne-'.$row['ID'].'" class="collapse" aria-labelledby="fqheadingOne" data-bs-parent="#simple_faq">
                                                                        <div class="card-body">
                                                                            <ul>';
                                                                            $query1 = "SELECT r. *, p.*
                                                                                      FROM `requirements` r
                                                                                      LEFT JOIN `purpose` p ON r.ID = p.ID
                                                                                      WHERE r.DocumentID = $DocumentID"; 
                                                                           
                                                                            if ($result1 = $mysqli->query($query1)) {
                                                                                while($row1 = $result1->fetch_array()){
                                                                                    echo '<li>'.$row1['Description'].'</li>';
                                                                                    
                                                                                }
                                                                                echo '<br>';
                                                                                if ($result1->num_rows > 0) {
                                                                                    $result1->data_seek(0);
                                                                                    echo '<h2 class="purpose">'."Purpose".'</h2>';
                                                                                    while($row1 = $result1->fetch_array()){
                                                                                        echo '<span class="purpose-description">'.$row1['Purpose_Description'].'</span>';
                                                                                    }
                                                                                }
                                                                                echo '<br>';
                                                                               
                                                                                echo $IsVoters;
                                                                                echo $IsNonVoter;
                                                                            }
                                                                            echo '</ul>
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
                            </div>
                            <div class="fq-tab-section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Terms and <span>Condition</span></h2>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion" id="simple_faq">
                                                    <li>Under 18 years old need a parental consent</li>
                                                </div>  
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
</body>
</html>