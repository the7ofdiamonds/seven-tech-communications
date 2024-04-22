<?php
header('X-Frame-Options: SAMEORIGIN');

use SEVEN_TECH\Communications\Post_Types\Founders\Founders;

$founders = new Founders;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        $currentURL = $_SERVER['REQUEST_URI'];
        $urlPosition = explode('/', $currentURL);
        $nicename = $urlPosition[2];
        ?>
    </title>

    <?php
    $site_icon_url = get_site_icon_url();

    if ($site_icon_url) {
        echo '<link rel="icon" href="' . esc_url($site_icon_url) . '" sizes="32x32" type="image/png">';
    }
    ?>
    <style>
        main {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <style>
        iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <iframe id="pdfViewer" src="<?php echo $founders->getFounderResume($nicename);; ?>" frameborder="0"></iframe>
</body>

</html>