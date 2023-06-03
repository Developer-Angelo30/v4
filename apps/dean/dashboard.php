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
                <span content-view="subject" class="mt-3 unactive-link">
                    <i class="fa fa-book">&nbsp;</i>
                    <strong class="fw-bold" >Subject</strong>
                </span>
                <span content-view="classroom" class="mt-3 unactive-link">
                    <i class="fa fa-building">&nbsp;</i>
                    <strong class="fw-bold" >Classroom</strong>
                </span>
                <span content-view="account" id="account" class="mt-3 unactive-link">
                    <i class="fa fa-user-plus">&nbsp;</i>
                    <strong class="fw-bold" >account</strong>
                </span>
            </div>
            <div class="sidebar-footer w-100 text-center" >
                <button type="button"  class="btn m-2 settingBtn" data-bs-toggle="modal" data-bs-target="#modalSetting"><i class="fa fa-cog" >&nbsp;</i><strong>Setting</strong></button>
                <a href="../logout.php" class="btn m-2 logoutBtn" ><i class="fa fa-sign-out-alt" >&nbsp;</i><strong>Logout</strong></a>
            </div>
        </div>
        <div class="content vh-100 ">
            <i class="fa fa-bars content-bar" ></i>
            <!-- <div class="home h-100 container-fluid ">
                Home
            </div>
            <div class="setup h-100 container-fluid ">
                Set Up
            </div>
            <div class="professor h-100 container-fluid ">
                professor
            </div> -->
            <!-- start subject code -->
            <div class="subject h-100 container-fluid ">
                <div class="box p-2 mt-3 shadow text-end rounded-3  ">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subject-add-modal">
                        <i class="fa fa-plus" ></i>
                        <strong>ADD SUBJECTS</strong>
                      </button>
                </div>
                <div class="box mt-4 mb-4 p-3 shadow rounded-3">
                    <div class="table-holde overflow-auto">
                        <table class="table table-borderless table-striped"  id="subject-table" >
                            <thead class="bg-primary text-white" >
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>Semester</th>
                                    <th>Laboratory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="subject-table-fetch" >
                                <tr>
                                    <td>CC101</td>
                                    <td>Conputer Programming 01</td>
                                    <td>1st</td>
                                    <td>1st</td>
                                    <td class="text-center" >
                                        <i class="fa fa-check-circle text-success" ></i>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary m-1" ><i class="fa fa-edit" ></i></button>
                                        <button class="btn btn-danger m-1" ><i class="fa fa-trash" ></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- modal add  subject -->
                    <div class="modal fade" id="subject-add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><span class="text-muted">ADD SUBJECT</span></h5>
                                    <button type="button" class="btn-close subject-reset-add-modal-table" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form   >
                                        <div class="row-fetch-subject overflow-auto">
                                            <table class="table table-borderless"  >
                                                <thead class="bg-primary  text-white" >
                                                    <tr>
                                                        <td class="text-uppercase" >#</td>
                                                        <td class="text-uppercase" >Code</td>
                                                        <td class="text-uppercase" >Name</td>
                                                        <td class="text-uppercase" >YearLevel</td>
                                                        <td class="text-uppercase" >Semester</td>
                                                        <td class="text-uppercase" >Laboratory</td>
                                                        <td class="text-uppercase" >Remove</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="subject-table-add-row" >
                                                    <tr class="subjecttable-row subjecttable-row-1" slot-number="1" >
                                                        <td>
                                                            <h6 class="fw-thin pt-2" >1</h6>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <input type="text" id="add-subject-code" name="add-subject-code[]" class="add-subject-code input form-control fix-with-input " placeholder="Code" >
                                                                <small class="error add-subject-code-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <input type="text" id="add-subject-name" name="add-subject-name[]" class="add-subject-name input form-control fix-with-input " placeholder="Name" >
                                                                <small class="error add-subject-name-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <select name="add-subject-year[]" id="add-subject-year" class="form-select input add-subject-year fix-with-input" >
                                                                    <option value="1">1st Year</option>
                                                                    <option value="2">2nd Year</option>
                                                                    <option value="3">3rd Year</option>
                                                                    <option value="4">4th Year</option>
                                                                </select>
                                                                <small class="error add-subject-year-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <select name="add-subject-semester[]" id="add-subject-semester" class="form-select input add-subject-semester fix-with-input" >
                                                                    <option value="1">1st Semester</option>
                                                                    <option value="2">2nd Semester</option>
                                                                </select>
                                                                <small class="error add-subject-semester-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase d-flex justify-content-center align-items-center" >
                                                            <input type="checkbox" value="true" name="add-subject-laboratory[]" id="add-subject-laboratory" class="form-check mt-1 input add-subject-laboratory" >
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <button type="button"  slot-number-remove="1" class="btn btn-danger subject-remove-row"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-success m-1 add-subject-row " >
                                                <span>
                                                    <i class="fa fa-plus" ></i>
                                                    <strong>Row</strong>
                                                </span>
                                            </button>
                                            <button type="button"  id="add-subject-form" class="btn btn-primary m-1" >
                                                <span>
                                                    <i class="fa fa-save" ></i>
                                                    <strong>Submit</strong>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- modal edit  subject -->
                     <div class="modal fade" id="subject-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><span class="text-muted">EDIT SUBJECT</span></h5>
                                    <button type="button" class="btn-close subject-reset-add-modal-table" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form   >
                                        <div class="row-fetch-subject overflow-auto">
                                            <table class="table table-borderless"  >
                                                <thead class="bg-primary  text-white" >
                                                    <tr>
                                                        <td class="text-uppercase" >#</td>
                                                        <td class="text-uppercase" >Code</td>
                                                        <td class="text-uppercase" >Name</td>
                                                        <td class="text-uppercase" >YearLevel</td>
                                                        <td class="text-uppercase" >Semester</td>
                                                        <td class="text-uppercase" >Laboratory</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="subject-table-add-row" >
                                                    <tr class="subjecttable-row subjecttable-row-1" slot-number="1" >
                                                        <td>
                                                            <h6 class="fw-thin pt-2" >1</h6>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <input type="text" id="edit-subject-code" name="edit-subject-code[]" class="edit-subject-code input form-control fix-with-input " placeholder="Code" >
                                                                <small class="error edit-subject-code-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <input type="text" id="edit-subject-name" name="edit-subject-name[]" class="edit-subject-name input form-control fix-with-input " placeholder="Name" >
                                                                <small class="error edit-subject-name-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <select name="edit-subject-year[]" id="edit-subject-year" class="form-select input edit-subject-year fix-with-input" >
                                                                    <option value="1">1st Year</option>
                                                                    <option value="2">2nd Year</option>
                                                                    <option value="3">3rd Year</option>
                                                                    <option value="4">4th Year</option>
                                                                </select>
                                                                <small class="error edit-subject-year-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase" >
                                                            <div class="form-group">
                                                                <select name="edit-subject-semester[]" id="edit-subject-semester" class="form-select input edit-subject-semester fix-with-input" >
                                                                    <option value="1">1st Semester</option>
                                                                    <option value="2">2nd Semester</option>
                                                                </select>
                                                                <small class="error edit-subject-semester-error text-danger text-capitalize" ></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-uppercase d-flex justify-content-center align-items-center" >
                                                            <input type="checkbox" value="1" name="edit-subject-laboratory[]" id="edit-subject-laboratory" class="form-check mt-1 input edit-subject-laboratory" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end">
                                            <button type="button"  id="edit-subject-form" class="btn btn-success m-1" >
                                                <span>
                                                    <i class="fa fa-save" ></i>
                                                    <strong>Submit</strong>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end subject code -->

            <!-- classroom start code -->
            <div class="classroom h-100 container-fluid ">
                classroom
            </div>
            <!-- endclasroom code -->

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

            <!-- MODAL SETTING -->
            <div class="modal fade" id="modalSetting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSettingLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSettingLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MODAL SETTING -->
        </div>
    </section>
    <script src="../../assets/js/jquery-3.6.4.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="../../assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dean-custom.js" ></script>
</body>
</html>