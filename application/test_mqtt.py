import subprocess, time

def main() :
    ip = '172.20.10.8'
    topic = 'Rocky'
    for i in range(5000) :
        msg = f'{i}:helloha'
        subprocess.Popen(f"mosquitto_pub -h {ip} -t {topic} -m {msg}", stdout=subprocess.PIPE, shell=True)
        time.sleep(0.12)

main()
