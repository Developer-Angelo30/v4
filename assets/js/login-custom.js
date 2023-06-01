$(document).ready(() => {

    const loginAccount = () =>{
        $(document).on('click', '#login-submit' , function(){

            var form = $('#login-form')
            var submitBtn = $('#login-submit')

            var email = $('.login-email');
            var emailError = $('.login-email-error');

            var password = $('.login-password');
            var passwordError = $('.login-password-error');

            if(!email.val() == ""){
                if(!password.val() == ""){
                    if(email.val().includes('@gmail.com')){
                        
                        const data = ({
                            "email": email.val(),
                            "password": password.val(),
                            "action-key": "loginAccounts"
                        })

                        $.ajax({
                            "url": "./view/user.view.php",
                            "method": "POST",
                            "data": data,
                            dataType: "JSON" ,
                            beforeSend: ()=>{
                                submitBtn.html('')
                                submitBtn.html('<span><i class="fa fa-spin fa-spinner" >&nbsp;</i><strong>Please wait.</strong></span>');
                                submitBtn.attr('disabled', true)
                            },
                            success: (response)=>{
                                if(response.status == true){
                                    location.href = response.location
                                }
                                else{
                                    switch(response.error){
                                        case 'email':{
                                            emailError.text(response.message);
                                            break;
                                        }
                                        case 'password':{
                                            passwordError.text(response.message);
                                            break;
                                        }
                                        default:{
                                            email.val('')
                                            password.val('')
                                            $('.error').text('')
                                            Swal.fire(
                                                'Maximun Attempt',
                                                response.message,
                                                'info'
                                            )
                                            break;
                                        }
                                    }
                                }
                            },
                            complete: ()=>{
                                submitBtn.html('')
                                submitBtn.html('<span><strong>Login </strong><i class="fa fa-arrow-right" ></i></span>');
                                submitBtn.removeAttr('disabled')
                            }
                        })
                      
                    }
                    else{
                        emailError.text("Please input valid email.")  
                    }
                }
                else{
                    passwordError.text("This field is required.")
                }
            }
            else{
                emailError.text("This field is required.")
            }
        })
    }
    loginAccount();


    const errorReset = () =>{
        $(document).on('click', '.input', function(){
            $('.error').text('')
        })
    }
    errorReset()

    const emailValidation = (emailField, emailError, buttonSubmit) => {
        $(document).on('keyup', emailField, function() {
            if($(this).val() != ""){
                if (!$(this).val().includes('@gmail.com')) {
                    $(emailField).addClass('border border-danger')
                    $(emailError).text("Please input a valid email.");
                    $(buttonSubmit).attr('disabled', true);
                } else {
                    $(emailField).removeClass('border border-danger')
                    $(emailError).text('');
                    $(buttonSubmit).removeAttr('disabled');
                }
            }
            else{
                $(emailField).removeClass('border border-danger')
                $(emailError).text('');
                $(buttonSubmit).removeAttr('disabled');
            }
        });
    };
    emailValidation('.login-email', '.login-email-error', '.login-submit');
});

const passwordValidate = (passwordField , passwordError , buttonSubmit )=>{
    $(document).on('keyup', passwordField , function(){
        if($(this).val() != ""){
            if($(this).val().length >= 8){
                $(passwordField).removeClass('border border-danger')
                $(passwordError).text('');
                $(buttonSubmit).removeAttr('disabled');
            }
            else{
                $(passwordField).addClass('border border-danger')
                $(passwordError).text("Password must be atleast 8 letters.");
                $(buttonSubmit).attr('disabled', true);
            }
        }
        else{
            $(passwordField).removeClass('border border-danger')
            $(passwordError).text('');
            $(buttonSubmit).removeAttr('disabled');
        }
    })
}
passwordValidate('.login-password', '.login-password-error' , '.login-submit')


const  passwordShow = (passwordField,passwordIcon)=>{
    let password = document.getElementById(passwordField);
    let icon = document.getElementById(passwordIcon);
    if(password.getAttribute('type') == "password"){
        password.setAttribute( "type", "text" )
        icon.classList.remove("fa-eye")
        icon.classList.add("fa-eye-slash")
    }
    else{
        password.setAttribute( "type", "password" )
        icon.classList.remove("fa-eye-slash")
        icon.classList.add("fa-eye")
    }
}