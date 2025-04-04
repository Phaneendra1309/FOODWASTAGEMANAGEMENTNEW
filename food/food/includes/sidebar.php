<?php
error_reporting(0);
// includes/sidebar.php - Sidebar Navigation
session_start();
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                
                <?php if ($user_role === 'admin') : ?>
                    <div class="sb-sidenav-menu-heading">Management</div>
                    <a class="nav-link" href="../admin/manage_users.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Manage Users
                    </a>
                    <a class="nav-link" href="../admin/manage_donations.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        Manage Donations
                    </a>
                    <a class="nav-link" href="../admin/reports.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                        Reports
                    </a>
                    <a class="nav-link" href="../admin/settings.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Settings
                    </a>
                <?php elseif ($user_role === 'donor') : ?>
                    <div class="sb-sidenav-menu-heading">Donor Panel</div>
                    <a class="nav-link" href="../donor/donate_food.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                        Donate Food
                    </a>
                    <a class="nav-link" href="../donor/view_requests.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                        View Requests
                    </a>
                    <a class="nav-link" href="../donor/donation_history.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Donation History
                    </a>
                    <a class="nav-link" href="../donor/awareness.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                        Awareness Tips
                    </a>
                <?php elseif ($user_role === 'receiver') : ?>
                    <div class="sb-sidenav-menu-heading">Receiver Panel</div>
                    <a class="nav-link" href="../receiver/request_food.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                        Request Food
                    </a>
                    <a class="nav-link" href="../receiver/view_donations.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        View Donations
                    </a>
                    <a class="nav-link" href="../receiver/request_history.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                        Request History
                    </a>
                    <a class="nav-link" href="../receiver/awareness.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                        Awareness Tips
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo ucfirst($user_role); ?>
        </div>
    </nav>
</div>