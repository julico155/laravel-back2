const signUp = document.getElementById('sign-up'),
    signIn = document.getElementById('sign-in'),
    loginIn = document.getElementById('login-in'),
    loginUp = document.getElementById('login-up'),
    error = document.getElementById('error'),
    sign = document.getElementById('sign'),
    pass1 = document.getElementById('password1'),
    pass2 = document.getElementById('password2')


signUp.addEventListener('click', ()=>{
    loginIn.classList.remove('block')
    loginUp.classList.remove('none')

    loginIn.classList.toggle('none')
    loginUp.classList.toggle('block')
})
sign.addEventListener('click', ()=>{
    if (pass1.value != pass2.value) {
        error.classList.remove('none')
        error.classList.toggle('block')
        console.log("funcaaaa")
    } else {
        error.classList.remove('block')
        error.classList.toggle('none')
    }
})
signIn.addEventListener('click', ()=>{
    loginIn.classList.remove('none')
    loginUp.classList.remove('block')

    loginIn.classList.toggle('block')
    loginUp.classList.toggle('none')
})
