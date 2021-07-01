<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="/nti/first_project/theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item m-auto text-center"><a class="navbar-brand" href="/nti/first_project/"><img class="brand-logo" alt="Chameleon admin logo" src="/nti/first_project/theme-assets/images/logo/logo.png" />
                    <h3 class="brand-text">Courses<span class="text-danger">4</span><span class="text-primary">U</span></h3>
                </a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            ?>
                <li class="nav-item"><a href="/nti/first_project/teacher/"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
            <?php } ?>

            <?php if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            ?>
                <li class="nav-item"><a href="/nti/first_project/"><i class="ft-home"></i><span class="menu-title" data-i18n="">Home</span></a>
                </li>
                <li class="nav-item"><a href="/nti/first_project/student/courses/all.php"><i class="ft-home"></i><span class="menu-title" data-i18n="">All Courses</span></a>
                </li>
            <?php
            } ?>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            ?>
                <!-- Teachers -->
                <li class="nav-item has-sub <?= isset($addTeacher) || isset($allTeachers) ? 'open' : '' ?>"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="">Teachers</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addTeacher) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/teacher/add.php"><i class="ft-plus"></i>&nbsp; Add New Teacher</a>
                        </li>
                        <li class="<?= isset($allTeachers) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/teacher/all.php"><i class="ft-eye"></i>&nbsp; Show All Teachers</a>
                        </li>
                    </ul>
                </li>

                <!-- Students -->
                <li class="nav-item has-sub <?= isset($addStudent) || isset($allStudents) ? 'open' : '' ?>"><a href="#"><i class="ft-user"></i><span class="menu-title" data-i18n="">Students</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addStudent) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/student/add.php"><i class="ft-plus"></i>&nbsp; Add New Student</a>
                        </li>
                        <li class="<?= isset($allStudents) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/student/all.php"><i class="ft-eye"></i>&nbsp; Show All Students</a>
                        </li>
                    </ul>
                </li>

                <!-- Countries -->
                <li class="nav-item has-sub <?= isset($addCountry) || isset($allCountries) ? 'open' : '' ?>"><a href="#"><i class="ft-globe"></i><span class="menu-title" data-i18n="">Countries</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addCountry) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/country/add.php"><i class="ft-plus"></i>&nbsp; Add New Country</a>
                        </li>
                        <li class="<?= isset($allCountries) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/country/all.php"><i class="ft-eye"></i>&nbsp; Show All Countries</a>
                        </li>
                    </ul>
                </li>

                <!-- Cities -->
                <li class="nav-item has-sub <?= isset($addCity) || isset($allCities) ? 'open' : '' ?>"><a href="#"><i class="ft-map-pin"></i><span class="menu-title" data-i18n="">Cities</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addCity) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/city/add.php"><i class="ft-plus"></i>&nbsp; Add New City</a>
                        </li>
                        <li class="<?= isset($allCities) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/city/all.php"><i class="ft-eye"></i>&nbsp; Show All Cities</a>
                        </li>
                    </ul>
                </li>

                <!-- Categories -->
                <li class="nav-item has-sub <?= isset($addCategory) || isset($allCategories) ? 'open' : '' ?>"><a href="#"><i class="ft-list"></i><span class="menu-title" data-i18n="">Categories</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addCategory) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/category/add.php"><i class="ft-plus"></i>&nbsp; Add New Category</a>
                        </li>
                        <li class="<?= isset($allCategories) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/category/all.php"><i class="ft-eye"></i>&nbsp; Show All Categories</a>
                        </li>
                    </ul>
                </li>

                <!-- Courses -->
                <li class="nav-item has-sub <?= isset($addCourse) || isset($allCourses) ? 'open' : '' ?>"><a href="#"><i class="ft-book"></i><span class="menu-title" data-i18n="">Courses</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addCourse) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/course/add.php"><i class="ft-plus"></i>&nbsp; Add New Course</a>
                        </li>
                        <li class="<?= isset($allCourses) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/course/all.php"><i class="ft-eye"></i>&nbsp; Show All Courses</a>
                        </li>
                    </ul>
                </li>

                <!-- Reviews -->
                <li class="nav-item has-sub <?= isset($addReview) || isset($allReviews) ? 'open' : '' ?>"><a href="#"><i class="ft-star"></i><span class="menu-title" data-i18n="">Reviews</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addReview) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/review/add.php"><i class="ft-plus"></i>&nbsp; Add New Review</a>
                        </li>
                        <li class="<?= isset($allReviews) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/review/all.php"><i class="ft-eye"></i>&nbsp; Show All Reviews</a>
                        </li>
                    </ul>
                </li>

                <!-- Subscriptions -->
                <li class="nav-item has-sub <?= isset($addSuscription) || isset($allSubscriptions) ? 'open' : '' ?>"><a href="#"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="">Subscriptions</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addSuscription) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/subscription/add.php"><i class="ft-plus"></i>&nbsp; Add New Subscription</a>
                        </li>
                        <li class="<?= isset($allSubscriptions) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/subscription/all.php"><i class="ft-eye"></i>&nbsp; Show All Subscriptions</a>
                        </li>
                    </ul>
                </li>

                <!-- Statuses -->
                <li class="nav-item has-sub <?= isset($addStatus) || isset($allStatuses) ? 'open' : '' ?>"><a href="#"><i class="ft-activity"></i><span class="menu-title" data-i18n="">Statuses</span></a>
                    <ul class="menu-content">
                        <li class="<?= isset($addStatus) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/status/add.php"><i class="ft-plus"></i>&nbsp; Add New Status</a>
                        </li>
                        <li class="<?= isset($allStatuses) ? 'active' : '' ?>">
                            <a class="menu-item" href="/nti/first_project/status/all.php"><i class="ft-eye"></i>&nbsp; Show All Statuses</a>
                        </li>
                    </ul>
                </li>
            <?php
            } ?>




        </ul>
    </div>
    <div class="navigation-background"></div>
</div>