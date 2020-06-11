const btnSignin = document.querySelector('.signin-btn');
const btnExitIn = document.querySelector('.btn-exit-in');
const signinForm = document.querySelector('.signin_form');
const btnSignup = document.querySelector('.signup-btn');
const btnExitUp = document.querySelector('.btn-exit-up');
const signupForm = document.querySelector('.signup_form');



btnSignin.addEventListener('click',show_signin);
btnExitIn.addEventListener('click',none_signin);
btnSignup.addEventListener('click',show_signup);
btnExitUp.addEventListener('click',none_signup);


function show_signin() {
    if(signupForm.style.display==='none'){
        signinForm.classList.remove('none');
    }
    else{
        signupForm.classList.add('none');
        signinForm.classList.remove('none');
    }
}

function none_signin() {
    signinForm.classList.add('none');
}


function show_signup() {
    if(signinForm.style.display==='none'){
        signupForm.classList.remove('none');
    }
    else{
        signinForm.classList.add('none');
        signupForm.classList.remove('none');
    }
}

function none_signup() {
    signupForm.classList.add('none');
}




