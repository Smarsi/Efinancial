<?php
include("session.php");
$update = false;
$alreadySelectedOption = null;
$category_name = null;
$disabled = false;
$cat_options = ["revenue", "expense"];  
if (isset($_POST['add'])) {
    $category_name = $_POST['category_name'];
    $category_type = $_POST['category_type'];

    print_r($category_name);
    print_r($category_type);

    $category = "INSERT INTO categories (category_name, category_type, created_at_ts, id_user) VALUES ('$category_name', '$category_type', current_timestamp(), $userid)";
    $result = mysqli_query($con, $category) or die("Something Went Wrong!");
    header('location: add_category.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['update'];
    $category_name = $_POST['category_name'];
    $sql = "UPDATE categories SET category_name='$category_name' where id_user='$userid' AND id_category='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_categories.php');
}

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM categories WHERE id_user='$userid' AND id_category=$id");
    $disabled = true;
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $category_name = $n['category_name'];
        $category_type = $n['category_type'];
        $alreadySelectedOption = $category_type;
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Efinancial - Adicionar Categoria</title>

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
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Home</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus"></span> Adicionar Gastos</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Gerenciar Gastos</a>
        <a href="add_revenue.php" class="list-group-item list-group-item-action "><span data-feather="plus"></span> Adicionar Receita</a>
        <a href="manage_revenue.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Gerenciar Receitas</a>
        <a href="manage_categories.php" class="list-group-item list-group-item-action "><span data-feather="settings"></span> Minhas Categorias</a>  
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

            <div class="container">
                <h3 class="mt-4 text-center">Adicionar Categoria</h3>
                <hr>
                <div class="row ">

                    <div class="col-md-3"></div>

                    <div class="col-md" style="margin:0 auto;">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="category_name" class="col-sm-6 col-form-label"><b>Nome</b></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control col-sm-12" value="<?php if($category_name){echo $category_name;} ?>" id="category_name" name="category_name" required>
                                </div>
                            </div>
                            <div class="form-group row">                                
                                    <legend class="col-form-label col-sm-6 pt-0"><b>Tipo</b></legend>
                                    <div class="col-md">
                                        <select <?php if($disabled){echo "disabled";} ?> class="form-select" name="category_type" aria-label="category_type" id="category_type" required>
                                            <option <?php if(!$alreadySelectedOption){echo "selected";} ?>>-- Selecione o tipo --</option>
                                            <option value="revenue" <?php if($alreadySelectedOption == "revenue"){echo "selected";} ?>>Receita</option>
                                            <option value="expense" <?php if($alreadySelectedOption == "expense"){echo "selected";} ?>>Despesa</option>
                                        </select>
                                    </div>                              
                                </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-primary" style="border-radius: 0%;" type="submit" name="update">Atualizar</button>
                                    <?php else : ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-primary" style="border-radius: 0%;">Adicionar Categoria</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3"></div>
                    
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
        feather.replace();
    </script>
    <script>

    </script>
</body>
</html>