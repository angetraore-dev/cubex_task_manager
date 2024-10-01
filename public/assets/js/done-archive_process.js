const doneArchive = () => {
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

    console.info("DOM loaded");
    $('#doneArchiveH3').addClass('gold text-uppercase')

    //Vars
    // $("#departmentListArchivedFilter").load(location.href+" #departmentlist>*","");
    let doneArchiveResponseDiv = $('#doneArchiveResponseDiv')
    let loader = $('.loader')
    let loaderSm = $('ul li span#loader-sm')
    let doneArchiveUserFilterList = $('#doneArchiveUserFilterList');
    let departmentFilterResult = $('#doneArchiveDepartmentListFilter');

    const refreshTableAfterAction = (data) => {
        loader.removeClass('d-none').fadeIn()
        //entity filter id
        let obj = {}
        let concat = data.split('-')

        if (concat.length > 2){
            obj = {
                entity: concat[0],
                filter: concat[1],
                id: concat[2]
            }

        }else {
            obj = {
                entity: concat[0],
                filter: concat[1]
            }
        }
        $.post({
            url: 'http://localhost/php/taskmanagerapp/admin/doneArchive',
            data: {varsObj: JSON.stringify(obj)},
            success: function (response) {
                loader.addClass('d-none')
                doneArchiveResponseDiv.removeClass('d-none').html(response).fadeIn()
            }
        })
    }

    //Send FormData to ServerSide and treat and return response
    const crudDoneArchive = (obj, lastOpenedFunc) => {
        loader.removeClass('d-none').fadeIn()
        $.post({
            url: "http://localhost/php/taskmanagerapp/admin/doneArchive",
            data: {doneArchiveCrud: JSON.stringify(obj)},
            success: function (response){
                console.log(response)
                loader.addClass('d-none').fadeOut()
                if (( ! response )){
                    Toast.fire({
                        icon: "error",
                        text: "Something went wrong, plz contact the dev"
                    })
                }else {
                    Toast.fire({
                        iconColor:"success",
                        icon: "success",
                        title:"Success",
                        text: "Task archived"
                    }).then(() => $("#staticBackdropDoneArchive").modal('hide'))
                }
                refreshTableAfterAction(lastOpenedFunc)
            }
        })
    }

    //Done Archive Crud Action
    $(document).on('click', 'li input[name="observation"]', function (){

        let TitleTaskIdFullname = $(this).closest("tr").data('id')
        let concatTitleTaskIdFullname = TitleTaskIdFullname.split('-')
        let obs = this.value
        let lastOpenedFunc = $(this).closest("table").data('id')

        $('#addArchiveForm input[name="taskTitle"]').val(concatTitleTaskIdFullname[0])
        $('#addArchiveForm input[name="taskId"]').val(concatTitleTaskIdFullname[1])
        $('#addArchiveForm input[name="userFullname"]').val(concatTitleTaskIdFullname[2])
        $('#addArchiveForm input[name="obs"]').val(obs)
        $('#addArchiveForm input[name="lastOpenedFunc"]').val(lastOpenedFunc)

        $('#staticBackdropDoneArchive').modal('show')
    })

    const getAddArchiveForm = (form) => {

        let formdata = new FormData(form)
        let obj = {}

        if (! form.checkValidity()){

            form.classList.add('was-validated')

        }else if ( (formdata.get("archive_libelle")) && (formdata.get("existing_archive"))){

            Toast.fire({
                toast: true,
                iconColor: "orange",
                icon:"warning",
                title: "Warning",
                text:"You cannot have archive libelle and select an existing archive libelle as value, plz leave one empty !",
                timer:2000
            })

        }else if ( ( !formdata.get("archive_libelle" ) ) && ( !formdata.get("existing_archive") ) ){

            Toast.fire({
                toast: true,
                iconColor: "orange",
                icon:"warning",
                title: "Warning",
                text:"Please fill archive libelle or select an existing archive, plz leave one empty !",
                timer:2000
            })

        }else {

            formdata.forEach((value, key) => obj[key] = value);
            crudDoneArchive(obj, formdata.get("lastOpenedFunc"))
        }
    }
    //on Form Sent Event
    $('#addArchiveForm button.sendFormBtnDoneArchive').click(function (){
        let form = document.querySelector("#addArchiveForm");
        //taskId: , observation: , archiveId: null
        getAddArchiveForm(form)

    })

    //Get both checked tasks by default
    const getDefaultCheckedTasks = () => {
        loader.removeClass('d-none').fadeIn()
        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/doneArchive",
            data:{defBothChecked:1},
            success:function (response){
                loader.addClass('d-none').fadeOut()
                doneArchiveResponseDiv.removeClass('d-none').html(response).fadeIn()
            }
        })
    }
    getDefaultCheckedTasks()

    //Close any form
    const closeForm = () => {
        $('#staticBackdropDoneArchive').modal('hide')
        getDefaultCheckedTasks()
    }
    $(document).on('click', '#addArchiveForm button.cancelFormDoneArchive', closeForm)

    //Get Department List to display in doneArchive Page Dropdown Filter
    const DepartmentListFilterInDoneArchive = () => {

        $.post({
            url:"http://localhost/php/taskmanagerapp/admin/doneArchive",
            data:{departmentListForFilterArchive:2},
            success:function (response){
                loaderSm.addClass('d-none').fadeOut()
                departmentFilterResult.fadeIn()
                departmentFilterResult.html(response)
            }
        })
    }

    //Render Departments UL List in Department Filter
    $(document).on('click', 'div.departmentListFilterInDoneArchive', function (){
        DepartmentListFilterInDoneArchive()
    })

    //Get both checked Tasks by Departments Api
    const displayCheckedTasksByFilter = (entity, filterFunc, varId) => {
        const defaultValues = {
            entity: entity,
            filter: filterFunc,
            id: varId
        };
        $.post({
            url: 'http://localhost/php/taskmanagerapp/admin/doneArchive',
            data: {varsObj: JSON.stringify(defaultValues)},
            success: function (response) {
                doneArchiveResponseDiv.removeClass('d-none').html(response).fadeIn()
            }
        })
    }

    //Display User List by Clicking on Department List Item
    $(document).on('click', 'ul li.departmentListArchivedFilter', function (){

        let value = $(this).closest('li').data('id')
        let values = value.split("-")
        let entity = values[0]
        let filterFunc = values[1]
        let varId = values[2]
        displayCheckedTasksByFilter(entity,filterFunc, varId)

        const defaultValues = {
            entity: 'User',
            filter: 'displayUserListInFilterDoneArchived',
            id: values[2]
        };

        $.post({
            url: 'http://localhost/php/taskmanagerapp/admin/doneArchive',
            data: {varsObj: JSON.stringify(defaultValues)},
            success:function (response) {
                doneArchiveUserFilterList.html(response);
            }
        })

    })

    //Get both checked Tasks By userId
    $(document).on('click', 'ul li.userListInArchiveDropdown', function (){
        let userIdForCheckedTask = $(this).closest('li').data('id')
        console.log(userIdForCheckedTask)
        let values = userIdForCheckedTask.split("-")
        let entity = values[0]
        let filterFunc = values[1]
        let varId = values[2]
        displayCheckedTasksByFilter(entity,filterFunc, varId)

    })


    //End DoneArchiveProcess
}

if (document.readyState === "loading") {
    // Loading hasn't finished yet
    document.addEventListener("DOMContentLoaded", doneArchive);
} else {
    // `DOMContentLoaded` has already fired
    doneArchive();
}


