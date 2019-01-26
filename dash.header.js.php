<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png"/>
    <link rel="icon" type="image/png" href="images/logo_img.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo (empty($_SESSION['title']))?'Welcome':@$_SESSION['title']; ?> | <?php echo $info['site-name']; ?></title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
        <!--Fonts and icons-->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/ >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
        <!--CSS Files-->
        <link href="assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet"/>
        <link href = "assets/demo/demo.css" rel = "stylesheet"/>
        <!--Description-->
        <meta name="description" content="<?php echo $info['descriptions'] ?>">
            <meta name="keywords" content="<?php echo $info['tags'] ?>">
                <meta name="author" content="<?php echo $info['site-aurthur'] ?>">

                    <!--TopProgress Bar-->
                    <script type="text/javascript"
                            src="js/lib/topBar.js"></script>
                    <link rel="stylesheet"
                          href="css/topBar.css"/>
                    <link rel="stylesheet"
                          href="css/custom.css"/>
                    <link rel="stylesheet"
                          href="css/jquery.modal.min.css"/>

                    <link rel="stylesheet"
                          href="css/froala_editor.min.css"/>
                    <link rel="stylesheet"
                          href="css/froala_style.min.css"/>
</head>
<style>
    .druplay_rotate {
    -webkit-animation:spin 2s linear infinite;
    -moz-animation:spin 2s linear infinite;
    animation:spin 2s linear infinite;
}
    @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
    @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style>