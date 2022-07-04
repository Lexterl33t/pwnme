#!/usr/bin/env python3
# coding: utf-8
import requests
import os
from flask import Flask, render_template_string, render_template, request
import jinja2

app = Flask(__name__, template_folder='./')

BOT_TOKEN_PWNME = "OTgzMDAxMTEyMzAwOTAwMzgz.GNY07s.3FDEC5wzzUIXNUzwm-JPUYrsshZqFvSSKIwyB8"
CLIENT_ID = "983001112300900383"


def get_username(id):
    response = requests.get(
        f"https://discordapp.com/api/v9/users/{id}", headers={"Authorization": f'Bot {BOT_TOKEN_PWNME}'})
    return response.json()['username']


# def sanitize(value):
#     blacklist = []
#     # ['self', 'eval', 'class', "config", 'FLAG',"token", ".", "__main__", "url_for", "request"]

#     for word in blacklist:
#         if word in value:
#             value = value.replace(word, '')
#     if any([bool(w in value) for w in blacklist]):
#         value = sanitize(value)
#     return value


@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method != 'POST' or 'server' not in request.form.keys():
        return render_template('index.html', client_id=CLIENT_ID)
    server_id = request.form['server']
    try:
        response = requests.get(
            f"https://discordapp.com/api/v9/guilds/{server_id}", headers={"Authorization": f'Bot {BOT_TOKEN_PWNME}'})
        owner_name = get_username(response.json()['owner_id'])
        owner_id = response.json()['owner_id']
        server_name = response.json()['name']
        if len(server_name) > 20:
            server_name = server_name[0:20] + '...'
        try:
            server_description = response.json()['description']
            if not server_description:
                server_description = "This server doesn't have a description"
        except:
            server_description = "This server doesn't have a description"
        server_region = response.json()['region']
        if response.json()['icon'] is not None:
            server_icon = f"https://cdn.discordapp.com/icons/{server_id}/"+response.json()[
                'icon']
        else:
            server_icon = "This server doesn't have an icon"
        template = f'''
        <br>
        <ul>
        <h5>Information for the server {server_id} :</h5>
        <li>Server Name : {server_name}</li>
        <li>Owner Name : {owner_name}</li>
        <li>Owner Id : {owner_id}</li>
        <li>Description : {server_description}</li> 
        <li>Region : {server_region}</li>  
        <li>Icon : {server_icon}</li>
        </ul>
        '''
        results = render_template_string(template)
        return render_template('index.html', results=results, client_id=CLIENT_ID)
    except jinja2.exceptions.TemplateSyntaxError as e:
        error = '''
            <br>
            <div class='alert alert-danger' role='alert'>
                We've detected weird inputs in response
            </div>
        '''
        return render_template('index.html', error=error, client_id=CLIENT_ID)
    except Exception:
        error = f'''
            <br>
            <div class='alert alert-danger' role='alert'>
                Error while getting server informations
            </div>
        '''
        return render_template('index.html', error=error, client_id=CLIENT_ID)


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=8083, threaded=False)
