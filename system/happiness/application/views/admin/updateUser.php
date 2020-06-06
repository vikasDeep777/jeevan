<!DOCTYPE html>
<html lang="en">

<head>
<title>My Profile</title>
<!-- Bootstrap core CSS-->
<?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
<!-- Custom fonts for this template-->
<?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
<!-- Page level plugin CSS-->
<?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
<!-- Custom styles for this template-->
<?php echo link_tag('assests/css/sb-admin.css'); ?>

  </head>

  <body id="page-top">

   <?php include APPPATH.'views/admin/includes/header.php';?>

    <div id="wrapper">

      <!-- Sidebar -->
  <?php include APPPATH.'views/admin/includes/sidebar.php';?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('admin/Dashboard'); ?>">User</a>
            </li>
            <li class="breadcrumb-item active">My Profile</li>
          </ol>

          <!-- Page Content -->
          <h1>My Profile</h1>
          <hr>
<!---- Success Message ---->
<?php if ($this->session->flashdata('success')) { ?>
<p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
</div>
<?php } ?>

<!---- Error Message ---->
<?php if ($this->session->flashdata('error')) { ?>
<p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('error');?></p>
<?php } ?> 



 <?php echo form_open('admin/Manage_Users/updateProfile/');


 
 ?>

<p> <strong>Reg Date :</strong> 

 <input type ='hidden' name='id' value =<?php  


 echo $profile['id'];  ?> >


            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">

<?php echo form_input(['name'=>'first_name','id'=>'firstname','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('first_name',$profile['first_name'])]);?>
<?php echo form_label('Enter your first name', 'first_name'); ?>
<?php echo form_error('first_name',"<div style='color:red'>","</div>");?>

                  </div>
                </div>
              </div>
            </div>


             <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">

<?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('email',$profile['email'])]);?>
<?php echo form_label('Enter your  last name', 'lastname'); ?>
<?php echo form_error('email',"<div style='color:red'>","</div>");?>

                  </div>
                </div>
              </div>
            </div>
			
			 <!--div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">

<?php echo form_input(['name'=>'password','type'=>'password','id'=>'password','class'=>'form-control','autofocus'=>'autofocus','value'=>'']);?>
<?php echo form_label('Enter your  Password ', 'Password'); ?>
<?php echo form_error('email',"<div style='color:red'>","</div>");?>

                  </div>
                </div>
              </div>
            </div-->

            <div class="form-group">
               <div class="form-row">
                    <div class="col-md-6">
              <div class="form-label-group">

<?php echo form_input(['name'=>'mobile','id'=>'mobile','class'=>'form-control','autofocus'=>'autofocus','readonly'=>'true','value'=>set_value('mobile',$profile['mobile'])]);?>
<?php echo form_label('Enter valid Mobile', 'mobile'); ?>
<?php echo form_error('mobile',"<div style='color:red'>","</div>");?>

              </div>
            </div>
  </div>
</div>
    

       <div class="form-row">
            <div class="col-md-6">  
 <?php echo form_submit(['name'=>'Update','value'=>'update','class'=>'btn btn-primary btn-block']); ?>
</div>
</div>

 


 <?php echo form_close();?>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
     <?php include APPPATH.'views/admin/includes/footer.php';?>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
  <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assests/js/sb-admin.min.js '); ?>"></script>

  </body>

</html>
