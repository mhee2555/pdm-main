<script>
  userID = "";
  // var DefaultTable = {
  //   language: {
  //     emptyTable: "Data not found"
  //   },
  //   info: false,
  //   scrollX: false,
  //   scrollCollapse: true,
  //   visible: false,
  //   searching: false,
  //   lengthChange: false,
  //   "order": [
  //     [0, "desc"]
  //   ]
  // };

  $(function() {

    $('#btnEditDoc').hide();
    $('#btnDeleteDoc').hide();
    $('#btncleanDoc').hide();

    
    $('#ID_txt').val("");
    $("#StatusRadio1").prop("checked", true);
    show_data();
  })




  $("#btnEditDoc").click(function() {

      $.confirm({
        title: 'Are sure!',
        content: 'ต้องการจะแก้ไขข้อมูล ใช่ หรือ ไม่?',
        type: 'green',
        autoClose: 'cancel|8000',
        buttons: {
          cancel: function() {},
          confirm: {
            btnClass: 'btn-primary',
            action: function() {
              editData();
            }
          }
        }
      });
  });


  $("#btncleanDoc").click(function() {
        $('#btnSaveDoc').show();
        $('#btnEditDoc').hide();
        $('#btnDeleteDoc').hide();
        $('#btncleanDoc').hide();
        $('#txtcustomers_ID').val("");
        $('#txtcustomers_name').val("");
        $('#ID_txt').val("");

        $(".chk_Cus").prop("checked", false);
        $("#StatusRadio1").prop("checked", true);
  });


  

  
  function saveData() {
    var txtcustomers_ID= $('#txtcustomers_ID').val();
    var txtcustomers_name= $('#txtcustomers_name').val();
    
    if(document.getElementById("StatusRadio1").checked == true && document.getElementById("StatusRadio2").checked == false ){
      var StatusRadio = 1
    }else{
      var StatusRadio = 2
    }

    var text = "";
    if (txtcustomers_ID == "") {
      text = "กรุณากรอกรหัสลูกค้า";
      showDialogFailed(text);
      return;
    }

    if (txtcustomers_name == "") {
      text = "กรุณากรอกชื่อลูกค้า";
      showDialogFailed(text);
      return;
    }

    $.ajax({
      url: "process/manage_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'saveData',
        'txtcustomers_ID': txtcustomers_ID,
        'txtcustomers_name': txtcustomers_name,
        'StatusRadio': StatusRadio
      },
      success: function(result) {
        if(result=="0"){
          showDialogFailed("รหัสลูกค้าซ้ำ ไม่สามารถเพิ่มข้อมูลได้ !!!");
        }else{
          showDialogSuccess(result);
        }
        
        show_data();
        $('#txtcustomers_ID').val("");
        $('#txtcustomers_name').val("");
        $('#ID_txt').val("");
        $("#StatusRadio1").prop("checked", true);
   
      }
    });
  }

  function editData() {
    var ID_txt = $('#ID_txt').val();
    var txtcustomers_ID= $('#txtcustomers_ID').val();
    var txtcustomers_name= $('#txtcustomers_name').val();
    
    if(document.getElementById("StatusRadio1").checked == true && document.getElementById("StatusRadio2").checked == false ){
      var StatusRadio = 1
    }else{
      var StatusRadio = 2
    }

    var text = "";
    if (txtcustomers_ID == "") {
      text = "กรุณากรอกรหัสลูกค้า";
      showDialogFailed(text);
      return;
    }

    if (txtcustomers_name == "") {
      text = "กรุณากรอกชื่อลูกค้า";
      showDialogFailed(text);
      return;
    }

    $.ajax({
      url: "process/manage_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'editData',
        'txtcustomers_ID': txtcustomers_ID,
        'txtcustomers_name': txtcustomers_name,
        'StatusRadio': StatusRadio,
        'ID_txt':ID_txt
      },
      success: function(result) {
        showDialogSuccess(result);
        show_data();
        $('#txtcustomers_ID').val("");
        $('#txtcustomers_name').val("");
        $('#ID_txt').val("");
        $("#StatusRadio1").prop("checked", true);

        $('#btnEditDoc').hide();
        $('#btnSaveDoc').show();
        $('#btnDeleteDoc').hide();
        $('#btncleanDoc').hide();
        
      }
    });
  }


  function show_data(){
    var  txtSearch =  $("#txtSearch").val();

    $.ajax({
      url: "process/manage_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'show_data',
        'Search_txt': txtSearch
      },
      success: function(result) {
        var ObjData = JSON.parse(result);
              var StrTR = "" ;
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(key, value) {

                  if(value.Status==1){
                    var Status_txt = "ลูกค้าใหม่";
                  }else{
                    var Status_txt = "เปิดบิล";
                  }
                  var chkDoc = "<input class='form-control chk_Cus' type='radio' value='1' name='id_Cus' id='id_Cus" + key + "' value='" + value.ID + "' onclick='show_Detail(\"" + value.ID + "\",\"" + key + "\")' style='width: 25%;height:20px;'>";
                  StrTR += "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;'>" +
                    "<td style='width:10%;text-align: center;'><center>"+chkDoc+"</center></td>" +
                    "<td style='width:10%;text-align: center;'>" + (key + 1) + "</td>" +
                    "<td style='width:34%;text-align: left;'>" + value.CustomerName + "</td>" +
                    "<td style='width:23%;text-align: center;'>" + value.CustomerCode + "</td>" +
                    "<td style='width:23%;text-align: center;'>" + Status_txt + "</td>" +
                    "</tr>";
                });
              }
              $('#customers_Table tbody').html(StrTR);
        
      }
    });

  }

  function show_Detail(ID){
    
    $('#ID_txt').val(ID);

    $.ajax({
      url: "process/manage_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'show_Detail',
        'ID': ID
      },
      success: function(result) {
        var ObjData = JSON.parse(result);
              
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(key, value) {

                  $('#txtcustomers_ID').val(value.CustomerCode);
                  $('#txtcustomers_name').val(value.CustomerName);

                  if(value.Status==1){
                    $("#StatusRadio1").prop("checked", true);
                    $("#StatusRadio2").prop("checked", false);
                  }else{
                    $("#StatusRadio1").prop("checked", false);
                    $("#StatusRadio2").prop("checked", true);
                  }

                  $('#btnEditDoc').show();
                  $('#btnSaveDoc').hide();
                  $('#btnDeleteDoc').show();
                  $('#btncleanDoc').show();
                });
              }
      }
    });

  }


  function deleteData() {
    var  ID_txt = $('#ID_txt').val();
    $.ajax({
      url: "process/manage_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'deleteData',
        'ID_txt': ID_txt
      },
      success: function(result) {
        // feedData();

          $('#txtcustomers_ID').val("");
          $('#txtcustomers_name').val("");
          $('#ID_txt').val("");
          $("#StatusRadio1").prop("checked", true);
          $(".chk_Cus").prop("checked", false);

        $('#btnSaveDoc').show();
        $('#btnEditDoc').hide();
        $('#btnDeleteDoc').hide();
        $('#btncleanDoc').hide();

        show_data();

        showDialogSuccess(result);
      }
    });
  }

  $("#btnDeleteDoc").click(function() {

    $.confirm({
      title: 'Are sure!',
      content: 'ต้องการจะลบข้อมูล ใช่ หรือ ไม่?',
      type: 'green',
      autoClose: 'cancel|8000',
      buttons: {
        cancel: function() {},
        confirm: {
          btnClass: 'btn-primary',
          action: function() {
            deleteData();
          }
        }
      }
    });
  });


  $("#showModalAddUsers").click(function() {
    clearData();
    setErrorInput();
    $("#titleDialog").text("เพิ่มข้อมูล ผู้ใช้งาน");
    $("#modalUsers").modal('show');
    // 
  })

  $('#formAddUsers').validate({
    errorPlacement: function(error, element) {
      $(element).closest("form").find("p[for='" + element.attr("id") + "']").append(error);
    },
    submitHandler: function() {
      saveData();
    }
  });

  function showDialogConfirm(id) {
    $.confirm({
      title: 'Are sure!',
      content: 'Do you want to delete?',
      type: 'red',
      autoClose: 'cancel|8000',
      buttons: {
        cancel: function() {},
        confirm: {
          btnClass: 'btn-red',
          action: function() {
            deleteData(id);
          }
        }
      }
    });
  }

  function showDialogSuccess(text) {
    $.confirm({
      title: 'Success!',
      content: text,
      type: 'green',
      autoClose: 'close|8000',
      typeAnimated: true,
      buttons: {
        close: function() {}
      }
    });
  }

  
  function showDialogFailed(text) {
    $.confirm({
      title: 'Failed!',
      content: text,
      type: 'red',
      autoClose: 'close|8000',
      typeAnimated: true,
      buttons: {
        close: function() {}
      }
    });
  }

  
  // $('#txtSearch').keydown(function(e) {
  //       if (e.keyCode == 13) {
  //         show_data();
  //       }
  //  })
 
</script>