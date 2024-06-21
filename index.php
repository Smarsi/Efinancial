<?php
  include("session.php");
  $labels_per_categorie_result = mysqli_query($con, "select c.category_name from expenses e, categories c WHERE e.expense_category = c.id_category and MONTH(e.made_in_dt) = MONTH(current_date()) and e.id_user = 1 group by e.expense_category;");
  $values_per_categorie_result = mysqli_query($con, "select SUM(e.expense_value) as expenses_names from expenses e, categories c WHERE e.expense_category = c.id_category and MONTH(e.made_in_dt) = MONTH(current_date()) and e.id_user = 1 group by e.expense_category;");

  while ($row = mysqli_fetch_assoc($labels_per_categorie_result)) {
      $labels_per_categorie[] = $row['category_name'];
  }

  while ($row = mysqli_fetch_assoc($values_per_categorie_result)) {
    $values_per_categorie[] = floatval($row['expenses_names']); // Converter para float se necessário
  }

  print_r($labels_per_categorie);
  print_r($values_per_categorie);

  $labels_per_day_result = mysqli_query($con, "SELECT DAY(made_in_dt) as e_day FROM expenses WHERE MONTH(made_in_dt) = MONTH(current_date()) AND id_user = $userid GROUP BY made_in_dt;");
  $values_per_day_result = mysqli_query($con, "SELECT SUM(expense_value) as e_value FROM expenses WHERE MONTH(made_in_dt) = MONTH(current_date()) AND id_user = $userid GROUP BY made_in_dt;");
 
  while ($row = mysqli_fetch_assoc($labels_per_day_result)) {
    $labels_per_day[] = $row['e_day'];
  }

  while ($row = mysqli_fetch_assoc($values_per_day_result)) {
    $values_per_day[] = $row['e_value'];
  }

  print_r($labels_per_day);
  print_r($values_per_day);

  $total_revenues_query = mysqli_query($con, "select sum(revenue_value) as total_revenues from revenues where MONTH(made_in_dt) = MONTH(CURRENT_DATE) AND YEAR(made_in_dt) = YEAR(CURRENT_DATE) AND id_user = $userid;");
  if ($total_revenues_query) {
    $total_revenues_row = mysqli_fetch_assoc($total_revenues_query);
    $total_revenues = $total_revenues_row['total_revenues'];
  } else {
    $total_revenues = "0.00";
  }
    
  $total_expenses_query = mysqli_query($con, "select sum(expense_value) as total_expenses from expenses where MONTH(made_in_dt) = MONTH(CURRENT_DATE) AND YEAR(made_in_dt) = YEAR(CURRENT_DATE) AND id_user = $userid;");
  if ($total_expenses_query) {
    $total_expenses_row = mysqli_fetch_assoc($total_expenses_query);
    $total_expenses = $total_expenses_row['total_expenses'];
  } else {
      $total_expenses = "0.00";
  }

  $balance = floatval($total_revenues) - floatval($total_expenses);

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartist/dist/chartist.min.js"></script>
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

        <div class="container-fluid">
            <div class="row">
              <div class="card col text-center">
                <div class="counter bg-success" style="color:white;">
                  <p><i class="fas fa-undo-alt"></i></p>
                    <h3>
                      Receitas deste mês
                    </h3>
                    <p style="font-size: 1.2em;">
                      <?php echo "R$ $total_revenues" ?>
                    </p>
                </div>
              </div>
              <div class="card col text-center">
                <div class="counter bg-danger" style="color:white;">
                  <p><i class="fas fa-tasks"></i></p>
                  <h3>
                    Despesas deste mês
                  </h3>
                  <p style="font-size: 1.2em;">
                      <?php echo "R$ $total_expenses" ?>
                  </p>
                </div>
              </div>
              <div class="card col text-center">
                <div class="counter <?php if ($balance > 0){echo "bg-success";} else{echo "bg-danger";} ?>" style="color:white;">
                  <p><i class="fas fa-calendar-week"></i></p>
                  <h3>
                    Balanço deste mês
                  </h3>
                  <p style="font-size: 1.2em;">
                    <?php echo "R$ $balance" ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="mt-4">Consolidado de Gastos</h3>
        <!-- <div class="row">
          <div class="col-md">
            <legend><b>Selecione o mês</b></legend>
          </div>
          <div class="col-md">
            <select class="form-select" name="range" aria-label="range" id="range" required></select>
          </div>
        </div> -->
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
    function generateRandomColors(numColors) {
      var colors = [];
      for (var i = 0; i < numColors; i++) {
          var color = '#' + Math.floor(Math.random() * 16777215).toString(16); // Gerar cor hexadecimal aleatória
          colors.push(color);
      }
      return colors;
    }

    // CATEGORY EXPENSES CHART
    var category_used_colors = generateRandomColors(<?php echo count($labels_per_categorie); ?>);
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    console.log(ctx);
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($labels_per_categorie); ?>,
        datasets: [{
          label: 'Gastos por Categoria',
          data: <?php echo json_encode($values_per_categorie); ?>,
          backgroundColor: category_used_colors,
          borderWidth: 6
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
    // CATEGORY EXPENSES CHART ENDS HERE

    // DAILY EXPENSES CHART
    var category_used_colors = generateRandomColors(<?php echo count($labels_per_categorie); ?>);
    var ctx = document.getElementById('expense_line').getContext('2d');
    console.log(ctx);
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($labels_per_day); ?>,
        datasets: [{
          label: 'Gastos por Dia',
          data: <?php echo json_encode($values_per_day); ?>,
          backgroundColor: category_used_colors,
          borderWidth: 6
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
    // DAILY EXPENSES CHART ENDS HERE
  </script>
</body>

</html>