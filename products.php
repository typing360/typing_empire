<?php
require_once 'conn.php';

// Kuhifadhi bidhaa mpya
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    mysqli_query($conn, "INSERT INTO products (name, price, quantity)
                         VALUES ('$name', '$price', '$quantity')");

    header("Location: products.php");
    exit();
}

// Kufuta bidhaa
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    header("Location: products.php");
    exit();
}

// Kuchukua taarifa za bidhaa inayohaririwa
$edit_product = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $edit_product = mysqli_fetch_assoc($result);
}

// Kuhifadhi mabadiliko ya bidhaa
if (isset($_POST['update_product'])) {
    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    mysqli_query($conn, "UPDATE products
                         SET name = '$name',
                             price = '$price',
                             quantity = '$quantity'
                         WHERE id = $id");

    header("Location: products.php");
    exit();
}

// Kuonyesha bidhaa zote
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TYPING EMPIRE | Products</title>

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <span class="navbar-text ml-3">TYPING EMPIRE</span>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <span class="brand-text font-weight-light ml-3">
                TYPING EMPIRE
            </span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="products.php" class="nav-link active">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Products</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="services.php" class="nav-link">
                            <i class="nav-icon fas fa-print"></i>
                            <p>Services</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="sales.php" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Sales</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="service_orders.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Service Orders</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1>Products Management</h1>
                <p>Manage your stationery products.</p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <!-- Fomu ya kuongeza au kuhariri bidhaa -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?>
                        </h3>
                    </div>

                    <form method="POST" action="products.php">
                        <div class="card-body">

                            <?php if ($edit_product) { ?>
                                <input type="hidden" name="id"
                                       value="<?php echo $edit_product['id']; ?>">
                            <?php } ?>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($edit_product['name'] ?? ''); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Price (TSh)</label>
                                <input type="number" name="price"
                                       class="form-control"
                                       min="0" step="0.01"
                                       value="<?php echo htmlspecialchars($edit_product['price'] ?? ''); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity"
                                       class="form-control"
                                       min="0"
                                       value="<?php echo htmlspecialchars($edit_product['quantity'] ?? ''); ?>"
                                       required>
                            </div>

                        </div>

                        <div class="card-footer">
                            <?php if ($edit_product) { ?>
                                <button type="submit" name="update_product"
                                        class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Product
                                </button>

                                <a href="products.php" class="btn btn-secondary">
                                    Cancel
                                </a>
                            <?php } else { ?>
                                <button type="submit" name="add_product"
                                        class="btn btn-info">
                                    <i class="fas fa-plus"></i> Add Product
                                </button>
                            <?php } ?>
                        </div>
                    </form>
                </div>

                <!-- Jedwali la bidhaa -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products List</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Price (TSh)</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($products)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>

                                        <td>
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </td>

                                        <td>
                                            <?php echo number_format($row['price']); ?>
                                        </td>

                                        <td><?php echo $row['quantity']; ?></td>

                                        <td>
                                            <a href="products.php?view=<?php echo $row['id']; ?>"
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            <a href="products.php?edit=<?php echo $row['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <a href="products.php?delete=<?php echo $row['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to delete this product?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                // Kuonyesha maelezo ya bidhaa
                if (isset($_GET['view'])) {
                    $id = (int) $_GET['view'];

                    $result_view = mysqli_query(
                        $conn,
                        "SELECT * FROM products WHERE id = $id"
                    );

                    $view_product = mysqli_fetch_assoc($result_view);

                    if ($view_product) {
                ?>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Product Details</h3>
                        </div>

                        <div class="card-body">
                            <p><strong>ID:</strong>
                                <?php echo $view_product['id']; ?></p>

                            <p><strong>Name:</strong>
                                <?php echo htmlspecialchars($view_product['name']); ?></p>

                            <p><strong>Price:</strong>
                                TSh <?php echo number_format($view_product['price']); ?></p>

                            <p><strong>Quantity:</strong>
                                <?php echo $view_product['quantity']; ?></p>

                            <a href="products.php" class="btn btn-secondary">
                                Close
                            </a>
                        </div>
                    </div>
                <?php
                    }
                }
                ?>

            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>TYPING EMPIRE</strong> | Stationery Management System
    </footer>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>