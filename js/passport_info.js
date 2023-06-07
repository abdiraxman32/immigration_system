fillpassport_type();
fill_price2();
load_passport_info();
function fillpassport_type() {

  let sendingData = {
    "action": "read_passport_type"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/passport_info.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
          html += `<option value="${res['passport_type_id']}">${res['passport_type']}</option>`;

        })

        $("#pasport_type_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

btnAction = "Insert";


$("#passport_info_form").on("submit", function (event) {

  event.preventDefault();

  let passport_name = $("#passport_name").val();
  let pasport_type_id = $("#pasport_type_id").val();
  let price = $("#price").val();
  let passport_id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "passport_name": passport_name,
      "pasport_type_id": pasport_type_id,
      "price": price,
      "action": "register_passport_info"
    }

  } else {
    sendingData = {
      "passport_id": passport_id,
      "passport_name": passport_name,
      "pasport_type_id": pasport_type_id,
      "price": price,
      "action": "update_passport_info"
    }
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/passport_info.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#passport_info_form")[0].reset();
        load_passport_info();





      } else {
        swal("NOW", response, "error");
      }

    },
    error: function (data) {
      swal("Good job!", response, "error");

    }

  })

})

$("#pasport_type_id").on("change", function () {
  let pasport_type_id = $(this).val();
  console.log("pasport_type_id", pasport_type_id);
  fill_price2(pasport_type_id);

})

$("#pasport_type_id").on("change", function(){
  if($("#pasport_type_id").val()== 0){
    console.log("0 waaye");
    $("#price").val("");

  }else{
    console.log(price);
  }
})



function fill_price2(passport_type_id) {
  let sendingData = {
    "action": "read_passport_price",
    "passport_type_id": passport_type_id

  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/passport_info.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      console.log("name", response)
      let html = '';
      let tr = '';

      if (status) {

        response.forEach(res => {
          $("#price").val(res['price']);

        })



      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


function load_passport_info() {
  $("#passport_info_Table tbody").html('');
  $("#passport_info_Table thead").html('');

  let sendingData = {
    "action": "read_passport_info"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/passport_info.php",
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

           
           
            
              tr += `<td>${res[r]}</td>`;
            

      }
      tr += `<td> <a class="btn btn-info update_info"  update_id=${res['passport_id']}><i class="bi bi-pencil-square" style="color: #fff"></i></a>&nbsp;&nbsp 
      </td>`

       
        tr += "</tr>"

        })
        $("#passport_info_Table thead").append(th);
        $("#passport_info_Table tbody").append(tr);
      }
     


    },
    error: function (data) {

    }

  })
}


function get_passport_info(passport_id) {

  let sendingData = {
    "passport_id": passport_id,
    "action": "get_passport_info"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/passport_info.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        btnAction = "update";

        $("#update_id").val(response['passport_id']);
        $("#passport_name").val(response['passport_name']);
        $("#pasport_type_id").val(response['passport_type_id']);
        $("#price").val(response['price']);
        $("#passport_info_modal").modal('show');
        load_passport_info();




      } else {
        dispplaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}



$("#passport_info_Table").on('click', "a.update_info", function () {
  let passport_id = $(this).attr("update_id");
  get_passport_info(passport_id);
})



