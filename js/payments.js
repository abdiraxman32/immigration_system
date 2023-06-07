fill_citizen();
loadpayment();
btnAction = "Insert";
fillpassport_type();
fill_price3();
fillpayment_method();
fillaccount();

function fill_citizen() {

  let sendingData = {
    "action": "read_all_citizen_name"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/payments.php",
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

        $("#cittizen_id").append(html);


      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}

function fillaccount() {

    let sendingData = {
        "action": "read_all_account"
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/account.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if (status) {
                response.forEach(res => {
                    html += `<option value="${res['Account_id']}">${res['bank_name']}</option>`;

                })

                $("#Accounttt_id").append(html);


            } else {
                displaymessage("error", response);
            }

        },
        error: function (data) {

        }

    })
}

function fillpayment_method() {

    let sendingData = {
        "action": "read_all_p_method"
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/pe_method.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if (status) {
                response.forEach(res => {
                    html += `<option value="${res['p_method_id']}">${res['name']}</option>`;

                })

                $("#payment_method_id").append(html);


            } else {
                displaymessage("error", response);
            }

        },
        error: function (data) {

        }

    })
}

$("#paymentform").on("submit", function (event) {
  event.preventDefault();

  let cittizen_id = $("#cittizen_id").val();
  let amount = $("#amount").val();
  let Accounttt_id = $("#Accounttt_id").val();
  let payment_method_id = $("#payment_method_id").val();
  let order_id = $("#update_id").val();

  let sendingData = {}

  if (btnAction == "Insert") {
    sendingData = {
      "cittizen_id": cittizen_id,
      "amount": amount,
      "Accounttt_id": Accounttt_id,
      "payment_method_id": payment_method_id,
      "action": "register_payments"
    }

  
  }



  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/payments.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        swal("Good job!", response, "success");
        btnAction = "Insert";
        $("#paymentform")[0].reset();
        loadpayment();





      } else {
        swal("NOW", response, "error");
      }

    },
    error: function (data) {
      swal("Good job!", response, "error");

    }

  })

})

$("#cittizen_id").on("change", function () {
  let cittizen_id = $(this).val();
  console.log("cittizen_id", cittizen_id);
  fill_price3(cittizen_id);

})

$("#cittizen_id").on("change", function(){
  if($("#cittizen_id").val()== 0){
    console.log("0 waaye");
    $("#amount").val("");

  }else{
    console.log(amount);
  }
})


function fill_price3(citizen_id) {
  let sendingData = {
    "action": "read_payment_price",
    "citizen_id": citizen_id

  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/payments.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      console.log("name", response)
      let html = '';
      let tr = '';

      if (status) {

        response.forEach(res => {
          $("#amount").val(res['amount']);

        })



      } else {
        displaymessage("error", response);
      }

    },
    error: function (data) {

    }

  })
}


function loadpayment() {
  $("#paymentTable tbody").html('');
  $("#paymentTable thead").html('');

  let sendingData = {
    "action": "read_all_payments"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/payments.php",
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

            if(r=="amount"){
                tr += `<td>$${res[r]}</td>`;
  
              }else{
                tr += `<td>${res[r]}</td>`;

              }




      }
     
       
        tr += "</tr>"

        })
        $("#paymentTable thead").append(th);
        $("#paymentTable tbody").append(tr);
      }
     


    },
    error: function (data) {

    }

  })
}




