
load_employe();
btnAction = "Insert";
filljob();

function filljob() {

  let sendingData = {
    "action": "read_job"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/employee.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
          html += `<option value="${res['job_id']}">${res['job_name']}</option>`;

        })

        $("#job_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


$("#employeform").on("submit", function (event) {

  event.preventDefault();


  let fullname = $("#fullname").val();
  let email = $("#email").val();
  let tell = $("#tell").val();
  let city = $("#city").val();
  let state = $("#state").val();
  let job_id = $("#job_id").val();
  let id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "fullname": fullname,
      "email": email,
      "tell": tell,
      "city": city,
      "state": state,
      "job_id": job_id,
      "action": "register_employe"
    }

  } else {
    sendingData = {
      "employe_id": id,
      "fullname": fullname,
      "email": email,
      "tell": tell,
      "city": city,
      "state": state,
      "job_id": job_id,
      "action": "update_employe"
    }
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/employee.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#employeform")[0].reset();
   load_employe();




      } else {
        swal("NOW!", response, "error");
      }

    },
    error: function (data) {
      swal("NOW!", response, "error");

    }

  })

})



function get_employe_info(employe_id) {

  let sendingData = {
    "action": "get_employe_info",
    "employe_id": employe_id 
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/employee.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        btnAction = "update";

        $("#update_id").val(response['employe_id']);
        $("#fullname").val(response['fullname']);
        $("#email").val(response['email']);
        $("#tell").val(response['tell']);
        $("#city").val(response['city']);
        $("#state").val(response['state']);
        $("#job_id").val(response['job_id']);
        $("#employee_modal").modal('show');




      } else {
        displaymssage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


function load_employe() {
  $("#employeeTable tbody").html('');
  $("#employeeTable thead").html('');

  let sendingData = {
    "action": "read_all_employe"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/employee.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';
      let th = '';


      if (status) {
        response.forEach(res => {
          th = "<tr>";
          for (let r in res) {
            th += `<th>${r}</th>`;
          }

          th += "<td>Action</td></tr>";

          tr += "<tr>";
          for(let r in res){

           
            if(r=="salary"){
              tr += `<td>$${res[r]}</td>`;

            }

            
            else{
              tr += `<td>${res[r]}</td>`;
            }

      }
      tr += `<td> <a class="btn btn-info update_info"  update_id=${res['ID']}><i class="bi bi-pencil-square" style="color: #fff"></i></a>&nbsp;&nbsp <a class="btn btn-danger delete_info" delete_id=${res['ID']}><i class="bi bi-trash" style="color: #fff"></i></a> </td>`

       
        tr += "</tr>"

        })
        $("#employeeTable thead").append(th);
        $("#employeeTable tbody").append(tr);
      }
     



    },
    error: function (data) {

    }

  })
}

function Delete_employe(employe_id) {

  let sendingData = {
    "action": "Delete_employe",
    "employe_id": employe_id 
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/employee.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        swal("Good job!", response, "success");
        load_employe();


      } else {
        swal(response);
      }

    },
    error: function (data) {

    }

  })
}

$("#employeeTable").on('click', "a.update_info", function () {
  let id = $(this).attr("update_id");
  get_employe_info(id)
})

$("#employeeTable").on('click', "a.delete_info", function () {
  let id = $(this).attr("delete_id");
  if (confirm("Are you sure To Delete")) {
    Delete_employe(id)

  }

})
