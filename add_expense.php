<?php
include("session.php");
$update = false;
$del = false;
$disabled = false;
$expenseamount = "";
$expense_description="";
$expensedate = date("Y-m-d");
$expensecategory = "Outros";
$alreadySelectedOption = null;
$cat_options = [];
$optionsquery = "SELECT id_category, category_name FROM categories WHERE category_type = 'expense' AND id_user = $userid";
$options_q = mysqli_query($con, $optionsquery);
while($row = mysqli_fetch_assoc($options_q)){
    $cat_options[$row['id_category']] = $row['category_name'];
}
if (count($cat_options) == 0){
    $disabled = true;
}

function formatFinancialValue($value) {
    $value = trim($value);
    if (strpos($value, ',') !== false) {
        $value = str_replace(',', '.', $value);
    }
    return $value;
}

if (isset($_POST['add'])) {
    $expense_description = $_POST['expense_description'];
    $expenseamount = floatval($_POST['expenseamount']);
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    // $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory')";
    $expenses = "INSERT INTO expenses (expense_description, expense_value, made_in_dt, created_at_ts, expense_category, id_user) VALUES('$expense_description', $expenseamount, '$expensedate', current_timestamp(), $expensecategory, $userid)";
    $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
    header('location: add_expense.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $expense_description = $_POST['expense_description'];
    $expenseamount = $_POST['expenseamount'];
    $formated_amount = formatFinancialValue($expenseamount);
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "UPDATE expenses SET expense_value='$formated_amount', expense_description='$expense_description', made_in_dt='$expensedate', expense_category='$expensecategory' WHERE id_user='$userid' AND id_expense='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "DELETE FROM expenses WHERE id_user='$userid' AND id_expense='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE id_user='$userid' AND id_expense=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense_value'];
        $expense_description = $n['expense_description'];
        $expensedate = $n['made_in_dt'];
        $expensecategory = $n['expense_category'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE id_user='$userid' AND id_expense=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense_value'];
        $expense_description = $n['expense_description'];
        $expensedate = $n['made_in_dt'];
        $expensecategory = $n['expense_category'];
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

    <title>Efinancial - Adicionar Gasto</title>

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
                <h3 class="mt-4 text-center">Adicionar Gasto</h3>
                <hr>
                <div class="row ">
                    
                    <div class="col-md-3"></div>
                    
                    <div class="col-md" style="margin:0 auto;">
                    <?php if($disabled){echo '<div class="alert alert-danger" role="alert">Atenção: Você ainda não tem nenhuma categoria de despesa! <a href="manage_categories.php">Crie sua primeira categoria aqui</a></div>';} ?>
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="expenseamount" class="col-sm-6 col-form-label"><b>Valor (R$)</b></label>
                                <div class="col-md-6">
                                    <input type="decimal" class="form-control col-sm-12" value="<?php echo $expenseamount; ?>" id="expenseamount" name="expenseamount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expense_description" class="col-sm-6 col-form-label"><b>Descrição</b></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control col-sm-12" value="<?php echo $expense_description; ?>" id="expense_description" name="expense_description" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expensedate" class="col-sm-6 col-form-label"><b>Data</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo $expensedate; ?>" name="expensedate" id="expensedate" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="row">
                                    <legend class="col-form-label col-sm-6 pt-0"><b>Categoria</b></legend>
                                    <div class="col-md">
                                        <select class="form-select" name="expensecategory" aria-label="expensecategory" id="expensecategory" required>
                                            <option <?php if(!$alreadySelectedOption){echo "selected";} ?>>-- Selecione a categoria --</option>
                                            <?php
                                                foreach ($cat_options as $index => $category_name) {
                                                    $item_value = $index;
                                                    if($expensecategory == $item_value){
                                                        echo '<option selected value="' . $index . '" name="expensecategory">' . htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    } else{
                                                        echo '<option value="' . $index . '" name="expensecategory">' . htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Atualizar</button>
                                    <?php elseif ($del == true) : ?>
                                        <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Deletar</button>
                                    <?php else : ?>
                                        <button <?php if($disabled){echo "disabled";} ?> type="submit" name="add" class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;">Adicionar Gasto</button>
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