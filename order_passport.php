<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:login.php');
    die();
}

?>


<?php
include 'include/header.php';


?>
<!-- ======= Header ======= -->
<?php
include 'include/nav.php';
?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php

include 'include/sidebar.php';

?>




<!-- End Sidebar-->

<main id="main" class="main">


    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-end">
                        <button type="button" class="btn btn-success  m-2" data-bs-toggle="modal" data-bs-target="#ordermodal">
                            Add New order
                        </button>
                    </div>
                    <h5 class="card-header">orders Table</h5>
                    <div class="table-responsive text-nowrap" id="orderTable">
                        <table class="table">
                            <thead class="table-light">


                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->



</main>


<!-- End #main -->

<div class="modal fade" id="ordermodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">orders Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="orderForm">
                    <input type="hidden" name="update_id" id="update_id">

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <select name="citizen_id" id="citizen_id" class="form-control">
                                    <option value="0">
                                        select citizen name
                                    </option>

                                </select>

                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <select name="passport_type_id" id="passport_type_id" class="form-control">
                                    <option value="0">
                                        select passport
                                    </option>

                                </select>

                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <input type="text" name="amount" id="amount" class="form-control" readonly>

                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <select name="issuing_authority_id" id="issuing_authority_id" class="form-control">
                                    <option value="0">
                                        select issuing authority
                                    </option>

                                </select>

                            </div>
                        </div>







                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <?php
    include 'include/footer.php';

    ?>