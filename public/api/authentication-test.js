$(document).ready(function () {
    $("#btn-register").click(function (e) { 
        e.preventDefault();
        register();
    });
    $("#btn-logout").click(function (e) { 
        e.preventDefault();
        logout();
    });
});
const register = () => {
    let name = "nouhaila 2";
    let email = "nouhaila.elkechchad2@gmail.com";
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
    let email = "nouhaila.elkechchad2@gmail.com";
    let pwd = "soufiane@soufiane";
    let dataToSend = {
        "email" : email,
        "password" : pwd,
    };
    addData('register', dataToSend, (data) => {
        console.log(data);
    });
}
const logout = () => {
    addData('logout', {}, (data) => {
        console.log(data);
    });
}
