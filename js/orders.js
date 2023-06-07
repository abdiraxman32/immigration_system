fill_citizen();
btnAction = "Insert";
fillpassport_type();
fill_price();
fill_issuing_authority();
load_order_info();
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

        $("#passport_type_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

function fill_citizen() {

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

      if (status) {
        response.forEach(res => {
          html += `<option value="${res['citizen_id']}">${res['fullname']}</option>`;

        })

        $("#citizen_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

function fill_issuing_authority() {

    let sendingData = {
      "action": "read_all_issuing_authority"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "Api/orders.php",
      data: sendingData,
  
      success: function (data) {
        let status = data.status;
        let response = data.data;
        let html = '';
        let tr = '';
  
        if (status) {
          response.forEach(res => {
            html += `<option value="${res['issuing_authority_id']}">${res['name']}</option>`;
  
          })
  
          $("#issuing_authority_id").append(html);
  
  
        } else {
          displaymessage("error", response);
        }
  
      },
      error: function (data) {
  
      }
  
    })
  }



$("#orderForm").on("submit", function (event) {
  event.preventDefault();

  let citizen_id = $("#citizen_id").val();
  let passport_type_id = $("#passport_type_id").val();
  let amount = $("#amount").val();
  let issuing_authority_id = $("#issuing_authority_id").val();
  let order_id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "citizen_id": citizen_id,
      "passport_type_id": passport_type_id,
      "amount": amount,
      "issuing_authority_id": issuing_authority_id,
      "action": "register_orders"
    }

  } else {
    sendingData = {
      "order_id": order_id,
      "citizen_id": citizen_id,
      "passport_type_id": passport_type_id,
      "amount": amount,
      "issuing_authority_id": issuing_authority_id,
      "action": "update_order"
    }
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/orders.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#orderForm")[0].reset();
        load_order_info();





      } else {
        swal("NOW", response, "error");
      }

    },
    error: function (data) {
      swal("Good job!", response, "error");

    }

  })

})

$("#passport_type_id").on("change", function () {
  let passport_type_id = $(this).val();
  console.log("passport_type_id", passport_type_id);
  fill_price(passport_type_id);

})

$("#passport_type_id").on("change", function(){
  if($("#passport_type_id").val()== 0){
    console.log("0 waaye");
    $("#amount").val("");

  }else{
    console.log(amount);
  }
})



function fill_price(passport_type_id) {
  let sendingData = {
    "action": "read_passport_price",
    "passport_type_id": passport_type_id

  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/orders.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      console.log("name", response)
      let html = '';
      let tr = '';

      if (status) {

        response.forEach(res => {
          $("#amount").val(res['price']);

        })



      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


function load_order_info() {
  $("#orderTable tbody").html('');
  $("#orderTable thead").html('');

  let sendingData = {
    "action": "read_all_orders"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/orders.php",
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
            if(r=="passport_price"){
              tr += `<td>$${res[r]}</td>`;

            }

           else if(r == "status"){
                if(res[r] == "completed"){
                    tr += `<td><span class="btn btn-primary btn-sm">${res[r]}</span></td>`;
                }else if(res[r] == "paid"){
                  tr += `<td><span class="btn btn-success btn-sm">${res[r]}</span></td>`;
                }else{
                  tr += `<td><span class="btn btn-danger btn-sm">${res[r]}</span></td>`;

                }
            }else{
                tr += `<td>${res[r]}</td>`;
            }


      }
      tr += `<td> <a class="btn btn-info update_info"  update_id=${res['order_id']}><i class="bi bi-pencil-square" style="color: #fff"></i></a>&nbsp;&nbsp 
      </td>`

       
        tr += "</tr>"

        })
        $("#orderTable thead").append(th);
        $("#orderTable tbody").append(tr);
      }
     


    },
    error: function (data) {

    }

  })
}


function get_orders_info(order_id) {

  let sendingData = {
    "order_id": order_id,
    "action": "get_orders_info"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/orders.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;


      if (status) {

        btnAction = "update";

        $("#update_id").val(response['order_id']);
        $("#citizen_id").val(response['citizen_id']);
        $("#passport_type_id").val(response['passport_type_id']);
        $("#amount").val(response['amount']);
        $("#issuing_authority_id").val(response['issuing_authority_id']);
        $("#ordermodal").modal('show');
        load_order_info();




      } else {
        dispplaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}



$("#orderTable").on('click', "a.update_info", function () {
  let order_id = $(this).attr("update_id");
  get_orders_info(order_id);
})



