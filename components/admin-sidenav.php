<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'dashboard') {
                    echo "active";
                } ?>" aria-current="page" href="admin-dashboard.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase pt-3">
            <span>Locations</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!-- <span data-feather="plus-circle" class="align-text-bottom"></span> -->
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'locations') {
                    echo "active";
                } ?>" href="locations-listing.php">
                    <span data-feather="map-pin" class="align-text-bottom"></span>
                    Locations Listing
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase pt-3">
            <span>Property Types</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!-- <span data-feather="plus-circle" class="align-text-bottom"></span> -->
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'types') {
                    echo "active";
                } ?>" href="property-types-listing.php">
                    <span data-feather="list" class="align-text-bottom"></span>
                    Property Types Listing
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase pt-3">
            <span>Properties</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!-- <span data-feather="plus-circle" class="align-text-bottom"></span> -->
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'create-property') {
                    echo "active";
                } ?>" href="create-property.php">
                    <span data-feather="file-plus" class="align-text-bottom"></span>
                    Create a new Property
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'property-listing') {
                    echo "active";
                } ?>" href="listing-admin.php">
                    <span data-feather="list" class="align-text-bottom"></span>
                    Property Listing
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase pt-3">
            <span>Schedules Visits</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!-- <span data-feather="plus-circle" class="align-text-bottom"></span> -->
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'scheduled-visits') {
                    echo "active";
                } ?>" href="scheduled-visits-admin.php">
                    <span data-feather="user-check" class="align-text-bottom"></span>
                    Scheduled Visits
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase pt-3">
            <span>Regisrered Users</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!-- <span data-feather="plus-circle" class="align-text-bottom"></span> -->
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'users') {
                    echo "active";
                } ?>" href="users-listing.php">
                    <span data-feather="user" class="align-text-bottom"></span>
                    Normal Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'managers') {
                    echo "active";
                } ?>" href="managers-listing.php">
                    <span data-feather="command" class="align-text-bottom"></span>
                    Property Managers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($_SESSION["page"] == 'admins') {
                    echo "active";
                } ?>" href="admins-listing.php">
                    <span data-feather="terminal" class="align-text-bottom"></span>
                    Platform Administrators
                </a>
            </li>
        </ul>
        <ul class="nav flex-column pt-3">
            <li class="nav-item">
                <a class="nav-link" href="./auth/logout.php">
                    <span data-feather="log-out" class="align-text-bottom"></span>
                    Logout
                </a>
            </li>
        </ul>

    </div>
</nav>