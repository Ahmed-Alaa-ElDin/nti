<style>
p {
    font-weight: bold;
}
</style>
<div style="text-align: center;">
<form method="get">
    <input type="number" name="age">
    <button type="submit">Can I Vote !!</button>
</form>
<?php
if ($_GET['age']) {
    if ($_GET['age'] >= 18) {
?>
        <p style="color: green;"> Yes you can vote :) </p>
    <?php
    } else {
    ?>
        <p style="color: red"> Sorry you can't vote </p>
<?php
    }
}
?>
</div>
