            <!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">ระบบ</a></li>
                      <li class="breadcrumb-item active">จัดการข้อมูลสินค้า</li>
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->



            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control" id="txtSearch" onkeyup="show_data();" placeholder="ค้นหารายการ">
              </div>
              <div class="col-3">
                <!-- <button type="submit" class="btn btn-primary" >ค้นหา</button> -->
                <!-- <button type="submit" class="btn btn-success" id="showModalAddUsers">เพิ่มข้อมูล</button> -->
              </div>
            </div>


            <div class="row mt-2" id="tb_Data" style="height: 420px;" >
              <div class="col-12">
                <table id="Data_Table" class="table table-bordered table-hover w-100">
                  <thead>
                    <tr class="text-center">
                      <th style="width: 5%;"></th>
                      <th style="width: 5%;">ลำดับ</th>
                      <th>รายการสินค้า</th>
                      <th>รหัสสินค้า</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
<hr>
            <div class="row ">
              <div class="col-3">
              </div>
              <div class="col-3">
              </div>
              <div class="col-5" style="margin-left: 8%;">
              <button style="width: 22%;" type="button" class="btn btn-outline-success" id="btnSaveDoc" onclick="saveData();">บันทึก</button>
              <button style="width: 22%;margin-left: 3%;" type="button" class="btn btn-outline-warning" id="btnEditDoc">แก้ไข</button>
              <button style="width: 22%;margin-left: 3%;" type="button" class="btn btn-outline-danger" id="btnDeleteDoc" >ลบ</button>
              <button style="width: 22%;margin-left: 3%;" type="button" class="btn btn-outline-secondary" id="btncleanDoc" onclick="clean();">ยกเลิก</button>
              </div>
            </div>

            <div class="row ml-4 mt-1">
              <div class="col-3 mt-3">
              <label>รหัสสินค้า :</label>
              <input type="text" class="form-control" id="ID_txt" hidden>
                <input type="text" class="form-control" id="txt_item_code" placeholder="รหัสลูกค้า">
              </div>
              <div class="col-3 mt-3">
              <label>ชื่อสินค้า :</label>
                <input type="text" class="form-control" id="txt_item_name" placeholder="ชื่อลูกค้า">
              </div>
            </div>
           

         

           
