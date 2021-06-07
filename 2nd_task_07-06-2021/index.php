<!-- Styling -->
<style>
    table {
        border: 5px solid #d35400;
        border-radius: 10px;
        box-shadow:         7px 7px 5px 0px rgba(50, 50, 50, 0.75);
    }

    td {
        display: inline-block;
        height: 55px;
        width: 55px;
        border: 0;
    }

    .white {
        background-color: white;
    }

    .black {
        background-color: black;
    }
</style>

<!-- start::table -->
<table>
    <?php

    // Variables declaration
    $white = '<td class="white"></td>';
    $black = '<td class="black"></td>';


    for ($i = 0; $i < 8; $i++) {
        if ($i % 2 == 0) {
            echo "<tr>";
            for ($x = 0; $x < 8; $x++) {
                if ($x % 2 == 0) {
                    echo $white;
                } else {
                    echo $black;
                }
            }
            echo "</tr>";
        } else {
            echo "<tr>";
            for ($x = 0; $x < 8; $x++) {
                if ($x % 2 == 0) {
                    echo $black;
                } else {
                    echo $white;
                }
            }
            echo "</tr>";
        }
    }
    ?>

</table>
<!-- end::table -->