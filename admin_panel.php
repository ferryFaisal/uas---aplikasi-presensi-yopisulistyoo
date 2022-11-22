<?php
require 'connect_db.php';
session_start();

if (isset($_SESSION['login'])) {
} else {
  die("Can't Access, please <a href='login.php'>Login here</a>");
}

if (isset($_SESSION['login']) && ($_SESSION['role'] == 'Dosen')) {
  die("Can't Access, please <a href='admin_panel.php'>Back here</a>");
}

$sql = "SELECT * FROM user where email = '$_SESSION[login]'";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT * FROM presensi order by id DESC";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result) > 0) {

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SB Admin - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/b5701f3c0c.js" crossorigin="anonymous"></script>

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet" />


    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet" />
  </head>

  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="admin_panel.php">Start Bootstrap</a>

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
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
              <img src="images/<?= $row['photo'] ?>" alt="" width="32px" height="32px" class="rounded-circle me-2">
              <strong>&nbsp;<?= $row['name'] ?></strong>
            <?php } ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
              <a class="dropdown-item" href="register.php"><?= ['role'] ?></a>
            <?php } ?>
            <a class="dropdown-item" href="register.php">Register</a>
            <a class="dropdown-item" href="edit_user.php">Change Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
    </nav>

    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
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
          <li class="nav-item">
            <a class="nav-link" href="table_user.php">
              <i class="fa-solid fa-user"></i>
              <span>Users</span>
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
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
          <div class="row">
            <!-- Session Admin -->
            <?php
            if ($_SESSION['role'] == "Admin") {
            ?>

              <!-- Card Go To Presensi -->
              <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                  <div class="card-body">
                    <div class="card-body-icon">
                      <i class="fas fa-fw fa-list"></i>
                    </div>
                    <div class="mr-5">Form Presensi</div>
                  </div>

                  <a class="card-footer text-white clearfix small z-1" href="index.php">
                    <span class="float-left">Click here</span>
                    <span class="float-right">
                      <i class="fas fa-angle-right"></i>
                    </span>
                  </a>
                </div>
              </div>

              <!-- Card Mahasiswa -->
              <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                  <div class="card-body">
                    <div class="card-body-icon">
                      <i class="fas fa-fw fa-list"></i>
                    </div>
                    <div class="mr-5">Tables Mahasiswa</div>
                  </div>

                  <a class="card-footer text-white clearfix small z-1" href="table_mahasiswa.php">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                      <i class="fas fa-angle-right"></i>
                    </span>
                  </a>
                </div>
              </div>

              <!-- Card Presensi -->
              <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                  <div class="card-body">
                    <div class="card-body-icon">
                      <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">Tables Presensi</div>
                  </div>
                  <a class="card-footer text-white clearfix small z-1" href="table_presensi.php">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                      <i class="fas fa-angle-right"></i>
                    </span>
                  </a>
                </div>
              </div>

              <!-- Card Users -->
              <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                  <div class="card-body">
                    <div class="card-body-icon">
                      <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">Tables Users</div>
                  </div>
                  <a class="card-footer text-white clearfix small z-1" href="table_user.php">
                    <span class="float-left">View Details</span>
                    <span class="float-right">
                      <i class="fas fa-angle-right"></i>
                    </span>
                  </a>
                </div>
              </div>
            <?php
            }
            ?>
          </div>

          <div class="card-header">
            <i class="fas fa-table"></i>
            Users Table - Recent
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status Presensi</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status Presensi</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                    <tr>
                      <td><?= $row["tgl_presensi"] ?></td>
                      <td><?= $row["makul"] ?></td>
                      <td><?= $row["kelas"] ?></td>
                      <td><?= $row["nim"] ?></td>
                      <td><?= $row["nama"] ?></td>
                      <td><?= $row["status_presensi"] ?></td>
                      <td style="text-align: center"><a href='edit_presensi.php'><i class="fa-solid fa-pen-to-square"></i></a> |
                        <a onclick="return confirm ('Want to Delete ?') " href='delete_presensi.php'><i class="fa-solid fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>



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
      <script src="vendor/chart.js/Chart.min.js"></script>
      <script src="vendor/datatables/jquery.dataTables.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin.min.js"></script>

      <!-- Demo scripts for this page-->
      <script src="js/demo/datatables-demo.js"></script>
      <script src="js/demo/chart-area-demo.js"></script>
  </body>

  </html>

<?php
} else {
  echo "0 results";
}
mysqli_close($conn);
?>