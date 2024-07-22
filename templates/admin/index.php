<?php ob_start();?>
<div class="container-fluid">

    <!-- Container for first buttons line row mt-4-->
    <div class="row justify-content-between mt-4">

        <!-- Left Buttons div -->
        <div class="col-sm-3 ">

            <div class="row justify-content-around bg-body-tertiary shadow-lg rounded rounded-2 ms-2 mb-3 p-1">
                <!-- add department delete department-->
                <fieldset class="border border-2 p-1 fw-bolder text-uppercase">
                    <legend  class="float-none w-auto text-wrap">Department</legend>
                    <div class="d-flex col justify-content-between">

                        <div class="me-2">
                            <button type="button" id="add-dep" class="add-dep col btn btn-success btn-outline-light text-uppercase border-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="">
                            <button type="button" id="del-dep" class="del-dep col btn btn-danger btn-outline-light text-uppercase border-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="row justify-content-around bg-body-tertiary shadow-lg rounded rounded-2 ms-2 mb-3 p-2">
                <!-- add User delete delete user -->
                <fieldset class="border border-2 p-2 fw-bold text-end text-uppercase">
                    <legend  class="float-none w-auto">User</legend>
                    <div class="d-flex col justify-content-between">

                        <div class="me-2">
                            <button type="button" id="add-user" class="add-user col btn btn-success btn-outline-light text-uppercase border-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="">
                            <button type="button" id="del-user" class="del-user col btn btn-danger btn-outline-light text-uppercase border-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- Right Buttons div -->
        <div class="col-sm-3">
            <!--filter for departments and responsibles-->
            <div class="d-flex ms-0 me-auto shadow-lg justify-content-around rounded rounded-2 mb-5 p-2">

                <!-- List of all departments -->
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

                <!-- List of all responsible -->
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

    <!-- Centered Button -->
    <div class="row d-flex justify-content-center align-items-center my-4">
        <div class="col-4 shadow-lg mb-5 p-4">
            <fieldset class="border border-2 p-2 fw-bold text-center text-uppercase">

                <legend  class="float-none w-auto">add task</legend>

                <div class="d-flex col  align-items-center justify-content-center">
                    <div>
                        <button type="button" id="add-user" class="add-user col btn btn-success btn-outline-light text-uppercase border-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

</div>
<?php $content = ob_get_clean(); ?>

<?php require_once DOCROOT .'/templates/layout.php';?>