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
    Get_customers();




          $('.numonly').on('input', function() {
            this.value = this.value.replace(/[^0-9-]/g, ''); //<-- replace all other than given set of values
          });

          $('.enonly').on('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9-/.@_ ]/g, ''); //<-- replace all other than given set of values
          });

          $('.thonly').on('input', function() {
            this.value = this.value.replace(/[^ก-ฮๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ0-9-/. ]/g, ''); //<-- replace all other than given set of values
          });

  })

  function Get_customers(){
    $.ajax({
      url: "process/contact_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'Get_customers'
      },
      success: function(result) {
        var ObjData = JSON.parse(result);
              $("#select_cus").empty();
              var Str = "";
              Str += "<option value=0 >-------กรุณาเลือกลูกค้า------------</option>";
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(key, value) {
                  Str += "<option value=" + value.ID + " >" + value.CustomerName + "</option>";
            
                });
              }
              $("#select_cus").append(Str);
        
      }
    });
  }

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

          $('#select_cus').val(0);
          $('#txt_contact_name').val("");
          $('#txt_deb_name').val("");
          $('#txt_email').val("");
          $('#txt_phonenumber').val("");
          $(".chk_Cus").prop("checked", false);

        $('#btnSaveDoc').show();
        $('#btnEditDoc').hide();
        $('#btnDeleteDoc').hide();
        $('#btncleanDoc').hide();
    });


  

  
  function saveData() {
      var select_cus= $('#select_cus').val();
      var txt_contact_name= $('#txt_contact_name').val();
      var txt_deb_name= $('#txt_deb_name').val();
      var txt_email= $('#txt_email').val();
      var txt_phonenumber= $('#txt_phonenumber').val();
      
 
      var text = "";

      if (select_cus == "0") {
        text = "กรุณาเลือกลูกค้า";
        showDialogFailed(text);
        return;
      }

      if (txt_contact_name == "") {
        text = "กรุณากรอกข้อมูลผู้ติดต่อ";
        showDialogFailed(text);
        return;
      }

      if (txt_deb_name == "") {
        text = "กรุณากรอกข้อมูลแผนก";
        showDialogFailed(text);
        return;
      }

      if (txt_email == "") {
        text = "กรุณากรอก E-Mail";
        showDialogFailed(text);
        return;
      }

      if (txt_phonenumber == "") {
        text = "กรุณากรอกข้อมูลเบอร์โทร";
        showDialogFailed(text);
        return;
      }

      $.ajax({
        url: "process/contact_customers.php",
        type: 'POST',
        data: {
          'FUNC_NAME': 'saveData',
          'select_cus': select_cus,
          'txt_contact_name': txt_contact_name,
          'txt_deb_name': txt_deb_name,
          'txt_email': txt_email,
          'txt_phonenumber': txt_phonenumber,
        },
        success: function(result) {
          if(result=="0"){
            showDialogFailed("รหัสลูกค้าซ้ำ ไม่สามารถเพิ่มข้อมูลได้ !!!");
          }else{
            showDialogSuccess(result);
          }
          
          show_data();
          $('#select_cus').val(0);
          $('#txt_contact_name').val("");
          $('#txt_deb_name').val("");
          $('#txt_email').val("");
          $('#txt_phonenumber').val("");
        
    
        }
      });
  }

  function editData() {
    var ID_txt = $('#ID_txt').val();
    var select_cus= $('#select_cus').val();
    var txt_contact_name= $('#txt_contact_name').val();
    var txt_deb_name= $('#txt_deb_name').val();
    var txt_email= $('#txt_email').val();
    var txt_phonenumber= $('#txt_phonenumber').val();
    
  
    var text = "";
     if (select_cus == "0") {
        text = "กรุณาเลือกลูกค้า";
        showDialogFailed(text);
        return;
      }

      if (txt_contact_name == "") {
        text = "กรุณากรอกข้อมูลผู้ติดต่อ";
        showDialogFailed(text);
        return;
      }

      if (txt_deb_name == "") {
        text = "กรุณากรอกข้อมูลแผนก";
        showDialogFailed(text);
        return;
      }

      if (txt_email == "") {
        text = "กรุณากรอก E-Mail";
        showDialogFailed(text);
        return;
      }

      if (txt_phonenumber == "") {
        text = "กรุณากรอกข้อมูลเบอร์โทร";
        showDialogFailed(text);
        return;
      }

    $.ajax({
      url: "process/contact_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'editData',
        'select_cus': select_cus,
        'txt_contact_name': txt_contact_name,
        'txt_deb_name': txt_deb_name,
        'txt_email': txt_email,
        'txt_phonenumber': txt_phonenumber,
        'ID_txt':ID_txt
      },
      success: function(result) {
        showDialogSuccess(result);
        show_data();
        $('#select_cus').val(0);
        $('#txt_contact_name').val("");
        $('#txt_deb_name').val("");
        $('#txt_email').val("");
        $('#txt_phonenumber').val("");

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
      url: "process/contact_customers.php",
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


                  var chkDoc = "<input class='form-control chk_Cus' type='radio' value='1' name='id_Cus' id='id_Cus" + key + "' value='" + value.ID + "' onclick='show_Detail(\"" + value.ID + "\",\"" + key + "\")' style='width: 25%;height:20px;'>";
                  StrTR += "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;'>" +
                    "<td style='width:6%;text-align: center;'><center>"+chkDoc+"</center></td>" +
                    "<td style='width:7%;text-align: center;'>" + (key + 1) + "</td>" +
                    "<td style='width:25%;text-align: left;'>" + value.CustomerName + "</td>" +
                    "<td style='width:20%;text-align: center;'>" + value.ContactName + "</td>" +
                    "<td style='width:15%;text-align: center;'>" + value.Department + "</td>" +
                    "<td style='width:23%;text-align: center;'>" + value.email + "</td>" +
                    "<td style='width:20%;text-align: center;'>" + value.Tel + "</td>" +
                    "</tr>";
                });
              }
              $('#contact_Table tbody').html(StrTR);
        
      }
    });

  }

  function show_Detail(ID){
    
    $('#ID_txt').val(ID);

    $.ajax({
      url: "process/contact_customers.php",
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


                  $('#select_cus').val(value.CustomerID);
                  $('#txt_contact_name').val(value.ContactName);
                  $('#txt_deb_name').val(value.Department);
                  $('#txt_email').val(value.email);
                  $('#txt_phonenumber').val(value.Tel);


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
      url: "process/contact_customers.php",
      type: 'POST',
      data: {
        'FUNC_NAME': 'deleteData',
        'ID_txt': ID_txt
      },
      success: function(result) {
        // feedData();
          $('#select_cus').val(0);
          $('#txt_contact_name').val("");
          $('#txt_deb_name').val("");
          $('#txt_email').val("");
          $('#txt_phonenumber').val("");
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

 
</script>