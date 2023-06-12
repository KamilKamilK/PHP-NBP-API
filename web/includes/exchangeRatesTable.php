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
