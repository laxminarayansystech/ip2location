<?php

require 'IP.php';

$whitelist = array(
    '127.0.0.1',
    '::1'
);

$error = false;

$is_post = false;
$is_domain = false;

if (isset($_POST['host']) && $_POST['host'] != "") {
    $ip = IP::domain_2_ip($_POST['host']);

    if ($ip == false) {
        $ip = $_POST['host'];
        $error = true;
    } else {
        if ($ip != $_POST['host']) {
            $domain = $_POST['host'];
            $is_domain = true;
        }
    }

    $is_post = true;
} else {
    if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '';
    }
}

if ($error == false) {
    $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
    $ip = $data['geoplugin_request'];
}

?>

<html>
<head>
    <title>IP Location Finder</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        h1#id span {
            color: #ff382f;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <a href="index.php">
                        <h1 class="title">IP Location Finder</h1>
                    </a>
                    <p class="description">Find a geo-location of an IP address including latitude, longitude, city,
                        region and country.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php
                if (!$error) {
                    if ($is_domain) {
                        ?>
                        <h1 class="text-center" id="ip">"<?php echo $domain; ?>" has IP address:
                            <span><?php echo $data['geoplugin_request']; ?><span></h1>
                        <?php
                    } else {
                        if ($is_post) { ?>
                            <h1 class="text-center" id="ip">Geolocation for IP Address: <span><?php echo $ip; ?><span>
                            </h1>
                        <?php } else { ?>
                            <h1 class="text-center" id="ip">Your IP Address: <span><?php echo $ip; ?><span></h1>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" required class="form-control" placeholder="IP address or Domain name"
                               name="host">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary" onClick="location.href=''">Check</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 col-sm-offset-1">
                <?php
                if ($error) {
                    ?>

                    <div class="alert alert-danger">
                        <strong>Error:</strong> <?php echo $ip; ?> does not exist.
                    </div>
                    <?php
                } else {
                    ?>

                    <table class="table table-striped">
                        <tbody>

                        <tr>
                            <td>Country Name</td>
                            <td><?php echo $data['geoplugin_countryName']; ?></td>
                        </tr>

                        <tr>
                            <td>Country Code</td>
                            <td><?php echo $data['geoplugin_countryCode']; ?></td>
                        </tr>

                        <tr>
                            <td>Region</td>
                            <td><?php echo $data['geoplugin_regionName']; ?></td>
                        </tr>

                        <tr>
                            <td>Region Code</td>
                            <td><?php echo $data['geoplugin_regionCode']; ?></td>
                        </tr>

                        <tr>
                            <td>City</td>
                            <td><?php echo $data['geoplugin_city'];; ?></td>
                        </tr>

                        <tr>
                            <td>Continent</td>
                            <td><?php echo $data['geoplugin_continentName']; ?></td>
                        </tr>

                        <tr>
                            <td>Continent Code</td>
                            <td><?php echo $data['geoplugin_continentCode']; ?></td>
                        </tr>

                        <tr>
                            <td>Time Zone</td>
                            <td><?php echo $data['geoplugin_timezone']; ?></td>
                        </tr>

                        <tr>
                            <td>Latitude</td>
                            <td><?php echo $data['geoplugin_latitude']; ?></td>
                        </tr>

                        <tr>
                            <td>Longitude</td>
                            <td><?php echo $data['geoplugin_longitude']; ?></td>
                        </tr>

                        <tr>
                            <td>Currency Code</td>
                            <td><?php echo $data['geoplugin_currencyCode']; ?></td>
                        </tr>

                        <tr>
                            <td>Currency Symbol</td>
                            <td><?php echo $data['geoplugin_currencySymbol']; ?></td>
                        </tr>

                        </tbody>
                    </table>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

