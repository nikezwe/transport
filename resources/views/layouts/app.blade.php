<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Mon App') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: #667eea;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed {
            margin-left: -250px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .main-content {
            transition: all 0.3s;
        }
        
        .main-content.expanded {
            margin-left: -250px;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand h4 {
            color: white;
            margin: 0;
        }
        
        .content-wrapper {
            padding: 20px;
            min-height: calc(100vh - 76px);
            background-color: #f8f9fa;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                margin-left: -250px;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar" style="width: 250px;">
            <div class="sidebar-brand">
                <h4><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</h4>
            </div>
            
            <nav class="nav flex-column py-3">
                <a class="nav-link active" href="">
                    <i class="fas fa-home me-2"></i>Dashboard
                </a>
                
                <a class="nav-link " href="">
                    <i class="fas fa-cogs me-2"></i>Gestion des Services
                </a>
                
                <a class="nav-link" href="">
                    <i class="fas fa-box me-2"></i>Produits
                </a>
                
                <a class="nav-link " href="">
                    <i class="fas fa-users me-2"></i>Membres
                </a>
                
                <a class="nav-link" href="">
                    <i class="fas fa-bullhorn me-2"></i>Annonces
                </a>
                {{-- <a class="nav-link {{ Request::routeIs('annonces.*') ? 'active' : '' }}" href="{{ route('annonces.index') }}">
                    <i class="fas fa-bullhorn me-2"></i>Annonces
                </a> --}}
                
                <hr class="mx-3" style="border-color: rgba(255, 255, 255, 0.2);">
                
                <a class="nav-link" href="">
                    <i class="fas fa-user me-2"></i>Profil
                </a>
                
                <a class="nav-link" href="">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content flex-fill" id="main-content">
            <!-- Header -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">   
                    
                    <div class="navbar-nav ms-auto">
                        <!-- Notifications -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="badge bg-danger">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Notifications</h6></li>
                                <li><a class="dropdown-item" href="#">Nouveau message</a></li>
                                <li><a class="dropdown-item" href="#">Commande en attente</a></li>
                                <li><a class="dropdown-item" href="#">Rapport mensuel</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Voir toutes</a></li>
                            </ul>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="https://via.placeholder.com/32x32" class="rounded-circle me-2" alt="Avatar">
                                {{ Auth::user()->name ?? 'Utilisateur' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="">
                                    <i class="fas fa-user me-2"></i>Profil
                                </a></li>
                                <li><a class="dropdown-item" href="">
                                    <i class="fas fa-cog me-2"></i>Paramètres
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="content-wrapper">
                <!-- Breadcrumb -->
                @if(!empty($breadcrumb))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
                        @foreach($breadcrumb as $item)
                            @if($loop->last)
                                <li class="breadcrumb-item active">{{ $item['name'] }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
                @endif
                
                <!-- Page Header -->
                @hasSection('page-header')
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3">@yield('page-header')</h1>
                        @hasSection('page-actions')
                            <div>
                                @yield('page-actions')
                            </div>
                        @endif
                    </div>
                @endif
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Main Content -->
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
    @stack('scripts')
</body>
</html>