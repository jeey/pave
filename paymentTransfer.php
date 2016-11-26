<?php 
require_once("config/database.php");
require_once("engine/bo/OrderBo.php");

$connection = openConnection();

$orderBo = OrderBo::newInstance($connection);

$order = $orderBo->get($_REQUEST["order"]);

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Parti Pirate">

    <title>Parti Pirate - Le Pavé</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="assets/css/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Retina Images Plugin -->
    <script src="assets/js/plugins/retina/retina.min.js"></script>

    <!-- Plugin CSS -->
    <link href="assets/css/plugins/hover/hover.min.css" rel="stylesheet">
    <link href="assets/css/plugins/owl.carousel/owl.carousel.css" rel="stylesheet">
    <link href="assets/css/plugins/owl.carousel/owl.theme.css" rel="stylesheet">
    <link href="assets/css/plugins/owl.carousel/owl.transitions.css" rel="stylesheet">
    <link href="assets/css/plugins/jquery.fs.wallpaper/jquery.fs.wallpaper.css" rel="stylesheet">
    <link href="assets/css/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Spectrum CSS -->
    <!-- Note: spectrum.css is the default blue theme. To use another theme, uncomment the one you want and delete the rest, including the default spectrum.css! -->
    <link href="assets/css/spectrum-purple.css" rel="stylesheet">
    <link href="assets/css/pp.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<!-- Piwik -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(["setDomains", ["*.template.partipirate.org"]]);
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
	    var u="//piwik.partipirate.org/";
	    _paq.push(['setTrackerUrl', u+'piwik.php']);
	    _paq.push(['setSiteId', 4]);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
	    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<noscript><p><img src="//piwik.partipirate.org/piwik.php?idsite=4" style="border:0;" alt="" /></p></noscript>
	<!-- End Piwik Code -->

    <div id="wrapper">

        <nav class="navbar navbar-dark navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="#page-top">
                        <span class="logo">
                            <img src="assets/img/logo.png" alt="">
                        </span>
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="page-link">
                            <a href="index.html">Le Pavé</a>
                        </li>
                        <li class="page-link">
                            <a href="https://www.partipirate.org">Le Parti Pirate</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <header class="video-bg">
            <div class="intro-video intro-dark-bg container">
                <div class="overlay"></div>
                <div class="intro-body">
                    <div class="container">
                        <h1 class="brand-heading">
                            Le<br><span class="text-primary">pavé</span>
                        </h1>
                        <hr class="light">
                        
	                    <div class="row text-center">
	                        <div class="col-lg-8 col-lg-offset-2">
	                            <h2>Paiement par virement</h2>
	                            <hr class="light">
	                            <p style="background-color: rgba(255,255,255,0.5); color: black; ">Votre avez décidé de payer votre pavé par virement. <br />
	                            	Veuillez transférer la somme de <?php echo $order["ord_amount"]; ?>&euro; en indiquant 
	                            	le code &laquo;PAVE-<?php echo $order["ord_id"]; ?>&raquo;
	                            	sur le compte bancaire suivant :<br />
	                            	Parti Pirate<br />
	                            	FR76 4255 9000 4741 0200 3318 752</p>
	                        </div>
	                    </div>

                        <div class="page-link" data-scrollreveal="enter bottom after .6s">
                            <a href="index.html" class="btn btn-scroll-light sink">
                                <i class="fa fa-angle-double-right" style="position: relative; top: -4px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <footer class="footer-1">
            <div class="upper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <h2 class="script">Parti Pirate</h2>
                            <address>
                                21, rue de la République<br>
                                75003 Paris<br>
							</address>
                        </div>
                        <div class="col-md-3">
                            <h4>Liens</h4>
                            <ul class="list-unstyled footer-links">
                                <li>
                                    <a href="https://www.partipirate.org" target="_blank">Site du Parti Pirate</a>
                                </li>
                                <li>
                                    <a href="https://wiki.partipirate.org" target="_blank">Wiki du Parti Pirate</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-3">
                            <h4>Social</h4>
                            <ul class="list-inline">
                                <li>
                                    <a href="https://www.facebook.com/partipiratefr/" class="btn btn-social-light btn-facebook"><i class="fa fa-fw fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/partipirate" class="btn btn-social-light btn-twitter"><i class="fa fa-fw fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lower">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="small"><a href="licences.html" title="Information licence">Mentions légales</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <script src="assets/js/min.js"></script>
    <script src="assets/js/pp.js"></script>

    <!-- Script to Activate Formstone Wallpaper jQuery Plugin - Use this script if you want to use an .mp4, .ovg, or .webm video as a background video. -->
    <script>
/*     $(".video-bg").wallpaper({
        source: {
            mp4: "assets/mp4/Drapeau.mp4",
            poster: "assets/img/demo-bgs/video-bg-fallback.jpg"
        }
    });
 */
 	</script>

</body>

</html>
