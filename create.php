<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nama = $wilayah = $jenis_sampah = $berat_sampah= "";
$nama_err = $wilayah_err = $jenis_sampah_err = $berat_sampah_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Masukkan nama.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Masukkan nama yang valid.";
    } else{
        $nama = $input_nama;
    }
    
    // Validate wilayah
    $input_wilayah = trim($_POST["wilayah"]);
    if(empty($input_wilayah)){
        $wilayah_err = "Please enter an address.";     
    } else{
        $wilayah = $input_wilayah;
    }
    
    // Validate jenis sampah
    $input_jenis_sampah = trim($_POST["jenis_sampah"]);
    if(empty($input_jenis_sampah)){
        $jenis_sampah_err = "Please enter the jenis sampah amount.";     
    } else{
        $jenis_sampah = $input_jenis_sampah;
    }
     // Validate berat_sampah
     $input_berat_sampah = trim($_POST["berat_sampah"]);
     if(empty($input_berat_sampah)){
         $berat_sampah_err = "Please enter the berat sampah amount.";     
     } else{
         $berat_sampah = $input_berat_sampah;
     }
    
    // Check input errors before inserting in database
    if(empty($nama_err) && empty($wilayah_err) && empty($jenis_sampah_err) && empty($berat_sampah_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO layanan (nama, wilayah , jenis_sampah, berat_sampah) VALUES (?, ?, ? ,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_nama, $param_wilayah, $param_jenis_sampah, $param_berat_sampah);
            
            // Set parameters
            $param_nama = $nama;
            $param_wilayah = $wilayah;
            $param_jenis_sampah = $jenis_sampah;
            $param_berat_sampah = $berat_sampah;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index2.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($wilayah_err)) ? 'has-error' : ''; ?>">
                            <label>Wilayah</label>
                            <textarea name="wilayah" class="form-control"><?php echo $wilayah; ?></textarea>
                            <span class="help-block"><?php echo $wilayah_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jenis_sampah_err)) ? 'has-error' : ''; ?>">
                            <label>Jenis Sampah</label>
                            <input type="text" name="jenis_sampah" class="form-control" value="<?php echo $jenis_sampah; ?>">
                            <span class="help-block"><?php echo $jenis_sampah_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($berat_sampah_err)) ? 'has-error' : ''; ?>">
                            <label>Berat Sampah</label>
                            <input type="text" name="berat_sampah" class="form-control" value="<?php echo $berat_sampah; ?>">
                            <span class="help-block"><?php echo $berat_sampah_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index2.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>