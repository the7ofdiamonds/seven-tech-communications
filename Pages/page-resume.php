<?php
header('X-Frame-Options: DENY');

use SEVEN_TECH\Communications\Resume\Resume;

$resume = new Resume;
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

        $resumeInfo = $resume->getResumeInfo($urlPosition[1], $urlPosition[2]);

        echo "{$resumeInfo['full_name']} Resume";
        ?>
    </title>

    <?php
    $site_icon_url = get_site_icon_url();

    if ($site_icon_url) {
        echo '<link rel="icon" href="' . esc_url($site_icon_url) . '" sizes="32x32" type="image/png">';
    }
    ?>
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

    <iframe id="pdfViewer" src="<?php echo $resumeInfo['resume']; ?>" frameborder="0"></iframe>
</body>

</html>