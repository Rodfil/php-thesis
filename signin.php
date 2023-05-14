<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignIn Cover | Fetch.it </title>
    <link rel="icon" type="image/x-icon" href="src/assets/img/logo-browser.png"/>
    <link href="layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="layouts/vertical-dark-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="src/font/nunito.css" rel="stylesheet">
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="src/assets/css/light/authentication/auth-cover.css" rel="stylesheet" type="text/css" />
    <link href="src/assets/css/dark/authentication/auth-cover.css" rel="stylesheet" type="text/css" />
    <link href="src/css/iziToast.min.css" rel="stylesheet" type="text/css" />
    <style>
        .auth-container{
            background-image: url(images/bgg.png);
            background-size: cover;
        }
        .auth-cover-bg-image {
            background: url(images/signin.png);
            background-repeat: no-repeat;
            background-size: cover;
            width: 60%;
        }
        .auth-overlay{
            background-image: linear-gradient(0deg, transparent 0%, transparent 0%, rgba(0, 0, 0, 0) 0%) !important;
            width: 60%;
        }

        .fetch-it {
            display: grid;
            justify-content: center;
        }

        .fetch-it img {
            position: relative;
            width: 89%;
            height: 60%;
           
        }
    </style>
    <!-- END GLOBAL MANDATORY STYLES -->
    
</head>
<body class="form">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->
    <div class="auth-container d-flex">
        <div class="container mx-auto align-self-center">
            <div class="row">
                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay" style="position: fixed;"></div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3 fetch-it">
                                    <img src="src/assets/img/browserlogo.png" alt="">
                                    <h1 class="text-warning"><b>Hello Again</b></h1>
                                   <!--  <p>Enter your email and password to login</p> -->
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" id="Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                            <label class="form-check-label" for="form-check-default">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button type="button" class="btn btn-secondary w-100" id="btn_Submit">SIGN IN</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Dont't have an account ? <a href="signup.php" class="text-warning">Sign Up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/iziToast.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
<script>
$("#btn_Submit").on("click",function(){
    var Email = $("#Email").val();
    var Password = $("#Password").val();
    if(Email == ''){
        $("#Email").focus();
        Message(1,'Email is required');
        return false;
    }
    if(Password == ''){
        $("#Password").focus();
        Message(1,'Password is required');
        return false;
    }
    var data = {
        Email : Email,
        Password : Password,
    };
    $.ajax({
        type: 'POST',
        url: 'function/login.php',
        data: data,
        dataType:'json',
        beforeSend: function(){},
        complete: function(){},
        success: function(evt){
            if(evt){
                if(evt['Result'] == 'Success'){
                    switch(evt['UserType']){
                        case "Client":
                            window.location = "home.php";
                        break;
                        default:
                            window.location = "request.php";
                        break;
                    }
                } 
                else if (evt['Result'] == "Exists"){
                    Message(1,'Account is pending, Please wait for approval');
                }
                else if (evt['Result'] == "Declined"){
                    Message(1,'Sorry, Your account has been declined');
                }
                else{
                    Message(1,'Invalid Username or Password');
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('error: ' + textStatus + ': ' + errorThrown);
        }
    });
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
        case 3:
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: message,
            });
        break;
    }
}
</script>
</html>