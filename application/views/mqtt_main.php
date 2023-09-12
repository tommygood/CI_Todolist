<html>
    <input type = 'text' id = 'pass_mqtt_msg'></input>
    <button id = 'send_mqtt_bt'>send_mqtt</button>
    <button id = 'get_mqtt_bt'>get_mqtt</button>
    <button id = 'reset_bt'>reset</button>
    <div id = 'mqtt_data_pos'></div>
    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js' ></script>
    <script>
        document.getElementById('send_mqtt_bt').addEventListener('click', postMqttData);
        document.getElementById('get_mqtt_bt').addEventListener('click', getMqttData);
        document.getElementById('reset_bt').addEventListener('click', resetData);

        function getId(id) {
	        return document.getElementById(id);
        }

        async function postMqttData() {
	        var test = new FormData();
	        var pass_data = getId('pass_mqtt_msg').value;
	        test.append('a', pass_data);
            var mqtt_msg = await axios.post('/test/sendMqtt', test);
            /*if (mqtt_msg.data != '\n') {
                getId('mqtt_data_pos').innerHTML += count_total + '：' + mqtt_msg.data + '<br/>';
                count_total += 1;
            }*/
        }

        var count_total = 0; // 總共有幾筆資料
        async function getMqttData() { // call 從 mqtt server 抓資料的 api
            var mqtt_msg = await axios.get('/test/getMqtt');
            if (mqtt_msg.data != '\n') {
                getId('mqtt_data_pos').innerHTML += count_total + '：' + mqtt_msg.data + '<br/>';
                count_total += 1;
            }
        }

        async function getDataLoop() {
            while (true) {
                await getMqttData();
            } 
            //window.setInterval(getMqttData, 0.1);
        }

        // loop to get the data from mqtt
        getDataLoop();

        function resetData() {
            count_total = 0;
            getId('mqtt_data_pos').innerHTML = '';
        }
    </script>
</html>

