#!/usr/bin/python3
from flask import Flask, jsonify, make_response, request

app = Flask(__name__)


@app.route('/')
def index():
    # Set the Content-Type header to application/json
    response = make_response(jsonify({"message": "Hello, FZUers!"}))
    response.headers['Content-Type'] = 'application/json'
    if request.headers.get('User-Agent') == 'ROIS_browser':
        response.headers['flag'] = 'ROIS{I_Can_Use_Burpsuite_Skillfully~~~~~~}'
    else:
        response.headers['flag'] = 'I can only give you flag with the browser of `ROIS_browser`'
    return response


if "__main__" == __name__:
    app.run(host="0.0.0.0", port=5000)
