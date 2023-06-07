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
            <button type="button" class="btn btn-success  m-2" data-bs-toggle="modal" data-bs-target="#citizenmodal">
              Add citizen
            </button>
          </div>
          <div class="table-responsive style=" overflow-y: scroll;">
            <table class="table" id="citizenTable">


              <thead>



              </thead>

              <tbody>

                <!-- <tr>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          
        </tr>
        <tr>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          
        </tr>
        <tr>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          
        </tr>
        <tr>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          <td>welcome</td>
          
        </tr> -->


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


<div class="modal fade " id="citizenmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">citizens</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="citizenform">
          <input type="hidden" name="update_id" id="update_id">
          <div class="row">
            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="fullname" required>
              </div>
            </div>



            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="number" name="phone" id="phone" class="form-control" placeholder="phone" required>
              </div>

            </div>


            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <select name="gender" id="gender" class="form-control">
                  <option value="0">select gender</option>
                  <option value="female">female</option>
                  <option value="male">male</option>
                </select>
              </div>

            </div>

            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="text" name="address" id="address" class="form-control" placeholder="address" required>
              </div>
            </div>


            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="text" name="city" id="city" class="form-control" placeholder="city" required>
              </div>

            </div>

            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="text" name="place_of_brith" id="place_of_brith" class="form-control" placeholder="place_of_brith" required>
              </div>
            </div>


            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="date" name="date_of_brith" id="date_of_brith" class="form-control" required>
              </div>
            </div>



            <div class="col-sm-6 mt-3">
              <div class="form-group">
                <input type="text" name="nationaty" id="nationaty" class="form-control" placeholder="nationaty" required>
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