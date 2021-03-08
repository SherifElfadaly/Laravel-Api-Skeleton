<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} Confirm Email</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .loader {
            position: relative;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 70px;
            height: 70px;
            left: 50%;
            top: 50%;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        #overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: black;
            opacity: .5;
        }

        .container {
            position: relative;
            height: 300px;
            width: 200px;
            border: 1px solid
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="text-center" style="background-color: #fafcfd;">
    <div id="overlay" style="display: none;">
        <div class="loader"></div>
    </div>

    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <img src="{{url('logo.png')}}" alt="Logo" width="300px">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <script>
        $('#overlay').show();
        axios({
            method: 'post',
            url: '{{ url('api/users/account/confirm/email') }}',
            data: {
                confirmation_code: '{{ $confirmation_token }}'
            }
        }).then(function(response) {
            $('#overlay').hide();
            alert('Email confirmed');
            window.location.href = '{{ config('core.web_url') }}'
        }).catch(function(error) {
            $('#overlay').hide();
            alert(error.response.data.message);
            window.location.href = '{{ config('core.web_url') }}'
        });
    </script>

</html>