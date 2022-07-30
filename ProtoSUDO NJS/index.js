const { Client, GatewayIntentBits ,SlashCommandBuilder, Routes} = require('discord.js');
const { token,GuildId,ClientId } = require('./config.json');
console.log("your token is: " + token + "\nyour client ID is: " + ClientId + "\nyour GUILD ID is: " + GuildId);
// Create a new client instance
const client = new Client({ intents: [GatewayIntentBits.Guilds] });
// When the client is ready, run this code (only once)
client.once('ready', () => {
	console.log('Ready!');
});

client.on('interactionCreate', async interaction => {
	if (!interaction.isChatInputCommand()) return;

	const { commandName } = interaction;

	if (commandName === 'ping') {
		await interaction.reply('Pong!');
	} else if (commandName === 'server') {
		await interaction.reply('Server info.');
	} else if (commandName === 'user') {
		await interaction.reply('User info.');
	}
});

// Login to Discord with your client's token
client.login(token);
