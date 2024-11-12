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
    <link
        href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
        rel="stylesheet"
        />
   
    

    <style>
       
       label {
            font-size:14px;
        }
        input,select,textarea{
           
            font-size:12px !important;
        }
        button {
            font-size: 13px !important;
        }
        
        th{
            font-size: 13px;
    font-weight: 700 !important;
        }
        td{
            
    font-size: 13px;
        }
        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Match the width of your sidebar */
            padding: 20px; /* Optional: add some padding */
            flex-grow: 1; /* Allow it to grow */
            width: -webkit-fill-available;
            transition: all 0.5s ease;
            padding-top: 70px;
        }
            
        .custom-multiselect {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        /* kapil_changes */
       
        .addnewuser {
    font-size: 13px;
}
    .table-wrapper {
        position: relative;
        overflow-x: auto;
        margin: 20px 0;
        
    }

    .fixed-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fixed-column {
        position: sticky;
        left: 0;
        /* background-color: #dfdfdf !important; */
      
        border-right: 1px solid #ddd !important;
    
        display: block;
    }

   

   

section.home-section {
    position: fixed;
    z-index: 9999;
}
.editdeletebtn {
    font-size: 13px !important;
}
.addnewgroupbtn {
    font-size: 13px;
}
::placeholder {
  color: #000 !important;
  
}
input::placeholder {
  color: #000 !important;
  
}
a.btn.btn-primary.float-end {
    font-size: 13px;
}
.card-body a {
    font-size: 13px !important;
}
.card-body button {
    font-size: 13px !important;
}
        .card-header.text-white h2 {
    font-size: 28px !important;
    font-weight: 500;
}

        .shadow label {
            font-size: 14px;
        }
        .shadow select {
            font-size: 12px;
        }
        .shadow input {
            font-size: 12px;
        }
        .shadow button {
            font-size: 13px !important;
        }
        h2 {
            font-size: 24px !important;
        }
        p {
            font-size: 12px;
        }
        .shadow .text-center.border h2 {
            padding: 10px 0 10px 0;
        }


        .topsection {
            padding: 20px 0 20px 0;
        }
        .applynow {
            margin: 10px 0 0 0;
            
        }
        button.btn.btn-success.downloadbtn {
            font-size: 13px;
        }

        .tablecontainer table thead tr th {
            font-size: 13px;
            font-weight: 700 !important;
        }

        .tablecontainer table tbody tr th {
            font-size: 13px;
            font-weight: 700 !important;
        }

        .tablecontainer table tbody tr td {
            font-size: 13px;
        }

        .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 260px;
        background: #007DBD;
        z-index: 100;
        transition: all 0.5s ease;
        }
        .sidebar.close {
        width: 78px;
        }
        .sidebar .logo-details {
        height: 60px;
        width: 100%;
        display: flex;
        align-items: center;
        }
        .sidebar .logo-details i {
        font-size: 30px;
        color: #fff;
        height: 60px;
        min-width: 78px;
        text-align: center;
        line-height: 50px;
        }
        .sidebar .logo-details .logo_name {
        font-size: 22px;
        color: #fff;
        font-weight: 600;
        transition: 0.3s ease;
        transition-delay: 0.1s;
        }
        .sidebar.close .logo-details .logo_name {
        transition-delay: 0s;
        opacity: 0;
        pointer-events: none;
        }
        .form-label{
            padding-left: 5px;
        }
        .sidebar .nav-links {
        height: 100%;
        padding: 30px 0 150px 0;
        overflow: auto;
        }
        .sidebar.close .nav-links {
        overflow: visible;
        }
        .sidebar .nav-links::-webkit-scrollbar {
        display: none;
        }
        .sidebar .nav-links li {
        position: relative;
        list-style: none;
        transition: all 0.4s ease;
        }
        .sidebar .nav-links li:hover {
        background: #006091;
        }
        .sidebar .nav-links li .iocn-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        }
        .sidebar.close .nav-links li .iocn-link {
        display: block;
        }
        .sidebar .nav-links li i {
        height: 50px;
        min-width: 56px;
        text-align: center;
        line-height: 50px;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        }
        .sidebar .nav-links li.showMenu i.arrow {
        transform: rotate(-180deg);
        }
        .sidebar.close .nav-links i.arrow {
        display: none;
        }
        .sidebar .nav-links li a {
        display: flex;
        align-items: center;
        text-decoration: none;
        }
        .sidebar .nav-links li a .link_name {
        font-size: 14px;
        font-weight: 400;
        color: #fff;
        transition: all 0.4s ease;
        }
        .sidebar.close .nav-links li a .link_name {
        opacity: 0;
        pointer-events: none;
        }
        .sidebar .nav-links li .sub-menu {
        padding: 6px 6px 14px 10px;
        margin-top: -10px;
        background: #006091;
        display: none;
        }
        .sidebar .nav-links li.showMenu .sub-menu {
        display: block;
        }
        .sidebar .nav-links li .sub-menu a {
        color: #fff;
        font-size: 14px;
        padding: 5px 0;
        white-space: nowrap;
        opacity: 0.6;
        transition: all 0.3s ease;
        }
        .sidebar .nav-links li .sub-menu a:hover {
        opacity: 1;
        }
        .sidebar.close .nav-links li .sub-menu {
        position: absolute;
        left: 100%;
        top: -10px;
        margin-top: 0;
        padding: 10px 20px;
        border-radius: 0 6px 6px 0;
        opacity: 0;
        display: block;
        pointer-events: none;
        transition: 0s;
        }
        .sidebar.close .nav-links li:hover .sub-menu {
        top: 0;
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        }
        .sidebar .nav-links li .sub-menu .link_name {
        display: none;
        }
        .sidebar.close .nav-links li .sub-menu .link_name {
        font-size: 14px;
        opacity: 1;
        display: block;
        }
        .sidebar .nav-links li .sub-menu.blank {
        opacity: 1;
        pointer-events: auto;
        padding: 3px 20px 6px 16px;
        opacity: 0;
        pointer-events: none;
        }
        .sidebar .nav-links li:hover .sub-menu.blank {
        top: 50%;
        transform: translateY(-50%);
        }
        .sidebar .profile-details {
        position: fixed;
        bottom: 0;
        width: 260px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #1d1b31;
        padding: 12px 0;
        transition: all 0.5s ease;
        }
        .sidebar.close .profile-details {
        background: none;
        }
        .sidebar.close .profile-details {
        width: 78px;
        }
        .sidebar .profile-details .profile-content {
        display: flex;
        align-items: center;
        }
        .sidebar .profile-details img {
        height: 52px;
        width: 52px;
        object-fit: cover;
        border-radius: 16px;
        margin: 0 14px 0 12px;
        background: #1d1b31;
        transition: all 0.5s ease;
        }
        .sidebar.close .profile-details img {
        padding: 10px;
        }
        .sidebar .profile-details .profile_name,
        .sidebar .profile-details .job {
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        white-space: nowrap;
        }
        .sidebar.close .profile-details i,
        .sidebar.close .profile-details .profile_name,
        .sidebar.close .profile-details .job {
        display: none;
        }
        .sidebar .profile-details .job {
        font-size: 12px;
        }
        .home-section {
        position: relative;
        background: #007DBD;
        
        left: 260px;
        width: calc(100% - 260px);
        transition: all 0.5s ease;
        }
        .sidebar.close ~ .home-section {
        left: 78px;
        width: calc(100% - 78px);
        }
        
        .home-section .home-content {
        height: 60px;
        display: flex;
        align-items: center;
        }
        .home-section .home-content .bx-menu,
        .home-section .home-content .text {
            color: #fff;
            font-size: 32px;
        }
        .home-section .home-content .bx-menu {
        margin: 0 15px;
        cursor: pointer;
        }
        .home-section .home-content .text {
        font-size: 26px;
        font-weight: 600;
        }
        @media (max-width: 420px) {
        .sidebar.close .nav-links li .sub-menu {
            display: none;
        }
        }

        .main-container.close .main-content{
            margin-left:78px !important;
        }

        .shadow .text-center.border h2 {
            padding: 10px 0 10px 0;
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
    
    <div class="main-container">  
        <livewire:new-sidebar />
        <div class=" main-content">
            {{ $slot }}
        </div>
    </div>

    
    @livewireScripts
   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
</body>
</html>
