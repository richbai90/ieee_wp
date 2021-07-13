/**
 * A ping pong bot, whenever you send "ping", it replies "pong".
 */

// Import the discord.js module
import Discord from 'discord.js'

// Create an instance of a Discord client
const client = new Discord.Client();

// Log our bot in using the token from https://discordapp.com/developers/applications/me
client.login('NjgzMDY1NjI3NzcwMDkzNTc4.XlmIxQ.QAO-EK0_oa3vbgnUCbKW2F_1JT0');

export default client;