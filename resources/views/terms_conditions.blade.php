<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ appName() }} T&C</title>
    <meta name="author" content="Xmartlabs" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="css/custom.css" rel="stylesheet" type="text/css" />


    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Projecthub" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:title" content="Projecthub Terms and Conditions" />
    <meta property="og:description" content="Manage your Github projects from the palm of your hand." />
  </head>

  <body id="terms-and-conditions">
    <header class="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col col-xs-10 col-xs-offset-1 col-sm-5 col-sm-offset-1">
            <a href="/">
              {{-- <img class="img-responsive logo" src="images/projecthub-logo.png" srcset="images/projecthub-logo@2x.png 2x, images/projecthub-logo@3x.png 3x" draggable="false" /> --}}
            </a>
          </div>
          <div class="col col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-1">
          </div>
        </div>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row terms-and-conditions-section">
        <div class="col-xs-12 text-center">
          <h1 class="title">الشروط والاحكام</h1>
        </div>

        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
          <div class="content">
              {!! setting('terms_conditions') !!}
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
