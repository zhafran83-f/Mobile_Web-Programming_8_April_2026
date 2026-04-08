<!DOCTYPE html>
<html>
<head>
    <title>Data Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Data Peserta</h2>

<h4><?php echo $edit ? 'Edit Peserta' : 'Form Tambah Peserta'; ?></h4>

<form method="post" action="<?php echo base_url('index.php/peserta/'.($edit ? 'update' : 'simpan')); ?>">

<?php if($edit){ ?>
    <input type="hidden" name="id" value="<?php echo $edit->id; ?>">
<?php } ?>

<div class="mb-2">
    <input type="text" name="nama" class="form-control" value="<?php echo $edit ? $edit->nama : ''; ?>" placeholder="Nama">
</div>

<div class="mb-2">
    <input type="text" name="tempat" class="form-control" value="<?php echo $edit ? $edit->tempatLahir : ''; ?>" placeholder="Tempat Lahir">
</div>

<div class="mb-2">
    <input type="date" name="tanggal" class="form-control" value="<?php echo $edit ? $edit->tanggalLahir : ''; ?>">
</div>

<div class="mb-2">
    <select name="agama" class="form-control">
        <option <?php if($edit && $edit->agama=='Islam') echo 'selected'; ?>>Islam</option>
        <option <?php if($edit && $edit->agama=='Kristen') echo 'selected'; ?>>Kristen</option>
        <option <?php if($edit && $edit->agama=='Hindu') echo 'selected'; ?>>Hindu</option>
        <option <?php if($edit && $edit->agama=='Budha') echo 'selected'; ?>>Budha</option>
    </select>
</div>

<div class="mb-2">
    <textarea name="alamat" class="form-control" placeholder="Alamat"><?php echo $edit ? $edit->alamat : ''; ?></textarea>
</div>


<div class="mb-2">
    <input type="text" name="telp" class="form-control"
    value="<?php echo $edit ? $edit->telepon : ''; ?>" placeholder="No Telp">
</div>

<div class="mb-2">
    <select name="kabupaten" class="form-control" onchange="getKota(this.value)">
        <option value="">-- Pilih Kabupaten --</option>
        <?php foreach($kabupaten as $k){ ?>
            <option value="<?php echo $k->id_kabupaten; ?>">
                <?php echo $k->nama_kabupaten; ?>
            </option>
        <?php } ?>
    </select>
</div>

<div class="mb-2">
    <div id="divKota">
        <select name="kota" class="form-control">
            <option value="">-- Pilih Kota --</option>
        </select>
    </div>
</div>

<div class="mb-2">
    <label>Jenis Kelamin:</label><br>
    <input type="radio" name="jk" value="1"
    <?php if($edit && $edit->jenis_kelamin==1) echo 'checked'; ?>> Pria

    <input type="radio" name="jk" value="2"
    <?php if($edit && $edit->jenis_kelamin==2) echo 'checked'; ?>> Wanita
</div>

<?php 
$hobi = $edit ? explode(',', $edit->hobi) : [];
?>

<div class="mb-2">
    <label>Hobi:</label><br>
    <input type="checkbox" name="hobi[]" value="Membaca"
    <?php if(in_array('Membaca', $hobi)) echo 'checked'; ?>> Membaca

    <input type="checkbox" name="hobi[]" value="Menulis"
    <?php if(in_array('Menulis', $hobi)) echo 'checked'; ?>> Menulis

    <input type="checkbox" name="hobi[]" value="Olahraga"
    <?php if(in_array('Olahraga', $hobi)) echo 'checked'; ?>> Olahraga
</div>

<div class="mb-2">
    <input type="file" name="foto" class="form-control">
</div>

<button type="submit" class="btn btn-primary">
    <?php echo $edit ? 'Update' : 'Simpan'; ?>
</button>

</form>

<hr>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Tempat</th>
            <th>Tanggal</th>
            <th>Agama</th>
            <th>Telepon</th>
            <th>Kabupaten</th>
            <th>Kota</th>
            <th>Alamat</th>
            <th>JK</th>
            <th>Hobi</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($peserta as $p){ ?>
        <tr>
            <td><?php echo $p->nama; ?></td>
            <td><?php echo $p->tempatLahir; ?></td>
            <td><?php echo $p->tanggalLahir; ?></td>
            <td><?php echo $p->agama; ?></td>
            <td><?php echo $p->telepon; ?></td>
            <td><?php echo $p->nama_kabupaten; ?></td>
            <td><?php echo $p->nama_kota; ?></td>
            <td><?php echo $p->alamat; ?></td>
            <td><?php echo ($p->jenis_kelamin == 1) ? 'Pria' : 'Wanita'; ?></td>
            <td><?php echo $p->hobi; ?></td>
            <td>
                <?php if($p->foto){ ?>
                    <img src="<?php echo base_url('upload/'.$p->foto); ?>" width="80">
                <?php } ?>
            </td>
            <td>
                <a href="<?php echo base_url('index.php/peserta/edit/'.$p->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?php echo base_url('index.php/peserta/hapus/'.$p->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>

</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function getKota(id_kab){
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('index.php/peserta/getKota'); ?>",
        data: { id_kab: id_kab },
        success: function(hasil){
            $("#divKota").html(hasil);
        }
    });
}
</script>

</body>
</html>