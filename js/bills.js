loadbills();
filluser();
fill_salary();
fill_employe();
function fill_employe() {

  let sendingData = {
    "action": "read_all_employee_name"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bils.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
        
          html += `<option value="${res['employe_id']}">${res['fullname']}</option>`;


        })

        $("#employee").append(html);


      } else {
        displaymssage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

function filluser() {

  let sendingData = {
    "action": "get_user_list"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/user.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
          html += `<option value="${res['id']}">${res['username']}</option>`;

        })

        $("#user").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}



btnAction = "Insert";

$("#billform").on("submit", function (event) {

  event.preventDefault();

  let employee = $("#employee").val();
  let amount = $("#amount").val();
  let month = $("#month").val();
  let year = $("#year").val();
  let description = $("#description").val();
  let user = $("#user").val();
  let id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "employee": employee,
      "amount": amount,
      "month": month,
      "year": year,
      "description": description,
      "user": user,
      "action": "register_bills"
    }

  
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bils.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        loadbills();
        $("#billform")[0].reset();







      } else {
        swal("NOW!", response, "error");
      }

    },
    error: function (data) {
      swal("NOW!", response, "error");

    }

  })

})

$("#employee").on("change", function () {
  let employee = $(this).val();
  console.log("name", employee);
  fill_salary(employee);

})


$("#employee").on("change", function(){
  if($("#employee").val()== 0){
    console.log("0 waaye");
    $("#amount").val("");

  }else{
    console.log(amount);
  }
})


function fill_salary(employe_id) {
  let sendingData = {
    "action": "read_employe_salary",
    "employe_id": employe_id

  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bils.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      console.log("name", response)
      let html = '';
      let tr = '';

      if (status) {

        response.forEach(res => {
          $("#amount").val(res['salary']);

        })



      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

function loadbills() {
  $("#billsTable tbody").html('');
  $("#billsTable thead").html('');

  let sendingData = {
    "action": "read_bills"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bils.php",
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





          tr += "<tr>";
          for (let r in res) {


            tr += `<td>${res[r]}</td>`;


          }

          tr += "</tr>"

        })
        $("#billsTable thead").append(th);
        $("#billsTable tbody").append(tr);
      }



    },
    error: function (data) {

    }

  })
}

