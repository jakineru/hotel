<?php
require_once 'includes/init.php';

$error = "";
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
    
require_once 'includes/header.php';
?>

<main>
<h1>habitaciones disponibles</h1>

<?php if (!empty($error)): ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<div class="habitaciones-list">
    <?php foreach ($_SESSION['habitaciones'] as $hab): ?>

        <?php if ($hab['estado'] == 'disponible'): ?>

            <div class="card">
                <img src="<?php echo $hab['imagen']; ?>" alt="foto" class="img-hab">
                <h2>> Habitación <?php echo $hab['numero']; ?> (<?php echo $hab['tipo']; ?>)</h2>
                <p><?php echo $hab['descripcion']; ?></p>
                <p>precio: $<?php echo $hab['precio']; ?> | capacidad: <?php echo $hab['capacidad']; ?> pers.</p>

                <form action="reservar.php" method="POST">
                    <input type="hidden" name="numero_hab" value="<?php echo $hab['numero']; ?>">
                    <input type="date" max="2028-01-01" min="<?php echo date('Y-m-d', strtotime('today')); ?>" name="fecha_in" required>
                    <input type="date" max="2028-01-01" min="<?php echo date('Y-m-d', strtotime('today')); ?>" name="fecha_out" required>
                    <button type="submit">reservar</button>
                </form>

            </div>

        <?php endif; ?>
    <?php endforeach; ?>
</div>
</main>
<?php require_once 'includes/footer.php'; ?>