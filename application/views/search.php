<html>
    <br/>
    <?php
	echo "<table border = '2'>";
	echo "<tr><td colspan = '6'>搜索</td></tr>";
	echo "<tr><td>編號</td><td>姓名</td><td>性別</td><td>生日</td></tr>";
	foreach ($member as $value) {
	    echo "<tr>";
	    echo "<td>";
	    echo $value['id'];
	    echo "</td>";
	    echo "<td>";
	    echo $value['name'];
	    echo "</td>";
	    echo "<td>";
	    echo $value['sex'];
	    echo "</td>";
	    echo "<td>";
	    echo $value['birth'];
	    echo "</td>";
	    echo "</tr>";
	}
	echo "</table>";
    ?>
</html>
