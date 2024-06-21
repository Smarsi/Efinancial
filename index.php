<?php
  include("session.php");
  // $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");
  $exp_category_dc = mysqli_query($con, "SELECT category_name FROM categories;");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense_value) FROM expenses WHERE id_user = '$userid' GROUP BY expense_category");

  $exp_date_line = mysqli_query($con, "SELECT made_in_dt FROM expenses WHERE id_user = '$userid' GROUP BY made_in_dt;");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense_value) FROM expenses WHERE id_user = '$userid' GROUP BY made_in_dt");

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Efinancial - Home</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }

    .feather-big-positive {
      stroke: #32a800!important;
      width: 50px;
      height: 50px;
    }

    .feather-big-negative {
      stroke: #dc3545!important;
      width: 50px;
      height: 50px;
    }
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Menu lateral -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Gerenciamento</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Home</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus"></span> Adicionar Gastos</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Gerenciar Gastos</a>
        <a href="add_revenue.php" class="list-group-item list-group-item-action "><span data-feather="plus"></span> Adicionar Receita</a>
        <a href="manage_revenue.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Gerenciar Receitas</a>
      </div>
      <div class="sidebar-heading">Configurações</div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Perfil</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="log-out"></span> Sair</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Página Principal -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Sair</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <h3 class="mt-4">Acesso Rápido</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col text-center">
                    <a href="add_expense.php"><i data-feather="plus" class="feather-big-negative" stroke="red"></i>
                      <p>Adicionar Gastos</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="manage_expense.php"><i data-feather="dollar-sign" stroke="red" class="feather-big-negative"></i>
                      <p>Gerenciar Gastos</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="add_revenue.php"><i data-feather="plus" class="feather-big-positive"></i>
                      <p>Adicionar Receita</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="manage_revenue.php"><i data-feather="dollar-sign" class="feather-big-positive"></i>
                      <p>Gerenciar Receitas</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="profile.php"><i data-feather="user" class="feather-big"></i>
                      <p>Perfil</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Cards de Gastos Consolidados -->

        <!-- <div class="container-fluid">
            <div class="row">
                <div class="card col text-center">
                    <div class="counter bg-danger" style="color:white;">
                        <p><i class="fas fa-tasks"></i></p>
                        <h3>
                            Today's Expenses
                        </h3>
                        <p style="font-size: 1.2em;">
                            <?php echo "teste 1" ?>
                        </p>
                    </div>
                </div>
                <div class="card col text-center">
                    <div class="counter bg-primary" style="color:white;">
                        <p><i class="fas fa-undo-alt"></i></p>
                        <h3>
                            Yesterday's Expenses
                        </h3>
                        <p style="font-size: 1.2em;">
                            <?php echo "teste2" ?>
                        </p>
                    </div>
                </div>
                <div class="card col text-center">
                    <div class="counter bg-warning" style="color:white;">
                        <p><i class="fas fa-calendar-week"></i></p>
                        <h3>
                            Last 7 day's Expenses
                        </h3>
                        <p style="font-size: 1.2em;">
                            <?php echo "teste3" ?>
                        </p>
                    </div>
                </div>
            </div>
          </div>
        </div> -->

        <h3 class="mt-4">Consolidado de Gastos</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Gastos Diários</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_line" height="150"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Gastos por Categoria</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_category_pie" height="150"></canvas>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  <script>
    feather.replace()
  </script>
  <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
                    echo '"' . $a['expensecategory'] . '",';
                  } ?>],
        datasets: [{
          label: 'Gastos por Categoria',
          data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                    echo '"' . $b['SUM(expense)'] . '",';
                  } ?>],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
            yAxes: [{
                ticks: {
                    min: 0
                }
            }]
        }
    }
    });

    var line = document.getElementById('expense_line').getContext('2d');
    var myChart = new Chart(line, {
      type: 'line',
      data: {
        labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                    echo '"' . $c['expensedate'] . '",';
                  } ?>],
        datasets: [{
          label: 'Gastos por Mês (Ano)',
          data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                    echo '"' . $d['SUM(expense)'] . '",';
                  } ?>],
          borderColor: [
            '#adb5bd'
          ],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          fill: false,
          borderWidth: 2
        }]
      },
      options: {
        scales: {
            yAxes: [{
                ticks: {
                    min: 0
                }
            }]
        }
    }
    });
  </script>
</body>

</html>