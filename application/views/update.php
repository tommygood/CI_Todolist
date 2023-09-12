<html>
    <?php 
        $this->load->library('form_validation');
	echo validation_errors();?>
    <?php echo form_open('http://127.0.0.1/data/update_data');?>
    <?php
	echo "<input type = 'hidden' name = 'user_id' value = '{$user_id}'>";
	echo "<table border = '2'>";
	echo "<tr><td colspan = '6'>更新</td></tr>";
	echo "<tr><td>編號</td><td>姓名</td><td>性別</td><td>生日</td></tr>";
	    echo "<tr>";
	    echo "<td>";
	    echo $user_id;
	    echo "</td>";
	    echo "<td>";
	    echo "<input type = 'text' name = 'name'>";
	    echo "</td>";
	    echo "<td>";
	    echo "<input type = 'text' name = 'sex'>";
	    echo "</td>";
	    echo "<td>";
	    echo "<input type = 'text' name = 'birth'>";
	    echo "</td>";
	    echo "<td>";
	    echo "<input type = 'submit' name = 'submit' value = 'update'>";
	    echo "</td>";
	    echo "</tr>";
	echo "</table>";
    ?>
    <style>
        td {
            text-align : center;
	}
    </style>
</html>
