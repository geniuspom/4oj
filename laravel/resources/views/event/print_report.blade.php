<?php
  use App\Http\Controllers\EventControl as EventControl;
  use App\Http\Controllers\Assignment\Assign as Assign;
  use App\Http\Controllers\Report\event_report as event_report;
  $id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>4oj</title>

    <!-- Print CSS-->
    <link href="{{$root_url}}/public/css/print.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="{{$root_url}}/public/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{$root_url}}/public/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{$root_url}}/public/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{$root_url}}/public/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{$root_url}}/public/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{$root_url}}/public/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery UI -->
    <link href="{{$root_url}}/public/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">

    <style>
    .table-5{
      width:5% !important;
    }
    .table-10{
      width:10% !important;
    }
    .table-15{
      width:15% !important;
    }
    .table-20{
      width:20% !important;
    }
    .table-25{
      width:25% !important;
    }
    .table-30{
      width:30% !important;
    }
    .table-35{
      width:35% !important;
    }
    .table-45{
      width:45% !important;
    }
    .table-50{
      width:50% !important;
    }
    .table-60{
      width:60% !important;
    }
    table{
      font-size: 12px;
      table-layout: auto;
    }
    .value{
      text-align: left;
      color:#555 !important;
    }
    .bg-gray{
      background-color: #eee;
    }
    .page-break	{ display: block; page-break-before: always; }
    </style>
</head>

<!--<body onload="window.print();window.close();">-->
<body onload="window.print();">
{{event_report::main($id,1)}}
<div class="page-break"></div>
</body>

</html>
