# Discord Lookup - hard

There is a public service, which allow you to view Discord server informations.

The bot behind this service has access to plenty of very confidentials discord channels.

Find a way to access private bot channel
# Solution

You need to create a custom discord channel, with an SSTI in channel description
Channel description can be edited if the channel is in "community mode"

Once you have the SSTI, you have to retreive the bot token. You can access the garbage collector to do this.

Since the garbage collector is very, very long, you'll have to guess where the token can be:

- you can CTRL+F 'PWMNE' (the beginning of the flag format) -> the token var name is BOT_TOKEN_PWNME
- you can CTRL+F 'Bot ', or 'Authorization' -> each request to the api use an header 'Authorization: Bot TOKEN'

Then, you'll need to login as a bot on discord.

Official Discord client doesn't allow you to connect with a bot token, so you need a custom client

There is a lot of librairies/clients doing this for us, just download one, and connect as a bot.

The flag is in "PWNME FLAG" channel