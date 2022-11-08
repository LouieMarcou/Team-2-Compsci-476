from venmo_api import Client
import os
import html
from dotenv import load_dotenv
html.entities.html5

# Get your access token. You will need to complete the 2FA process
# Please store it somewhere safe and use it next time
# Never commit your credentials or token to a git repository
load_dotenv()

access_token = access_token = Client.get_access_token(username=os.getenv('user'),
                                                      password=os.getenv('password'))


client = Client(access_token=access_token)

print(client)

#def callback(transactions_list):
#    for transaction in transactions_list:
#        print(transaction)

# callback is optional. Max number of transactions per request is 50.
#client.user.get_user_transactions(user_id='0000000000000000000',
 #                                    callback=callback)

client.log_out(access_token)