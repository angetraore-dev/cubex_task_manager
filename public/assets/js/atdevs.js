$(document).ready(function (){
    console.log("angetraore-dev: +225 0507 333 944");
    //Toast
    let toastMixin = Swal.mixin({
        toast: true,
        icon: "success",
        title: "Notification",
        position: "center",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen(popup) {
            popup.addEventListener('mouseenter', Swal.stopTimer);
            popup.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    //For datatable return int on string or char
    let intVal = function (i) {
        return typeof i === 'string'
            ? i.replace(/[\$,]/g, '') * 1
            : typeof i === 'number'
                ? i
                : 0;
    };


    //Login Process
    $("#loginform").on("submit", function (event){
        let form = document.querySelector("#loginform");
        event.preventDefault()
        event.stopPropagation()
        $('.fa-spin').removeClass('d-none').fadeIn();

        if (!form.checkValidity()) {

            form.classList.add('was-validated')
            $(".fa-spin").addClass('d-none').fadeOut();

        }else {
            let obj = {};
            let formData = new FormData(form);
            formData.forEach((value, key) => obj[key]=value);
            $.post({
                url:"http://localhost/php/taskmanagerapp/login/loginRequest",
                data:{login: JSON.stringify(obj)},
                success:function (response) {
                    console.log(response)
                    $(".fa-spin").addClass('d-none').fadeOut();

                    if ( !response ){
                        toastMixin.fire({
                            icon: "error",
                            title: "Error",
                            text: "Bad credentials"
                        })
                        //.then(() => $('#loginform').get(0).reset())

                    }else {
                        window.location.replace("http://localhost/php/taskmanagerapp"+response)
                    }

                }
            })
        }

    })

    //Department Process
    $('#saveDepartment').click(function (){
        let form = document.querySelector("#departmentForm");

        if ( !form.checkValidity()){
            form.classList.add('was-validated');
        }else {
            let obj = {};
            let formData = new FormData(form);
            formData.forEach((value, key) => obj[key] = value);
            $.post({
                url: "http://localhost/php/taskmanagerapp/admin/adminRequest",
                data: {saveDepartment:JSON.stringify(obj)},
                success:function (response){
                    //console.log(response)
                    if (!response){
                        toastMixin.fire({
                            icon:"error",
                            title:"Something went wrong!",
                            text: "please contact the developer."
                        })
                    }else {
                        toastMixin.fire({
                            text: "Department sucessfully create"
                        }).then(() => $("#departmentForm").get(0).reset())
                    }
                }
            })
        }
    })

    $(".cancelDepartment").click(function (){
        $("#departmentForm").get(0).reset();
    })

    //User Process
    $('#saveUser').click(function (){
        let form = document.querySelector('#userForm');
        //console.log(form)
        if (!form.checkValidity()){
            form.classList.add('was-validated');
        }else {
            let obj = {};
            let formData = new FormData(form);
            formData.forEach((value,key) => obj[key]=value);
            $.post({
                url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                data:{saveUser:JSON.stringify(obj)},
                success:function (response) {
                    //console.log(response)
                    if (response == true){

                        toastMixin.fire({
                            text: "User sucessfully created"
                        }).then(() => $("#userForm").get(0).reset())
                    }else {
                        toastMixin.fire({
                            icon:"error",
                            title:"Something went wrong!",
                            text: "please contact the developer."
                        })
                    }
                }
            })
        }
    })
    $(".cancelUser").click(function (){ $("#userForm").get(0).reset();})

    //display list of all users and admin can choose who to delete, Grouped delete or single
    $('.delUser').click(function (){
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{delUserForm:1},
            success:function (response) {
                $(".delUserList").html(response);
            }
        })
    })

    $(document).on("click", "form #delGpedUser", function (){

        let data = document.querySelector("#delgped");
        if ( !data.checkValidity()){
            data.classList.add('was-validated')
        }else {
            let obj={};
            let formData = new FormData(data);
            formData.forEach((value,key) => obj[key] = value);

            $.post({
                url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                data:{deleteUser:JSON.stringify(obj)},
                success:function (response){
                    if (response == true){

                        toastMixin.fire({
                            text: "User sucessfully deleted"
                        }).then(() => window.location.reload())
                    }else {
                        toastMixin.fire({
                            icon:"error",
                            title:"Something went wrong!",
                            text: "please contact the developer."
                        })
                    }
                }
            })
        }
    })

})
//$(document).on('click', 'li', function(){
//
//         $('#client').val($(this).text());
//
//         $('#clientList').fadeOut();
//         //$("#detail_facture_div").fadeOut();
//
//     });