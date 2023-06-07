load_citizens();
btnAction = "Insert";

$("#citizenform").on("submit", function (event) {

  event.preventDefault();


  let fullname = $("#fullname").val();
  let phone = $("#phone").val();
  let gender = $("#gender").val();
  let address = $("#address").val();
  let city = $("#city").val();
  let place_of_brith = $("#place_of_brith").val();
  let date_of_brith = $("#date_of_brith").val();
  let nationaty = $("#nationaty").val();
  let id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "fullname": fullname,
      "phone": phone,
      "gender": gender,
      "address": address,
      "city": city,
      "place_of_brith": place_of_brith,
      "date_of_brith": date_of_brith,
      "nationaty": nationaty,
      "action": "register_citizens"
    }

  } else {
    sendingData = {
      "citizen_id": id,
      "fullname": fullname,
      "phone": phone,
      "gender": gender,
      "address": address,
      "city": city,
      "place_of_brith": place_of_brith,
      "date_of_brith": date_of_brith,
      "nationaty": nationaty,
      "action": "update_citizens"
    }
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/citizens.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#citizenform")[0].reset();
        $("citizenmodal").modal("hide");
        load_citizens();





      } else {
        swal("NOW!", response, "error");
      }

    },
    error: function (data) {
      swal("NOW!", response, "error");

    }

  })

})


function load_citizens() {
  $("#citizenTable tbody").html('');
  $("#citizenTable thead").html('');

  let sendingData = {
    "action": "read_all_citizens"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/citizens.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';
      let th = '';


      if (status) {
        response.forEach(res => {
          tr += "<tr>";
          th = "<tr>";
          for (let r in res) {
            th += `<th>${r}</th>`;

            tr += `<td>${res[r]}</td>`;


          }
          th += "<td>Action</td></tr>";

          tr += `<td> <a class="btn btn-info update_info"  update_id=${res['citizen_id']}><i class="bi bi-pencil-square" style="color: #fff"></i></a>&nbsp;&nbsp <a class="btn btn-danger delete_info" delete_id=${res['citizen_id']}><i class="bi bi-trash" style="color: #fff"></i></a> </td>`
          tr += "</tr>"

        })

        $("#citizenTable thead").append(th);
        $("#citizenTable tbody").append(tr);
      }




    },
    error: function (data) {

    }

  })
}

function get_citizen_info(citizen_id) {

  let sendingData = {
    "action": "get_citizen_info",
    "citizen_id": citizen_id
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/citizens.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        btnAction = "update";

        $("#update_id").val(response['citizen_id']);
        $("#fullname").val(response['fullname']);
        $("#phone").val(response['phone']);
        $("#gender").val(response['gender']);
        $("#address").val(response['address']);
        $("#city").val(response['city']);
        $("#place_of_brith").val(response['place_of_brith']);
        $("#date_of_brith").val(response['date_of_brith']);
        $("#nationaty").val(response['nationaty']);
        $("#citizenmodal").modal('show');




      } else {
        dispalaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}



function Delete_citizens(citizen_id) {

  let sendingData = {
    "action": "Delete_citizens",
    "citizen_id": citizen_id
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/citizens.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        swal("Good job!", response, "success");
        load_citizens();


      } else {
        swal(response);
      }

    },
    error: function (data) {

    }

  })
}

$("#citizenTable").on('click', "a.update_info", function () {
  let id = $(this).attr("update_id");
  get_citizen_info(id)
})


$("#citizenTable").on('click', "a.delete_info", function () {
  let id = $(this).attr("delete_id");
  if (confirm("Are you sure To Delete")) {
    Delete_citizens(id)

  }

})