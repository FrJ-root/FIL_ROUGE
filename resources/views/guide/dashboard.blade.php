<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Guide</li>
                    </ol>
                </nav>
                
                <h1>Dashboard Guide</h1>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Getting Started</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Welcome to your dashboard!</h5>
                        <p class="card-text">This guide will help you navigate and use the features available in your dashboard.</p>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Navigation</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Main Menu</h5>
                        <p class="card-text">The main menu is located on the left side of the dashboard and contains links to all major sections.</p>
                        
                        <h5 class="card-title mt-3">Quick Actions</h5>
                        <p class="card-text">Quick actions can be found at the top of the dashboard for frequently used tasks.</p>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Features</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Analytics</h5>
                                        <p class="card-text">View detailed statistics and reports about your activities.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">User Management</h5>
                                        <p class="card-text">Add, edit, or remove users and manage their permissions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Settings</h5>
                                        <p class="card-text">Configure your dashboard preferences and system settings.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
