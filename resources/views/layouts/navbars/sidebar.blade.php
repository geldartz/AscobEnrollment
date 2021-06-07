@can('isAdmin')
<div class="sidebar">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="#" class="simple-text logo-mini">
     <img src="{{ asset('images/logo.png') }}" class=img-fluid alt="">
    </a>
    <a href="http://www.creative-tim.com" class="simple-text logo-normal">
     ENROLLMENT SYSTEM
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li>
        <a data-toggle="collapse" href="#laravelExamples">
            <i class="now-ui-icons users_circle-08"></i>
          <p>
            {{ __("Student Management") }}
            <b class="caret"></b>
          </p>
        </a>
          <div class="collapse" id="laravelExamples">
            <ul class="nav">
              <li >
                <router-link  to="/student-management">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Management</p>
                </router-link>
              </li>
              <li class="">
                <router-link to="/student-requirements">
                  <i class="now-ui-icons design_bullet-list-67"></i>
                  <p> {{ __("Student Requirements") }} </p>
                </router-link>
              </li>
              <li class="">
                <router-link to="/online-applications">
                  <i class="now-ui-icons design_bullet-list-67"></i>
                  <p> {{ __("Online Application") }} </p>
                </router-link>
              </li>
            </ul>
          </div>
      </li> 
      <li>
        <a data-toggle="collapse" href="#subject">
            <i class="now-ui-icons education_agenda-bookmark"></i>
          <p>
            {{ __("Subject") }}
            <b class="caret"></b>
          </p>
        </a>
          <div class="collapse" id="subject">
            <ul class="nav">
              <li class="">
                <router-link  to="/subject-maintenance">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Subject Maintenance</p>
                </router-link>
              </li>
              <li class="">
                <router-link  to="/subject-scheduling">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Subject Scheduling</p>
                </router-link>
              </li>
            </ul>
          </div>
      </li> 
      <li class="">
        <router-link  to="/users">
            <i class="fa fa-users"></i>
            <p>Manage Accounts</p>
        </router-link>
      </li>
      <li class="">
        <router-link  to="/maintenance">
            <i class="now-ui-icons loader_gear"></i>
            <p>Settings</p>
        </router-link>
      </li>
   
    </ul>
  </div>
</div>


<nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <div class="navbar-toggle">
        <button type="button" class="navbar-toggler">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>
    <a class="navbar-brand" href="#pablo"></a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <form>
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Search...">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="now-ui-icons ui-1_zoom-bold"></i>
            </div>
          </div>
        </div>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="now-ui-icons users_single-02"></i>
            <p>
              <span class="d-lg-none d-md-block">Account</span>
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">My Profile</a>
            <a class="dropdown-item" href="#">Edit Profile</a>
            <router-link class="dropdown-item" to="/logout"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </router-link>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
@endcan

@can('isUser')
 
@endcan