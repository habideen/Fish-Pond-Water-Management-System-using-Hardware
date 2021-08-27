<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Intellifarms Pool Manager</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=0175b6b498de860296f1af1a5eed3086">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css?h=0c556d5438933bda409408695b5733e7">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css?h=0c556d5438933bda409408695b5733e7">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=c48b9939e54dc897daeef7735d3ec808">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand bg-white navigation-clean">
        <div class="container"><a class="navbar-brand text-white" href="#"><img src="assets/img/pond-logo.png?h=74fa24083874e52b3236bd3ce25ddcc0" width="45px" height="auto"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1"><a class="btn btn-danger ml-auto" role="button" href="logout.php">Logout</a></div>
        </div>
    </nav>
    <header class="masthead text-white text-center" style="background: url(assets/img/pool-manager.jpg?h=97cdaa9a3d9ec3948c9dbcfcc55dbfdb);background-size: cover;height: 420px;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5" style="margin-bottom: 20px !important;">Intellifarms Pond Manager</h1>
                    <p>We give you live update of your pond.</p>
                    <div class="row p-3 mt-5 text-center" style="background-color: rgba(0,0,0,0.62);">
                        <div class="col-sm-4"><a class="text-light" href="<?php echo $dashboard; ?>">Monitor</a></div>
                        <div class="col-sm-4"><a class="text-light" href="<?php echo $settings; ?>">Settings</a></div>
                        <div class="col-sm-4"><a class="text-light" href="<?php echo $password; ?>">Password</a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>