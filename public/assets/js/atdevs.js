$(document).ready(function (){
    console.log("angetraore-dev: +225 0507 333 944");
    //refresh div $("#departmentlist").load(location.href+" #departmentlist>*","")

    //Dynamic displayed allTables DIV -->
    let allTablesDiv = $('#allTables');


    //stay on tab active on refresh
    $(document).on('click', 'a[data-bs-toggle="tab"]', function (e) {
        try {
            localStorage.setItem('activeTab', e.target.dataset.bsTarget);
        } catch (e) {
            console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
        }
        //console.log(localStorage.getItem('activeTab'));
    });
    try {
        var activeTab = localStorage.getItem('activeTab');
    } catch (e) {
        console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
    }
    if (activeTab) {
        let triggerEL = document.querySelector(`a[data-bs-target="${activeTab}"]`);
        if (triggerEL) {
            bootstrap.Tab.getOrCreateInstance(triggerEL).show()
        }
    }
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
        position: 'top-end',
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

    //DataTable.moment("DD-MM-YYYY");

    let loader = $("#loaderDiv");
    //All top buttons div
    let depUserTaskDiv = $("#depUserTaskDiv");
    let taskFormDiv = $("#taskFormDiv");
    //TaskByUserTable in AdminController
    let taskByUserTableVeritable = $(this).closest('#userTaskTable').DataTable({
        "RowId": 0,
        "searching": true,
        "paging":true,
        "pageLength": 2,
        "orderable":true,
        "order": [[1, 'asc']],
        "autoWidth": false,
        "selected": false,
        "columns":[
            {"data":0},
            {"data":1},
            {"data":2},
            {"data":3}
        ]
    });

    //TaskByDepartment in AdminController
    let DepartmentTasksTableVeritable = $(this).closest('#DepartmentTasksTable').DataTable({
        "destroy":true,
        "RowId": 0,
        "searching": true,
        "paging":true,
        "pageLength": 2,
        "orderable":true,
        "order": [[1, 'asc']],
        "autoWidth": false,
        "selected": false,
        "columns":[
            {"data":0},
            {"data":1},
            {"data":2},
            {"data":3},
            {"data":4}
        ],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
            {
                text: 'Set Status',
                className: 'btn btn-outline-warning',
                action: function(e, dt, node, config) {

                    var client_table = DepartmentTasksTableVeritable.dataTable();

                    var rows = $(client_table.$('input[type="checkbox"]').map(function() {
                        return $(this).prop("checked") ? $(this).closest('tr') : null;
                    }));

                    // here I got the rows, but I don't know how to get the value of simsPid. iccid, and imei

                    $.each(rows, function(index, rowId) {


                    });

                }
            },
            {
                text: 'Discard',
                className: 'btn btn-outline-secondary',
                action: function(e, dt, node, config) {

                }
            }
        ]
    });

    //user-task-table-div
    let userTaskTableDivInDashboard = $('#user-task-table');
    //department-task-table-div
    let departmentTaskTableDivInDashboard = $('#department-task-table');

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
                        //console.log(response)
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


    //Dropdown user Filter
    let userDropdownFilter = $('#userbydepartment-1')
    $(document).on("click", 'li[data-id] a', function (){
        const id = $(this).closest('li').data('id');

        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{userByDep:id},
            success:function (response) {
                userDropdownFilter.html(response);
            }
        })
    })

    //result of Click On User List in Dropdown user Filter
    $(document).on("click", 'li[data-id] p', function (){
        const userid = $(this).closest('li').data('id');
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{userTask:userid},
            success:function (response) {
                //display table of user's task
                //departmentTaskTableDivInDashboard.load(location.href+" #department-task-table>*","");
                //userTaskTableDivInDashboard.removeClass('d-none').fadeIn().html(response);
                allTablesDiv.removeClass('d-none').fadeIn().html(response)
            }
        })
    })

    //Result of Click On display list task all Department in User Dropdown Filter
    $(document).on('click', 'li.alldep', function (){
        const departmentId = $(this).closest('li').data('id');
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{depTask:departmentId},
            success:function (response){

               allTablesDiv.removeClass('d-none').fadeIn().html(response)
               new DataTable(DepartmentTasksTableVeritable);
            }
        })
    })

    //List Department Clicked in Department Dropdown
    $(document).on('click', 'li.departmentList', function (){
        let depId = $(this).closest('li').data('id')
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{displayDepartmentTaskOnDropdownClick:depId},
            success:function (response){

                allTablesDiv.removeClass('d-none').fadeIn()
                allTablesDiv.html(response)
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
        userTaskTableDivInDashboard.addClass('d-none').fadeOut()
        departmentTaskTableDivInDashboard.addClass('d-none').fadeOut();
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



    //first-page-admin Btn and actions Div Btn Menu
    let firstPageAdminBtnDiv = $('#first-page-admin')
    let menus = document.querySelectorAll('.pageHref');
    let backDiv = $('.backDiv');
    let backToFirstPageAdminBtnDiv = document.querySelectorAll('.back');

    //Menu Button to Display Page and Back to menu button
    const menuBtnAction = () => {
        'use strict'
        Array.from(menus).forEach(menu =>{
            menu.addEventListener('click', event => {

                loader.removeClass('d-none').fadeIn()
                let containerPageDisplay = event.currentTarget.getAttribute('data-id')

                firstPageAdminBtnDiv.addClass('d-none').fadeOut()

                try {
                    localStorage.setItem('activePage', containerPageDisplay);
                } catch (e) {
                    console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
                }

                backDiv.removeClass('d-none').fadeIn()
                $("#"+containerPageDisplay).removeClass('d-none').fadeIn()

                loader.addClass('d-none').fadeOut()

            }, false)
        });

        Array.from(backToFirstPageAdminBtnDiv).forEach(back =>{
            back.addEventListener('click', e =>{
                loader.removeClass('d-none').fadeIn()
                let quitPage = localStorage.getItem('activePage');
                $("#"+quitPage).addClass('d-none').fadeOut();
                localStorage.setItem('activePage', '')
                backDiv.addClass('d-none').fadeOut()
                firstPageAdminBtnDiv.removeClass('d-none').fadeIn()
                loader.addClass('d-none').fadeOut()
            }, false)
        });

    }
    menuBtnAction()

    //Display active Page on reload Page
    try {
        var activePage = localStorage.getItem('activePage');
    } catch (e) {
        console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
    }
    if (activePage) {
        firstPageAdminBtnDiv.addClass('d-none').fadeOut()
        loader.removeClass('d-none').fadeIn()
        backDiv.removeClass('d-none').fadeIn()
        $("#"+activePage).removeClass('d-none').fadeIn()
        loader.addClass('d-none').fadeOut()
    }

    //Display Department list in Task-page for CEO - ADMIN ROLE
    let departmentListDiv = $("#departmentListInTaskPage");
    const loadDepartments = () => {
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{departmentList:1},
            success:function (response) {
                departmentListDiv.html(response);
            }
        })
    }
    loadDepartments();

    //Load Active task to Display in common admin Ceo View
    let activeTasksInTaskPage = $("#activeTasksInTaskPage");
    const loadActiveTasks = () => {
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{activeTasksList:1},
            success:function (response) {
                activeTasksInTaskPage.html(response);
            }
        })
    }
    loadActiveTasks();

    /*
    ADD TASK PAGE PROCESS
     */

    //Refresh and DISPLAY ALl Tables Onclick Event Process
    const refreshTable = (tableBtn) => {
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{viewTasksBtn:tableBtn},
            success:function (response) {
                allTablesDiv.removeClass('d-none').fadeIn()
                allTablesDiv.html(response)
            }
        })
    }

    //Display Table : All tasks Btn - Today Task Btn - Late Task Btn - Future Task Btn
    let viewTaskBtns = document.querySelectorAll(".viewTasksBtn");
    const displayTasksTableOnClickBtn = () => {
        'use-strict'
        Array.from(viewTaskBtns).forEach(viewTaskBtn => {

            viewTaskBtn.addEventListener('click', (event) => {

                let func = event.currentTarget.getAttribute('data-id');
                refreshTable(func)
            })
        })
    }
    displayTasksTableOnClickBtn()

    //CheckBoxes Process
    $(document).on('click', 'tr input.checkbox', function (event){

        let displayedTable = $(this).closest('tr').data('id');
        let obj = {};
        let check = event.currentTarget.checked;
        let taskId = event.currentTarget.getAttribute('data-id');
        obj['check'] = check
        obj['taskId'] = taskId

        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{checkedd:JSON.stringify(obj)},
            success:function (response){
                if (!response){
                    toastMixin.fire({
                        icon:"error",
                        text:"something went wrong, please contact the admin"

                    }).then( () => {
                        // $("#"+displayedTable).load(location.href +" #"+displayedTable +">*","")
                        refreshTable(displayedTable)
                    })
                }else {
                    Toast.fire({
                        text:"Successfull updated"
                    }).then(() => {
                        refreshTable(displayedTable)
                    })
                }
            }
        })

    })

    //Delete Task Item in All Table Process WORK AND REFRESHED TABLE WORK TOO
    $(document).on('click', 'tr button.delItem', function (e){
        let displayedTable = $(this).closest('tr').data('id');
        let taskIdItem = $(this).data('id');
        Toast.fire({
            icon:"warning",
            text:"Do you want to delete this item?",
            showCancelButton:true,
            showConfirmButton:true,
            timer:false,
            timerProgressBar:false

        }).then((response) => {
            if (response.isConfirmed){
                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                    data:{delTask:taskIdItem},
                    success:function (response) {
                        if (!response){
                            Toast.fire({
                                icon:"error",
                                text:"Something went wrong",
                                position:"bottom-end"
                            }).then(() => {
                                refreshTable(displayedTable)
                            })
                        }else {
                            Toast.fire({
                                icon:"success",
                                text:"Successfull deleted",
                                position:"bottom-end"
                            }).then(() => {
                                //$("#"+displayedtable).DataTable().row($button.parents('tr')).remove().draw(false)
                                refreshTable(displayedTable)
                            })

                        }
                    }
                })

            }
        })
    })

    //Get Department List to display in Add Task Page Dropdown Filter
    let departmentDropdownContainer = $('#receiveDepartmentList');
    const allDepartmentsListForDropdownFilter = () => {

        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{departmentListForFilter:1},
            success:function (response){
                departmentDropdownContainer.html(response)
            }
        })
    }

    //Display Department List in Filter Dropdown On demand *Click on
    $(document).on('click', 'div .departmentListFilter', function (){
        allDepartmentsListForDropdownFilter()
    })


})
