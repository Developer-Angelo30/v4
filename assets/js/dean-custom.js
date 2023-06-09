$(document).ready(()=>{

    let errorReset = () =>{
        $(document).on('keyup', '.input', function(){
            $(this).removeClass('border-danger')
            $('.error').text('')
            $('.global-error').text('')
            $('.global-error').addClass('d-none')
        })
    }
    errorReset()

    // subject start code ------------------

    let startSubject = () =>{
        
    }
    startSubject();

    let addSubject = () => {
        $(document).on('click', '#add-subject-form', function() {
          let code = [];
          let name = [];
          let year = [];
          let semester = [];
          let laboratory = [];
          let slot = [];
          let hasError = false;
      
          $(".subjecttable-row").each(function() {
            let row = $(this);
            let slotNumber = row.attr('slot-number');
            let sub_code = row.find("input[name='add-subject-code[]']");
            let sub_name = row.find("input[name='add-subject-name[]']");
            let sub_year = row.find("select[name='add-subject-year[]']");
            let sub_semester = row.find("select[name='add-subject-semester[]']");
            let sub_laboratory = row.find("input[name='add-subject-laboratory[]']").is(":checked");
            let codeError = row.find(".add-subject-code-error");
            let nameError = row.find(".add-subject-name-error");
      
            if (sub_code.val()) {
              if (sub_name.val()) {
                if (sub_year.val()) {
                  if (sub_semester.val()) {
                    code.push(sub_code.val());
                    name.push(sub_name.val());
                    year.push(sub_year.val());
                    semester.push(sub_semester.val());
                    laboratory.push(sub_laboratory);
                    slot.push(slotNumber);
                    hasError = false;
                  }
                }
              } else {
                sub_name.focus();
                sub_name.addClass('border-danger shadow-danger');
                nameError.text(`This field is required.`);
                hasError = true;
                return false;
              }
            } else {
              sub_code.focus();
              sub_code.addClass('border-danger shadow-danger');
              codeError.text(`This field is required.`);
              hasError = true;
              return false;
            }
          });
      
          if (!hasError) {
            $.ajax({
              url: '../controller/subject.controller.php',
              data: {"code": code, "name": name, "year": year, "semester": semester, "laboratory":laboratory  ,"slot": slot, "action-key":"AddSubjects"},
              type: 'POST',
              beforeSend: ()=>{

              },
              success: (response)=> {
                console.log(response);
              },
              complete: ()=>{

              }
            });
          }
        });
      };
      addSubject();

    let readSubjects = () =>{
        const data = ({
            "action-key":"readSubjects"
        })
        $.ajax({
            url: "../view/subject.view.php",
            method: "POST",
            data: data,
            dataType: "JSON",
            success: (response)=>{
                $('#subject-table-fetch').html('')
                for(i in response){
                    $('#subject-table-fetch').append(`
                    <tr>
                        <td>${response[i]['subCode']}</td>
                        <td>${response[i]['subName']}</td>
                        <td>${response[i]['subYear']}</td>
                        <td>${response[i]['subSemester']}</td>
                        <td class="" >
                            ${response[i]['subLaboratory'] == 1 ? '<i class="fa fa-check-circle text-success fs-4" ></i>' : '<i class="fa fa-times-circle text-danger fs-4" ></i> '}
                        </td>
                        <td>
                            <button data-id="${response[i]['subCode']}"id="show-edit-subject-btn" class="btn btn-secondary m-1"  data-bs-toggle="modal" data-bs-target="#subject-edit-modal" ><i class="fa fa-edit" ></i></button>
                            <button data-id="${response[i]['subCode']}"id="remove-subject-btn" class="btn btn-danger m-1" ><i class="fa fa-trash" ></i></button>
                        </td>
                    </tr>
                    `)
                }
                $('#subject-table').DataTable({});
            }
        })
    }
    readSubjects()

    let showDataSubjectUpdates = () =>{
        $(document).on('click', '#show-edit-subject-btn', function(){
            
            const code = $(this).attr('data-id')
            const data = ({
                "code": code,
                "action-key": "showDataSubjectUpdates"
            })

            $.ajax({
                url:"../view/subject.view.php",
                method: "POST",
                data: data,
                dataType: "JSON",
                success: function(response){
                    $('.edit-subject-code-static').val(response[0]['subCode'])
                    $('.edit-subject-code').val(response[0]['subCode'])
                    $('.edit-subject-name').val(response[0]['subName'])
                    $('.edit-subject-year').val(response[0]['subYear']).attr("selected",true)
                    $('.edit-subject-semester').val(response[0]['subSemester']).attr("selected",true)
                    if(response[0]['subLaboratory'] == 1){
                        $('.edit-subject-laboratory').attr("checked", true);
                    }
                    else{
                        $('.edit-subject-laboratory').attr("checked", false);
                    }
                }
            })
        })
    }
    showDataSubjectUpdates()

    let actualSubjectUpdates = () =>{
        $(document).on('click', '#edit-subject-form', ()=>{
            
            let staticCode = $('.edit-subject-code-static').val();
            let code = $('.edit-subject-code').val();
            let name = $('.edit-subject-name').val();
            let year = $('.edit-subject-year :selected').val();
            let semester = $('.edit-subject-semester :selected').val();
            let lab = $('.edit-subject-laboratory').is(":checked");
            let laboratory = 0;

            if(lab == true){
                laboratory = 1;
            }
           
            console.log(`${staticCode} , ${code} , ${name}, ${year} , ${semester}, ${laboratory}`)

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, Update!'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         if(true){
            //             if(true){

            //             }
            //             else{

            //             }
            //         }
            //         else{

            //         }
            //     }
            // })
        })
    }
    actualSubjectUpdates();

    let rowCount = 1;

    let addSubjectRow = () =>{
        $(document).on('click', '.add-subject-row', ()=>{
            ++rowCount;
            $('#subject-table-add-row').append(`
                <tr class="subjecttable-row subject-table-row-${rowCount}" slot-number="${rowCount}" >
                    <td>
                    <h6 class="fw-thin pt-2" >${rowCount}</h6>
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
                        <input type="checkbox" value="true" name="add-subject-laboratory[]" id="add-subject-laboratory" class="form-check mt-1 add-subject-laboratory" >
                    </td>
                    <td class="text-uppercase" >
                        <button type="button" slot-number-remove="${rowCount}" class="btn btn-danger subject-remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `)

        })
    }
    addSubjectRow();

    let removeSubjectRow = () =>{
        $(document).on('click', '.subject-remove-row', function(){
            let slot = $(this).attr('slot-number-remove')
            $(`.subject-table-row-${slot}`).remove()
        })
    }
    removeSubjectRow()

    let resetSubjectAddRow = ()=>{
        $(document).on('click', '.subject-reset-add-modal-table', ()=>{
            rowCount = 1;
            $('#subject-table-add-row').html('')
            $('#subject-table-add-row').append(`
                <tr class="subjecttable-row subject-table-row-${rowCount}" slot-number="${rowCount}" >
                    <td>
                    <h6 class="fw-thin pt-2" >${rowCount}</h6>
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
                        <input type="checkbox" value="true" name="add-subject-laboratory[]" id="add-subject-laboratory" class="form-check mt-1 add-subject-laboratory" >
                    </td>
                    <td class="text-uppercase" >
                        <button type="button" slot-number-remove="${rowCount}" class="btn btn-danger subject-remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `)
        })
    }
    resetSubjectAddRow()

    // acounts  start code --------------------

    let accountStart = () =>{
        $(document).on('click', '#account', function(){
            readAccounts()
        })
    }
    accountStart()

    let addAccountDeans = () =>{

        $(document).on("click", '#add-account-dean-form', function(){

            var email = $('.add-account-dean-email');
            var emailError = $('.add-account-dean-email-error');
        
            var fullname = $('.add-account-dean-fullname');
            var fullnameError = $('.add-account-dean-fullname-error');
        
            var department  = $(".add-account-dean-department :selected");
        
            var globalError = $('.add-account-dean-global-error');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create account!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!email.val() == ""){
                        if(!fullname.val() == ""){
                            if(email.val().includes("@gmail.com")){
                                const data = {
                                    "email": email.val(),
                                    "fullname": fullname.val(),
                                    "department": department.val(),
                                    "action-key": "createAccountDeans"
                                }
                    
                                $.ajax({
                                    "url": "../controller/user.controller.php",
                                    "method": "POST",
                                    "data": data,
                                    "dataType": "JSON",
                                    beforeSend: ()=>{
                                        $(this).html('')
                                        $(this).html('<span> <i class="fa fa-spin fa-spinner" >&nbsp;</i> <strong>Please wait.</strong> </span>')
                                        $(this).attr("disabled", true)
                                    },
                                    success: (response)=>{
                                        if(response.status === true){
                                            email.val('')
                                            fullname.val('')
                                            Swal.fire("", response.message , "success")
                                        }
                                        else{
                                            email.val('')
                                            fullname.val('')
                                            globalError.removeClass("d-none")
                                            globalError.text(response.message)
                                        }
                                    },
                                    complete: ()=>{
                                        $(this).html('')
                                        $(this).html('<span> <strong>Create Account</strong> </span>')
                                        $(this).removeAttr("disabled")
                                    }
                                })
                            }
                            else{
                                emailError.text("Please input valid email address.")
                            }
                        }
                        else{
                            fullnameError.text("This field is required.")   
                        }
                    }
                    else{
                        emailError.text("This field is required.")
                    }
                }
            })
        })
    }
    addAccountDeans()

    let addAccountSuperAdmins = () =>{

        $(document).on("click", '#add-account-admin-form', function(){

            var email = $('.add-account-admin-email');
            var emailError = $('.add-account-admin-email-error');
        
            var fullname = $('.add-account-admin-fullname');
            var fullnameError = $('.add-account-admin-fullname-error');
        
            var globalError = $('.add-account-admin-global-error');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create account!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!email.val() == ""){
                        if(!fullname.val() == ""){
                            if(email.val().includes("@gmail.com")){
                                const data = {
                                    "email": email.val(),
                                    "fullname": fullname.val(),
                                    "action-key": "createAccountSuperAdmins"
                                }
                                $.ajax({
                                    "url": "../controller/user.controller.php",
                                    "method": "POST",
                                    "data": data,
                                    "dataType": "JSON",
                                    beforeSend: ()=>{
                                        $(this).html('')
                                        $(this).html('<span> <i class="fa fa-spin fa-spinner" >&nbsp;</i> <strong>Please wait.</strong> </span>')
                                        $(this).attr("disabled", true)
                                    },
                                    success: (response)=>{
                                        if(response.status === true){
                                            email.val('')
                                            fullname.val('')
                                            Swal.fire("", response.message , "success")
                                        }
                                        else{
                                            email.val('')
                                            fullname.val('')
                                            globalError.removeClass("d-none")
                                            globalError.text(response.message)
                                        }
                                    },
                                    complete: ()=>{
                                        $(this).html('')
                                        $(this).html('<span> <strong>Create Account</strong> </span>')
                                        $(this).removeAttr("disabled")
                                    }
                                })
                            }
                            else{
                                emailError.text("Please input valid email address.")
                            }
                        }
                        else{
                            fullnameError.text("This field is required.")   
                        }
                    }
                    else{
                        emailError.text("This field is required.")
                    }
                }
            })
        })
    }
    addAccountSuperAdmins()

    let readAccounts = () =>{

        var table = $('#account-table-fetch')

        const data = ({
            "action-key": "readAccounts"
        })

        $.ajax({
            "url": "../view/user.view.php",
            "method": "POST",
            "data": data,
            "dataType": "JSON",
            success: (response)=>{
                table.html('')
                for (i  in response) {
                   table.append('\
                    <tr>\
                        <td>'+response[i]["userEmail"]+'</td>\
                        <td>'+response[i]["userFullname"]+'</td>\
                        <td>\
                            <button type="button" data-id="'+response[i]["userID"]+'" class="btn btn-secondary m-1"  id="show-edit-account-btn"   data-bs-toggle="modal" data-bs-target="#account-edit-modal"  ><i class="fa fa-edit" ></i></button>\
                            <button type="button" data-id="'+response[i]["userID"]+'" id="remove-account-btn" class="btn btn-danger m-1" ><i class="fa fa-trash" ></i></button>\
                        </td>\
                    </tr>\
                ')
               }
               $('#account-table').DataTable();
            },
        })
    }

    let showDataAccountUpdates = () =>{
        $(document).on('click', '#show-edit-account-btn', function(){
            
            const id = $(this).attr('data-id')
            const data = ({
                "id": id,
                "action-key": "showDataAccountUpdates"
            })

            $.ajax({
                "url":"../view/user.view.php",
                "method": "POST",
                "data": data,
                "dataType": "JSON",
                success: function(response){
                    $('.edit-account-id').val(response[0]['userID'])
                    $('.edit-account-email').val(response[0]['userEmail'])
                    $('.edit-account-fullname').val(response[0]['userFullname'])
                }
            })
        })
    }
    showDataAccountUpdates()

    let actualAccountUpdate = () =>{
        $(document).on('click', '#edit-account-form', ()=>{
            const id = $('.edit-account-id').val()
            const email = $('.edit-account-email')
            let emailError = $('.edit-account-email-error');

            const fullname  = $('.edit-account-fullname')
            let fullnameError = $('.edit-account-fullname-error')

            let button = $('.edit-account-form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Update!'
            }).then((result) => {
                if (result.isConfirmed) {

                    if(!email.val() == "" ){
                        if(!fullname.val() == ""){
                            if(email.val().includes("@gmail.com")){
                                
                                const data = ({
                                    "id": id,
                                    "email": email.val(),
                                    "fullname": fullname.val(),
                                    "action-key": "actualAccountUpdates"
                                })

                                $.ajax({
                                    "url": "../controller/user.controller.php",
                                    "method": "POST",
                                    "data": data,
                                    "dataType": "JSON",
                                    beforeSend: ()=>{
                                        button.html('<span> <i class="fa fa-spin fa-spinner" >&nbsp;</i> <strong>Please wait.</strong> </span>')
                                        button.attr("disabled", true)
                                    },
                                    success: (response)=>{
                                        if(response.status == true){
                                            Swal.fire("Success", response.message, "success");
                                            readAccounts()

                                        }
                                        
                                    },
                                    complete: ()=>{
                                        button.html('<span> <strong>EDIT ACCOUNT</strong> </span>')
                                        button.removeAttr("disabled")
                                    }
                                })
                            }
                            else{
                                emailError.text("Please input valid email address")
                            }
                        }
                        else{
                            fullnameError.text("This field is required.")
                        }
                    }
                    else{
                        emailError.text("This field is required.")
                    }
                }
            })

        })
    }
    actualAccountUpdate();

    let deleteAccounts = ()=>{
        $(document).on('click', '#remove-account-btn' ,function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).attr('data-id')

                    let data = ({
                        "id": id,
                        "action-key": "deleteAccounts"
                    })

                    $.ajax({
                        "url": "../controller/user.controller.php",
                        "method": "POST",
                        "data": data,
                        "dataType": "JSON",
                        beforeSend: ()=>{
                            $(this).attr("disabled", true)
                        },
                        success: (response)=>{
                            if(response.status == true){
                                readAccounts()
                                Swal.fire("success", response.message , "success");
                            }
                        },
                        complete: ()=>{
                            $(this).removeAttr("disabled")
                        }
                    })
                    // 
                }
            })
        })
    }
    deleteAccounts()

    //account end code

    let changeContent = () =>{
        $(document).on('click', '.unactive-link', function(){

            if(window.innerWidth <= 480){
                $('.dean-section > .sidebar').css("display", "none");
            }

            const content = $(this).attr('content-view')
            $("."+content)[0].scrollIntoView();
            $('.unactive-link').removeClass('active-link');
            $(this).addClass('active-link')
        })
    }
    changeContent()

    let showSideBar = ()=>{
        $(document).on('click', '.content-bar', ()=>{
            if(window.innerWidth <= 480){
                $('.dean-section > .sidebar').css({'display':'block', "transition":"1s"})
            }
        })   
    }
    showSideBar()

    let closeSideBar = () =>{
        $(document).on('click', '.sidebar-close', ()=>{
            if(window.innerWidth <= 480){
                $('.dean-section > .sidebar').css('display','none')
            }
        })   
    }
    closeSideBar()

    let emailValidation = (emailField, emailError, buttonSubmit) => {
        $(document).on('keyup', emailField, function() {
            if($(this).val() != ""){
                if (!$(this).val().includes('@gmail.com')) {
                    $(emailField).addClass('border border-danger')
                    $(emailError).text("Please input a valid email.");
                    $(buttonSubmit).attr('disabled', true);
                } else {
                    $(emailError).text('');
                    $(emailField).removeClass('border border-danger')
                    $(buttonSubmit).removeAttr('disabled');
                }
            }
            else{
                $(emailError).text('');
                $(emailField).removeClass('border border-danger')
                $(buttonSubmit).removeAttr('disabled');
            }
        });
    };
    emailValidation('.add-account-dean-email', '.add-account-dean-email-error', '.add-account-dean-form');
    emailValidation('.add-account-admin-email', '.add-account-admin-email-error', '.add-account-admin-form');
    emailValidation('.edit-account-email', '.edit-account-email-error', '.edit-account-form');

    let fullNameValidation = (inputField, inputError , buttonSubmit = null) =>{
        $(document).on('keyup', inputField , function(){
            var regex = /^[A-Za-z\s]+$/;

            if($(inputField).val() != ""){
                
                if(regex.test($(inputField).val())){
                    $(buttonSubmit).removeAttr('disabled');
                    $(inputField).removeClass('border border-danger')
                    $(inputError).text('')
                }
                else{
                    $(inputField).addClass('border border-danger')
                    $(inputError).text('alpha and white space only.')
                    $(buttonSubmit).attr('disabled', true);
                }
            }
            else{
                $(buttonSubmit).removeAttr('disabled');
                $(inputField).removeClass('border border-danger')
                $(inputError).text('')
            }
        })
    }
    fullNameValidation('.add-account-dean-fullname', '.add-account-dean-fullname-error', '.add-account-dean-form')
    fullNameValidation('.add-account-admin-fullname', '.add-account-admin-fullname-error', '.add-account-admin-form')
    fullNameValidation('.edit-account-fullname', '.edit-account-fullname-error', '.edit-account-form')
})
