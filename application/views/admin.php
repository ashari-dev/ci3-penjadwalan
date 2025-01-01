
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Admin";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Admin';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_admin" ><i class="fa fa-plus"></i> Create Admin</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  
                  <th></th>
                  
                </tr>
                </thead>
                <tbody id="semua_guru">
				 <?php  
				 $i=1;
				  $semua_admin = $this->M_Admin->semua_admin();
				  $banyak_admin = $this->M_Admin->banyak_admin();
				  foreach($semua_admin as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->nama.'</td>
					  <td> '.$b->email.'</td>
					  <td><button type="button" id="'.$b->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_admin" ><i class="fa fa-edit"></i> Update</button>'; 
					  if($banyak_admin > 1){
					  
					  echo'<button type="button" id="'.$b->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_admin" ><i class="fa fa-ban"></i> Delete</button>';
					  }
					  echo'</td>
					  
					</tr>';
				  $i++;
				 }
			  
			  ?>
                
                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
  
	<div class="modal fade" id="tambah_admin">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Admin</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_admin">
                <!-- text input -->
                <div class="form-group">
                  <label>Nama </label>
                  <input type="text" name="nama" class="form-control" placeholder="Nama">
                </div>
				<div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email"  class="form-control" placeholder="Email">
                </div>
				<div class="form-group">
                  <label>Password</label>
                  <input type="password" name="alamat" class="form-control" placeholder="Password">
                </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
			 </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
	
	<div class="modal fade" id="edit_admin">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_admin">
          <div class="modal-dialog">
            <div class="modal-content" id="form_hapus">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
  
  <script type='text/javascript'>
	$(document).ready(function() {
	
		$('.edit').on("click", function(){
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/admin/detail_admin'); ?>',
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
				  
						html ='<form class="userregisterModal" id="simpan_edit">'+
						'<div class="modal-header">'+
								  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								  '</button>'+
								'<h4 class="modal-title">Update Admin</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama</label>'+
								  '<input type="text" name="nama" value="'+data[i].nama+'"class="form-control" placeholder="Nama">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Email</label>'+
								  '<input type="text" name="email"  value="'+data[i].email+'" class="form-control" placeholder="Email">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Alamat</label>'+
								  '<input type="password" name="password"  class="form-control" placeholder="Password">'+
								'</div>'+
							'</div>'+
							  '</div>'+
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>'+
								'<button type="submit" class="btn btn-primary" >Save</button>'+
							  '</div>'+
							 '</form>';
					}
					$('#form_edit').html(html);
				},
				error: function(){
					alert('Could not get Data from Database');
				}
			});
			
			$('#simpan_edit').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
					$.ajax({
							 url:'<?php echo base_url();?>index.php/admin/cek_admin/'+id,
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Email Sudah ada.");
							  $('#simpan_edit')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/admin/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Admin.");
									  $('#edit_admin').modal('hide');
										$('#simpan_edit')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Admin');
									  }
									  $('#edit_admin').modal('hide');
									  $('#simpan_edit')[0].reset();
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
							  }
							  
						   },
						   error: function(){
							alert('Could not get Data from Database');
							
						   }
						 });
						 
		
		});
			});

		$('#simpan_admin').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/admin/cek_admin_awal',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Admin Sudah ada.");
							  document.location.reload(true);
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/admin/simpan_admin',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Admin.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Admin');
									  }
									  $('#tambah_admin').modal('hide');
									  $('#simpan_admin')[0].reset();
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
							  }
							  $('#tambah_admin').modal('hide');
							  $('#simpan_admin')[0].reset();
							  
						   },
						   error: function(){
							alert('Could not get Data from Database');
							
						   }
						 });
					
						 
		
		});
		$('.hapus').on("click", function(){
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/admin/detail_admin'); ?>',
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
				  
						html ='<form class="userregisterModal" id="delete">'+
						'<div class="modal-header">'+
								  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								  '</button>'+
								'<h4 class="modal-title">Delete Admin '+data[i].nama+' ?</h4>'+
							  '</div>'+
							  
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>'+
								'<button type="submit" class="btn btn-danger" >Delete</button>'+
							  '</div>'+
							 '</form>';
					}
					$('#form_hapus').html(html);
				},
				error: function(){
					alert('Could not get Data from Database');
				}
			});
				$('#delete').submit(function(){
					
							$.ajax({
									 url:'<?php echo base_url();?>index.php/admin/hapus_admin/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Admin.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Admin');
									  }
									  $('#hapus_admin').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				});
			
			});
			
	
	});
</script>