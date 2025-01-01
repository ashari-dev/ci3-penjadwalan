
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Riwayat Penjadwalan";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Riwayat Penjadwalan';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			<?php if(isset($hapus)) { ?>                        
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo $hapus;?>
            </div>  
        <?php } ?>  
			<div class="container-fluid">
         <?php if($this->session->flashdata('msg')) { ?>                        
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo $this->session->flashdata('msg');?>
            </div>  
        <?php } ?>  
			<form class="form-control" method="POST" action="<?php echo base_url() . 'index.php/pengampu/pengampu_search'?>" >
          
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
			   $semua_prodi = $this->M_Prodi->semua_prodi2();
				  
                  foreach($semua_prodi as $sj) { 
               
                  echo'<option value="'.$sj->kode.'">'.$sj->nama_prodi.'</option>';
					 
               
                  } 
                ?>
			
          </select>
            

			<!--<label>Guru</label>-->  
          <input type="hidden" name="search_query" value="<?php echo isset($search_query) ? $search_query : '' ;?>">  
          
         
        </form>
		
		<?php if($rs_riwayat->num_rows() === 0)
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
			<a href="<?php echo base_url();?>index.php/riwayat_penjadwalan3/hapus_jadwal"><button id="hapus_jadwal" class="btn btn-danger pull-right" onclick="ShowProgressAnimation();"><i class="icon-plus"></i> Hapus Jadwal</button></a>
			<a href="<?php echo base_url();?>index.php/riwayat_penjadwalan3/excel_report2"> <button class="btn btn-primary "><i class="icon-plus"></i> Cetak Excel</button></a>	<br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Hari</th>
                  <th>Sesi</th>
                  <th>Jam</th>
                  <th>Mata Kuliah</th>
                  <th>Dosen</th>
                  <th>SKS</th>
                  <th>Kelas</th>
                  <th>Semester</th>
				  <th>Prodi</th>
				  <th>Kuota</th>
				  <th>Jurusan</th>
                  <th>Ruang</th>
                  <th>Kapasitas</th>
                  
                </tr>
                </thead>
                <tbody >
				 <?php                 
				 $i=1;
                        foreach($rs_riwayat->result() as $jadwal) {      
				
						echo'
						<tr>
                        <td>'.$i.'</td>
						<td>'.$jadwal->hari.'</td>
						<td>'.$jadwal->sesi.'</td>
						<td>'.$jadwal->jam_kuliah.'</td>
						<td>'.$jadwal->nama_mk.'</td>
						<td>'.$jadwal->guru.'</td>
						<td>'.$jadwal->jumlah_jam.'</td>
						<td>'.$jadwal->nama_kelas.'</td>
						<td>'.$jadwal->nama_semester.'</td>
						<td>'.$jadwal->nama_prodi.'</td>
						<td>'.$jadwal->kuota.'</td>
						<td>'.$jadwal->nama_jurusan.'</td>
						<td>'.$jadwal->ruang.'</td>
						<td>'.$jadwal->kapasitas.'</td>
						
						
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
			  <div id="loading-div-background">
		  <div id="loading-div" class="ui-corner-all">
			<img style="height:50px;width:50px;margin:20px;" src="<?php echo base_url()?>assets/loader2.gif" alt="Loading.."/><br>PROCESSING<br>PLEASE WAIT
		  </div>
		</div>
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
  
	
  <script type="text/javascript">
            
	function change_get(){		
		 	var semester_tipe = document.getElementById('semester_tipe');
			var tahun_akademik = document.getElementById('tahun_akademik');
			var prodi = document.getElementById('prodi');
			
		 	window.location.href = "<?php echo base_url().'index.php/riwayat_penjadwalan3/index/' ?>" + semester_tipe.options[semester_tipe.selectedIndex].value  + "/"+ tahun_akademik.options[tahun_akademik.selectedIndex].value + "/"+ prodi.options[prodi.selectedIndex].value;		
		 }
		 
	function get_matapelajaran(value) {		   
			var sm = value;
			//
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
				data: {sm: sm},
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
				data: {sm: sm},
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
			return ;		 
		}
	function get_mapel(value) {		   
						var sm = value;
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/mapel/get_mapel'); ?>',
							data: {sm: sm},
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
						$.ajax({
							type: 'ajax',
							method: 'get',
							url: '<?php echo base_url('index.php/semester/get_semester'); ?>',
							data: {sm: sm},
							async: false,
							dataType: 'json',
						   success: function(data){
								var html = '';
								var j;
								for(j=0; j<data.length; j++){
								html+='<option value="'+data[j].kode+'">'+data[j].nama_semester+'</option>';
								}
							  $('#semester_edit').html(html);
						   },
						   error: function(){
								alert('Could not get Data from Database');
							}
						});	
						return;
					}	
	$("#loading-div-background").css({ opacity: 0.5 });					
	function ShowProgressAnimation(){
			$("#loading-div-background").show();
		}	

  </script>
  
  