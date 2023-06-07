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
                <div class="card p-4">
                    <div class="text-end">
                        <button type="button" class="btn btn-success  m-2 mdi mdi mdi-plus-circle" data-bs-toggle="modal" data-bs-target="#accountmodal">
                            Add new Account
                        </button>
                    </div>
                    <table class="table table-striped" id="accountTable">

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




    <div class="modal fade" id="accountmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Account Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="accountForm">
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">bank_name</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" required>
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">holder_name</label>
                                    <input type="text" name="holder_name" id="holder_name" class="form-control" required>
                                </div>

                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">accoun_number</label>
                                    <input type="number" name="accoun_number" id="accoun_number" class="form-control" required>
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">balance</label>
                                    <input type="number" name="balance" id="balance" class="form-control" required>
                                </div>

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
</main>


<!-- End #main -->





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