$(document).ready(()=>{

    let errorReset = () =>{
        $(document).on('click', '.input', function(){
            $('.error').text('')
            $('.global-error').text('')
            $('.global-error').addClass('d-none')
        })
    }
    errorReset()

    // acounts  start code

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
    readAccounts()

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
