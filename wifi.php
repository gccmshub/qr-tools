<?php
$f = "wifi_counter.php";
if (!file_exists($f)) {
    touch($f);
    $handle =  fopen($f, "w");
    fwrite($handle, 0);
    fclose($handle);
}

include('libs/phpqrcode/qrlib.php');


if (isset($_POST['submit'])) {
    $tempDir = 'temp/';
    $ssd = $_POST['ssd'];
    $pwd = $_POST['pwd'];
    $type =  $_POST['type'];
    $filename = md5(rand(6, 32));


    $codeContents = 'WIFI:S:' . $ssd . '; P:' . $pwd . '; T:' . $type . '; H:false';

    QRcode::png($codeContents, $tempDir . '' . $filename . '.png', QR_ECLEVEL_L, 5);
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>WiFi (QR) Code Generator</title>
    <link rel="icon" href="img/favicon.ico" type="image/png">
    <link rel="stylesheet" href="libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/style.css">
</head>

<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading"><img src="img/pawan.png" class="hederimg" style="height: 20px;"></div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action bg-dark text-light">Email - QR Generator</a>
                <a href="contact.php" class="list-group-item list-group-item-action bg-dark text-light">vCard - QR Generator</a>
                <a href="wifi.php" class="list-group-item list-group-item-action bg-dark active">WiFi - QR Generator</a>
                <a href="secret.php" class="list-group-item list-group-item-action bg-dark text-light">Secret - QR Generator</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom text-white">
                <span style="font-size:30px;">WiFi Network Connector ~ (QR) Code Generator</span>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <div class="pagevisit">
                                <div class="visitcount">
                                    <?php
                                    $handle = fopen($f, "r");
                                    $counter = (int) fread($handle, 20);
                                    fclose($handle);

                                    if (!isset($_POST["submit"])) {
                                        $counter++;
                                    }

                                    echo "This Page is Visited " . $counter . " Times";
                                    $handle =  fopen($f, "w");
                                    fwrite($handle, $counter);
                                    fclose($handle);
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container px-5" style="margin-top:10%;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="qr-code">
                                    <?php
                                    if (!isset($filename)) {
                                        $filename = "default";
                                    }
                                    ?>
                                    <?php echo '<img src="temp/' . @$filename . '.png">'; ?>
                                    <div class="mt-2 text-center">
                                        <a class="btn btn-primary" href="download.php?file=<?php echo $filename; ?>.png ">Download QR Code</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label>Authentication</label>
                                        <select name="type" class="form-control">
                                            <option value="WEP" <?php if (isset($_POST['type'])) {
                                                                    if ($_POST['type'] == 'WEP') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>WEP</option>
                                            <option value="WPA" <?php if (isset($_POST['type'])) {
                                                                    if ($_POST['type'] == 'WPA') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>WPA / WPA2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>SSID</label>
                                        <input type="text" class="form-control" name="ssd" placeholder="Enter your wifi network name" value="<?php echo @$ssd; ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="pwd" placeholder="Enter your wifi password" value="<?php echo @$pwd; ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" class="btn btn-primary" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

</body>

</html>