    <?php
    if (count($errors) > 0) {
        foreach ($errors as $key => $err) {
            echo "<p class='text-white bg-danger p-3 w-50 m-auto border border-2 mb-2' onclick='this.remove()' >$err</p>";
        }
    }
    ?>