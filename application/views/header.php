<html>
    <?php 
        $this->load->library('form_validation');
	echo validation_errors();?>
    <?php echo form_open('http://127.0.0.1/data/create');?>
    <head>
        <h1>todolist</h1>
	<input type = 'hidden' name = 'detail_id' id = 'detail_id'></input>
	<input type = 'hidden' name = 'delete_id' id = 'delete_id'></input>
	<input type = 'hidden' name = 'update_id' id = 'update_id'></input>
	<table border = '2' id = 'tab'>
	    <tr>代辦清單</tr>
	    <tr>
		<td>細項</td>
	        <td>id</td> 
		<td>name</td>
		<td>sex</td>
	    </tr>
	    <?php 
	    foreach ($member as $key=>$item) {
	        echo "<tr>";
	        echo "<td>{$item["id"]}</td> <td>{$item["name"]}</td> <td>{$item['sex']}</td>";
		echo "<td><input onclick = 'insertDetail({$item['id']})' type = 'submit' name = 'submit' value = 'detail'></input></td>";
		echo "<td><input onclick = 'insertDelete({$item['id']})' type = 'submit' name = 'submit' value = 'delete'></input></td>";
	        echo "</tr>";
	    }
	    ?>
	</table>
	<!-- table page -->
	<ul class="nav nav-tabs" id="myTab" role="tablist">
	</ul>
	<div id = 'tab_pos_title' class = 'position-relative'></div>
	<div id = 'tab_pos' class = 'position-relative'></div>
	<nav aria-label="Page navigation example" class = 'position-absolute bottom-0' id = "page_top">
	</nav>
	    <table border = '2'>
	        <tr><td colspan = '4'>新增事項</td></tr>
		<tr>
		    <td>姓名</td>
		    <td>性別</td>
		    <td>生日</td>
		</tr>
		<tr>
	            <td><input type = "input" name = "name"></input></td>
	            <td><input type = "input" name = "sex"></input></td>
	    	    <td><input type = "input" name = "birth"></input></td>
	    	    <td><input type = "submit" name = "submit" value = 'add'></input></td>
		</tr>
	    </table>
	    <div>搜尋事項</div>
	    <input type = "input" name = "search_id" id = 'search_id'></input>
	    <input type = "submit" name = "submit" value = 'search'></input>
	</div>
    </head>
    <style>
    a {
        color : #f33;
       -webkit-user-select:none;
       -moz-user-select:none;
        user-select:none;
        text-align : center;
    }

    #page_last {
       width : 105px;
    }

    #page_next {
        width : 105px;
    }

    #last_page {
        width : 80px;
    }

    #first_page {
        width : 80px;
    }

    #page_top {
        left : 30%
    }

    td {
        text-align : center;
    }
    </style>
    <script>
        function insertDetail(detail_id) {
	    document.getElementById('detail_id').value = parseInt(detail_id);
        }
    </script>
    <script>
	var a = `<?php echo $member;?>`;
	function getDataLen() {
	    var data_len = `
	    <?php 
	    $total = 0;
	    foreach ($member as $item) {
	        $total += 1;
	    }
	    echo $total;
	    ?>
	    `
	    return parseInt(data_len);
        }

	function getData() {
	    var data_content = `
	    <?php 
	    foreach ($member as $item) {
	        echo "$,$";
	        echo $item['id'];
	        echo '-.-';
	        echo $item['name'];
	        echo '-.-';
	        echo $item['sex'];
	        echo "$,$";
	        //echo implode(" ",$item);
	        //print_r(array_keys($item));
	    }
	    ?>
	    `
	    data_content = data_content.replaceAll("\n", "");
	    data_content = data_content.replaceAll("\t", "");
	    data_content = data_content.split('$,$');
	    var clean_data = [];
	    for (let i = 1;i < data_content.length-1;i++) {
	        data_content[i] = data_content[i].split('-.-');
		if (i % 2 != 0) {
		    clean_data.push(data_content[i]);
		}
	    }
	    return clean_data;
	}
	

	function lessTime(times) { // 把時間弄得好看一點
        if (times == null) // 如果還沒有時間
            return null;
        var new_time = '';
        for (let i = 0;i < times.length-5;i++) { // 不要後面五個字元
            if (times[i] == 'T') { // 把 T 換掉
                new_time += '\n';
                continue;
            }
            new_time += times[i];
        }
        return new_time;
    }

    function getId(id) {
        return document.getElementById(id);
    }

    // make page
    let now_page = 0; // 現在的頁數

    async function putRecord(page) {
	const data_content = getData(); // get data
        var count_records = 0; // 總共有幾個可以放的紀錄, 不包含看完的
        var count_added_records = 0; // 真正放了幾個紀錄進 table
        total_len = 0; // when reset table, reset the total_len too
        getId("tab").innerHTML = ""; // 每次重新點, 都清空 table
        await tabTitle(); // 製作 tab title
        // 把各個批次的藥分開
        for (let i = 0;i < data_content.length;i++) {
                //console.log(med_inventory_each[i]);
            count_records++; // 計算總共有加了幾筆紀錄
            if (count_records <= (page-1) * limit_records) // 還沒到可以放進去的 index
                continue; // 重找
            if (count_added_records >= limit_records) // 真正放進去的紀錄不能超過限制的次數
                break; // 停止
            count_added_records++; // 真正放進去的次數
            tab.innerHTML += "<tr id = 'each_row'" + i + "/><td/>" + data_content[i][0] + 
            "<td>" + data_content[i][1] + "</td>" +
            "<td>" + data_content[i][2] + "</td>" +
	    "<td><input type = 'submit' class = 'detail'  name = 'submit' value = 'detail' id = '" + data_content[i][0] + "'></input></td>" +
	    "<td><input type = 'submit' class = 'delete'  name = 'submit' value = 'delete' id = '" + data_content[i][0] + "'></input></td>" +
	    "<td><input type = 'submit' class = 'update'  name = 'submit' value = 'update' id = '" + data_content[i][0] + "'></input></td></tr>";
        }
	const all_detail_bt = document.getElementsByClassName('detail');
	for (let i = 0;i < all_detail_bt.length;i++) {
	    all_detail_bt[i].addEventListener('click', submitDetail);
	}
	const all_delete_bt = document.getElementsByClassName('delete');
	for (let i = 0;i < all_delete_bt.length;i++) {
	    all_delete_bt[i].addEventListener('click', submitDelete);
	}
	const all_update_bt = document.getElementsByClassName('update');
	for (let i = 0;i < all_update_bt.length;i++) {
	    all_update_bt[i].addEventListener('click', submitUpdate);
	}
    }

    var total_len = 0;
    let limit_records = 2; // 頁面能顯示最大的列數量

    async function tabTitle() { // 製作 table title
        //const {data : user} = await axios.get('/viewPa/nId');
        getId('tab').innerHTML = 
        "<tr><td colspan = '7'>人員</td></tr><tr><td>編號</td><td>姓名</td><td>性別</td><td>細項</td><td>刪除</td><td>更新</td></tr>"; 
    }

    function mkPage(page_num) { // make page with page_num
        if (getId('page_list')) // if page_list exist, renew one
            getId("page_list").remove(); // remove
        // 如果總頁數 < 一行限制最大頁數，一行限制最大頁數 = 總頁數
        var temp_max_col_page = total_page_num < max_col_page ? total_page_num : max_col_page; 
        // create and add the needed elements
        var page_list_element = document.createElement("ul");
        page_list_element.className = "pagination";
        page_list_element.setAttribute("id", "page_list");
        var page_top = getId("page_top");
        page_top.appendChild(page_list_element);
        var page_list = getId('page_list');
        var page_list = getId('page_list');
        if (page_num >= temp_max_col_page) { // 一行最大只能 10 頁
            page_num = temp_max_col_page + parseInt(now_page);
        }
        if (page_num >= total_page_num) { // 不能超過最大頁數
            page_num = total_page_num;
        }
        if (now_page > total_page_num-temp_max_col_page) {
            // 總共的頁數不能低於 10 ，所以當現在頁數 < 總頁數-10，開始的頁數還是要保持在總頁數 -10
            start_page = total_page_num-temp_max_col_page;
        }
        else { // 開始頁數 = 現在頁數
            start_page = now_page;
        }
        // 製作元素

        // 上一頁的元素
        var page_li= document.createElement("li");
        page_li.className = "page-item";
        var page_a = document.createElement("a");
        page_a.className = "page-link";
        page_a.setAttribute("id", "page_last");
        page_a.innerHTML = '上一頁'; // start from page 1
        page_li.appendChild(page_a);
        page_list.appendChild(page_li);

        // 首頁的元素
        var page_li= document.createElement("li");
        page_li.className = "page-item";
        var page_a = document.createElement("a");
        page_a.className = "page-link";
        page_a.setAttribute("id", "first_page");
        page_a.innerHTML = '首頁'; // start from page 1
        page_li.appendChild(page_a);
        page_list.appendChild(page_li);

        for (let i = start_page;i < page_num;i++) { // make page with page num
            var page_li= document.createElement("li");
            page_li.className = "page-item";
            var page_a = document.createElement("a");
            page_a.className = "page-link";
            page_a.setAttribute("id", "page_"+(i+1));
            if (i == now_page) { // 目前的頁數要用黑色字體
                page_a.style.color = 'black';
            }
            page_a.style.width = '50px';
            page_a.innerHTML = (parseInt(i)+1); // start from page 1
            page_li.appendChild(page_a);
            page_list.appendChild(page_li);
        }
        // 尾頁的元素
        var page_li= document.createElement("li");
        page_li.className = "page-item";
        var page_a = document.createElement("a");
        page_a.className = "page-link";
        page_a.setAttribute("id", "last_page");
        page_a.innerHTML = '尾頁'; // start from page 1
        page_li.appendChild(page_a);
        page_list.appendChild(page_li);

        // 下一頁
        var page_li= document.createElement("li");
        page_li.className = "page-item";
        var page_a = document.createElement("a");
        page_a.className = "page-link";
        page_a.setAttribute("id", "page_next");
        page_a.innerHTML = '下一頁'; // start from page 1
        page_li.appendChild(page_a);
        page_list.appendChild(page_li);
    }

    let start_page; // 開始的頁數
    let max_col_page = 10; // 一行最多可以有幾個頁數
    function mkPageListener(page_num) { // 依照 page 的數量監聽
        // 如果總頁數 < 一行限制最大頁數，一行限制最大頁數 = 總頁數
        var temp_max_col_page = total_page_num < max_col_page ? total_page_num : max_col_page; 
        mkPage(page_num); // 製作頁面按鈕
        if (page_num >= temp_max_col_page) { // 最大只能 15 頁
            page_num = temp_max_col_page + parseInt(now_page);;
        }
        if (page_num >= total_page_num) {
            page_num = total_page_num;
        }
        getId('page_last').addEventListener('click', turnPage);
        getId('page_next').addEventListener('click', turnPage);
        getId('last_page').addEventListener('click', turnPage);
        getId('first_page').addEventListener('click', turnPage);
        for (let i = parseInt(start_page)+1;i < page_num+1;i++) // 從第一頁開始監聽
            getId('page_'+i).addEventListener('click', turnPage); // put records in table depend on page num
    }

    function turnPage(e) { // 翻頁
        if (e.target.innerHTML == "上一頁") {
            // 不能讓上一頁到 -1
            if (now_page < 1) {
                now_page = 0;
            }
            else {
                now_page -= 1;
            }
        }
        else if (e.target.innerHTML == "下一頁") {
            if (now_page+1 < total_page_num) { // 下一頁不能超過最後一頁
                now_page += 1;
            }
        }
        else if (e.target.innerHTML == "首頁") {
            now_page = 0;
        }
        else if (e.target.innerHTML == "尾頁") {
            now_page = total_page_num-1;
        }
        else { // 現在頁數 = 案的頁數-1
            now_page = parseInt(e.target.innerHTML)-1;
        }
        mkPageListener(total_page_num); // 重新製作頁面按鈕、監聽
        putRecord(now_page+1); // 把紀錄放進 table, 現在是第幾個 table, 第幾頁
    };

    let total_page_num;
    async function mkDoc(e) { // 製作醫生 table
        //now_page = 0;
        if (e == 'first') {
            var tab_id = 1;
        }
        else {
            var tab_id = getDid(e.target.id); // 取得 dId
        }
        now_table = tab_id;
        //mkTable(tab_id); // 製作該 id 的 table
        putRecord(tab_id);
	var page_num_result = getDataLen();	
	total_page_num = countPageNum(page_num_result); // total_page_num = all records/limit_records
        mkPageListener(total_page_num); // make listener of page list 
    }

    function countPageNum(page_num_result) { // count page num
        let page_num = Math.floor(page_num_result/limit_records); // without float
        let page_less = page_num_result%limit_records; 
        if (page_less != 0) // is float
            page_num += 1; // add one more page
        return page_num;
    }

    mkDoc('first');

	    var data_content = `
	    <?php 
	    foreach ($member as $item) {
	        echo $item['id'];
	        echo $item['name'];
	        //echo implode(" ",$item);
	        //print_r(array_keys($item));
	    }
	    ?>
	    `
	    data_content = data_content.replaceAll("\n", "");
	    data_content = data_content.replaceAll("\t", "");

	function submitDetail(e) {
	    var bt_id = e.target.id;
	    document.getElementById('detail_id').value = parseInt(bt_id);
	}

	function submitDelete(e) {
	    var bt_id = e.target.id;
	    document.getElementById('delete_id').value = parseInt(bt_id);
	}

	function submitUpdate(e) {
	    var bt_id = e.target.id;
	    document.getElementById('update_id').value = parseInt(bt_id);
	}
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

</html>
