<div class="sidebar" data-color="orange" data-background-color="black" data-image="{{ asset('img/sidebar-2.jpg')  }}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            Loans Manager
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ ($LOCAL === 'dashboard')?'active':'' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ ($LOCAL === 'alerts')?'active':'' }}">
                <a class="nav-link" href="{{ route('alerts') }}">
                    <i class="material-icons">notifications</i>
                    <p>Alerts</p>
                </a>
            </li>
            <li class="nav-item {{ ($LOCAL === 'contacts')?'active':'' }}">
                <a class="nav-link" href="{{ route('contacts') }}">
                    <i class="material-icons">group</i>
                    <p>Contacts</p>
                </a>
            </li>
            <li class="nav-item {{ ($LOCAL === 'tasks')?'active':'' }}">
                <a class="nav-link" href="{{ route('tasks') }}">
                    <i class="material-icons">list</i>
                    <p>Tasks</p>
                </a>
            </li>
        </ul>
    </div>
</div>