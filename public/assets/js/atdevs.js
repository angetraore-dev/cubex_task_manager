//import menu_process from "./menu_process";


$(document).ready(function (){


    console.log("angetraore-dev: +225 0507 333 944");

    //Add-Task-Page and Done Archive
    let addTaskPageDiv = $('#addTaskPageContainerDiv')
    //let doneArchiveDiv = $('#doneArchiveContainerDiv')
    let allTablesDiv = $('#allTables');
    let loader = $("#loaderDiv");
    let userDropdownFilter = $('#userbydepartment-1')
    let addBtns = document.querySelectorAll(".addBtn")
    let allBtnsAddTaskPageDiv = $('.allBtnsAddTaskPage')
    let addTaskPageFormsDisplay = $('#addTaskPageFormsDisplay')
    let firstPageAdminBtnDiv = $('#first-page-admin')//oo
    let menus = document.querySelectorAll('.pageHref');//oo
    let backDiv = $('.backDiv');//oo
    let backToFirstPageAdminBtnDiv = document.querySelectorAll('.back');//oo
    let departmentListDiv = $("#departmentListInTaskPage");
    let activeTasksInTaskPage = $("#activeTasksInTaskPage");
    let viewTaskBtns = document.querySelectorAll(".viewTasksBtn");
    let departmentDropdownContainer = $('#receiveDepartmentList');

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

    //menu_process();

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

            //contentType: "application/json; charset=utf-8", what type of data you send
            //dataType: "text/html", what expectation
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

                    }else {
                        window.location.replace("http://localhost/php/taskmanagerapp"+response)
                    }

                }
            })
        }

    })

    //Get user by Task in Dropdown user Filter add Task
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
    $(document).on("click", 'ul#userbydepartment-1 li[data-id] p', function (){
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
    $(document).on('click', 'ul.receiveDepartmentList li.departmentList', function (){
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
                            }).then(() => closeForm() )//window.location.reload()

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


    /**
     * Good Add Process Start
     */

    //Add Process Department - Task - User --- Use too to delete User or Department
    Array.from(addBtns).forEach(addBtn => {
        addBtn.addEventListener('click', event => {
            loader.removeClass('d-none').fadeIn()
            let func = event.currentTarget.getAttribute('data-id')
            //console.log(func)
            loadForm(func)
        })
    })

    //Form Add Process Display
    const loadForm = (func) => {
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{disForm:func},
            success:function (response) {
                allBtnsAddTaskPageDiv.addClass('d-none').fadeOut()
                allTablesDiv.addClass('d-none').fadeOut()
                loader.addClass('d-none').fadeOut()
                addTaskPageFormsDisplay.removeClass('d-none').html(response).fadeIn()
            }
        })
    }

    $(document).on('click', '.cancelForm', function (){
        loader.removeClass('d-none').fadeIn()
        addTaskPageFormsDisplay.addClass('d-none').fadeOut()
        loader.addClass('d-none').fadeOut()
        allBtnsAddTaskPageDiv.removeClass('d-none').fadeIn()
    })

    //Send Any form and Php Process Side OK
    $(document).on('click', '.sendFormBtn', function (event){

        //this var contain formID - Entity Name and method name
        let info = event.currentTarget.getAttribute('data-id')
        const words = info.split('_')

        let form = document.querySelector('#'+words[0]);

        if (!form.checkValidity()){

            form.classList.add('was-validated')

        }else {

            let formdata = new FormData(form);

            if (words[0] == "taskForm"){

                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/addtaskRequest",
                    contentType:false,
                    processData:false,
                    data:formdata,
                    success:function (response) {

                        if (response != true){

                            Toast.fire({
                                icon:"error",
                                text:"Something went wrong, please contact the admin"
                            }).then(() => closeForm())

                        }else {

                            Toast.fire({
                                icon:"success",
                                text:"Task Successfully created"

                            }).then(() => closeForm())

                        }
                    }
                })

            }else {
                let obj = {}
                obj['class'] = words[1]
                obj['method'] = words[2]
                formdata.forEach(((value, key) => obj[key] = value))

                $.post({
                    url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
                    data:{formIns:JSON.stringify(obj)},
                    success:function (response){

                        if (response == true){

                            Toast.fire({
                                toast:true,
                                icon:"success",
                                text:"Successfully Updated"

                            }).then(() => closeForm())

                        }else {
                            Toast.fire({
                                icon:"error",
                                text:response
                            }).then(() => closeForm())
                        }
                    }
                })

            }
            //console.log(words[0] +" "+words[1] +" " +words[2])
        }


    })

    //Load Active tasks And departments in Task-page for CEO - ADMIN ROLE
    const loadDepartments = () => {
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{departmentList:1},
            success:function (response) {
                departmentListDiv.html(response);

            }
        })
    }
    loadDepartments()

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

    //Close any form
    const closeForm = () => {
        $('.cancelForm').trigger('click')
        //Load departments and active Tasks in task-page again
        setTimeout(() => {
            loadDepartments()
            loadActiveTasks()
        },2000)
    }

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


    //First menu on Admin Route
    const menuBtnAction = () => {
        'use strict'

        //render menu route on click
        Array.from(menus).forEach(menu =>{
            menu.addEventListener('click', event => {

                loader.removeClass('d-none').fadeIn()
                let containerPageDisplay = event.currentTarget.getAttribute('data-id')

                firstPageAdminBtnDiv.addClass('d-none').fadeOut()

                try {
                    localStorage.setItem('activePage', containerPageDisplay);
                    window.location.reload()

                } catch (e) {
                    console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
                }

                backDiv.removeClass('d-none').fadeIn()
                $("#"+containerPageDisplay).removeClass('d-none').fadeIn()

                loader.addClass('d-none').fadeOut()

                //Load departments and active Tasks in task-page again
                setTimeout(() => {
                    loadDepartments()
                    loadActiveTasks()
                },2000)

            }, false)
        });

        //Back Menu in admin route
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
    //Admin Page side Menu actions
    menuBtnAction()

    //Display active Page on reload Page
    try {
        var activePage = localStorage.getItem('activePage');
    } catch (e) {
        console.log("localstorage is not allowed in code snippets here test it on jsfiddle");
    }
    if (activePage) {
        //addTask-page doneArchiveContainerDiv

        firstPageAdminBtnDiv.addClass('d-none').fadeOut()
        loader.removeClass('d-none').fadeIn()
        backDiv.removeClass('d-none').fadeIn()
        $("#"+activePage).removeClass('d-none').fadeIn()
        loader.addClass('d-none').fadeOut()
        //if (activePage == "doneArchiveContainerDiv"){
        //             firstPageAdminBtnDiv.addClass('d-none').fadeOut()
        //             loader.removeClass('d-none').fadeIn()
        //             backDiv.removeClass('d-none').fadeIn()
        //             $("#"+activePage).removeClass('d-none').fadeIn()
        //             loader.addClass('d-none').fadeOut()
        //             //window.location.reload()
        //         }
    }



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
                    Toast.fire({
                        icon:"error",
                        text:"something went wrong, please contact the admin"

                    }).then( () => {
                        // $("#"+displayedTable).load(location.href +" #"+displayedTable +">*","")
                        refreshTable(displayedTable)
                    })
                }else {
                    Toast.fire({
                        icon:"success",
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
                                text:"Something went wrong"

                            }).then(() => {
                                refreshTable(displayedTable)
                            })

                        }else {

                            Toast.fire({
                                icon:"success",
                                text:"Successfull deleted"
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
    const allDepartmentsListForDropdownFilter = () => {

        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/adminRequest",
            data:{departmentListForFilter:1},
            success:function (response){
                departmentDropdownContainer.html(response)
            }
        })
    }

    //Display Department List in Filter Dropdown On demand OnClick
    $(document).on('click', 'div .departmentListFilter', function (){
        allDepartmentsListForDropdownFilter()
    })


})
