<?php
    session_start();
    require_once("../include/session/loggedSession.php");
    if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) && isset($_SESSION['department'])){
        $session = new mySession($_SESSION['email'], $_SESSION['password'], $_SESSION['role'], $_SESSION['department']);
        $session->loggedSessionDean();
    }
    else{
        header("location: ../logout.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="../../assets/css/all.css">
    <link rel="stylesheet" href="../../assets/DataTables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/css/dean-styles.css">
    <title>Document</title>
</head>
<body>
    <section class="wrapper dean-section vh-100">
        <div class="sidebar vh-100 position-relative">
            <i class="sidebar-close fa fa-close"></i>
            <div class="navbar-blue d-flex justify-content-center align-items-center ">
                <div class="information-sidebar text-center">
                    <img src="../../assets/images/user-big.png" alt="img-profile"><br>
                    <strong class="mt-1 text-white" >Mr. Dean</strong><br>
                    <small class="text-white text- " >ICT</small>
                </div>
            </div>
            <div class="sidebar-group-link position-relative">
                <span content-view="home" class="mt-3 unactive-link active-link">
                    <i class="fa fa-home">&nbsp;</i>
                    <strong class="fw-bold" >Home</strong>
                </span>
                <span content-view="setup" class="mt-3 unactive-link">
                    <i class="fa fa-tasks">&nbsp;</i>
                    <strong class="fw-bold" >Set Up</strong>
                </span>
                <span content-view="professor" class="mt-3 unactive-link">
                    <i class="fa fa-users">&nbsp;</i>
                    <strong class="fw-bold" >Professor</strong>
                </span>
                <span content-view="classroom" class="mt-3 unactive-link">
                    <i class="fa fa-building">&nbsp;</i>
                    <strong class="fw-bold" >classroom</strong>
                </span>
                <span content-view="account" id="account" class="mt-3 unactive-link">
                    <i class="fa fa-user-plus">&nbsp;</i>
                    <strong class="fw-bold" >account</strong>
                </span>
            </div>
            <div class="sidebar-footer w-100 text-center" >
                <a href="#" class="btn m-2 settingBtn" ><i class="fa fa-cog" >&nbsp;</i><strong>Setting</strong></a>
                <a href="../logout.php" class="btn m-2 logoutBtn" ><i class="fa fa-sign-out-alt" >&nbsp;</i><strong>Logout</strong></a>
            </div>
        </div>
        <div class="content vh-100 ">
            <i class="fa fa-bars content-bar" ></i>
            <div class="home h-100 container-fluid ">
                Home
            </div>
            <div class="setup h-100 container-fluid ">
                Set Up
            </div>
            <div class="professor h-100 container-fluid ">
                professor
            </div>
            <div class="classroom h-100 container-fluid ">
                classroom
            </div>

            <!-- account start code -->
            <div class="account h-100 container-fluid ">
                <div class="box p-2 mt-3 shadow text-end rounded-3  ">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#account-add-modal">
                        <i class="fa fa-plus" ></i>
                        <strong>ADD ACCOUNTS</strong>
                      </button>
                </div>
                <div class="box mt-4 mb-4 p-3 shadow rounded-3">
                    <div class="table-holde overflow-auto">
                        <table class="table table-borderless table-striped"  id="account-table" >
                            <thead class="bg-primary text-white" >
                                <tr>
                                    <th>Email</th>
                                    <th>Fullname</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="account-table-fetch" >
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- modal add admin account -->
                    <div class="modal fade" id="account-add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><span class="text-muted">ADD ACCOUNT</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                          <button class="nav-link active" id="nav-admin-tab" data-bs-toggle="tab" data-bs-target="#nav-admin" type="button" role="tab" aria-controls="nav-admin" aria-selected="true">ADMIN ACCOUNT</button>
                                          <button class="nav-link" id="nav-dean-tab" data-bs-toggle="tab" data-bs-target="#nav-dean" type="button" role="tab" aria-controls="nav-dean" aria-selected="false">DEAN ACCOUNT</button>
                                        </div>
                                      </nav>
                                      <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
                                            <form >
                                                <div class="mt-2 global-error alert alert-danger text-center add-account-admin-global-error d-none"></div>
                                                    <div class="form-group mt-3">
                                                        <div class="input-group ">
                                                            <input type="text"= class="add-account-admin-email input form-control" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2"> <i class="fa fa-envelope"></i> </span>
                                                        </div>
                                                        <small class="error add-account-admin-email-error text-danger" ></small>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <div class="input-group ">
                                                            <input type="text" class="add-account-admin-fullname input form-control" placeholder="Fullname" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2"> <i class=" fa fa-user"></i> </span>
                                                        </div>
                                                        <small class="error add-account-admin-fullname-error text-danger" ></small>
                                                    </div>
                                                    <div class="form-group text-center mt-3">
                                                        <button type="button" id="add-account-admin-form" class="add-account-admin-form btn btn-primary w-100" ><strong>CREATE ACCOUNT</strong></button>
                                                    </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-dean" role="tabpanel" aria-labelledby="nav-dean-tab">
                                            <form>
                                                <div class="mt-2 global-error alert alert-danger text-center add-account-dean-global-error d-none "></div>
                                                <div class="form-group mt-3">
                                                    <div class="input-group ">
                                                        <input type="text" class="add-account-dean-email input form-control" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2"> <i class="fa fa-envelope"></i> </span>
                                                    </div>
                                                    <small class="error add-account-dean-email-error text-danger" ></small>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <div class="input-group ">
                                                        <input type="text" class="add-account-dean-fullname input form-control" placeholder="Fullname" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2"> <i class=" fa fa-user"></i> </span>
                                                    </div>
                                                    <small class="error add-account-dean-fullname-error text-danger" ></small>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <div class="input-group ">
                                                        <select name="" class="add-account-dean-department form-select" id="">
                                                            <option value="CICT">CICT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center mt-3">
                                                    <button type="button"  id="add-account-dean-form" class="add-account-dean-form btn btn-success w-100" ><strong>Create Account</strong></button>
                                                </div>
                                            </form>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- modal edit admin account -->
                     <div class="modal fade" id="account-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><span class="text-muted">EDIT ACCOUNT</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form >
                                        <input type="hidden" name="" class="edit-account-id" >
                                        <div class="form-group mt-3">
                                            <div class="input-group ">
                                                <input type="text"= class="edit-account-email input form-control" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <small class="error edit-account-email-error text-danger" ></small>
                                        </div>
                                        <div class="form-group mt-3">
                                            <div class="input-group ">
                                                <input type="text" class="edit-account-fullname input form-control" placeholder="Fullname" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2"> <i class=" fa fa-user"></i> </span>
                                            </div>
                                            <small class="error edit-account-fullname-error text-danger" ></small>
                                        </div>
                                        <div class="form-group text-center mt-3">
                                            <button type="button"  id="edit-account-form" class="edit-account-form btn btn-primary w-100" ><strong>EDIT ACCOUNT</strong></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- account end code -->
        </div>
    </section>
    <script src="../../assets/js/jquery-3.6.4.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="../../assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dean-custom.js" ></script>
</body>
</html>