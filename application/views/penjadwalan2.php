
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
		
		echo "Penjadwalan";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo 'Penjadwalan';?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			
			<div class="container-fluid">
         <?php if(isset($msg)) { ?>                        
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo $msg;?>
            </div>  
        <?php } ?>  
		<?php if(isset($waktu)) { ?>                        
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo $waktu;?>
            </div>  
        <?php } ?>  
		<?php  ?>                        
            <div id="notif"  style="display: none" class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>                
              <?php echo 'Berhasil Menyimpan Jadwal';?>
            </div>  
        <?php  ?>  
		<?php 
		  if(isset($ses_id_guru)){ 
		  } 
		  else 
		  {
		  ?>
			<form class="form" method="POST" action=" ">
          
          <label>Semester</label>
		  
          <select id = "semester_tipe" name="semester_tipe" class="input-xlarge" onchange="change_get()">            
            <?php
			if($semester_a==false){
			echo'
			<option value="1">GANJIL</option>
			<option value="2">GENAP</option>
			';
			}
			else{
				if($semester_a==1){
				$semester_b=2;
				$nama_semester_a='GANJIL';
				$nama_semester_b='GENAP';
				}
				else{
				$semester_b=1;
				$nama_semester_b='GANJIL';
				$nama_semester_a='GENAP';
				}
			echo'
			<option value="'.$semester_a.'">'.$nama_semester_a.'</option>
			<option value="'.$semester_b.'">'.$nama_semester_b.'</option>
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
		  <label>Jurusan</label>
          <select id="jurusan" name="jurusan" class="input-xlarge" >
            
               <?php  
			   if($jurusan==true){
			   $kode_jurusan = $this->M_Jurusan->per_jurusan($jurusan);
				  foreach($kode_jurusan as $j);
				  echo'<option value="'.$j->kode.'">'.$j->nama_jurusan.'</option>';
			   }
			   else{
				echo'<option value="0">Semua Jurusan</option>';
			   }
			   $semua_jurusan = $this->M_Jurusan->semua_jurusan();
				  
                  foreach($semua_jurusan as $sj) { 
               
                  echo'<option value="'.$sj->kode.'">'.$sj->nama_jurusan.'</option>';
					 
               
                  } 
                ?>
			
          </select>
		  <input type="hidden" name="jumlah_populasi" value="<?php echo isset($jumlah_populasi) ? $jumlah_populasi : '50' ;?>">  
          
          <div class="block span6">
       
            <input type="hidden"  name="probabilitas_crossover" value="<?php echo isset($probabilitas_crossover) ? $probabilitas_crossover: '0.70' ;?>">
            
         
            <input type="hidden"  name="probabilitas_mutasi" value="<?php echo isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.20' ;?>">
            
 
            <input type="hidden"  name="jumlah_generasi" value="<?php echo isset($jumlah_generasi) ? $jumlah_generasi : '180' ;?>">
          </div>
		  <br><br>
		  <button type="submit" class="btn btn-primary " onclick="ShowProgressAnimation();" ><i class="fa fa-plus"></i> Proses</button> 
            
          <!--<label>Guru</label>-->  
          
          
         <!-- <div class="form">
            <button type="submit" class="btn">Cari</button>
            <a href="<?php echo base_url() . 'index.php/pengampu/index';?>"><button type="button" class="btn">Clear</button> </a>
          </div> -->
        </form>
		<?php } ?>
		<?php if($rs_jadwal->num_rows() !== 0):?>			
			
		 <button id="simpan_jadwal" class="btn btn-success pull-right"><i class="icon-plus"></i> Simpan Jadwal</button>
		<a href="<?php echo base_url();?>index.php/penjadwalan2/excel_report"> <button class="btn btn-primary pull-right"><i class="icon-plus"></i> Cetak  Excel</button></a>	
			
		<?php endif;?>
			
		
		
		<?php if($rs_jadwal->num_rows() === 0)
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
			<?php
			
			foreach($rs_jadwal->result() as $ket);
			
			echo"<label> Semester $ket->tipe_semester Tahun Ajaran  $ket->nama_tahun  </label>"
			?>
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
				  <th>Jurusan</th>
                  <th>Ruang</th>
                  
                </tr>
                </thead>
                <tbody >
				 <?php                 
				 $i=1;
                        foreach($rs_jadwal->result() as $jadwal) {      
				
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
						<td>'.$jadwal->nama_jurusan.'</td>
						<td>'.$jadwal->ruang.'</td>
						
						
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
  
  
            
	$(document).ready(function (){
			$("#loading-div-background").css({ opacity: 0.5 });
		 <?php if(isset($clear_text_box)) { ?>    
			$('input[type=text]').each(function() {
			    $(this).val('');
			});
		 <?php } ?>
		 $('#simpan_jadwal').on("click", function(){
		 
								$.ajax({
									 url:'<?php echo base_url();?>index.php/penjadwalan2/simpan_jadwal',
									 dataType: 'json',
									 processData:false,
									 contentType:false, 
									 cache:false,
									 async:false,
									  success: function(data){
									  
									  document.getElementById('notif').style='display:block;';
									  
								   },
								   error: function(){
									alert('Could not get Data from Database');
									
								   }
								 });
		});
		 
		});
		
		function ShowProgressAnimation(){
			$("#loading-div-background").show();
		}
		
		

  </script>
  
  