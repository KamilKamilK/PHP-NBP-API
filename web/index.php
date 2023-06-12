<?php
declare(strict_types=1);

use Controller\CurrencyController;
use Service\CurrencyService;

require "/srv/www/vendor/autoload.php";

include __DIR__ . '/Client/NbpClient.php';
include __DIR__ . '/Repository/CurrencyRepository.php';
include __DIR__ . '/Service/CurrencyService.php';
include __DIR__ . '/Controller/CurrencyController.php';

include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navigation_bar.php';

$path = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$currencyService = new CurrencyService();
$currencyController = new CurrencyController($currencyService);

if ($path === '/' && $method === 'GET') {
    $rates = $currencyController->index();

} elseif ($path === '/update' && $method === 'POST') {
    $rates = $currencyController->update();

} elseif ($path === '/exchange' && $method === 'POST') {
    $exchangeResult = $currencyController->exchange();
} else {
    http_response_code(404);
    echo "404 - Page not found";
}

?>
<div class="container">
    <?php include 'includes/exchangeForm.php'; ?>

    <?php if (isset($exchangeResult)): ?>
        Exchange Result: <h3><?php echo $exchangeResult['convertedAmount'] ?></h3>
        <?php include 'includes/converseTable.php'; ?>
    <?php else: ?>
    <?php include 'includes/exchangeRatesTable.php'; ?>

</div>

<?php endif ?>

<div class="col-xs-6">
    <form action="/update" method="POST">
        <button type="submit" class="btn btn-primary">Update table</button>
    </form>
</div>
<?php
include('includes/footer.php');
?>
