<?php
    include_once("../constants.php");
?>

<html>
<head> <title>Demo Online Book Catalog</title> </head>
<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1> Demo Book Catalog</h1>
</td> </tr>

<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=test user=postgres password=@42cNa4h")
    or die('Could not connect: ' . pg_last_error());
?>

<tr>
<td style="background-color:#eeeeee;">
<form>
        Title: <input type="text" name="Title" id="Title">

        <select name="Language"> <option value="">Select Language</option> </select>

        <input type="radio" name="Format" id="Format1" value="hardcover">hardcover
        <input type="radio" name="Format" id="Format2" value="paperback">paperback

        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php if(isset($_GET['formSubmit'])) 
{
	$query = 'SELECT DISTINCT language FROM book';
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());


	echo "<b>SQL: </b>".$query."<br><br>";
	
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
  } 
	
	pg_free_result($result);
}
?>
</td> </tr>
<?php
pg_close($dbconn);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>

</body>
</html>
