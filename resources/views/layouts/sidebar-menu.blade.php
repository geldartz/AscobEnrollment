<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>
      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-user nav-icon cyan "></i>
            <p>Accounts</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/students" class="nav-link">
            <i class="fa fa-users nav-icon yellow"></i>
            <p>Students</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/fee-management" class="nav-link">
            <i class="fa fa-credit-card nav-icon gold"></i>
            <p>Fee Management</p>
          </router-link>
        </li>
      @endcan

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-tasks green"></i>
          <p>
            Scholarship
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/scholarships" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                  Management
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/scholarship-maintenance" class="nav-link">
              <i class="nav-icon fa fa-cog green"></i>
              <p>
                  Settings
              </p>
            </router-link>
          </li>
         
     
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-book orange"></i>
          <p>
            Report
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/statement-of-account" class="nav-link">
              <i class="nav-icon fa fa-bookmark orange"></i>
              <p>
                Statement of Account
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/fees-to-date" class="nav-link">
              <i class="nav-icon fa fa-bookmark orange"></i>
              <p>
                Fees to Date
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/end-of-day-report" class="nav-link">
              <i class="nav-icon fa fa-bookmark orange"></i>
              <p>
                End of Day Report
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/custom-report" class="nav-link">
              <i class="nav-icon fa fa-bookmark orange"></i>
              <p>
                Custom Report
              </p>
            </router-link>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <router-link to="/settings" class="nav-link">
          <i class="nav-icon fa fa-cogs red"></i>
          <p>
            System Maintenance
          </p>
        </router-link>
      </li>
     

      @endcan
      
    </ul>
  </nav>