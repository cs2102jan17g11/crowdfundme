<html>
<?php
    include_once("../env.php");
    include_once("../headers.php");
?>

<head>
    <title>Online Projects Catalog</title>
</head>

<body>
<table>
<tr>
    <td colspan="2" style="background-color:#FFA500;">
        <h1>Demo Book Catalog</h1>
    </td>
</tr>

<?php
$dbconn = pg_connect(pg_connect_string)
    or die('Could not connect: ' . pg_last_error());
?>

<tr>
    <td style="background-color:#eeeeee;">
        <form>
                Title: <input type="text" name="Title" id="Title">

                <select name="Language"> <option value="">Select Language</option>
                <?php
                $query = 'SELECT DISTINCT language FROM book';
                $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                 
                while ($row = pg_fetch_row($result)){
                  echo "<option value=\"".$row[0]."\">".$row[0]."</option><br>";
                }
                pg_free_result($result);
                ?>
                </select>

                <input type="radio" name="Format" id="Format1" value="hardcover">hardcover
                <input type="radio" name="Format" id="Format2" value="paperback">paperback

                <input type="submit" name="formSubmit" value="Search" >
        </form>
    </td>
</tr>
<?php
pg_close($dbconn);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>

</body>
</html>
