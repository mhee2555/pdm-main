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
        $('#txt_item_code').val("");
        $('#txt_item_name').val("");
        $('#ID_txt').val("");

        $(".chk_Cus").prop("checked", false);
    });


  

  
  function saveData() {
    var txt_item_code= $('#txt_item_code').val();
    var txt_item_name= $('#txt_item_name').val();
    


    var text = "";
    if (txt_item_code == "") {
      text = "กรุณากรอกรหัสสินค้า";
      showDialogFailed(text);
      return;
    }

    if (txt_item_name == "") {
      text = "กรุณากรอกชื่อสินค้า";
      showDialogFailed(text);
      return;
    }

    $.ajax({
      url: "process/manage_item.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'saveData',
        'txt_item_code': txt_item_code,
        'txt_item_name': txt_item_name
      },
      success: function(result) {
        if(result=="0"){
          showDialogFailed("รหัสลูกค้าซ้ำ ไม่สามารถเพิ่มข้อมูลได้ !!!");
        }else{
          showDialogSuccess(result);
        }
        
        show_data();
        $('#txt_item_code').val("");
        $('#txt_item_name').val("");
        $('#ID_txt').val("");
      
   
      }
    });
  }

  function editData() {
    var ID_txt = $('#ID_txt').val();
    var txt_item_code= $('#txt_item_code').val();
    var txt_item_name= $('#txt_item_name').val();
    


    var text = "";
    if (txt_item_code == "") {
      text = "กรุณากรอกรหัสลูกค้า";
      showDialogFailed(text);
      return;
    }

    if (txt_item_name == "") {
      text = "กรุณากรอกชื่อลูกค้า";
      showDialogFailed(text);
      return;
    }

    $.ajax({
      url: "process/manage_item.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'editData',
        'txt_item_code': txt_item_code,
        'txt_item_name': txt_item_name,
        'ID_txt':ID_txt
      },
      success: function(result) {
        showDialogSuccess(result);
        show_data();
        $('#txt_item_code').val("");
        $('#txt_item_name').val("");
        $('#ID_txt').val("");

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
      url: "process/manage_item.php",
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
                    "<td style='width:23%;text-align: center;'>" + value.ProductName + "</td>" +
                    "<td style='width:23%;text-align: center;'>" + value.ProductCode + "</td>" +
                    "</tr>";
                });
              }
              $('#Data_Table tbody').html(StrTR);
        
      }
    });

  }

  function show_Detail(ID){
    
    $('#ID_txt').val(ID);

    $.ajax({
      url: "process/manage_item.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'show_Detail',
        'ID': ID
      },
      success: function(result) {
        var ObjData = JSON.parse(result);
              
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(key, value) {

                  $('#txt_item_code').val(value.ProductCode);
                  $('#txt_item_name').val(value.ProductName);

                 
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
      url: "process/manage_item.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'deleteData',
        'ID_txt': ID_txt
      },
      success: function(result) {
        // feedData();

          $('#txt_item_code').val("");
          $('#txt_item_name').val("");
          $('#ID_txt').val("");
      
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