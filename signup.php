<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignUp Cover | Fetch.it </title>
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
            background: url(images/signup.png);
            background-repeat: no-repeat;
            background-size: cover;
            width: 60%;
            height: 100%;
        }
        .auth-overlay{
            background-image: linear-gradient(0deg, transparent 0%, transparent 0%, rgba(0, 0, 0, 0) 0%) !important;
            width: 60%;
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
                                <div class="col-md-12 mb-3">
                                    <h1 class="text-warning"><b>Create Your Account</b></h1>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="Firstname" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="Lastname" placeholder="Enter Last Name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-control" id="Gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Birthdate</label>
                                        <input type="date" class="form-control" id="Birthdate">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Voter Registration Status</label>
                                        <select class="form-control" id="RegistrationStatus">
                                            <option value="Registered Voter">Registered Voter</option>
                                            <option value="None registered">None registered</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" id="Address" placeholder="Enter Address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control" id="ContactNo" placeholder="Enter Contact No">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="text" class="form-control" id="EmailAddress" placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Create your password</label>
                                        <input type="password" class="form-control" id="Password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm your password</label>
                                        <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button type="button" id="btn_SignUp" class="btn btn-secondary w-100">SIGN UP</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Already have an account ? <a href="signin.php" class="text-warning">Sign in</a></p>
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
    $("#btn_SignUp").on("click",function(){
        var Firstname = $("#Firstname").val();
        var Lastname = $("#Lastname").val();
        var Gender = $("#Gender").val();
        var Birthdate = $("#Birthdate").val();
        var RegistrationStatus = $("#RegistrationStatus").val();
        var Address = $("#Address").val();
        var EmailAddress = $("#EmailAddress").val();
        var ContactNo = $("#ContactNo").val();
        var Password = $("#Password").val();
        var ConfirmPassword = $("#ConfirmPassword").val();
        if(Firstname == ''){
            Message(1,'First name is required');
            return false;
        }
        if(Lastname == ''){
            Message(1,'Last name is required');
            return false;
        }
        if(Birthdate == ''){
            Message(1,'Birthdate is required');
            return false;
        }
        if(ContactNo == ''){
            Message(1,'Contact No is required');
            return false;
        }
        if(Address == ''){
            Message(1,'Address is required');
            return false;
        }
        if(EmailAddress == ''){
            Message(1,'Email address is required');
            return false;
        }
        if(Password == ''){
            Message(1,'Password is required');
            return false;
        }
        if(ConfirmPassword == ''){
            Message(1,'Confirm Password is required');
            return false;
        }
        if(ConfirmPassword != Password){
            Message(1,'Password mismatch');
            return false;
        }
        var data = {
            Firstname : Firstname,
            Lastname : Lastname,
            Gender : Gender,
            Birthdate : Birthdate,
            RegistrationStatus : RegistrationStatus,
            Address :Address,
            EmailAddress :EmailAddress,
            ContactNo :ContactNo,
            Password : Password,
        };
        $.ajax({
            type: 'POST',
            url: 'function/register.php',
            data: data,
            dataType:'json',
            beforeSend: function(){},
            complete: function(){},
            success: function(evt){
                if(evt){
                    if(evt == "Exists"){
                        Message(1,'Email address already in used');
                    }
                    else{
                        if(evt == 'Success'){
                            Message(2,'Registration successfully submitted, Please wait for approval');
                            setTimeout(clearFields, 5000);
                        }
                        else{
                            Message(1,'Error occur while processing data');
                        }
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('error: ' + textStatus + ': ' + errorThrown);
            }
        });
    });
    function clearFields(){
        $("#Firstname").val("");
        $("#Lastname").val("");
        $("#Gender").val("");
        $("#Birthdate").val("");
        $("#RegistrationStatus").val("");
        $("#EmailAddress").val("");
        $("#Address").val("");
        $("#ContactNo").val("");
        $("#Password").val("");
        $("#ConfirmPassword").val("");
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