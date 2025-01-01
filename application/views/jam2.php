
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Jam";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Jam';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_jam" ><i class="fa fa-plus"></i> Create Jam</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Range Jam</th>
                  <th>SKS</th>
                  <th>Sesi</th>
                  <th></th>
                  
                </tr>
                </thead>
                <tbody id="semua_jam">
				 <?php  
				 $i=1;
				  $semua_jam = $this->M_Jam2->semua_jam();
				  foreach($semua_jam as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->range_jam.'</td>
					  <td>'.$b->sks.'</td>
					  <td>'.$b->sesi.'</td>
					  <td><button type="button" id="'.$b->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_jam" ><i class="fa fa-edit"></i> Update</button> <button type="button" id="'.$b->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_jam" ><i class="fa fa-ban"></i> Delete</button></td>
					  
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
  
  
	<div class="modal fade" id="tambah_jam">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Jam</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_jam">
                <!-- text input -->
                <div class="form-group">
                  <label>Range Jam</label>
                  <input type="text" name="range_jam" class="form-control" placeholder="Range Jam">
                </div>
				<div class="form-group">
                  <label>SKS</label>
                  <input type="text" name="sks" class="form-control" placeholder="SKS">
                </div>
				<div class="form-group">
                  <label>Sesi</label>
                  <input type="text" name="sesi" class="form-control" placeholder="Sesi">
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
		
	
	<div class="modal fade" id="edit_jam">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_jam">
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
				url: '<?php echo base_url('index.php/jam2/detail_jam'); ?>',
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
								'<h4 class="modal-title">Update Jam</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Range Jam</label>'+
								  '<input type="text" name="range_jam" value="'+data[i].range_jam+'"class="form-control" placeholder="Range Jam">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>SKS</label>'+
								  '<input type="text" name="sks" value="'+data[i].sks+'"class="form-control" placeholder="SKS">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Sesi</label>'+
								  '<input type="text" name="sesi" value="'+data[i].sesi+'"class="form-control" placeholder="Sesi">'+
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
							 url:'<?php echo base_url();?>index.php/jam2/cek_jam',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Jam Sudah ada.");
							  $('#simpan_edit')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/jam2/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Jam.");
									  $('#edit_jam').modal('hide');
										$('#simpan_edit')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Jam');
									  }
									  $('#edit_jam').modal('hide');
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

		$('#simpan_jam').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/jam2/cek_jam',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Jam Sudah ada.");
							  $('#simpan_jam')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/jam2/simpan_jam',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Jam.");
									  $('#tambah_jam').modal('hide');
									  $('#simpan_jam')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Jam');
									  }
									  $('#tambah_jam').modal('hide');
									  $('#simpan_jam')[0].reset();
									  
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
				url: '<?php echo base_url('index.php/jam2/detail_jam'); ?>',
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
								'<h4 class="modal-title">Delete Jam '+data[i].range_jam+' ?</h4>'+
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
									 url:'<?php echo base_url();?>index.php/jam2/hapus_jam/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Jam.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Jam');
									  }
									  $('#hapus_jam').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>