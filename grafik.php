<html>
<head>
	<title>MEMBUAT GRAFIK DARI DATABASE MYSQL DENGAN PHP DAN CHART.JS - www.malasngoding.com</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<style type="text/css">
	body{
		font-family: roboto;
	}
 
	table{
		margin: 0px auto;
	}
	</style>

		<h2>GRAFIK MONITORING SAMPAH</h2>
 
	<?php 
	include 'connect.php';
	?>
 
	<div style="width: 800px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>
 
	<br/>
	<br/>
 
	<table borderWidth="medium">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Wilayah</th>
				<th>Jenis Sampah</th>
				<th>Berat Sampah</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			$data = mysqli_query($koneksi,"select * from layanan");
			while($d=mysqli_fetch_array($data)){
				?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $d['nama']; ?></td>
					<td><?php echo $d['wilayah']; ?></td>
                    <td><?php echo $d['jenis_sampah']; ?></td>
                    <td><?php echo $d['berat_sampah']; ?></td>
				</tr>
				<?php 
			}
			?>
		</tbody>
	</table>
 
 
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Surabaya", "Gresik", "Lamongan", "Sidoarjo"],
				datasets: [{
					label: '',
					data: [
					<?php 
					$jumlah_surabaya = mysqli_query($koneksi,"select * from layanan where wilayah='surabaya'");
					echo mysqli_num_rows($jumlah_surabaya);
					?>, 
					<?php 
					$jumlah_gresik = mysqli_query($koneksi,"select * from layanan where wilayah='gresik'");
					echo mysqli_num_rows($jumlah_gresik);
					?>, 
					<?php 
					$jumlah_lamongan = mysqli_query($koneksi,"select * from layanan where wilayah='lamongan'");
					echo mysqli_num_rows($jumlah_lamongan);
					?>, 
					<?php 
					$jumlah_sidoarjo = mysqli_query($koneksi,"select * from layanan where wilayah='sidoarjo'");
					echo mysqli_num_rows($jumlah_sidoarjo);
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>