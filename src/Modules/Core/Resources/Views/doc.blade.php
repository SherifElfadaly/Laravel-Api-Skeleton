<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Api Documentation</title>

    <link href="{{ asset('/doc/assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/doc/assets/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/doc/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/doc/assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet">

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('/doc/assets/css/components.min.css') }}" rel="stylesheet" id="style_components">
    <link href="{{ asset('/doc/assets/css/plugins.min.css') }}" rel="stylesheet">
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('/doc/assets/css/layout.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/doc/assets/css/themes/dark.min.css') }}" rel="stylesheet" id="style_color" />
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
                    <a href="#">
                        <img style="margin: 10px 0 0;" src="{{ asset('/doc/assets/img/logo1.png') }}" alt="logo" class="logo-default" /> </a>
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
                        @foreach ($modules as $moduleName => $model)
                        <li class="nav-item ">
                             <a href="#{{$moduleName}}" id="{{$moduleName}}-1" data-toggle="collapse" data-target="#{{$moduleName}}" aria-expanded="false" class="nav-link nav-toggle ">
                                <i class="icon-docs"></i>
                                <span class="title">{{ucfirst($moduleName)}}</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu " id="{{$moduleName}}" role="menu" aria-labelledby="{{$moduleName}}-1">
                                @foreach ($model as $api)
                                    <li class="nav-item ">
                                        <a href="#{{$moduleName}}_{{$api['name']}}" class="nav-link ">
                                            <span class="title">{{ucfirst($api['name'])}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>    
                        </li>
                        @endforeach
                        <li class="nav-item ">
                            <a href="#available-reports" class="nav-link nav-toggle">
                                <i class="icon-doc"></i>
                                <span class="title">Available Reports</span>
                            </a>
                        </li>  
                        <li class="nav-item ">
                            <a href="#errors" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Errors</span>
                            </a>
                        </li>  
                        <li class="nav-item ">
                            <a href="#models" class="nav-link nav-toggle" data-toggle="collapse" data-target="#models" aria-expanded="false" class="nav-link nav-toggle ">
                                <i class="icon-docs"></i>
                                <span class="title">Models</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" id="models" role="menu" aria-labelledby="models-1">
                                @foreach ($models as $name => $value)
                                <li class="nav-item ">
                                    <a href="#model_{{$name}}" class="nav-link">
                                        <span class="title">{{ucfirst($name)}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
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
                        @foreach ($modules as $moduleName => $model)
                            <div class="col-lg-12" id="{{$moduleName}}">
                                <h1>{{ucfirst($moduleName)}}</h1>

                                @foreach ($model as $api)
                                    <div class="panel panel-default" id="{{$moduleName}}_{{$api['name']}}">
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
                                                            @if(strpos($api['uri'], $parametarName . '?') !== false || 
                                                                strpos($parametarDescription, '?') !== false)
                                                            <span class="label label-default">Optional</span>
                                                            @else
                                                            <span class="label label-danger">Required</span>
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
                                                            @else
                                                            <span class="label label-danger">Required</span>
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
                                                    <pre>{{json_encode($condition['content'], JSON_PRETTY_PRINT)}}</pre>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                            @if($api['response'])
                                            <span id="apiResponse{{$moduleName}}_{{$api['name']}}">
                                                @foreach($api['response'] as $object => $relations)
                                                <h4>Response</h4>
                                                @if(array_key_exists('parametars', $api) && array_key_exists('perPage', $api['parametars']))
                                                <pre>{{$paginateObject}}</pre>
                                                @else
                                                <pre>{{$responseObject}}</pre>
                                                @endif
                                                <h4>Response</h4>
                                                <table class="table table-bordered"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>Model</th> 
                                                            @if(count($relations))
                                                            <th>Rlations</th> 
                                                            @endif
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                        <tr> 
                                                            <td>
                                                                <a href="#model_{{$object}}">{{ucfirst(\Illuminate\Support\Str::singular($object))}}</a>
                                                            </td> 
                                                            @if(count($relations))
                                                            <td>
                                                                @foreach ($relations as $relation)
                                                                @if($relation == 'item')
                                                                {{ucfirst($relation)}}: could be any model ex (User, Role....).
                                                                @elseif(\Illuminate\Support\Str::singular($relation) !== $relation)
                                                                Array of <a href="#model_{{\Illuminate\Support\Str::plural($relation)}}">{{ucfirst($relation)}}</a>
                                                                @else
                                                                <a href="#model_{{\Illuminate\Support\Str::plural($relation)}}">{{ucfirst($relation)}}</a>
                                                                @endif
                                                                <br>
                                                                @endforeach
                                                            </td> 
                                                            @endif
                                                        </tr> 
                                                    </tbody> 
                                                </table>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach
                        <div class="col-lg-12" id="errors">
                            <h1>Available error codes</h1>
                            <div class="panel panel-default" id="{{$moduleName}}_{{$api['name']}}">
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
                        <div class="col-lg-12" id="available-reports">
                            <h1>Available reports</h1>
                            <div class="panel panel-default" id="{{$moduleName}}_{{$api['name']}}">
                                <div class="panel-body">
                                    <table class="table table-bordered"> 
                                        <thead> 
                                            <tr> 
                                                <th>ID</th> 
                                                <th>Report Name</th> 
                                                <th>View Name</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($reports as $report)
                                            <tr> 
                                                <td>{{$report['id']}}</td> 
                                                <td>{{$report['report_name']}}</td>
                                                <td>{{$report['view_name']}}</td> 
                                            </tr> 
                                            @endforeach
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="models">
                            <h1>Model Object Examples</h1>
                            @foreach($models as $name => $value)
                            <div class="panel panel-default" id="model_{{$name}}">
                                <div class="panel-heading">{{ucfirst($name)}}</div>
                                <div class="panel-body">
                                    <pre>{{$value}}</pre>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- End CONTENT -->
        </div>
        <!-- End CONTAINER -->

    <!-- JS -->
    <script src="{{ asset('/doc/assets/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('/doc/assets/js/bootstrap.min.js') }}"></script>        
    <script src="{{ asset('/doc/assets/js/js.cookie.min.js') }}"></script>
    <script src="{{ asset('/doc/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/doc/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('/doc/assets/js/layout.min.js') }}"></script>
</body>

</html>