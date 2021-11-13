from http.server import BaseHTTPRequestHandler, HTTPServer
import logging
import os
import json

class Server(BaseHTTPRequestHandler):
    def do_HEAD(self):
        self.send_response(200)
        self.send_header('Content-type', 'text/html')
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Access-Control-Allow-Headers', 'Content-Type,Authorization')
        self.send_header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
        self.end_headers()

    def do_GET(self):
        paths = {
            '/ok': {'status': 200}, # return data of success
            '/no': {'status': 203}, # return data of invalid
            '/all': {'status': 206}, # return all of data
            '/get': {'status': 305}, # retuen the ones of data
            '/': {'status': 401} # verify that the server is running
        }

        if self.path in paths:
            self.respond(paths[self.path])
        else:
            self.respond({'status': 502})
        #logging.info("GET request,\nPath: %s\nHeaders:\n%s\n", str(self.path), str(self.headers))
        #self.wfile.write("GET request for {}".format(self.path).encode('utf-8'))

    def do_POST(self):
        content_length = int(self.headers['Content-Length']) # <--- Gets the size of data
        post_data = self.rfile.read(content_length) # <--- Gets the data itself

        # logging.info("POST request,\nPath: %s\nHeaders:\n%s\n\nBody:\n%s\n",
        #      str(self.path), str(self.headers), post_data.decode('utf-8'))

        filename = "user.json"
        with open(filename,"a+") as f:
            f.seek(0,0) # move the cursor to the beginning of the file
            content = f.read()
            if content=='':
                dict = []
                dict.append(json.loads(post_data.decode('utf-8')))
                json.dump(dict,f)
            else:
                dict = list(eval(content))
                dict.append(json.loads(post_data.decode('utf-8')))
                f.seek(0)
                f.truncate()
                json.dump(dict,f)
                    
        res = "POST request data was successfully written to the file"

        self.do_HEAD()
        # self.wfile.write("POST request for {}".format(self.path).encode('utf-8'))
        self.wfile.write("{}".format(res).encode('utf-8'))
        # self.wfile.write("POST request for {ASS}".format(data).encode('utf-8'))
        
    def respond(self, opts):
        filename = "user.json"
        with open(filename,"r") as fr:
            dict = json.loads(fr.read())
        if opts['status'] == 200:
            for d in dict:
                if d['state']=='OK':
                    response = self.handle_http(opts['status'], d['data'])
                    self.wfile.write(response)
        elif opts['status'] == 203:
            for d in dict:
                if d['state']=='NO':
                    response = self.handle_http(opts['status'], d['data'])
                    self.wfile.write(response)
        elif opts['status'] == 206:
            for d in dict:
                response = self.handle_http(opts['status'], d['data'])
                self.wfile.write(response)
        elif opts['status'] == 305:
            for d in dict:
                response = self.handle_http(opts['status'], d['data'])
                self.wfile.write(response)
        else: 
            response = self.handle_http(opts['status'], self.path)
            self.wfile.write(response)

    def handle_http(self, code, data):
        self.send_response(code)
        self.send_header('Content-type', 'text/html')
        self.end_headers()
        content = '''{key} => {value} \n'''.format(**{"key": code, "value":data})
        return bytes(content, 'UTF-8')


def run(server_class=HTTPServer, handler_class=Server, port=8080):
    print("Server is start running in {} port...".format(port))
    logging.basicConfig(level=logging.INFO)
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    logging.info('Httpd is started...\n')
    try:
        httpd.serve_forever()
    except KeyboardInterrupt:
        pass
    httpd.server_close()
    print("Server required to close")
    logging.info('Httpd is over...\n')


if __name__ == '__main__':
    from sys import argv

    if len(argv) == 2:
        run(port=int(argv[1]))
    else:
        run()
