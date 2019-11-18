<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Inventory management software manipulate your business in one click.">
    <meta name="keywords" content="Inventory Management Software, Inventory">
    <meta name="author" content="Mohammad Farid Ahammad">

    <title>{{ trans('global.site_title') }}</title>
    <link href="{{asset('CSS')}}/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/font-awesome.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/all.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/select.dataTables.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/coreui.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/font-awesomea.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/select2.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar" style="background:#357CA5;">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full" style="color: #fff; font-weight: bolder;">Inventory</span>
            <span class="navbar-brand-minimized">P</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" style="background-color: white;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="nav navbar-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            @endif
        </ul>
    </header>

    <div class="app-body">
        @include('partials.menu')
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">

                @yield('content')

            </div>


        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <script src="{{asset('JS')}}/jquery.min.js"></script>
    <script src="{{asset('JS')}}/bootstrap.min.js"></script>
    <script src="{{asset('JS')}}/umd/popper.min.js"></script>
    <script src="{{asset('JS')}}/coreui.min.js"></script>
    <script src="{{asset('JS')}}/jquery.dataTables.min.js"></script>
    <script src="{{asset('JS')}}/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('JS')}}/dataTables.buttons.min.js"></script>
    <script src="{{asset('JS')}}/buttons.flash.min.js"></script>
    <script src="{{asset('JS')}}/buttons.html5.min.js"></script>
    <script src="{{asset('JS')}}/buttons.print.min.js"></script>
    <script src="{{asset('JS')}}/buttons.colVis.min.js"></script>
    <script src="{{asset('JS')}}/pdfmake.min.js"></script>
    <script src="{{asset('JS')}}/vfs_fonts.js"></script>
    <script src="{{asset('JS')}}/jszip.min.js"></script>
    <script src="{{asset('JS')}}/dataTables.select.min.js"></script>
    <script src="{{asset('JS')}}/ckeditor.js"></script>
    <script src="{{asset('JS')}}/moment.min.js"></script>
    <script src="{{asset('JS')}}/bootstrap-datetimepicker.min.js"></script>
    <script src="{{asset('JS')}}/select2.full.min.js"></script>
    <script src="{{asset('JS')}}/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function() {

  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'


  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages.{{ app()->getLocale() }}
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [


      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

    </script>
    @yield('scripts')
</body>

</html>