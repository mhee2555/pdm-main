 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-light-primary sidebar-no-expand elevation-4">
     <!-- Brand Logo -->
     <a href="javascript:void(0)" class="brand-link">
         <!-- <img src="assets/dist/img/Plogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
         <!-- <span class="brand-text font-weight-light">Poseintelligence</span> -->
         <!-- <img src="/assets/dist/img/posehealthcare_logo.png" alt=""> -->
         <img src="assets/dist/img/logo/logo200.png" alt="AdminLTE Logo" class="brand-image  " style="width:200px;">
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- super -->

                 <li class="nav-item has-treeview " id="li_general">
                     <a href="#" class="nav-link" id="a_general">
                         <i class="nav-icon fas fa-home"></i>
                         <p>
                             ระบบ
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <!-- <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=general" class="nav-link" id="general">
                                 <i class="fas fa-home"></i>
                                 <p>ทั่วไป</p>
                             </a>
                         </li>
                     </ul> -->
                     <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=manage_customers" class="nav-link " id="manage_customers">
                                 <i class="fas fa-home"></i>
                                 <p>จัดการข้อมูลลูกค้า</p>
                             </a>
                         </li>
                     </ul>
                     <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=contact_customers" class="nav-link " id="contact_customers">
                                 <i class="fas fa-home"></i>
                                 <p>จัดการข้อมูลติดต่อลูกค้า</p>
                             </a>
                         </li>
                     </ul>
                     <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=manage_item" class="nav-link " id="manage_item">
                                 <i class="fas fa-home"></i>
                                 <p>จัดการข้อมูลสินค้า</p>
                             </a>
                         </li>
                     </ul>
                     <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=register_doc" class="nav-link " id="register_doc">
                                 <i class="fas fa-home"></i>
                                 <p>ลงทะเบียนเอกสาร</p>
                             </a>
                         </li>
                     </ul>
                     
                     <!-- <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=receiveStock" class="nav-link " id="receiveStock">
                                 <i class="fas fa-home"></i>
                                 <p>รับของเข้าสต็อค</p>
                             </a>
                         </li>
                     </ul> -->
                     <!-- <ul class="nav nav-treeview ul_general" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=stock" class="nav-link " id="stock">
                                 <i class="fas fa-home"></i>
                                 <p>คลัง</p>
                             </a>
                         </li>
                     </ul> -->
                 </li>

                 <!-- <li class="nav-item has-treeview " id="li_report">
                     <a href="#" class="nav-link " id="a_report">
                         <i class="nav-icon fas fa-copy"></i>
                         <p>
                             รายงาน
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview ul_report" style="display: none;">
                         <li class="nav-item">
                             <a href="index.php?page=report" class="nav-link" id="report">
                                 <i class="fas fa-copy"></i>
                                 <p>รายงาน</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <?php// if ($permissionID == "1" || $permissionID == "2") { ?>
                     <li class="nav-item has-treeview " id="li_system">
                         <a href="#" class="nav-link " id="a_system">
                             <i class="nav-icon fas fa-cogs"></i>
                             <p>
                                 ระบบ
                                 <i class="right fas fa-angle-left"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=site" class="nav-link" id="site">
                                     <i class="fas fa-cogs"></i>
                                     <p>โรงพยาบาล</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=group" class="nav-link" id="group">
                                     <i class="fas fa-cogs"></i>
                                     <p>กลุ่ม</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=department" class="nav-link" id="department">
                                     <i class="fas fa-cogs"></i>
                                     <p>แผนก</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=item" class="nav-link" id="item">
                                     <i class="fas fa-cogs"></i>
                                     <p>รายการ</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=binditem" class="nav-link" id="binditem">
                                     <i class="fas fa-cogs"></i>
                                     <p>ผูกรายการ</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=units" class="nav-link" id="units">
                                     <i class="fas fa-cogs"></i>
                                     <p>หน่วยนับ</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=remark" class="nav-link" id="remark">
                                     <i class="fas fa-cogs"></i>
                                     <p>หมายเหตุ</p>
                                 </a>
                             </li>
                         </ul>
                         <ul class="nav nav-treeview ul_system" style="display: none;">
                             <li class="nav-item">
                                 <a href="index.php?page=users" class="nav-link" id="users">
                                     <i class="fas fa-cogs"></i>
                                     <p>ผู้ใช้งาน</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
         <?php //} ?>
 -->






                 <div class="divider"></div>
                 <li class="nav-item">
                     <a href="javascript:void(0)" class="nav-link" id="btnLogout">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>