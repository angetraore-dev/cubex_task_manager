<?php ob_start();?>
<div class="container-fluid">

    <!-- Container for first buttons line -->
    <div class="row d-flex justify-content-between">
        <div class="col-md-7 g-3 border-2 border-danger">
            <!-- add department delete department-->
            <div class="justify-content-around py-2">
                <button type="button" class="col-4 btn btn-success btn-outline-light text-uppercase border-success">
                    <span class="fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 24 24">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                    </svg> Department
                    </span>
                </button>
                <button type="button" class="col-5 btn btn-danger btn-outline-light text-uppercase border-danger">
                    <span class="fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 24 24">
                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                        </svg>
                    </span>
                    delete department
                </button>
            </div>

            <div class="justify-content-around py-2">
                <button type="button" class="col-4 btn btn-success btn-outline-light text-uppercase border-success">
                    <span class="fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 24 24">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                    </svg> User
                    </span>
                </button>
                <button type="button" class="col-5 btn btn-danger btn-outline-light text-uppercase border-danger">
                    <span class="fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 24 24">
                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                        </svg>
                    </span>
                    delete user
                </button>
            </div>
        </div>

        <!-- filter for departments and responsibles -->
        <div class="col-md-4 g-3 border-2 border-primary">
           <div class="justify-content-around py-2 d-inline-flex">

               <div class="dropdown mx-2">
                   <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       departments
                   </button>
                   <ul class="dropdown-menu">
                       <li><a class="dropdown-item" href="#">loop foreach</a></li>
                       <li><a class="dropdown-item" href="#">Another action</a></li>
                       <li><a class="dropdown-item" href="#">Something else here</a></li>
                   </ul>
               </div>



               <div class="dropdown mx-2">
                   <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       responsibles
                   </button>
                   <ul class="dropdown-menu">
                       <li><a class="dropdown-item" href="#">loop foreach</a></li>
                       <li><a class="dropdown-item" href="#">Another action</a></li>
                       <li><a class="dropdown-item" href="#">Something else here</a></li>
                   </ul>
               </div>

           </div>


        </div>
    </div>

    <!-- Container for add a Task -->
    <div class="row d-flex justify-content-center align-items-center my-4">
        <button type="button" class="btn btn-success btn-outline-light col-4 text-uppercase">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 24 24">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
            </svg>Add Task
        </button>
    </div>

</div>
<?php $content = ob_get_clean(); ?>

<?php require_once DOCROOT .'/templates/layout.php';?>