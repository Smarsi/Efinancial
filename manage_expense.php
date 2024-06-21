<?php
include("session.php");
$exp_fetched = mysqli_query($con, "select e.*, c.category_name from expenses e, categories c where e.expense_category = c.id_category AND e.id_user = $userid;");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Efinancial - Gerenciar Gastos</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>

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
        <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Home</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus"></span> Adicionar Gastos</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="dollar-sign"></span> Gerenciar Gastos</a>
      </div>
      <div class="sidebar-heading">Configurações</div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Perfil</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="log-out"></span> Sair</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
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
                <h3 class="mt-4 text-center">Gerenciar Gastos</h3>
                <hr>
                <div class="row justify-content-center">

                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Categoria</th>
                                    <th colspan="2">Ação</th>
                                </tr>
                            </thead>

                            <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $row['made_in_dt']; ?></td>
                                    <td><?php echo 'R$ '.$row['expense_value']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td class="text-center">
                                        <a href="add_expense.php?edit=<?php echo $row['id_expense']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Editar</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="add_expense.php?delete=<?php echo $row['id_expense']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Deletar</a>
                                    </td>
                                </tr>
                            <?php $count++; } ?>
                        </table>
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

</body>

</html>