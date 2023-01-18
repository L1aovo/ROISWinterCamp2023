FROM python:3.8

# Install Flask and other dependencies
RUN pip install flask -i https://mirrors.aliyun.com/pypi/simple/

# Copy the app code into the container
COPY . /app
WORKDIR /app

# Run the app
CMD ["python3", "app.py"]
