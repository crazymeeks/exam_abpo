<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EXAM</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        
    <a href="{{$googleAuthUrl}}">Google Login</a>
    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
    <script>
      (function($){

        let email = "<?php echo $email;?>";
        if (email) {

          $.ajax({
            method: "POST",
            url: "/api/login",
            data: {
              email: email
            },
            success: function(response){

              localStorage.setItem('token', response.token);
              window.location.href = "/customers";
            },
            error: function(xhr){
              const { message } = xhr.responseJSON
              alert(message);
            }
          });
        } else {
          localStorage.removeItem('token');
        }
      })(jQuery);
    </script>
    </body>
</html>
