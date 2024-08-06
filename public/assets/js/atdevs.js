$(document).ready(function (){
    console.log("angetraore-dev: +225 0507 333 944");
    //refresh div $("#departmentlist").load(location.href+" #departmentlist>*","")

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

    const Toast = Swal.mixin({
        toast: true,
        position: 'le',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    //For datatable return int on string or char
    let intVal = function (i) {
        return typeof i === 'string'
            ? i.replace(/[\$,]/g, '') * 1
            : typeof i === 'number'
                ? i
                : 0;
    };

    let loader = $("#loaderDiv");
    //All top buttons div
    let depUserTaskDiv = $("#depUserTaskDiv");
    let taskFormDiv = $("#taskFormDiv");
    //TaskByUserTable
    let taskByUserTable = $('#userTaskTable');//$(this).closest('#userTaskTable')
    //user-task-table-div
    let userTaskTable = $('#user-task-table');
    //department-task-table
    let departmentTaskTable = $('#department-task-table');

    console.log(taskByUserTable)
    //Draw Task By User Table
    taskByUserTable.DataTable().draw();
    if (taskByUserTable instanceof $.fn.dataTable.Api) {
        console.log("is initialized")
        // variable "table" is a valid initialized DataTable ... do datatable stuff
    } else {
        // variable "table" is not a datatable... do other stuff
        console.log("is not initialized")
    }

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
                        }).then(() => {
                            $("#departmentForm").get(0).reset();
                            var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('addDepartment'));
                            myModal.hide();

                            $("#departmentlist").load(location.href+" #departmentlist>*","");
                        })
                    }
                }
            })
        }
    })

    $(".cancelDepartment").click(function (){
        $("#departmentForm").get(0).reset();
    })

    //Display del department form on click
    $('.delDep').click(function (){
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{delDepForm:1},
            success:function (response) {
                $(".delDepList").html(response);
            }
        })
    })

    $(document).on("click", "form #delGpedDep", function (){
        let form = document.querySelector(".delgped-dep");

        if (!form.checkValidity()){
            form.classList.add('was-validated')
        }else {
            let obj={};
            let formdata = new FormData(form);
            formdata.forEach((value, key) => obj[key]=value);
            if (jQuery.isEmptyObject(obj)){

                toastMixin.fire({
                    icon:"warning",
                    title:"Please select someone to delete!",
                    text: "Please select someone to delete"
                })

            }else {
                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                    data:{deleteDepartment:JSON.stringify(obj)},
                    success:function (response) {
                        console.log(response)
                        if (response != true){

                            toastMixin.fire({
                                icon:"error",
                                title:"Something went wrong!",
                                text: "please contact the developer."
                            })
                        }else {
                            toastMixin.fire({
                                text: "Department sucessfully deleted"
                            }).then(() => window.location.reload())
                        }
                    }
                })
            }
        }
    })

    //display task by USER
    $(document).on("click", 'li[data-id] a', function (){
        const id = $(this).closest('li').data('id');
        //display user of the department concerned
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{userByDep:id},
            success:function (response) {
                //console.log(response)
                $("#userbydepartment-1").html(response);
            }
        })

    })

    //display task table by USER
    $(document).on("click", 'li[data-id] p', function (){
        const userid = $(this).closest('li').data('id');
        //console.log(userid)
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{userTask:userid},
            success:function (response) {
                //display table of user's task
                departmentTaskTable.load(location.href+" #department-task-table>*","");
                userTaskTable.removeClass('d-none').fadeIn().html(response);
            }
        })
    })

    //display task table by DEPARTMENT
    $(document).on('click', 'li.alldep', function (){
        const departmentId = $(this).closest('li').data('id');
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{depTask:departmentId},
            success:function (response){

                userTaskTable.load(location.href+" #user-task-table>*","");
                departmentTaskTable.removeClass('d-none').fadeIn().html(response);
            }
        })
    })

    //User Process
    $('#saveUser').click(function (){
        let form = document.querySelector('#userForm');
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
            if (jQuery.isEmptyObject(obj)){
                toastMixin.fire({
                    icon:"warning",
                    title:"Please select someone to delete!",
                    text: "Please select someone to delete"
                })
            }else {
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
        }
    })

    //Task Process
    $('#addTaskBtn').click(function (){
        depUserTaskDiv.addClass('d-none').fadeOut();
        loader.removeClass('d-none');
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{taskBtn:1},
            success: function (response) {
                loader.addClass('d-none').fadeOut();
                taskFormDiv.removeClass('d-none').fadeIn().html(response);
            }
        })
    })

    $(document).on('click', '.closeTaskFormBtn', function (){
        loader.removeClass('d-none').fadeIn()
        taskFormDiv.addClass('d-none').fadeOut()
        loader.addClass('d-none').fadeOut()
        depUserTaskDiv.removeClass('d-none').fadeIn()
    })

    $(document).on('click', '.sendTaskFormBtn', function (){
        let form = document.querySelector('#taskForm');
        if (!form.checkValidity()){
            form.classList.add('was-validated')
        }else {
            let formdata = new FormData(form);
            $.post({
                url:"http://localhost/php/taskmanagerapp/admin/addtaskRequest",
                contentType:false,
                processData:false,
                data:formdata,
                success:function (response) {
                    //console.log(response)
                    if (response != true){

                        toastMixin.fire({
                            icon:"error",
                            text:"Something went wrong, please contact the admin"
                        })
                            //.then(()=> window.location.reload())

                    }else {
                        toastMixin.fire({
                            title:"Task successfull Assigned",
                            text:"Would you want to assign another task ?",
                            timer:false,
                            timerProgressBar: false,
                            showConfirmButton: true,
                            confirmButtonText: "Yes",
                            showCancelButton:true,
                            customClass: {
                                actions: 'my-actions',
                                //cancelButton: 'order-1 right-gap',
                                confirmButton: 'order-2',
                                cancelButton: 'order-3',
                            },
                        }).then( (result) => {
                            if (result.isConfirmed){
                                form.reset();
                            }else {
                                window.location.reload()
                            }
                        })
                    }
                }
            })
        }
    })

    //Delete Task
    $(document).on('click', 'tr button#delTask', function (){
        let tr = $(this).closest('tr');
        const taskid = tr.find('#delTask').data('id');
        toastMixin.fire({
            icon:"warning",
            title:"warning",
            text:"Do you want to delete this task?",
            showConfirmButton:true,
            confirmButtonText: "Yes",
            showCancelButton: true,
            timer:false,
            timerProgressBar:false
        }).then((response)=>{
            if (response.isConfirmed){
                let userid = tr.find("#userid").val();

                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                    data:{delTask:taskid},
                    success:function (response) {
                        if (!response){
                            toastMixin.fire({
                                icon:"error",
                                title:"error",
                                text:"Something went wrong, please contact the admin"
                            })
                        }else {
                            Toast.fire({
                                icon:"success",
                                iconColor: "succes",
                                text:"Successfull delete"
                            }).then(() => {
                                $.post({
                                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                                    data:{userTask:userid},
                                    success:function (response){
                                        //loader.removeClass('d-none').fadeIn()
                                        departmentTaskTable.load(location.href+" #department-task-table>*","");
                                        //userTaskTable.load(location.href+ "#user-ask-table>*","")
                                        userTaskTable.removeClass('d-none').fadeIn().html(response);
                                    }
                                })
                            })
                        }
                    }
                })
            }
        })
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




//var object = {};
//             formdata.forEach((value, key) => {
//                 // Reflect.has in favor of: object.hasOwnProperty(key)
//                 if(!Reflect.has(object, key)){
//                     object[key] = value;
//                     return;
//                 }
//                 if(!Array.isArray(object[key])){
//                     object[key] = [object[key]];
//                 }
//                 object[key].push(value);
//             });
//             var json = JSON.stringify(object);
//             console.log(json)