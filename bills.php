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


    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card">
                    <div class="text-end">
                        <button type="button" class="btn btn-success  m-2" data-bs-toggle="modal" data-bs-target="#bilsmodal">
                            Add bills
                        </button>
                    </div>
                    <table class="table" id="billsTable">

                        <thead>



                        </thead>

                        <tbody>




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->



</main>


<!-- End #main -->


<div class="modal fade" id="bilsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Bills</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="billform">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="row">

                        <div class="col-sm-6 mt-4">
                            <div class="form-group">
                                <select name="employee" id="employee" class="form-control">

                                    <option value="0">select employee</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="from-group">
                                <label for="">salary</label>
                                <input type="text" class="form-control" id="amount" readonly>
                            </div>
                        </div>


                        <div class="col-sm-6 mt-3">
                            <div class="form-group">
                                <label for="">month</label>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="0">Select month</option>
                                    <option value="Jan">Jan</option>
                                    <option value="Feb">Feb</option>
                                    <option value="Mar">Mar</option>
                                    <option value="Apr">Apr</option>
                                    <option value="May">May</option>
                                    <option value="Jun">Jun</option>
                                    <option value="July">July</option>
                                    <option value="Aug">Aug</option>
                                    <option value="Sep">Sep</option>
                                    <option value="Oct">Oct</option>
                                    <option value="Nov">Nov</option>
                                    <option value="Dec">Dec</option>

                                </select>
                            </div>

                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group">
                                <label for="">year</label>
                                <input type="text" name="year" id="year" class="form-control" required>
                            </div>

                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group">
                                <label for="">description</label>
                                <input type="text" name="description" id="description" class="form-control" required>
                            </div>

                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group">
                                <label for="">user</label>
                                <select name="user" id="user" class="form-control" required>
                                    <option value="0">select user</option>
                                </select>
                            </div>

                        </div>





                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="insert" class="btn btn-primary">Save Info</button>
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