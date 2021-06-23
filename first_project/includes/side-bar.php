<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="/nti/first_project/theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item m-auto text-center"><a class="navbar-brand" href="home.html"><img class="brand-logo" alt="Chameleon admin logo" src="/nti/first_project/theme-assets/images/logo/logo.png" />
                    <h3 class="brand-text">Courses<span class="text-danger">4</span><span class="text-primary">U</span></h3>
                </a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a href="/nti/first_project/teacher/"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
            </li>
            <li class="nav-item"><a href="/nti/first_project/student/"><i class="ft-home"></i><span class="menu-title" data-i18n="">Home</span></a>
            </li>
            <li class="nav-item has-sub <?= isset($addTeacher) || isset($allTeachers) ? 'open' : '' ?>"><a href="#"><i class="ft-grid"></i><span class="menu-title" data-i18n="">Teachers</span></a>
                <ul class="menu-content">
                    <li class="<?= isset($addTeacher) ? 'active' : '' ?>">
                        <a class="menu-item" href="/nti/first_project/teacher/add.php"><i class="ft-plus"></i>&nbsp; Add New Teacher</a>
                    </li>
                    <li class="<?= isset($allTeachers) ? 'active' : '' ?>">
                        <a class="menu-item" href="/nti/first_project/teacher/all.php"><i class="ft-eye"></i>&nbsp; Show All Teachers</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="navigation-background"></div>
</div>