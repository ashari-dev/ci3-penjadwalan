
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Ruang";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Ruang';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_ruang" ><i class="fa fa-plus"></i> Tambah Ruang</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Kapasitas</th>
                  <th>Lantai</th>
                  <th>Jenis</th>
                  <th>Jurusan</th>
                  <th></th>
                  
                </tr>
                </thead>
                <tbody id="semua_ruang">
				 <?php  
				 $i=1;
				  $semua_ruang = $this->M_Ruang->semua_ruang();
				  foreach($semua_ruang as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->nama.'</td>
					  <td>'.$b->kapasitas.'</td>
					  <td> '.$b->lantai.'</td>
					  <td> '.$b->jenis.'</td>
					  <td> '.$b->nama_jurusan.'</td>
					  <td><button type="button" id="'.$b->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_ruang" ><i class="fa fa-edit"></i> Edit</button> <button type="button" id="'.$b->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_ruang" ><i class="fa fa-ban"></i> Hapus</button></td>
					  
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
  
  
	<div class="modal fade" id="tambah_ruang">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Ruang</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_ruang">
                <!-- text input -->
                <div class="form-group">
                  <label>Nama Ruang</label>
                  <input type="text" name="nama" class="form-control" placeholder="Nama">
                </div>
				<div class="form-group">
                  <label>Kapasitas</label>
                  <input type="text" name="kapasitas"  class="form-control" placeholder="Kapasitas">
                </div>
				<div class="form-group">
                  <label>Lantai</label>
                  <input type="text" name="lantai"  class="form-control" placeholder="Isikan Angka">
                </div>
				<div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control" role="menu">
						<li><option value="TEORI">Teori</option></li>
						<li><option value="LABORATORIUM">LABORATORIUM</option></li>
				  </select>
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
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
			 </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
	
	<div class="modal fade" id="edit_ruang">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_ruang">
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
				url: '<?php echo base_url('index.php/ruang/detail_ruang'); ?>',
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						if(data[i].jenis=='TEORI'){
							var kategori='LABORATORIUM';
						}
						else{
							var kategori='TEORI';
						}
						html ='<form class="userregisterModal" id="simpan_edit">'+
						'<div class="modal-header">'+
								  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								  '</button>'+
								'<h4 class="modal-title">Edit Ruang</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama Ruang</label>'+
								  '<input type="text" name="nama" value="'+data[i].nama+'"class="form-control" placeholder="Nama">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Kapasitas</label>'+
								  '<input type="text" name="kapasitas"  value="'+data[i].kapasitas+'" class="form-control" placeholder="Kapasitas">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Lantai</label>'+
								  '<input type="text" name="lantai"  value="'+data[i].lantai+'" class="form-control" placeholder="Isikan Angka">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Kategori</label>'+
								  '<select name="kategori" class="form-control" role="menu">'+
										'<li><option value="'+data[i].jenis+'">'+data[i].jenis+'</option></li>'+
										'<li><option value="'+kategori+'">'+kategori+'</option></li>'+
								  '</select>'+
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
								'<button type="submit" class="btn btn-primary" >Simpan</button>'+
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
									 url:'<?php echo base_url();?>index.php/ruang/cek_angka',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
										if(data.success){
										 $.ajax({
											 url:'<?php echo base_url();?>index.php/ruang/cek_ruang/'+id,
											 type:'post',
											 data:formData,
											 dataType: 'json',
											 processData:false,
											 contentType:false, 
											 cache:false,
											 async:false,
											  success: function(data){
											  if(data.success){
											  alert("Ruang Sudah ada.");
											  $('#simpan_edit')[0].reset();
											  }
											  else{
												$.ajax({
													 url:'<?php echo base_url();?>index.php/ruang/simpan_edit/'+id,
													 type:'post',
													 data:formData,
													 dataType: 'json',
													 processData:false,
													 contentType:false, 
													 cache:false,
													 async:false,
													  success: function(data){
													  if(data==true){
													  alert("Berhasil Mengedit Ruang.");
													  $('#edit_ruang').modal('hide');
														$('#simpan_edit')[0].reset();
													  document.location.reload(true);
													  }
													  else{
													  alert('Gagal mengedit Ruang');
													  }
													  $('#edit_ruang').modal('hide');
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
										}
										else{
											alert('Lantai Harus Diisi Angka');
										}
								   },
								   error: function(){
									alert('Lantai Harus Diisi Angka');
									
								   }
								 });
					
						 
		
		});
			});

		$('#simpan_ruang').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
			$.ajax({
									 url:'<?php echo base_url();?>index.php/ruang/cek_angka',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
										if(data.success){
										$.ajax({
							 url:'<?php echo base_url();?>index.php/ruang/cek_ruang_awal',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Ruang Sudah ada.");
							  $('#simpan_ruang')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/ruang/simpan_ruang',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Ruang.");
									  $('#tambah_ruang').modal('hide');
									  $('#simpan_ruang')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Ruang');
									  }
									  $('#tambah_ruang').modal('hide');
									  $('#simpan_ruang')[0].reset();
									  
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
										}
										else{
											alert('Lantai Harus Diisi Angka');
										}
								   },
								   error: function(){
									alert('Lantai Harus Diisi Angka');
									
								   }
								 });
				
					
						 
		
		});
		$('.hapus').on("click", function(){
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/ruang/detail_ruang'); ?>',
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
								'<h4 class="modal-title">Hapus '+data[i].nama+' ?</h4>'+
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
									 url:'<?php echo base_url();?>index.php/ruang/hapus_ruang/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Ruang.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menghapus Ruang');
									  }
									  $('#hapus_ruang').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>