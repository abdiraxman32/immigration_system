let tempTotalincome = 0;
let tempTotalexpense = 0;
get_total_income();
get_all_employee();
get_total_expense();
loadcitizen_completed();
get_all_users();


function get_total_expense() {

  let sendingData = {
      "action": "get_total_expense"

  }

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "Api/income.php",
      data: sendingData,
      async: false,
      success: function (data) {
          let status = data.status;
          let response = data.data;


          if (status) {


              document.querySelector("#total_expense").innerText = response['total'];

              tempTotalexpense = response['total'];

          } else {

          }

      },
      error: function (data) {

      }

  })
}

function get_total_income() {

  let sendingData = {
      "action": "get_total_income"

  }

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "Api/income.php",
      data: sendingData,
      async: false,
      success: function (data) {
          let status = data.status;
          let response = data.data;


          if (status) {


              document.querySelector("#totalincome").innerText = response['total'];

              tempTotalincome = response['total'];

          } else {

          }

      },
      error: function (data) {

      }

  })
}

function get_all_employee() {

    let sendingData = {
        "action": "get_all_employee"

    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/income.php",
        data: sendingData,
        async: false,
        success: function (data) {
            let status = data.status;
            let response = data.data;


            if (status) {


                document.querySelector("#employeee").innerText = response['employee'];


            } else {

            }

        },
        error: function (data) {

        }

    })
}

function get_all_users() {

    let sendingData = {
        "action": "get_all_users"

    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/income.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;


            if (status) {


                document.querySelector("#users").innerText = response['users']


            } else {

            }

        },
        error: function (data) {

        }

    })
}



function loadcitizen_completed() {
    $("#citizen_completed tbody").html('');
    $("#citizen_completed thead").html('');
  
    let sendingData = {
      "action": "read__citizen_completed"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "Api/income.php",
      data: sendingData,
  
      success: function (data) {
        let status = data.status;
        let response = data.data;
        let html = '';
        let tr = '';
        let th = '';
  
        if (status) {
          response.forEach(res=>{
            tr += "<tr>";
            th = "<tr>";
            for(let r in res){
              th += `<th>${r}</th>`;
  

              if(r=="amount"){
                tr += `<td>$${res[r]}</td>`;
  
              }
  
           else if(r == "status"){
            if(res[r] == "completed"){
              tr += `<td><span class="btn btn-primary btn-sm">${res[r]}</span></td>`;
           
            }
            
           }else{
            tr += `<td>${res[r]}</td>`;
           }
  
            }
     
          
        })
          $("#citizen_completed thead").append(th);
          $("#citizen_completed tbody").append(tr);
        }
  
      },
      error: function (data) {
  
      }
  
    })
  }
  