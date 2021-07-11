$(document).load(function(){
    User.create("#signUp", "#user_password_sign_up_checkout", "#user_password_sign_up_confirmation_checkout", "#signUpContainer");
    Session.create("#signIn", "#signInContainer");
})