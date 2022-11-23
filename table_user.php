<?php
ob_start();
require "connect_db.php";

session_start();
if (isset($_SESSION['login'])) {
} else {
  die("Can't Access, please <a href='login.php'>Login here</a>");
}

if (isset($_SESSION['login']) && ($_SESSION['role'] == 'Dosen')) {
  die("Can't Access, please <a href='../index.php'>Back here</a>");
}

$sql2 = "SELECT * FROM user where email = '$_SESSION[login]'";
$result2 = mysqli_query($conn, $sql2);

$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) { ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SB Admin - Tables</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/b5701f3c0c.js" crossorigin="anonymous"></script>


    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  </head>

  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="index.html">Start Bootstrap</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
              <img src="images/<?= $row['photo'] ?>" alt="" width="32px" height="32px" class="rounded-circle me-2">
              <strong>&nbsp;<?= $row['name'] ?></strong>
            <?php } ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="register.php">Register</a>
            <a class="dropdown-item" href="updatedata_users.php?email=<?= $_SESSION['login'] ?>">Change Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
    </nav>

    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="admin_panel.php">
            <i class="fa-solid fa-gauge"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- Session Admin -->
        <?php
        if ($_SESSION['role'] == 'Admin') {
        ?>
          <!-- Data Mahasiswa -->
          <li class="nav-item">
            <a class="nav-link" href="table_mahasiswa.php">
              <i class="fa-solid fa-users"></i>
              <span>Mahasiswa</span>
            </a>
          </li>

          <!-- Data Presensi -->
          <li class="nav-item">
            <a class="nav-link" href="table_presensi.php">
              <i class="fa-solid fa-table"></i>
              <span>Presensi</span>
            </a>
          </li>

          <!-- Data User -->
          <li class="nav-item active">
            <a class="nav-link" href="table_user.php">
              <i class="fa-solid fa-user"></i>
              <span>Users</span>
            </a>
          </li>
        <?php
        }
        ?>

        <!-- Session Dosen -->
        <?php
        if ($_SESSION['role'] == 'Dosen') {
        ?>
          <!-- Data Mahasiswa -->
          <li class="nav-item">
            <a class="nav-link" href="table_mahasiswa.php">
              <i class="fa-solid fa-users"></i>
              <span>Mahasiswa</span>
            </a>
          </li>

          <!-- Data Presensi -->
          <li class="nav-item">
            <a class="nav-link" href="table_presensi.php">
              <i class="fa-solid fa-table"></i>
              <span>Presensi</span>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Users</a>
            </li>
            <li class="breadcrumb-item active">Table Users</li>
          </ol>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              Users Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <th>Fullname</th>
                      <th>Role</th>
                      <th>Date Created</th>
                      <th>Date Modified</th>
                      <?php if ($_SESSION['role'] == 'Admin') { ?>
                        <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Email</th>
                      <th>Fullname</th>
                      <th>Role</th>
                      <th>Date Created</th>
                      <th>Date Modified</th>
                      <?php if ($_SESSION['role'] == 'Admin') { ?>
                        <th>Action</th>
                      <?php } ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                      <tr>
                        <td><?= $row["email"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["role"] ?></td>
                        <td><?= $row["date_created"] ?></td>
                        <td><?= $row["date_modified"] ?></td>
                        <?php if ($_SESSION['role'] == 'Admin') { ?>
                          <td style="text-align: center"><a href='edit_user.php?email=<?= $row['email'] ?>'><i class="fa-solid fa-pen-to-square"></i></a> |
                            <a onclick="return confirm ('Want to Delete ?') " href='delete_user.php?email=<?= $row['email'] ?>'><i class="fa-solid fa-trash"></i></a>
                          </td>
                        <?php } ?>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer small text-muted">
              Updated yesterday at 11:59 PM
            </div>
          </div>

          <p class="small text-center text-muted my-5">
            <em>More table examples coming soon...</em>
          </p>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2019</span>
            </div>
          </div>
        </footer>
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">
              Cancel
            </button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
  </body>

  </html>

<?php
} else {
  echo "0 results";
}
mysqli_close($conn);
?>