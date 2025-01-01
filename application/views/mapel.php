
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Mata Kuliah";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Mata Kuliah';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_lelang" data-toggle="modal" data-target="#tambah_mapel" ><i class="fa fa-plus"></i> Create Matkul</button> <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Matkul</th>
                  <th>Nama</th>
                  <th>Semester</th>
                  <th>Jumlah Jam</th>
                  <th>Jenis</th>
                  <th>Prodi</th>
                  <th></th>
                  
                  
                </tr>
                </thead>
                <tbody id="semua_mapel">
				 <?php  
				 $i=1;
				  $semua_mapel = $this->M_Mapel->semua_mapel();
				  foreach($semua_mapel as $b){
					echo'<tr>
					  <td> '.$i.'</td>
					  <td>'.$b->nama_kode.'</td>
					  <td>'.$b->nama.'</td>
					  <td> '.$b->tipe_semester.'</td>
					  <td> '.$b->jumlah_jam.'</td>
					  <td> '.$b->jenis.'</td>
					  <td> '.$b->nama_prodi.'</td>
					  <td><button type="button" id="'.$b->kode_matkul.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_mapel" ><i class="fa fa-edit"></i> Update</button> <button type="button" id="'.$b->kode_matkul.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_mapel" ><i class="fa fa-ban"></i> Delete</button></td>
					  
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
  
  
	<div class="modal fade" id="tambah_mapel">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Matakuliah</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_mapel">
                <!-- text input -->
                
				<div class="form-group">
                  <label>Nama Matakuliah</label>
                  <input type="text" name="nama"  class="form-control" placeholder="Nama Matakuliah">
                </div>
				<div class="form-group">
                  <label>Kode Mata Kuliah</label>
                  <input type="text" name="kode_matkul"  class="form-control" placeholder="Kode Matkul">
                </div>
				<div class="form-group">
                  <label>Prodi</label>
                  <select name="prodi" class="form-control" role="menu">
				  <?php 
				  $jurusan=$this->M_Prodi->semua_prodi();
				  foreach($jurusan as $j) {      
						echo'
						<li><option value="'.$j->kode.'">'.$j->nama_prodi.'</option></li>
						';
					}	
					?>	
				  </select>
                </div>
				<div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control" role="menu">
						<li><option value="TEORI">Teori</option></li>
						<li><option value="PRAKTIKUM">Praktikum</option></li>
				  </select>
                </div>
				<div class="form-group">
                  <label>Semester</label>
				  <select name="semester_tipe" class="form-control" role="menu">
						<li><option value="1">GANJIL</option></li>
						<li><option value="2">GENAP</option></li>
				  </select>
                </div>
				<div class="form-group">
                  <label>Jumlah Jam</label>
                  <input type="text" name="jumlah_jam" class="form-control" placeholder="Jumlah Jam">
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
		
	
	<div class="modal fade" id="edit_mapel">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_mapel">
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
				url: '<?php echo base_url('index.php/mapel/detail_mapel'); ?>',
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						if(data[i].jenis=='TEORI'){
							var kategori='PRAKTIKUM';
						}
						else{
							var kategori='TEORI';
						}
						
						if(data[i].semester=='1'){
							var semester='2';
							var nama_semester='GANJIL';
							var nama_semester2='GENAP';
						}
						else{
							var semester='1';
							var nama_semester='GENAP';
							var nama_semester2='GANJIL';
						}
						html ='<form class="userregisterModal" id="simpan_edit">'+
						'<div class="modal-header">'+
								  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								  '</button>'+
								'<h4 class="modal-title">Update Matakuliah</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama Mata Pelajaran</label>'+
								  '<input type="text" name="nama"  value="'+data[i].nama+'" class="form-control" placeholder="Nama">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Kode Mata Kuliah</label>'+
								  '<input type="text" name="kode_matkul"  value="'+data[i].nama_kode+'" class="form-control" placeholder="Kode Mata Kuliah">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Prodi</label>'+
								  '<select id="prodi_edit" name="prodi" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_prodi+'">'+data[i].nama_prodi+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Kategori</label>'+
								  '<select name="kategori" class="form-control" role="menu">'+
										'<li><option value="'+data[i].jenis+'">'+data[i].jenis+'</option></li>'+
										'<li><option value="'+kategori+'">'+kategori+'</option></li>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Semester</label>'+
								  '<select id = "semester_tipe" name="semester_tipe" role="menu" class="form-control" >'+
										'<li><option value="'+data[i].semester+'">'+nama_semester+'</option></li>'+
										'<li><option value="'+semester+'">'+nama_semester2+'</option></li>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Jumlah Jam</label>'+
								  '<input type="text" name="jumlah_jam"  value="'+data[i].jumlah_jam+'" class="form-control" placeholder="Jumlah Jam">'+
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
							url: '<?php echo base_url('index.php/prodi/semua_prodi'); ?>',
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama_prodi+'</option>';
								}
							  $('#prodi_edit').append(html);
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
							 url:'<?php echo base_url();?>index.php/mapel/cek_mapel/'+id,
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Mata Pelajaran Sudah ada.");
							  $('#simpan_mapel')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/mapel/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Matakuliah.");
									  $('#edit_mapel').modal('hide');
										$('#simpan_edit')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Matakuliah');
									  }
									  $('#edit_mapel').modal('hide');
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

		$('#simpan_mapel').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/mapel/cek_mapel_awal',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Matakuliah Sudah ada.");
							  $('#simpan_mapel')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/mapel/simpan_mapel',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Matakuliah.");
									  $('#tambah_mapel').modal('hide');
									  $('#simpan_mapel')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Matakuliah');
									  }
									  $('#tambah_mapel').modal('hide');
									  $('#simpan_mapel')[0].reset();
									  
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
				url: '<?php echo base_url('index.php/mapel/detail_mapel'); ?>',
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
								'<h4 class="modal-title">Delete Matakuliah '+data[i].nama+' ?</h4>'+
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
									 url:'<?php echo base_url();?>index.php/mapel/hapus_mapel/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Matakuliah.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Matakuliah');
									  }
									  $('#hapus_mapel').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>