const eye = document.getElementById('eye');
const passwordInput = document.getElementById('password');
eye.addEventListener('click', ()=>{
    if(passwordInput.type === "password" && passwordInput.value){
        passwordInput.type = "text";
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash')
    }else{
        passwordInput.type = "password";
        eye.classList.add('fa-eye');
        eye.classList.remove('fa-eye-slash')
    }
});
// const form = document.getElementById('form');
// form.addEventListener('onsubmit', (e)=>{
//     e.preventDefault();
// });
// const recover = document.getElementById("recover")
// const modal = document.getElementById('modal');
// modal.style.display = 'none';
// recover.addEventListener('click', ()=>{
//     modal.style.display = 'block';  
// })