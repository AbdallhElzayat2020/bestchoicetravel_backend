<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/dashboard/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS (LTR) -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />



    <style>
        html {
            direction: ltr !important;
        }

        /* Summernote dropdown fixes */
        .note-dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }

        .note-popover {
            z-index: 9998 !important;
        }

        .note-editor.note-frame {
            z-index: 1 !important;
        }

        .note-dropdown-menu .dropdown-item {
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
        }

        .note-dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Fix for Bootstrap 5 compatibility */
        .note-btn-group .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }

        /* Additional Summernote dropdown fixes */
        .note-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .note-dropdown-menu.open {
            display: block;
        }

        .note-dropdown-menu>li>a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }

        .note-dropdown-menu>li>a:hover,
        .note-dropdown-menu>li>a:focus {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .note-btn-group.open .note-dropdown-menu {
            display: block;
        }

        .note-btn-group.open .dropdown-toggle {
            outline: 0;
        }

        .note-btn-group.open .dropdown-toggle {
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }

        /* Summernote Light Mode Styles */
        html:not(.dark-style) .note-editor {
            background: #ffffff !important;
            border: 1px solid #dbdade !important;
        }

        html:not(.dark-style) .note-editor .note-editing-area {
            background: #ffffff !important;
            color: #6f6b7d !important;
        }

        html:not(.dark-style) .note-editor .note-editing-area .note-editable {
            color: #6f6b7d !important;
        }

        html:not(.dark-style) .note-toolbar {
            background: #f8f7fa !important;
            border-bottom: 1px solid #dbdade !important;
        }

        html:not(.dark-style) .note-btn-group .note-btn {
            background: transparent !important;
            border-color: #dbdade !important;
            color: #6f6b7d !important;
        }

        html:not(.dark-style) .note-btn-group .note-btn:hover {
            background: #f8f7fa !important;
            color: #5d596c !important;
        }

        html:not(.dark-style) .note-btn-group .note-btn.active {
            background: #7367f0 !important;
            color: #ffffff !important;
            border-color: #7367f0 !important;
        }

        html:not(.dark-style) .note-dropdown-menu {
            background-color: #ffffff !important;
            border: 1px solid #dbdade !important;
            color: #6f6b7d !important;
        }

        html:not(.dark-style) .note-dropdown-menu>li>a {
            color: #6f6b7d !important;
        }

        html:not(.dark-style) .note-dropdown-menu>li>a:hover,
        html:not(.dark-style) .note-dropdown-menu>li>a:focus {
            color: #5d596c !important;
            background-color: #f8f7fa !important;
        }

        /* Summernote Dark Mode Styles */
        html.dark-style .note-editor {
            background: #2f3349 !important;
            border: 1px solid #434968 !important;
        }

        html.dark-style .note-editor .note-editing-area {
            background: #2f3349 !important;
            color: #b6bee3 !important;
        }

        html.dark-style .note-editor .note-editing-area .note-editable {
            color: #b6bee3 !important;
        }

        html.dark-style .note-toolbar {
            background: #25293c !important;
            border-bottom: 1px solid #434968 !important;
        }

        html.dark-style .note-btn-group .note-btn {
            background: transparent !important;
            border-color: #434968 !important;
            color: #b6bee3 !important;
        }

        html.dark-style .note-btn-group .note-btn:hover {
            background: #3a3f57 !important;
            color: #cfd3ec !important;
        }

        html.dark-style .note-btn-group .note-btn.active {
            background: #7367f0 !important;
            color: #ffffff !important;
            border-color: #7367f0 !important;
        }

        html.dark-style .note-dropdown-menu {
            background-color: #2f3349 !important;
            border: 1px solid #434968 !important;
            color: #b6bee3 !important;
        }

        html.dark-style .note-dropdown-menu>li>a {
            color: #b6bee3 !important;
        }

        html.dark-style .note-dropdown-menu>li>a:hover,
        html.dark-style .note-dropdown-menu>li>a:focus {
            color: #cfd3ec !important;
            background-color: #3a3f57 !important;
        }

        /* Summernote Code View Styles */
        html:not(.dark-style) .note-editor .note-codable {
            background: #f8f7fa !important;
            color: #6f6b7d !important;
        }

        html.dark-style .note-editor .note-codable {
            background: #25293c !important;
            color: #b6bee3 !important;
        }

        /* Summernote Popover Styles */
        html:not(.dark-style) .note-popover {
            background: #ffffff !important;
            border: 1px solid #dbdade !important;
        }

        html.dark-style .note-popover {
            background: #2f3349 !important;
            border: 1px solid #434968 !important;
        }

        html:not(.dark-style) .note-popover .popover-content {
            background: #ffffff !important;
            color: #6f6b7d !important;
        }

        html.dark-style .note-popover .popover-content {
            background: #2f3349 !important;
            color: #b6bee3 !important;
        }
    </style>
    @stack('css')
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/pages/cards-advance.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/dashboard/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/dashboard/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/dashboard/assets/js/config.js') }}"></script>

    {{-- summernote Plugine --}}
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
</head>