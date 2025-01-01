
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Mengajar";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Mengajar';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<button type="button" class="btn btn-primary tambah_pengampu" data-toggle="modal" data-target="#tambah_pengampu" ><i class="fa fa-plus"></i> Create Mengajar</button> <br><br>
			<div class="container-fluid">
         <?php if($this->session->flashdata('msg')) { ?>                        
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo $this->session->flashdata('msg');?>
            </div>  
        <?php } ?>  
			<form class="form-control" method="POST" action="<?php echo base_url() . 'index.php/pengampu/pengampu_search'?>">
          
          <label>Semester</label>
		  
          <select id = "semester_tipe" name="semester_tipe" class="input-xlarge" onchange="change_get()">            
            <?php
			if($semester_a==1){
			echo'
			<option value="1">GANJIL</option>
			<option value="2">GENAP</option>
			';
			}
			else{
			echo'
			<option value="2">GENAP</option>
			<option value="1">GANJIL</option>
			';
			
			}
			?>
          </select>
            
          <label>Tahun Akademik</label>
          <select id="tahun_akademik" name="tahun_akademik" class="input-xlarge" onchange="change_get()">
            
               <?php  
			  if($tahun_a==true){
			   $tahun_awal = $this->M_Tahun->tahun_awal($tahun_a);
				  foreach($tahun_awal as $a);
				  echo'<option value="'.$a->kode.'">'.$a->tahun.'</option>';
			   }
			   
                  foreach($rs_tahun as $tahun) { 
               ?>
                     <option value="<?php echo $tahun->kode;?>" <?php echo $this->session->userdata('pengampu_tahun_akademik') === $tahun->tahun ? 'selected':'' ;?> /> <?php echo $tahun->tahun;?>
					 
               <?php 
                  } 
                ?>
			
          </select>
		  
		  <label>Prodi</label>
          <select id="prodi" name="prodi" class="input-xlarge" onchange="change_get()">
            
               <?php  
			   if($prodi==true){
			   $kode_prodi = $this->M_Prodi->per_prodi($prodi);
				  foreach($kode_prodi as $j);
				  echo'<option value="'.$j->kode.'">'.$j->nama_prodi.'</option>';
				  echo'<option value="0">Semua Prodi</option>';
			   }
			   else{
				echo'<option value="0">Semua Prodi</option>';
			   }
			   $semua_prodi = $this->M_Prodi->semua_prodi();
				  
                  foreach($semua_prodi as $sj) { 
               
                  echo'<option value="'.$sj->kode.'">'.$sj->nama_prodi.'</option>';
					 
               
                  } 
                ?>
			
          </select>
            
          <!--<label>Guru</label>-->  
          <input type="hidden" name="search_query" value="<?php echo isset($search_query) ? $search_query : '' ;?>">  
          
         <!-- <div class="form">
            <button type="submit" class="btn">Cari</button>
            <a href="<?php echo base_url() . 'index.php/pengampu/index';?>"><button type="button" class="btn">Clear</button> </a>
          </div> -->
        </form>
		
		<?php if($rs_pengampu->num_rows() === 0)
		{
		echo'<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>             
				Tidak ada data.
			</div>  
		';
		}
		
		else{
		?> 
            <br><br>
              <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
                  <th>No</th>
                  <th>Mata Kuliah</th>
                  <th>Dosen</th>
                  <th>Kelas</th>
                  <th>Semester</th>
                  <th>Jurusan</th>
                  <th>Kuota</th>
                  <th>Tahun Akademik</th>
                  <th>Ruangan</th>
                  <th></th>
                  
                </tr>
                </thead>
                <tbody >
				 <?php                 
				 $i=1;
                        foreach($rs_pengampu->result() as $pengampu) {      
						if($pengampu->kode_ruang == 0){
							$nama_ruang = 'Acak';
						}
						else{
							$nama_ruang = $pengampu->nama_ruang;
						}
						echo'
						<tr>
                        <td>'.$i.'</td>
						<td>'.$pengampu->nama_mk.'</td>
						<td>'.$pengampu->nama_guru.'</td>
						<td>'.$pengampu->nama_kelas.'</td>
                        <td>'.$pengampu->nama_semester.'</td>
                        <td>'.$pengampu->nama_prodi.'</td>
                        <td>'.$pengampu->kuota.'</td>
                        <td>'.$pengampu->tahun_akademik.'</td>
                        <td>'.$nama_ruang.'</td>
						
						<td>
						<button type="button" id="'.$pengampu->kode.'"class="btn btn-info edit" data-toggle="modal" data-target="#edit_pengampu" ><i class="fa fa-edit"></i> Update</button> 
						<button type="button" id="'.$pengampu->kode.'" class="btn btn-danger hapus" data-toggle="modal" data-target="#hapus_pengampu" ><i class="fa fa-ban"></i> Delete</button>
						</td>
						
						</tr>
						';
						$i++;
						}
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
  </div>
  
	<div class="modal fade" id="tambah_pengampu">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Mengajar</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
              <form id="simpan_pengampu">
                <!-- text input -->
				<div class="form-group">
                  <label>Tahun Akademik</label>
                  <select name="tahun" class="form-control" role="menu">
				  <?php 
				  $tahun=$this->M_Tahun->semua_tahun();
				  foreach($tahun as $t) {      
						echo'
						<li><option value="'.$t->kode.'">'.$t->tahun.'</option></li>
						';
					}	
					?>	
				  </select>
                </div>
                <div class="form-group">
                  <label>Semester Tipe</label>
                  <select id = "semester_tipe2" name="semester_tipe" role="menu" class="form-control" onchange="get_matapelajaran(this.value);" >            
						<li><option value="1">GANJIL</option></li>
						<li><option value="2">GENAP</option></li>
				  </select>
                </div>
				<div class="form-group">
                  <label>Prodi</label>
                  <select id="prodi2" name="prodi" class="form-control" role="menu" onchange="get_matapelajaran(this.value);">
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
                  <label>Jenis Mata Kuliah</label>
                  <select id="jenis" name="jenis" class="form-control" role="menu" onchange="get_mapel();">
				  
				  </select>
                </div>
				<div class="form-group">
                  <label>Semester </label>
                  <select id = "semester" name="semester" role="menu" class="form-control" >            
						
				  </select>
                </div>
				<div class="form-group">
                  <label>Matakuliah</label>
                  <select name="mapel" class="form-control" id="mapel" role="menu">
				  
				  </select>
                </div>
				<div class="form-group">
                  <label>Dosen</label>
                  <select name="guru" class="form-control" role="menu">
				  <?php 
				  $guru=$this->M_Guru->semua_guru();
				  foreach($guru as $g) {      
						echo'
						<li><option value="'.$g->kode.'">'.$g->nama.'</option></li>
						';
					}	
					?>	
				  </select>
                </div>	
				
				<div class="form-group">
                  <label>Kelas</label>
                  <select name="kelas" class="form-control" role="menu">
				  <?php 
				  $kelas=$this->M_Kelas->semua_kelas();
				  foreach($kelas as $k) {      
						echo'
						<li><option value="'.$k->kode.'">'.$k->nama_kelas.'</option></li>
						';
					}	
					?>	
				  </select>
                </div>
				
				<div class="form-group">
                  <label>Kuota</label>
                  <input type="text" name="kuota"  class="form-control" placeholder="Kuota">
                </div>
				
				<div class="form-group">
                  <label>Ruangan</label>
                  <select id="ruang" name="ruang" class="form-control" role="menu">
				  <?php 
				  
					
						
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
		
	
	<div class="modal fade" id="edit_pengampu">
          <div class="modal-dialog-tambah">
            <div class="modal-content-tambah" id="form_edit">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	
	
	<div class="modal fade" id="hapus_pengampu">
          <div class="modal-dialog">
            <div class="modal-content" id="form_hapus">
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
  
  <script type="text/javascript">
            
	function change_get(){		
		 	var semester_tipe = document.getElementById('semester_tipe');
			var tahun_akademik = document.getElementById('tahun_akademik');
			var prodi = document.getElementById('prodi');
		 	window.location.href = "<?php echo base_url().'index.php/pengampu/index/' ?>" + semester_tipe.options[semester_tipe.selectedIndex].value  + "/"	  + tahun_akademik.options[tahun_akademik.selectedIndex].value + "/"+ prodi.options[prodi.selectedIndex].value;		
		 }
	function get_matapelajaran(value) {		   
			var semester_tipe =document.getElementById('semester_tipe2');
			var prodi = document.getElementById('prodi2');
			var s = semester_tipe.options[semester_tipe.selectedIndex].value;
			var p = prodi.options[prodi.selectedIndex].value;
			
			$.ajax({
					type: 'ajax',
					method: 'get',
					url: '<?php echo base_url('index.php/mapel/jenis_mapel'); ?>',
					data: {s:s, p : p},
					async: false,
					dataType: 'json',
				   success: function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
						html+='<option value="'+data[i].jenis_mapel+'">'+data[i].jenis_mapel+'</option>';
						var j = data[0].jenis_mapel;
						}
					  $('#jenis').html(html);
					  $('#jenis_edit').html(html);
					  
					
					$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
							data: {s:s, p:p, j:j},
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var i;	
								for(i=0; i<data.length; i++){
								html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
								}
							  $('#mapel').html(html);
							  $('#mapel_edit').html(html);
						   }
						   
						});
				   }
				   
				});
				
			
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/semester/get_semester'); ?>',
				data: {s: s},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama_semester+'</option>';
					}
				  $('#semester').html(html);
				  $('#semester_edit').html(html);
			   }
			});
			
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/ruang/ruang_perjurusan'); ?>',
				data: {p: p},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
					}
					
				  $('#ruang').html(html);
			   }
			});	
			return ;		 
		}
		
	function get_mapel() {		   
				var semester_tipe =document.getElementById('semester_tipe2');
			var prodi = document.getElementById('prodi2');
			var s = semester_tipe.options[semester_tipe.selectedIndex].value;
			var p = prodi.options[prodi.selectedIndex].value;
				
			var jenis = document.getElementById('jenis');		 
			var j = jenis.options[jenis.selectedIndex].value;	
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
				data: {s:s, p : p,j:j},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
					}
				  $('#mapel').html(html);
				  $('#mapel_edit').html(html);
			   }
			   
			});
		return;
	}	
		
	function get_matapelajaran2(value) {		   
			var semester_tipe =document.getElementById('semester_tipe3');
			var prodi = document.getElementById('prodi_edit');
			var s = semester_tipe.options[semester_tipe.selectedIndex].value;
			var p = prodi.options[prodi.selectedIndex].value;
			
			$.ajax({
					type: 'ajax',
					method: 'get',
					url: '<?php echo base_url('index.php/mapel/jenis_mapel'); ?>',
					data: {s:s, p : p},
					async: false,
					dataType: 'json',
				   success: function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
						html+='<option value="'+data[i].jenis_mapel+'">'+data[i].jenis_mapel+'</option>';
						var j = data[0].jenis_mapel;
						}
					  
					  $('#jenis_edit').html(html);
					  
					
					$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
							data: {s:s, p:p, j:j},
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var i;	
								for(i=0; i<data.length; i++){
								html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
								}
							  $('#mapel_edit').html(html);
						   }
						   
						});
				   }
				   
				});
				
			
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/semester/get_semester'); ?>',
				data: {s: s},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama_semester+'</option>';
					}
				  $('#semester_edit').html(html);
			   }
			});
			
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/ruang/ruang_perjurusan'); ?>',
				data: {p: p},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
					}
					var html2='<li><option value="0">Acak</option></li>';
				  $('#ruang_edit').html(html2+html);
			   }
			});	
			return ;		 
		}
		
	function get_mapel2() {		   
				var semester_tipe =document.getElementById('semester_tipe3');
			var prodi = document.getElementById('prodi_edit');
			var s = semester_tipe.options[semester_tipe.selectedIndex].value;
			var p = prodi.options[prodi.selectedIndex].value;
				
			var jenis = document.getElementById('jenis_edit');		 
			var j = jenis.options[jenis.selectedIndex].value;	
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
				data: {s:s, p : p,j:j},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
					}
				  $('#mapel_edit').html(html);
			   }
			   
			});
		return;
	}		

  </script>
  
  <script type='text/javascript'>
	$(document).ready(function() {
		$('.tambah_pengampu').on("click", function(){
			var semester_tipe =document.getElementById('semester_tipe2');
			var prodi = document.getElementById('prodi');
			var s = 1;
			var p = 1;	
			
			$.ajax({
					type: 'ajax',
					method: 'get',
					url: '<?php echo base_url('index.php/mapel/jenis_mapel'); ?>',
					data: {s:s, p : p},
					async: false,
					dataType: 'json',
				   success: function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
						html+='<option value="'+data[i].jenis_mapel+'">'+data[i].jenis_mapel+'</option>';
						}
					  $('#jenis').html(html);
				   }
				});
			var jenis = document.getElementById('jenis');		 
			var j = jenis.options[jenis.selectedIndex].value;	
			$.ajax({
					type: 'ajax',
					method: 'get',
					url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
					data: {s:s, p:p, j:j},
					async: false,
					dataType: 'json',
				   success: function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
						html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
						}
					  $('#mapel').html(html);
				   }
				});
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/semester/get_semester'); ?>',
				data: {s: s},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama_semester+'</option>';
					}
				  $('#semester').html(html);
			   }
			});	
			
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/ruang/ruang_perjurusan'); ?>',
				data: {p: p},
				async: false,
				dataType: 'json',
			   success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
					}
				  $('#ruang').append(html);
			   }
			});	
			
		
		});
		
		$('.edit').on("click", function(){
		
			var id= this.id;
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/pengampu/detail_pengampu'); ?>',
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
					if(data[i].semester_tipe== 1){
							var semester='2';
							var nama_semester='GANJIL';
							var nama_semester2='GENAP';
						}
						else{
							var semester='1';
							var nama_semester='GENAP';
							var nama_semester2='GANJIL';
						}
					if(data[i].kode_ruang == 0){
						var nama_ruang ='Acak';
					}
					else{
						var nama_ruang = data[i].nama_ruang;
					}
					
						html ='<form  id="simpan_edit">'+
						'<div class="modal-header">'+
								  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								  '</button>'+
								'<h4 class="modal-title">Update Mengajar</h4>'+
							  '</div>'+
							  '<div class="modal-body">'+
								'<div class="box-body" >'+
								'<div class="form-group">'+
								  '<label>Tahun Akademik</label>'+
								  '<select id="tahun_edit" name="tahun" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_tahun+'">'+data[i].tahun_akademik+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Semester Tipe</label>'+
								  '<select id = "semester_tipe3" name="semester_tipe" role="menu" class="form-control" onchange="get_matapelajaran2(this.value);">'+
										'<option value="'+data[i].semester_tipe+'">'+nama_semester+'</option>'+
										'<option value="'+semester+'">'+nama_semester2+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Prodi</label>'+
								  '<select id="prodi_edit" name="prodi" role="menu" class="form-control" onchange="get_matapelajaran2(this.value);" >'+
										'<option value="'+data[i].kode_prodi+'">'+data[i].nama_prodi+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Jenis Mata Kuliah</label>'+
								  '<select id="jenis_edit" name="jenis" role="menu" class="form-control"  onchange="get_mapel2(this.value);" >'+
										'<option value="'+data[i].jenis_mk+'">'+data[i].jenis_mk+'</option>'+
								  '</select>'+
								'</div>'+
								
								'<div class="form-group">'+
								  '<label>Mata Pelajaran</label>'+
								  '<select id="mapel_edit" name="mapel" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_mk+'">'+data[i].nama_mk+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Guru</label>'+
								  '<select id="guru_edit" name="guru" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_guru+'">'+data[i].nama_guru+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Semester</label>'+
								  '<select id="semester_edit" name="semester" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_semester+'">'+data[i].nama_semester+'</option>'+
								  '</select>'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Kelas</label>'+
								  '<select id="kelas_edit" name="kelas" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_kelas+'">'+data[i].nama_kelas+'</option>'+
								  '</select>'+
								'</div>'+
								
								'<div class="form-group">'+
								  '<label>Kuota</label>'+
								  '<input type="text" name="kuota"  value="'+data[i].kuota+'" class="form-control" placeholder="Kuota">'+
								'</div>'+
								'<div class="form-group">'+
								  '<label>Ruangan</label>'+
								  '<select id="ruang_edit" name="ruang" role="menu" class="form-control"  >'+
										'<option value="'+data[i].kode_ruang+'">'+nama_ruang+'</option>'+
								  '</select>'+
								'</div>'+
							'</div>'+
							  '</div>'+
							  '<div class="modal-footer">'+
								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>'+
								'<button type="submit" class="btn btn-primary" >Save</button>'+
							  '</div>'+
							 '</form>';
					$('#form_edit').html(html);
					var s = data[i].semester_tipe;
					var p = data[i].kode_prodi;
					$.ajax({
						type: 'ajax',
						method: 'get',
						url: '<?php echo base_url('index.php/ruang/ruang_perjurusan'); ?>',
						data: {p: p},
						async: false,
						dataType: 'json',
					   success: function(data){
							var html = '';
							var i;
							for(i=0; i<data.length; i++){
							html+='<option value="'+data[i].kode+'">'+data[i].nama+'</option>';
							}
						  $('#ruang_edit').append(html);
					   }
					});	
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/mapel/jenis_mapel'); ?>',
							data: {s:s, p : p},
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var i;
								for(i=0; i<data.length; i++){
									html+='<option value="'+data[i].jenis_mapel+'">'+data[i].jenis_mapel+'</option>';
								}
									
								
								
							  $('#jenis_edit').append(html);
						   }
						});
						var j=data[i].jenis_mk;
					$.ajax({
									type: 'ajax',
									method: 'get',
									url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
									data: {s:s, p : p,j:j},
									async: false,
									dataType: 'json',
								   success: function(data){
										var html = '';
										var j;
										for(j=0; j<data.length; j++){
										html+='<option value="'+data[j].kode+'">'+data[j].nama+'</option>';
										}
									  $('#mapel_edit').append(html);
								   },
								   error: function(){
										alert('Could not get Data from Database');
									}
								});	
					var sm = data[i].semester_tipe;
					
					$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/guru/semua_guru'); ?>',
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama+'</option>';
								}
							  $('#guru_edit').append(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});	
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/kelas/semua_kelas'); ?>',
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama_kelas+'</option>';
								}
							  $('#kelas_edit').append(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/tahun/semua_tahun'); ?>',
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].tahun+'</option>';
								}
							  $('#tahun_edit').append(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});	
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/semester/get_semester'); ?>',
							data: {s: s},
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama_semester+'</option>';
								}
							  $('#semester_edit').append(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});
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
					}
					
				},
				error: function(){
					alert('Could not get Data from Database');
				}
			});
			
			
			
			
						
			
			$('#simpan_edit').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
			$.ajax({
									 url:'<?php echo base_url();?>index.php/pengampu/simpan_edit/'+id,
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Mengedit Pengampu");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal mengedit Pengampu');
									  }
									  $('#edit_pengampu').modal('hide');
									  $('#simpan_edit')[0].reset();
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
					
		});
			});

		$('#simpan_pengampu').submit(function(e){
		    e.preventDefault(); 
			var formData = new FormData(this);
				$.ajax({
									 url:'<?php echo base_url();?>index.php/pengampu/simpan_pengampu',
									 type:'post',
									 data:formData,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menambahkan Pengampu.");
									  $('#tambah_pengampu').modal('hide');
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal Menambahkan Pengampu');
									  }
									  $('#tambah_pengampu').modal('hide');
									  
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
				url: '<?php echo base_url('index.php/pengampu/detail_pengampu'); ?>',
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
								'<h4 class="modal-title">Delete Pengajar '+data[i].nama_mk+' '+data[i].nama_guru+' ?</h4>'+
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
									 url:'<?php echo base_url();?>index.php/pengampu/hapus_pengampu/'+id,
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  if(data==true){
									  alert("Berhasil Menghapus Pengampu.");
									  document.location.reload(true);
									  }
									  else{
									  alert('Gagal menghapus Pengampu');
									  }
									  $('#hapus_pengampu').modal('hide');
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
								 
				
				});
			
			});
			
	
	});
</script>