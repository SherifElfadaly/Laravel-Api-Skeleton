<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <link href="{{$baseUrl}}Resources/Assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{$baseUrl}}Resources/Assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet">
    <link href="{{$baseUrl}}Resources/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{$baseUrl}}Resources/Assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet">

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{$baseUrl}}Resources/Assets/css/components.min.css" rel="stylesheet" id="style_components">
    <link href="{{$baseUrl}}Resources/Assets/css/plugins.min.css" rel="stylesheet">
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{$baseUrl}}Resources/Assets/css/layout.min.css" rel="stylesheet">
    <link href="{{$baseUrl}}Resources/Assets/css/themes/dark.min.css" rel="stylesheet" id="style_color" />
    <!-- END THEME LAYOUT STYLES -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-fixed">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img style="margin: 10px 0 0;" src="{{$baseUrl}}Resources/Assets/img/logo1.png" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
            </div>
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        @foreach ($modules as $moduleName => $module)
                        <li class="nav-item ">
                             <a href="#{{$moduleName}}" id="{{$moduleName}}-1" data-toggle="collapse" data-target="#{{$moduleName}}" aria-expanded="false" class="nav-link nav-toggle ">
                                <i class="icon-docs"></i>
                                <span class="title">{{ucfirst($moduleName)}}</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" id="{{$moduleName}}" role="menu" aria-labelledby="{{$moduleName}}-1">
                                @foreach ($module as $modelName => $model)
                                <li class="nav-item ">
                                    <a href="#{{$modelName}}" data-toggle="collapse" data-target="#{{$modelName}}" aria-expanded="false" class="nav-link nav-toggle">
                                        <span class="title">{{ucfirst($modelName)}}</span>
                                        <span class="arrow "></span>
                                    </a>
                                    <ul class="sub-menu " id="{{$modelName}}" role="menu" aria-labelledby="{{$modelName}}-1">
                                        @foreach ($model as $api)
                                        <li class="nav-item ">
                                            <a href="#{{$moduleName}}_{{$modelName}}_{{$api['name']}}" class="nav-link ">
                                                <span class="title">{{ucfirst($api['name'])}}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>    
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                        <li class="nav-item ">
                            <a href="#errors" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Errors</span>
                            </a>
                        </li>  
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->

            <!--Pag Content -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="row">
                        @foreach ($modules as $moduleName => $module)
                        <div class="col-lg-12" id="{{$moduleName}}">
                            <h1>{{ucfirst($moduleName)}}</h1>

                            @foreach ($module as $modelName => $model)
                            <h3 id="{{$modelName}}">{{ucfirst($modelName)}}</h3>

                            @foreach ($model as $api)
                            <div class="panel panel-default" id="{{$moduleName}}_{{$modelName}}_{{$api['name']}}">
                                <div class="panel-heading">{{ucfirst($api['name'])}} 
                                    @if($api['method'] == 'GET')
                                    <span class="label label-success">{{$api['method']}}</span>
                                    @else
                                    <span class="label label-danger">{{$api['method']}}</span>
                                    @endif
                                </div>
                                <div class="panel-body">
                                    <p>{{$api['description']}}</p>
                                    <pre>{{url($api['uri'])}}</pre>

                                    <h4>Headers</h4>
                                    <table class="table table-bordered"> 
                                        <thead> 
                                            <tr> 
                                                <th>Field</th> 
                                                <th>Value</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($api['headers'] as $headerName => $headerValue)
                                            <tr> 
                                                <td>{{$headerName}}</td> 
                                                <td>{{$headerValue}}</td> 
                                            </tr> 
                                            @endforeach
                                        </tbody> 
                                    </table>

                                    @if(array_key_exists('parametars', $api))
                                    <h4>Parametars</h4>
                                    <table class="table table-bordered"> 
                                        <thead> 
                                            <tr> 
                                                <th>Field</th> 
                                                <th>Value</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($api['parametars'] as $parametarName => $parametarDescription)
                                            <tr> 
                                                <td>
                                                    {{$parametarName}}
                                                    @if(strpos($api['uri'], $parametarName . '?') !== false)
                                                    <span class="label label-default">Optional</span>
                                                    @endif
                                                </td> 
                                                <td>{{$parametarDescription}}</td> 
                                            </tr> 
                                            @endforeach
                                        </tbody> 
                                    </table>
                                    @endif

                                    @if(array_key_exists('body', $api) && is_array($api['body']))
                                    <h4>Body</h4>
                                    <table class="table table-bordered"> 
                                        <thead> 
                                            <tr> 
                                                <th>Field</th> 
                                                <th>Rules</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($api['body'] as $parametarName => $parametarRules)
                                            <tr> 
                                                <td>
                                                    {{$parametarName}}
                                                    @if(strpos($parametarRules, 'required') === false)
                                                    <span class="label label-default">Optional</span>
                                                    @endif
                                                </td> 
                                                <td>{{$parametarRules}}</td>
                                            </tr> 
                                            @endforeach
                                        </tbody> 
                                    </table>
                                    @elseif(array_key_exists('body', $api) && $api['body'] == 'conditions')
                                    <h4>Body</h4>
                                    <p>This examples applied on users only change them based on the requested api.</p>
                                    <ul class="nav nav-tabs" role="tablist"  id="conditionsTabs">
                                        @foreach ($conditions as $key => $condition)
                                        @if($key == 0)
                                        <li class="active">
                                        @else
                                        <li>
                                        @endif
                                            <a href=".{{$key}}" data-toggle="tab">{{$condition['title']}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($conditions as $key => $condition)
                                        @if($key == 0)
                                        <div class="tab-pane active {{$key}}">
                                        @else
                                        <div class="tab-pane {{$key}}">
                                        @endif
                                            <pre>{{$condition['content']}}</pre>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    <button id="apiResponseBtn{{$moduleName}}_{{$modelName}}_{{$api['name']}}" type="button" class="btn btn-primary" onClick="testApi('{{addslashes(json_encode($api))}}', '{{$moduleName}}_{{$modelName}}_{{$api['name']}}')">View Response</button>

                                    <a id="apiResponseShowHide{{$moduleName}}_{{$modelName}}_{{$api['name']}}" onClick="showHideResponse('{{$moduleName}}_{{$modelName}}_{{$api['name']}}')" style="display: none">Show/Hide Response</a>

                                    <i class="fa fa-spinner fa-spin" id="loading{{$moduleName}}_{{$modelName}}_{{$api['name']}}" style="font-size:24px;display: none"></i>

                                    <pre id="apiResponse{{$moduleName}}_{{$modelName}}_{{$api['name']}}" style="display: none"></pre>
                                </div>
                            </div>
                            @endforeach

                            @endforeach
                        </div>
                        @endforeach
                        <div class="col-lg-12" id="errors">
                            <h1>Available error codes</h1>
                            <div class="panel panel-default" id="{{$moduleName}}_{{$modelName}}_{{$api['name']}}">
                                <div class="panel-body">
                                    <table class="table table-bordered"> 
                                        <thead> 
                                            <tr> 
                                                <th>Code</th> 
                                                <th>Description</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($errors as $errorCode => $errorsDesc)
                                            <tr> 
                                                <td>{{$errorCode}}</td> 
                                                <td>
                                                    @foreach ($errorsDesc as $errorDesc)
                                                    <p>{{ucfirst($errorDesc)}} : {{trans('errors.' . $errorDesc . '')}}</p>
                                                    @endforeach
                                                </td> 
                                            </tr> 
                                            @endforeach
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End CONTENT -->
        </div>
        <!-- End CONTAINER -->

    <!-- JS -->
    <script src="{{$baseUrl}}Resources/Assets/js/jquery.min.js"></script> 
    <script src="{{$baseUrl}}Resources/Assets/js/bootstrap.min.js"></script>        
    <script src="{{$baseUrl}}Resources/Assets/js/js.cookie.min.js"></script>
    <script src="{{$baseUrl}}Resources/Assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="{{$baseUrl}}Resources/Assets/js/app.min.js"></script>
    <script src="{{$baseUrl}}Resources/Assets/js/layout.min.js"></script>
    
    <script>
      function testApi(route, selector){
        route        = JSON.parse(route);
        route._token = '{{csrf_token()}}';
        $("#loading" + selector).show();
          $.ajax({
              type: 'POST',
              url: "{{url('testApi')}}",
              data: route,
              success: function(response){
                  $("#apiResponse" + selector).html(JSON.stringify(response, undefined, 2));
                  $("#apiResponse" + selector).show();
                  $("#apiResponseBtn" + selector).hide();
                  $("#apiResponseShowHide" + selector).show();
                  $("#loading" + selector).hide();
              }
          });
      }
      function showHideResponse(selector){
        $("#apiResponse" + selector).toggle();
      }
  </script>
</body>

</html>