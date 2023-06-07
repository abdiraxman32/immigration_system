fill_citizen_order();
load_released_passport();
btnAction = "Insert";
fillpassport_type();
fill_passport();
function fill_citizen_order() {

  let sendingData = {
    "action": "read_all_orders_name"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/released.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
          html += `<option value="${res['citizen_id']}">${res['fullname']}</option>`;

        })

        $("#Citizen_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


$("#releasedform").on("submit", function (event) {
  event.preventDefault();

  let Citizen_id = $("#Citizen_id").val();
  let passport_type_id = $("#passport_type_id").val();
  let issuing_date = $("#issuing_date").val();
  let expire_date = $("#expire_date").val();
  let release_id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "Citizen_id": Citizen_id,
      "passport_type_id": passport_type_id,
      "issuing_date": issuing_date,
      "expire_date": expire_date,
      "action": "register_released_passport"
    }

  
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/released.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#releasedform")[0].reset();
        load_released_passport();





      } else {
        swal("NOW", response, "error");
      }

    },
    error: function (data) {
      swal("Good job!", response, "error");

    }

  })

})

$("#Citizen_id").on("change", function () {
  let Citizen_id = $(this).val();
  console.log("Citizen_id", Citizen_id);
  fill_passport(Citizen_id);

})

$("#Citizen_id").on("change", function(){
  if($("#Citizen_id").val()== 0){
    console.log("0 waaye");
    $("#passport_type_id").val("");

  }else{
    console.log(amount);
  }
})


function fill_passport(citizen_id) {
  let sendingData = {
    "action": "read_passport",
    "citizen_id": citizen_id

  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/released.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      console.log("name", response)
      let html = '';
      let tr = '';

      if (status) {

        response.forEach(res => {
          $("#passport_type_id").val(res['passport_type']);

        })



      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


function load_released_passport() {
  $("#releasedTable tbody").html('');
  $("#releasedTable thead").html('');

  let sendingData = {
    "action": "read_all_released"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/released.php",
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
          for(let r in res){

           
              tr += `<td>${res[r]}</td>`;





      }
     
       
        tr += "</tr>"

        })
        $("#releasedTable thead").append(th);
        $("#releasedTable tbody").append(tr);
      }
     


    },
    error: function (data) {

    }

  })
}




