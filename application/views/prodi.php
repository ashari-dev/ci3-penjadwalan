
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Program Studi";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Program Studi';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_prodi" ><i class="fa fa-plus"></i> Create Prodi</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Prodi</th>
                  <th>Nama Jurusan</th>
                  <th></th>
                  
                  
                </tr>
                </thead>
                <tbody id="semua_semester">
				 <?php  
				 $i=1;
				  $semua_prodi = $this->M_Prodi->semua_prodi();
				  foreach($semua_prodi as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->nama_prodi.'</td>
					  <td>'.$b->nama_jurusan.'</td>
					  <td>
					  <button type="button" id="'.$b->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_prodi" ><i class="fa fa-edit"></i> Update</button> 
					  <button type="button" id="'.$b->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_prodi" ><i class="fa fa-ban"></i> Delete</button>
					  </td>
					  
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
  
  
	<div class="modal fade" id="tambah_prodi">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Prodi</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_prodi">
                <!-- text input -->
                
				<div class="form-group">
                  <label>Nama Prodi</label>
                  <input type="text" name="nama"  class="form-control" placeholder="Nama Prodi">
                </div>
				<div class="form-group">
                  <label>Jurusan</label>
                  <select name="jurusan" class="form-control" role="menu">
				  <?php 
				  $jurusan=$this->M_Jurusan->semua_jurusan();
				  foreach($jurusan as $j) {      
						echo'
						<li><option value="'.$j->kode.'">'.$j->nama_jurusan.'</option></li>
						';
					}	
					?>	
				  </select>
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
		
	
	<div class="modal fade" id="edit_prodi">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_prodi">
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
				url: '<?php echo base_url('index.php/prodi/detail_prodi'); ?>',
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
								'<h4 class="modal-title">Update Prodi</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama Prodi</label>'+
								  '<input type="text" name="nama" value="'+data[i].nama_prodi+'"class="form-control" placeholder="Nama Prodi">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Jurusan</label>'+
								  '<select id="jurusan_edit" name="jurusan" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_jurusan+'">'+data[i].nama_jurusan+'</option>'+
								  '</select>'+
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
					$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/jurusan/semua_jurusan'); ?>',
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama_jurusan+'</option>';
								}
							  $('#jurusan_edit').append(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});	
				},
				error: function(){
					alert('Could not get Data from Database');
				}
			});
			
			$('#simpan_edit').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
			$.ajax({
							 url:'<?php echo base_url();?>index.php/prodi/cek_prodi/'+id,
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Prodi Sudah ada.");
							  $('#simpan_edit')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/prodi/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Prodi");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Prodi');
									  }
									  $('#edit_prodi').modal('hide');
									  $('#simpan_edit')[0].reset();
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
							  }
							  $('#tambah_prodi').modal('hide');
							  $('#simpan_prodi')[0].reset();
							  
						   },
						   error: function(){
							alert('Could not get Data from Database');
							
						   }
						 });
					
		});
			});

		$('#simpan_prodi').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/prodi/cek_prodi_awal',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Prodi Sudah ada.");
							  $('#simpan_prodi')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/prodi/simpan_prodi',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Prodi.");
									  $('#tambah_prodi').modal('hide');
										$('#simpan_prodi')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Prodi');
									  }
									  $('#tambah_prodi').modal('hide');
									  $('#simpan_prodi')[0].reset();
									  
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
				url: '<?php echo base_url('index.php/prodi/detail_prodi'); ?>',
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
								'<h4 class="modal-title">Delete Prodi '+data[i].nama_prodi+' ?</h4>'+
							  '</div>'+
							  
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Cancel</button>'+
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
									 url:'<?php echo base_url();?>index.php/prodi/hapus_prodi/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Prodi.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Prodi');
									  }
									  $('#hapus_prodi').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>