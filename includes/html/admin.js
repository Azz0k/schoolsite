function showPass(){
    if (pass.type==='password'){
        pass.type = 'text';
    }
    else
    {
        pass.type='password';
    }
}
var show = document.getElementById('show');
var pass = document.getElementById('password');
show.onclick = showPass;