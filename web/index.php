<?php
declare(strict_types=1);

use Controller\CurrencyController;
use Service\CurrencyService;

require "/srv/www/vendor/autoload.php";

include __DIR__ . '/Client/NbpClient.php';
include __DIR__ . '/Repository/CurrencyRepository.php';

include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navigation_bar.php';
include 'Service/CurrencyService.php';
include __DIR__ . '/Controller/CurrencyController.php';

$path = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];


$currencyService = new CurrencyService();
$currencyController = new CurrencyController($currencyService);

//var_dump($path, $method);
if ($path === '/' && $method === 'GET') {
    $rates = $currencyController->index();

} elseif ($path === '/update' && $method === 'POST') {

    $rates = $currencyController->store();
} elseif ($path === '/exchange' && $method === 'POST') {
    $exchangeResult = $currencyController->exchange();
} else {
    http_response_code(404);
    echo "404 - Page not found";
}
?>
<?php if (!http_response_code(404)): ?>
    <div class="container">
    <form method="post" action="/exchange">
        <label for="amount">Kwota:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>

        <label for="source_currency">Source currency:</label>
        <select id="source_currency" name="source_code" required>
            <?php foreach ($rates as $rate): ?>
                <option value="<?php echo $rate['currency_code'] ?>"><?php echo $rate['currency_code'] ?></option>
            <?php endforeach; ?>
        </select>


        <label for="target_currency">Target currency:</label>
        <select id="target_currency" name="target_code" required>
            <?php foreach ($rates as $rate): ?>
                <option value="<?php echo $rate['currency_code'] ?>"><?php echo $rate['currency_code'] ?></option>
            <?php endforeach; ?>
        </select>


        <input type="submit" class="btn btn-primary" value="Przelicz">
    </form>
    <?php if (isset($exchangeResult)): ?>
        Exchange Result: <h3><?php echo $exchangeResult['convertedAmount'] ?></h3>
    <?php endif ?>

    <?php if (isset($exchangeResult['conversions'])): ?>
        <div class="col-xs-6">
            <div class='table-responsive'>
                <table id='myTable' class='table table-striped table-bordered'>
                    <tr>
                        <th>id</th>
                        <th>Source code</th>
                        <th>Target code</th>
                        <th>Amount</th>
                        <th>Converted amount</th>
                        <th>Created at</th>
                    </tr>

                    <?php foreach ($exchangeResult['conversions'] as $conversion): ?>
                        <tr>
                            <td><?php echo $conversion['id']; ?></td>
                            <td><?php echo $conversion['source_code']; ?></td>
                            <td><?php echo $conversion['target_code']; ?></td>
                            <td><?php echo $conversion['amount']; ?></td>
                            <td><?php echo $conversion['converted_amount']; ?></td>
                            <td><?php echo $conversion['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    <?php else: ?>

        <div class="col-xs-6">
            <div class='table-responsive'>
                <table id='myTable' class='table table-striped table-bordered'>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Currency code</th>
                        <th>Exchange rate</th>
                    </tr>
                    <?php foreach ($rates as $rate): ?>
                        <tr>
                            <td><?php echo $rate['id']; ?></td>
                            <td><?php echo $rate['currency_name']; ?></td>
                            <td><?php echo $rate['currency_code']; ?></td>
                            <td><?php echo $rate['exchange_rate']; ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
        </div>

        <div class="col-xs-6">
            <form action="/update" method="POST">
                <button type="submit" class="btn btn-primary">Update table</button>
            </form>
        </div>

    <?php endif ?>
<?php endif ?>
<?php
include('includes/footer.php');
?>
