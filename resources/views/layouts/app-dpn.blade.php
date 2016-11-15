<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <!-- <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/materialize.min.css') }}"  media="screen,projection"/> -->
      <link rel="stylesheet" href="{{ elixir('frontend/css/styles.css') }}">
      <!-- <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}"> -->

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>UCP</title>
    </head>

    <body>
    <nav>
      <div class="nav-wrapper">
        <div class="container">
          <a href="#" class="brand-logo">Logo</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="sass.html">Sass</a></li>
            <li><a href="badges.html">Components</a></li>
            <li><a href="collapsible.html">JavaScript</a></li>
          </ul>
        </div>
      </div>
    </nav>
      @yield('content')

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="{{ asset('frontend/js/materialize.min.js') }}"></script>
      <!-- <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script> -->
      <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    </body>
  </html>