<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="Logo Image">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard"><i class="fa fa-home"></i><span>Dashboard</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-database"></i><span>Masters</span>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="parliaments">View Parliaments/Assemblies</a></li>
            <li><a class="dropdown-item" href="#">View Municipalities/Wards</a></li>
            <li><a class="dropdown-item" href="#">Add Parliament</a></li>
            <li><a class="dropdown-item" href="/assemblies/create">Add Assembly</a></li>
            <li><a class="dropdown-item" href="/states">View States</a></li>
            <li><a class="dropdown-item" href="/states/create">Add State</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view-surveys"><i class="fa fa-list-ul"></i><span>Survey List</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view-employees"><i class="fa fa-users"></i><span>Employees</span></a>
        </li>

      </ul>
      <span class="navbar-text">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://www.tutorialrepublic.com/examples/images/avatar/3.jpg" class="avatar" alt="Avatar"> <Name> <b class="caret"></b>
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="profile"><i class="fa fa-user-o"></i> Profile</a></li>
            <li><a class="dropdown-item" href="change-password"><i class="fa fa-key"></i> Change Password</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa fa-sliders"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout"><i class="material-icons">&#xE8AC;</i>Logout</a></li>
          </ul>
        </li>
      </span>

    </div>
  </div>
</nav>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">




