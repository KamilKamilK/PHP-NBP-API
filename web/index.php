<?php
declare(strict_types=1);

use Service\CurrencyService;

require "/srv/www/vendor/autoload.php";

include __DIR__ . '/Client/NbpClient.php';
include __DIR__ . '/Repository/CurrencyRepository.php';
include __DIR__ . '/Service/CurrencyService.php';
include __DIR__ . '/Controller/CurrencyController.php';

include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navigation_bar.php';

$currencyService = new CurrencyService();
$rates = $currencyService->handleRequest();

$exchangeResult = $rates['converses'] ?? null;
$rates = $rates['rates'] ?? null;

$httpResponseCode = http_response_code();

if ($httpResponseCode !== 200) {
    $currencyService->handleNotFoundResponse();
}
?>

<div class="container">
    <?php include 'includes/exchangeForm.php'; ?>

    <?php if (isset($exchangeResult)): ?>
        Exchange Result: <h3><?php echo $exchangeResult['convertedAmount'] ?></h3>
        <?php include 'includes/converseTable.php'; ?>
    <?php else: ?>
        <?php include 'includes/exchangeRatesTable.php'; ?>
    <?php endif ?>


    <div class="col-xs-6">
        <form action="/update" method="POST">
            <button type="submit" class="btn btn-primary">Update table</button>
        </form>
    </div>

</div>
<?php
include('includes/footer.php');
?>
