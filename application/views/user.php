
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "User";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'User';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_user" ><i class="fa fa-plus"></i> Tambah User</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th></th>
                  
                </tr>
                </thead>
                <tbody id="semua_jam">
				 <?php  
				 $i=1;
				  $semua_user = $this->M_User->semua_user();
				  foreach($semua_user as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->nama.'</td>
					  <td>'.$b->email.'</td>
					  <td><button type="button" id="'.$b->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_user" ><i class="fa fa-edit"></i> Edit</button> <button type="button" id="'.$b->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_user" ><i class="fa fa-ban"></i> Hapus</button></td>
					  
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
  
  
	<div class="modal fade" id="tambah_user">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah User</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_user">
                <!-- text input -->
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="Nama">
                </div>
				<div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
			 </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
	
	<div class="modal fade" id="edit_user">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_user">
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
				url: '<?php echo base_url('index.php/user/detail_user'); ?>',
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
								'<h4 class="modal-title">Edit User</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama</label>'+
								  '<input type="text" name="nama" value="'+data[i].nama+'"class="form-control" placeholder="Nama">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Email</label>'+
								  '<input type="text" name="email" value="'+data[i].email+'"class="form-control" placeholder="Email">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Password Baru</label>'+
								  '<input type="text" name="password" class="form-control" placeholder="Password Baru">'+
								'</div>'+
								
							'</div>'+
							  '</div>'+
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>'+
								'<button type="submit" class="btn btn-primary" >Simpan</button>'+
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
							 url:'<?php echo base_url();?>index.php/user/cek_user',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Username Sudah ada.");
							  $('#simpan_edit')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/user/simpan_user/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit User.");
									  $('#edit_user').modal('hide');
										$('#simpan_edit')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit User');
									  }
									  $('#edit_user').modal('hide');
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

		$('#simpan_user').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/user/cek_user',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("User Sudah ada.");
							  $('#simpan_user')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/user/simpan_user',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan User");
									  $('#tambah_user').modal('hide');
									  $('#simpan_user')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan User');
									  }
									  $('#tambah_user').modal('hide');
									  $('#simpan_user')[0].reset();
									  
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
		$('.hapus').on("click", function(){
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/user/detail_user'); ?>',
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
								'<h4 class="modal-title">Hapus user '+data[i].email+' ?</h4>'+
							  '</div>'+
							  
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>'+
								'<button type="submit" class="btn btn-danger" >Hapus</button>'+
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
									 url:'<?php echo base_url();?>index.php/user/hapus_user/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus User.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus User');
									  }
									  $('#hapus_user').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>