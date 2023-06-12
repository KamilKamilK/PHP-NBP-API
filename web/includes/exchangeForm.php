<form method="post" action="/exchange">
    <label for="amount">Kwota:</label>
    <input type="number" id="amount" name="amount" step="0.01" required>

    <label for="source_currency">Source currency:</label>
    <select id="source_currency" name="source_code" required>
        <?php
        $rates = $rates ?? $currencyController->index();

        foreach ($rates as $rate): ?>
            <option value="<?php echo $rate['currency_code'] ?>"><?php echo $rate['currency_code'] ?></option>
        <?php endforeach; ?>
    </select>


    <label for="target_currency">Target currency:</label>
    <select id="target_currency" name="target_code" required>
        <?php foreach ($rates as $rate): ?>
            <option value="<?php echo $rate['currency_code'] ?>"><?php echo $rate['currency_code'] ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" class="btn btn-primary" value="Converse">
</form>