<html>
<head>
	<title>Print kwitansi {{kwitansiNo}}</title>
	<style type="text/css">
			.lead {
				font-family: "Verdana";
				font-weight: bold;
			}
			.value {
				font-family: "Verdana";
			}
			.value-big {
				font-family: "Verdana";
				font-weight: bold;
				font-size: large;
			}
			.td {
				valign : "top";
			}

			hr.new4 {
				border: 10px solid black;
			}

			/* @page { size: with x height */
			/*@page { size: 20cm 10cm; margin: 0px; }*/
			/* @page {
				size: A4;
				margin : 0px;
			} */
	        @media print {
			  html, body {
			  	width: 210mm;
			  }
			}
			/*body { border: 2px solid #000000;  }*/
	</style>
</head>
<body>
	<!-- <h3 style="margin-bottom: -1px;">
		SMP PGRI 32 Jakarta						  
	</h3>
	<p style="font-size: 11px; font-family: arial; margin-top: 5px; margin-bottom: -1px;">
		Jl. Kyai Tapa No.34 - Jakarta Pusat			  
	</p>
	<p style="font-size: 11px; font-family: arial; margin-top: 5px">
		(021) 22633708
	</p> -->

	<div class="row" style=" width:100%; height:40px;">
		<div style="width: 20%; float:left; margin-left: 3px;">
			<img src="<?= base_url() ?>/public/assets/img/brand/logo-smp.png" width="100px" height="80px">
		</div>
		
		<div style="width: 75%; text-align: center;">
			<b> YAYASAN PEMBINA LEMBAGA PENDIDIKAN DIKDASMEN PGRI </b>
			<br/>
			<b> PROVINSI DAERAH KHUSUS IBUKOTA </b>
			<br/>
			<b> SEKOLAH MENENGAH PERTAMA PGRI 32 JAKARTA </b>
			<br/>
			<div style="font-size: 12px;">
				Jalan Setia Kawan III No. 25 Jakarta Pusat Telepon 021-22633708
				<br/>
			</div>
			AKREDITASI B
		</div>
		
		<div style="width: 100%; margin-bottom: 5px;">
			<div style="font-size: 12px; width: 50%; margin-left: 13px; margin-top: -10px; float:left;">
				DKI JAKARTA
				<br>
				E-Mail : <u>32smppgri@gmail.com</u>
			</div>
			<div style="font-size: 12px; width: 35%; margin-top: 15px;">
				NIS : 20101513 &nbsp; &nbsp; &nbsp; NPSN: 20106421
			</div>
		</div>
	</div>

	<div class="row" style=" width: 70%;">
		
	</div>

	<table width="700" style="margin-top:- 100; font-size: 11px; text-align:center;">
		<tr style="background: black;">
			<th style="border-right: 1px solid black;"></th>         
		</tr>
		<!-- <tr style="text-align: left; ">
			<td>test</td>
		</tr> -->
	</table>

	<table width="200" style="margin-top: 20; border: 1px solid; font-size: 14px; 
								text-align:center; margin-left: auto; margin-right: auto;">
		<tr style="background: #fff;">
			<th>Tanda Bukti Pembayaran</th>         
		</tr>
	</table>

	<?php 
		function penyebut($nilai) {
			$nilai = abs($nilai);
			$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " ". $huruf[$nilai];
			} else if ($nilai <20) {
				$temp = penyebut($nilai - 10). " Belas";
			} else if ($nilai < 100) {
				$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " Seratus" . penyebut($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " Seribu" . penyebut($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
			}     
			return $temp;
		}
	 
		function terbilang($nilai) {
			if($nilai<0) {
				$hasil = "Minus ". trim(penyebut($nilai));
			} else {
				$hasil = trim(penyebut($nilai));
			}     		
			return $hasil;
		}

		function getbulan($val) {
			switch ($val) {
				case '1':
					echo "Januari";
					break;
				case '2':
					echo "Pebruari";
					break;

				case '3':
					echo "Maret";
					break;

				case '4':
					echo "April";
					break;

				case '5':
					echo "Mei";
					break;

				case '6':
					echo "Juni";
					break;

				case '7':
					echo "Juli";
					break;

				case '8':
					echo "Agustus";
					break;

				case '9':
					echo "September";
					break;

				case '10':
					echo "Oktober";
					break;

				case '11':
					echo "Nopember";
					break;

				default:
					echo "Desember";
					break;
			};
		}
	?>

	<table style="font-size: 12px; margin-top: 10; margin-left: 15;">
		<tr>
			<td height="45">Telah terima dari</td>
			<td>:</td>
			<td><?= $data->nama_siswa; ?> Kelas <?= $data->nama_kelas; ?></td>
		</tr>

		<tr>
			<td height="45">Uang sejumlah</td>
			<td>:</td>
			<td><?= terbilang($data->jumlah_bayar); ?> Rupiah </td>
		</tr>

		<tr>
			<td height="45">Untuk pembayaran</td>
			<td>:</td>
			<td>SPP Bulan 
				<?php getbulan($data->tagihan_bulan); ?>
				Tahun <?= $data->tagihan_tahun; ?>
			</td>
		</tr>
	</table>

	<p style="padding-top:-128px; padding-left:135; font-size:12px;">..........................................................................................................................................................</p>
	<p style="padding-top:16px; padding-left:135; font-size:12px;">..........................................................................................................................................................</p>
	<p style="padding-top:17px; padding-left:135; font-size:12px;">..........................................................................................................................................................</p>

	<table style="border:0 !important; margin-top:-20px;  margin-left: 15;">
		<tr>
		<td width="555" style="font-size: 12px;">
			<div style="border:1px double; padding: 10px; ">
			&#10;
			&nbsp; &nbsp; Total : Rp. <?= number_format($data->jumlah_bayar, 0, ',', '.'); ?> &nbsp; &nbsp;
			</div>
		</td>

		<td width="135" style="border:0 !important;">
		<div style="font-size: 12px; border-spacing: 15px;" >
			<div style="text-align: right;">
				Jakarta, <?= date("d-M-Y", strtotime($data->insert_date)); ?>
			</div>

			<br />
			<br />
			<br />

			<div style="text-align: center; margin-top: 5px;">
				&nbsp; Kasir : (<?= $data->nama_lengkap; ?>)
			</div>
		</div>
		</td>
		</tr>
	</table>
</body>
</html>