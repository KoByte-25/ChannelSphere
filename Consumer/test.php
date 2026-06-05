<form action="" method="post">
    <select name="chooseOp">
        <option value="A">A</option>
    </select>
    <button type="submit" name="subBtn">Submit</button>
</form>

<?php
    if(isset($_POST["subBtn"]))
        {
            echo $_POST["chooseOp"];
        }
?>