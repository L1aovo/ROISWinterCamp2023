from flask import Flask, request, render_template, render_template_string
from waitress import serve

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    try:
        if request.method == 'GET':
            return render_template("index.html", request_method="GET")
        elif request.method == 'POST':
            username = request.form.get("username")
            password = request.form.get("password")
            print(username)

            if username == "" or password == "":
                return render_template("index.html", request_method="GET")
            else:
                # Just for websec learning, do not use render_template_string in production environment
                return render_template("index.html", request_method="POST", name=render_template_string(username))
    except:
        return render_template("index.html", request_method="GET")

if __name__ == '__main__':
    serve(app, host="0.0.0.0", port=5000, threads=1000, cleanup_interval=30)