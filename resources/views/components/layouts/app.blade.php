<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NPS Calculator' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <!-- Bootstrap Icons (optional for settings icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

   
    

    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            overflow-y: auto; /* Enable scrolling if content overflows */
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Match the width of your sidebar */
            padding: 20px; /* Optional: add some padding */
            flex-grow: 1; /* Allow it to grow */
        }
            
        .custom-multiselect {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-multiselect input {
            
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-shadow: none;
        }

        .dropdown-options {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ced4da;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border-radius: 4px;
        }

        .dropdown-options.show {
            display: block;
        }

        .dropdown-item {
            padding: 8px 12px;
            display: flex;
            justify-content: flex-start;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item input {
            margin-right: 8px;
        }

        .dropdown-item label {
            margin: 0;
            font-size: 14px;
        }

        .dropdown-item input[type="checkbox"] {
            cursor: pointer;
        }

        /* Style for Search Input */
        #searchInput {
            cursor: pointer;
        }
                /* Style for Selected Items Display in Input */
        #selectedGroups {
            cursor: pointer;
            background-color: #fff;
        }
        </style>

    @livewireStyles
</head>
<body>
    @if (!Request::is('login') && !Request::is('signup'))
        <livewire:navbar />
    @endif
    <div class="d-flex">
        <div class="sidebar">
            <livewire:sidebar />
        </div>
        <div class="container-fluid main-content">
            {{ $slot }}
        </div>
    </div>
    
    @livewireScripts
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    

    
</body>
</html>
