<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nama = $wilayah = $jenis_sampah =$berat_sampah = "";
$nama_err = $wilayah_err = $jenis_sampah_err =$berat_sampah_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Please enter a name.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Please enter a valid name.";
    } else{
        $nama = $input_nama;
    }
    
    // Validate address address
    $input_wilayah = trim($_POST["wilayah"]);
    if(empty($input_wilayah)){
        $wilayah_err = "Please enter an address.";     
    } else{
        $wilayah = $input_wilayah;
    }
    
    // Validate jenis_sampah
    $input_jenis_sampah = trim($_POST["jenis_sampah"]);
    if(empty($input_jenis_sampah)){
        $jenis_sampah_err = "Please enter an jenis sampah.";     
    } else{
        $jenis_sampah = $input_jenis_sampah;
    }
    // Validate salary
    $input_berat_sampah = trim($_POST["berat_sampah"]);
    if(empty($input_berat_sampah)){
        $berat_sampah_err = "Please enter an address.";     
    } else{
        $berat_sampah = $input_berat_sampah;
    }


    // Check input errors before inserting in database
    if(empty($nama_err) && empty($wilayah_err) && empty($jenis_sampah_err) && empty($berat_sampah_err)){
        // Prepare an update statement
        $sql = "UPDATE layanan SET nama=?, wilayah=?, jenis_sampah=? ,berat_sampah=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_nama, $param_wilayah, $param_jenis_sampah, $param_berat_sampah, $param_id);
            
            // Set parameters
            $param_nama = $nama;
            $param_wilayah = $wilayah;
            $param_jenis_sampah = $jenis_sampah;
            $param_berat_sampah=$berat_sampah;
            $param_id = $id;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index2.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
              // Close statement
        mysqli_stmt_close($stmt);
        echo mysqli_error($link);
        echo mysqli_errno($link);
        }
         
      
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM layanan WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nama = $row["nama"];
                    $wilayah = $row["wilayah"];
                    $jenis_sampah = $row["jenis_sampah"];
                    $berat_sampah = $row["berat_sampah"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
              // Close statement
        mysqli_stmt_close($stmt);
        }
        
      
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($wilayah_err)) ? 'has-error' : ''; ?>">
                            <label>ALamat</label>
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index2.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>