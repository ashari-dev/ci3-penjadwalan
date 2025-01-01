
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Waktu Tidak Bersedia";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Waktu Tidak Bersedia';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<form class="form" method="POST">
			<label> Nama Guru</label>
			<?php if(isset($msg)) { ?>                        
			  <div class="alert alert-success">
				 <button type="button" class="close" data-dismiss="alert">x</button>                
				 <?php echo $msg;?>
			  </div>
			  <?php } ?>  
            <select id ="kode_guru" name="kode_guru" class="form-control" onchange="change_guru_tidak_bersedia()">
               <?php if($ses_id_guru!=NULL){ ?>
                  <option value="<?php echo $ses_id_guru;?>" selected> <?php echo $ses_nama;?></option>
               <?php } else {
                  foreach($rs_guru as $guru) { 
               ?>
                     <option value="<?php echo $guru->kode;?>" <?php echo isset($kode_guru) ? ($kode_guru === $guru->kode ? 'selected':'') : '' ;?> /> <?php echo $guru->nama;?>
               <?php 
                  } 
               } ?>
            </select>
            <div class="form">
               <input type="hidden" name="hide_me" value="hide_me">
               <button type="submit" class="btn btn-primary">Simpan</button>            
            </div>
			<div style="float: right; width: 45%">
               <input type="checkbox" onclick="toggle(this)"> Pilih Semua <br>
            </div>
            <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>Hari</th>
                  <th>Jam</th>
                  <th>SKS</th>
                  <th>Status</th>
                  
                </tr>
                </thead>
                <tbody >
				 <?php                 
				 $semua_hari = $this->M_Hari->semua_hari();
                        foreach($semua_hari as $hari) {
                           foreach($rs_jam as $jam) { 
				
				?>
                     <tr>
                        <?php
						echo'
                        <td></td>
						<td>'.$hari->nama.'</td>
                        <td>'.$jam->range_jam.'</td>
                        <td>'.$jam->sks.'</td>
						';
						?>
                        <?php
                           $status = '';
                           foreach($rs_waktu_tidak_bersedia->result() as $wtb) {                           
                             
                             if($wtb->kode_hari === $hari->kode && $wtb->kode_jam === $jam->kode) {
                               $status = 'checked';
                             }
                           } ?>
                        <td>
                           <input type="checkbox" name="arr_tidak_bersedia[]" value="<?php echo $kode_guru . '-'. $hari->kode . '-' . $jam->kode ?>" <?php echo $status; ?>> Tidak Bersedia
                        </td>
                     </tr>
                     <?php     
                        }                        
                      }
                    ?>
                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
              </table>
			  </form>
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
  
  
	<div class="modal fade" id="tambah_hari">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Hari</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_hari">
                <!-- text input -->
                <div class="form-group">
                  <label>Nama Hari</label>
                  <input type="text" name="nama" class="form-control" placeholder="Nama Hari">
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
		
	
	<div class="modal fade" id="edit_hari">
          <div class="modal-dialog">
            <div class="modal-content" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_hari">
          <div class="modal-dialog">
            <div class="modal-content" id="form_hapus">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
  
  <script type="text/javascript">
               function toggle(pilih){
                  checkboxes = document.getElementsByName('arr_tidak_bersedia[]');
                  for(var i=0, n=checkboxes.length;i<n;i++){
                     checkboxes[i].checked = pilih.checked;
                  }
               }
			   
		function change_guru_tidak_bersedia() {
			var kode_guru = document.getElementById('kode_guru');			
			window.location.href = "<?php echo base_url().'index.php/waktu_tidak_bersedia/index/' ?>" + kode_guru.options[kode_guru.selectedIndex].value;		
		 }	   
            </script>
  
  <script type='text/javascript'>
	$(document).ready(function() {
	
		$('.edit').on("click", function(){
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/hari/detail_hari'); ?>',
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
								'<h4 class="modal-title">Edit Jam</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								
								'<div class="form-group">'+
								  '<label>Nama Hari</label>'+
								  '<input type="text" name="nama" value="'+data[i].nama+'"class="form-control" placeholder="Nama Hari">'+
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
							 url:'<?php echo base_url();?>index.php/hari/cek_hari',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Hari Sudah ada.");
							  $('#simpan_edit')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/hari/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Hari");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Hari');
									  }
									  $('#edit_hari').modal('hide');
									  $('#simpan_edit')[0].reset();
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
							  }
							  $('#tambah_hari').modal('hide');
							  $('#simpan_hari')[0].reset();
							  
						   },
						   error: function(){
							alert('Could not get Data from Database');
							
						   }
						 });
					
		});
			});

		$('#simpan_hari').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
							 url:'<?php echo base_url();?>index.php/hari/cek_hari',
							 type:'post',
							 data:formData,
							 dataType: 'json',
							 processData:false,
							 contentType:false, 
							 cache:false,
							 async:false,
							  success: function(data){
							  if(data.success){
							  alert("Hari Sudah ada.");
							  $('#simpan_hari')[0].reset();
							  }
							  else{
								$.ajax({
									 url:'<?php echo base_url();?>index.php/hari/simpan_hari',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Hari.");
									  $('#tambah_hari').modal('hide');
										$('#simpan_hari')[0].reset();
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Hari');
									  }
									  $('#tambah_hari').modal('hide');
									  $('#simpan_hari')[0].reset();
									  
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
				url: '<?php echo base_url('index.php/hari/detail_hari'); ?>',
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
								'<h4 class="modal-title">Hapus Hari '+data[i].nama+' ?</h4>'+
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
									 url:'<?php echo base_url();?>index.php/hari/hapus_hari/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Hari.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Hari');
									  }
									  $('#hapus_hari').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>