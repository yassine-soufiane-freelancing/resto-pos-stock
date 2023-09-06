$(document).ready(function () {
    $("#btn-register").click(function (e) { 
        e.preventDefault();
        register();
    });
    $("#btn-login").click(function (e) { 
        e.preventDefault();
        login();
    });
    $("#btn-logout").click(function (e) { 
        e.preventDefault();
        logout();
    });
});
const register = () => {
    let name = "XXXX";
    let email = "xx.xxx@gmail.com";
    let pwd = "soufiane@soufiane";
    let pwdConfirm = "soufiane@soufiane";
    let dataToSend = {
        "name" : name,
        "email" : email,
        "password" : pwd,
        "password_confirmation" : pwdConfirm,
    };
    addData('register', dataToSend, (data) => {
        console.log(data);
    });
}
const login = () => {
    let email = "xx.xxx@gmail.com";
    let pwd = "soufiane@soufiane";
    let dataToSend = {
        "email" : email,
        "password" : pwd,
    };
    addData('login', dataToSend, (data) => {
        console.log(data);
    });
}
const logout = () => {
    addData('logout', {}, (data) => {
        console.log(data);
    });
}
