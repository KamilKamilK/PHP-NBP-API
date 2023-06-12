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