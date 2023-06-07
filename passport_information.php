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
            <button type="button" class="btn btn-success  m-2" data-bs-toggle="modal" data-bs-target="#passport_info_modal">
              Add passport_information
            </button>
          </div>
          <table class="table" id="passport_info_Table">

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



<div class="modal fade" id="passport_info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">passport_info_modal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="passport_info_form">
          <input type="hidden" name="update_id" id="update_id">


          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <input type="text" name="passport_name" id="passport_name" class="form-control mt-2" placeholder="passport_name">
              </div>

            </div>

            <div class="col-sm-12 mt-3">
              <div class="form-group">
                <select name="pasport_type_id" id="pasport_type_id" class="form-control mt-2">
                  <option value="0">select passport</option>
                </select>
              </div>

            </div>

            <div class="col-sm-12 mt-3">
              <div class="form-group">
                <input type="text" name="price" id="price" class="form-control mt-2" placeholder="price" readonly>
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