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
    let loaderSm = $('ul li span#loader-sm')
    let doneArchiveUserFilterList = $('#doneArchiveUserFilterList');
    let departmentFilterResult = $('#doneArchiveDepartmentListFilter');

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

    //Get Tasks by Departments Api
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


