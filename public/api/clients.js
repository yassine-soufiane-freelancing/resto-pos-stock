$(document).ready(function () {
    $("#btn-show").click(function (e) { 
        e.preventDefault();
        getAllData(`${apiEndpoint}clients`, allClients);
    });
    $("#btn-add").click(function (e) { 
        e.preventDefault();
        addClient();
    });
});
const allClients = (data) => {
    console.log(data);
}
const addClient = () => {
    let fullName = "XXX1";
    let email = "xxx1@gmail.com";
    let address = "XXX XXXX X";
    let phone = "0600000000";
    let dataToSend = {
        "full_name":fullName,
        "email":email,
        "address":address,
        "phone":phone,
    };
    addData(`${apiEndpoint}clients`, dataToSend, (data) => {
        console.log(data);
    });
}
