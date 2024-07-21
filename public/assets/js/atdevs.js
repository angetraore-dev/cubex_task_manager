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


    const form = document.querySelector("#loginform");
    //const loginBtn = document.querySelector("#login");
    form.addEventListener('submit', function (event){
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
                        }).then(() => $('#loginform').get(0).reset())

                    }else {
                       window.location.replace("http://localhost/php/taskmanagerapp"+response)
                    }

                }
            })

        }

    })
})

/**
 * const form = document.querySelector("#loginform");
 *
 *     //pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
 *     $("#login").on('click', function (){
 *         const form = document.querySelector("#loginform");
 *
 *         $('.fa-spin').removeClass('d-none').fadeIn();
 *
 *         if (!form.checkValidity()) {
 *             form.classList.add('was-validated')
 *             $(".fa-spin").addClass('d-none').fadeOut();
 *
 *         }else {
 *             let obj = {};
 *             formData = new FormData(form);
 *             formData.forEach((value, key) => obj[key]=value);
 *             $.post({
 *                 url: "http://<?= HTTTP .'/login/loginRequest'?>",
 *                 data:{login: JSON.stringify(obj)},
 *                 success:function (response) {
 *                     console.log(response);
 *                 }
 *             })
 *         }
 *     })
 */